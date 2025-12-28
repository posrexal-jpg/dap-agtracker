// Offline Data Management for Dag-ag Tracker PWA
class OfflineManager {
    constructor() {
        this.dbName = 'DagAgTrackerDB';
        this.dbVersion = 1;
        this.init();
    }

    // Initialize IndexedDB
    async init() {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(this.dbName, this.dbVersion);

            request.onerror = () => reject(request.error);
            request.onsuccess = () => {
                this.db = request.result;
                resolve(this.db);
            };

            request.onupgradeneeded = (event) => {
                const db = event.target.result;

                // Create object stores if they don't exist
                if (!db.objectStoreNames.contains('locations')) {
                    const locationStore = db.createObjectStore('locations', { keyPath: 'id', autoIncrement: true });
                    locationStore.createIndex('syncStatus', 'syncStatus', { unique: false });
                    locationStore.createIndex('timestamp', 'timestamp', { unique: false });
                }

                if (!db.objectStoreNames.contains('photos')) {
                    db.createObjectStore('photos', { keyPath: 'id' });
                }

                if (!db.objectStoreNames.contains('syncQueue')) {
                    db.createObjectStore('syncQueue', { keyPath: 'id' });
                }
            };
        });
    }

    // Store location data offline
    async storeLocationOffline(locationData, photos = []) {
        const db = await this.ensureDB();
        const transaction = db.transaction(['locations', 'photos'], 'readwrite');

        // Store location data
        const locationStore = transaction.objectStore('locations');
        const locationWithMeta = {
            ...locationData,
            id: Date.now() + Math.random(),
            syncStatus: 'pending',
            timestamp: new Date().toISOString(),
            photos: photos.map(photo => photo.id)
        };

        await this.promisifyRequest(locationStore.add(locationWithMeta));

        // Store photos
        if (photos.length > 0) {
            const photoStore = transaction.objectStore('photos');
            for (const photo of photos) {
                await this.promisifyRequest(photoStore.add(photo));
            }
        }

        // Update UI to show offline status
        this.showOfflineNotification('Data saved offline. Will sync when online.');

        return locationWithMeta.id;
    }

    // Get all offline locations
    async getOfflineLocations() {
        const db = await this.ensureDB();
        const transaction = db.transaction(['locations'], 'readonly');
        const store = transaction.objectStore('locations');

        return this.promisifyRequest(store.getAll());
    }

    // Sync pending data when online
    async syncData() {
        if (!navigator.onLine) {
            throw new Error('No internet connection');
        }

        const locations = await this.getOfflineLocations();
        const pendingLocations = locations.filter(loc => loc.syncStatus === 'pending');

        if (pendingLocations.length === 0) {
            return { synced: 0, message: 'No data to sync' };
        }

        // Prepare location data for API (exclude photos for now, handle separately)
        const locationsForSync = pendingLocations.map(loc => {
            const { id, syncStatus, timestamp, photos, ...locationData } = loc;
            return locationData;
        });

        try {
            // Send locations to API
            const response = await fetch('/api/sync-locations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify({ locations: locationsForSync })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                // Mark locations as synced in IndexedDB
                for (const location of pendingLocations) {
                    await this.markLocationSynced(location.id);
                }

                return {
                    synced: result.synced_count,
                    total: pendingLocations.length,
                    errors: result.errors || [],
                    message: result.message
                };
            } else {
                throw new Error(result.message || 'Sync failed');
            }

        } catch (error) {
            console.error('Sync failed:', error);
            throw error;
        }
    }

    // Mark location as synced
    async markLocationSynced(locationId) {
        const db = await this.ensureDB();
        const transaction = db.transaction(['locations'], 'readwrite');
        const store = transaction.objectStore('locations');

        const location = await this.promisifyRequest(store.get(locationId));
        if (location) {
            location.syncStatus = 'synced';
            await this.promisifyRequest(store.put(location));
        }
    }

    // Get photo by ID
    async getPhoto(photoId) {
        const db = await this.ensureDB();
        const transaction = db.transaction(['photos'], 'readonly');
        const store = transaction.objectStore('photos');

        return this.promisifyRequest(store.get(photoId));
    }

    // Store photo offline
    async storePhotoOffline(file) {
        const photoId = Date.now() + Math.random();
        const photoData = {
            id: photoId,
            file: file,
            filename: file.name,
            timestamp: new Date().toISOString()
        };

        const db = await this.ensureDB();
        const transaction = db.transaction(['photos'], 'readwrite');
        const store = transaction.objectStore('photos');

        await this.promisifyRequest(store.add(photoData));

        return photoId;
    }

    // Check if we're online
    isOnline() {
        return navigator.onLine;
    }

    // Show offline notification
    showOfflineNotification(message) {
        // Create notification element if it doesn't exist
        let notification = document.getElementById('offline-notification');
        if (!notification) {
            notification = document.createElement('div');
            notification.id = 'offline-notification';
            notification.className = 'alert alert-warning alert-dismissible fade show position-fixed';
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <i class="fas fa-wifi-slash me-2"></i>
                <span id="notification-message">${message}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(notification);
        } else {
            document.getElementById('notification-message').textContent = message;
            notification.classList.remove('d-none');
        }

        // Auto-hide after 5 seconds
        setTimeout(() => {
            notification.classList.add('d-none');
        }, 5000);
    }

    // Ensure DB is initialized
    async ensureDB() {
        if (!this.db) {
            await this.init();
        }
        return this.db;
    }

    // Helper to promisify IndexedDB requests
    promisifyRequest(request) {
        return new Promise((resolve, reject) => {
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
}

// Initialize offline manager when DOM is loaded
let offlineManager;
document.addEventListener('DOMContentLoaded', () => {
    offlineManager = new OfflineManager();

    // Register service worker if supported
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('Service Worker registered');

                // Register background sync if supported
                if ('sync' in registration) {
                    // Auto-sync when coming online
                    window.addEventListener('online', () => {
                        registration.sync.register('background-sync');
                    });
                }
            })
            .catch(error => {
                console.log('Service Worker registration failed:', error);
            });
    }

    // Handle online/offline events
    window.addEventListener('online', () => {
        console.log('Back online - syncing data...');
        if (offlineManager) {
            offlineManager.syncData().then(result => {
                if (result.synced > 0) {
                    offlineManager.showOfflineNotification(`Synced ${result.synced} locations successfully!`);
                }
            }).catch(error => {
                console.error('Sync failed:', error);
            });
        }
    });

    window.addEventListener('offline', () => {
        console.log('Gone offline');
        offlineManager?.showOfflineNotification('You are now offline. Data will be saved locally.');
    });
});

// Export for use in other scripts
window.OfflineManager = OfflineManager;