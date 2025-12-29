// User Offline Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Load offline manager with error handling
    try {
        // Check if offline manager script exists before trying to use it
        if (typeof window.offlineManager === 'undefined') {
            console.warn('Offline manager not loaded, some features may not work offline');
        }
    } catch (offlineError) {
        console.warn('Offline manager error:', offlineError);
    }

    // Initialize offline functionality
    initializeOfflineFunctionality();
});

function initializeOfflineFunctionality() {
    const locationForm = document.getElementById('locationForm');
    if (!locationForm) return;

    const submitBtn = locationForm.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn ? submitBtn.innerHTML : '';

    // Update form submission to handle offline
    locationForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!navigator.onLine && window.offlineManager) {
            // Handle offline submission
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving Offline...';
                submitBtn.disabled = true;
            }

            try {
                const formData = new FormData(this);
                const locationData = {};

                // Convert FormData to object
                for (let [key, value] of formData.entries()) {
                    if (key !== 'photo[]') {
                        locationData[key] = value;
                    }
                }

                // Handle photos
                const photoFiles = formData.getAll('photo[]').filter(file => file.size > 0);
                const photoIds = [];

                for (const file of photoFiles) {
                    const photoId = await window.offlineManager.storePhotoOffline(file);
                    photoIds.push(photoId);
                }

                // Store location data offline
                const locationId = await window.offlineManager.storeLocationOffline(locationData, photoIds);

                // Reset form
                this.reset();

                // Show success message
                showNotification('Data saved offline! Will sync when online.', 'success');

                if (submitBtn) {
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                }

                // Close modal on mobile
                if (window.innerWidth < 768) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modal1'));
                    if (modal) modal.hide();
                }

            } catch (error) {
                console.error('Offline save failed:', error);
                showErrorAlert('Failed to save data offline. Please try again.');
                if (submitBtn) {
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                }
            }
        } else {
            // Normal online submission
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                submitBtn.disabled = true;
            }

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    const result = await response.json();
                    showNotification('Location saved successfully!', 'success');
                    this.reset();
                    // Optionally refresh the page or update the UI
                    setTimeout(() => location.reload(), 1000);
                } else {
                    const error = await response.json();
                    showNotification(error.message || 'Failed to save location', 'error');
                }
            } catch (error) {
                console.error('Save failed:', error);
                showNotification('Failed to save location. Please try again.', 'error');
            }

            if (submitBtn) {
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            }
        }
    });

    // Show online/offline status
    updateConnectionStatus();
    window.addEventListener('online', updateConnectionStatus);
    window.addEventListener('offline', updateConnectionStatus);

    // Add mobile-specific event listeners
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.addEventListener('message', event => {
            if (event.data && event.data.type === 'SYNC_COMPLETE') {
                showNotification('Data synced successfully!', 'success');
                updateConnectionStatus();
            }
        });
    }
}

function updateConnectionStatus() {
    const statusElement = document.getElementById('connectionStatus');
    if (statusElement) {
        if (navigator.onLine) {
            statusElement.className = 'connection-status online';
            statusElement.innerHTML = '<i class="fas fa-wifi"></i><span>Online</span>';
        } else {
            statusElement.className = 'connection-status offline';
            statusElement.innerHTML = '<i class="fas fa-wifi-slash"></i><span>Offline</span>';
        }
    }
}

function addNewSighting() {
    // Trigger map click or open modal
    if (typeof addMarkerAtCurrentLocation === 'function') {
        addMarkerAtCurrentLocation();
    } else {
        // Fallback: open the modal
        const modal = new bootstrap.Modal(document.getElementById('modal1'));
        if (modal) modal.show();
    }
}

function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());

    // Create new notification
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);

    // Auto-hide after 4 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 4000);

    // Add click to dismiss
    notification.addEventListener('click', () => notification.remove());
}

// Manual sync button functionality
function manualSync() {
    const syncBtn = document.getElementById('syncBtn');
    const originalHTML = syncBtn ? syncBtn.innerHTML : '';

    if (window.offlineManager && navigator.onLine) {
        if (syncBtn) {
            syncBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Syncing...';
            syncBtn.disabled = true;
        }

        window.offlineManager.syncData().then(result => {
            if (result.synced > 0) {
                showNotification(`Synced ${result.synced} locations successfully!`, 'success');
            } else {
                showNotification('No data to sync', 'info');
            }
            if (syncBtn) {
                syncBtn.innerHTML = originalHTML;
                syncBtn.disabled = false;
            }
        }).catch(error => {
            showNotification('Sync failed: ' + error.message, 'error');
            if (syncBtn) {
                syncBtn.innerHTML = originalHTML;
                syncBtn.disabled = false;
            }
        });
    } else if (!navigator.onLine) {
        showNotification('Cannot sync while offline', 'warning');
    } else {
        showNotification('Sync manager not available', 'warning');
    }
}

// Mobile-specific enhancements
if ('visualViewport' in window) {
    window.visualViewport.addEventListener('resize', () => {
        // Handle mobile keyboard appearance
        document.body.style.height = window.visualViewport.height + 'px';
    });
}

// Prevent zoom on input focus for iOS
const inputs = document.querySelectorAll('input, select, textarea');
inputs.forEach(input => {
    input.addEventListener('focus', () => {
        if (window.innerWidth < 768) {
            input.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
});