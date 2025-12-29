// Service Worker for PWA - Enhanced Offline Support
const CACHE_NAME = 'dag-ag-tracker-v3';
const STATIC_CACHE = 'dag-ag-static-v3';
const DYNAMIC_CACHE = 'dag-ag-dynamic-v3';

// Static assets to cache immediately
const STATIC_ASSETS = [
    '/',
    '/login',
    '/sightings',
    '/download',
    '/offline.html',
    '/manifest.json',
    '/images/logo.png',
    '/images/cots-image.jpg',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js'
];

// Install Service Worker
self.addEventListener('install', event => {
    console.log('Service Worker installing...');
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(cache => {
                console.log('Caching static assets...');
                return cache.addAll(STATIC_ASSETS);
            })
            .then(() => {
                console.log('Service Worker installed successfully');
                return self.skipWaiting();
            })
            .catch(error => {
                console.error('Service Worker installation failed:', error);
            })
    );
});

// Activate Service Worker
self.addEventListener('activate', event => {
    console.log('Service Worker activating...');
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== STATIC_CACHE && cacheName !== DYNAMIC_CACHE) {
                        console.log('Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
        .then(() => {
            console.log('Service Worker activated and old caches cleaned');
            return self.clients.claim();
        })
    );
});

// Enhanced fetch event with better caching strategies
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    // Skip non-GET requests
    if (request.method !== 'GET') return;

    // Skip Chrome extension requests
    if (url.protocol === 'chrome-extension:') return;

    // Handle API requests differently
    if (url.pathname.startsWith('/api/')) {
        event.respondWith(
            fetch(request)
                .then(response => {
                    // Cache successful API responses
                    if (response.status === 200) {
                        const responseClone = response.clone();
                        caches.open(DYNAMIC_CACHE).then(cache => {
                            cache.put(request, responseClone);
                        });
                    }
                    return response;
                })
                .catch(() => {
                    // Return cached API response if available
                    return caches.match(request).then(cachedResponse => {
                        if (cachedResponse) {
                            return cachedResponse;
                        }
                        // Return offline message for API calls
                        return new Response(
                            JSON.stringify({
                                error: 'Offline',
                                message: 'You are currently offline. Data will sync when connection is restored.'
                            }),
                            {
                                status: 503,
                                statusText: 'Service Unavailable',
                                headers: { 'Content-Type': 'application/json' }
                            }
                        );
                    });
                })
        );
        return;
    }

    // Handle navigation requests
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request)
                .then(response => {
                    // Cache successful navigation responses
                    if (response.status === 200) {
                        const responseClone = response.clone();
                        caches.open(DYNAMIC_CACHE).then(cache => {
                            cache.put(request, responseClone);
                        });
                    }
                    return response;
                })
                .catch(() => {
                    // Try cache first, then offline page
                    return caches.match(request)
                        .then(cachedResponse => {
                            if (cachedResponse) {
                                return cachedResponse;
                            }
                            return caches.match('/offline.html');
                        });
                })
        );
        return;
    }

    // Handle static assets with cache-first strategy
    if (STATIC_ASSETS.includes(request.url) ||
        request.url.includes('.css') ||
        request.url.includes('.js') ||
        request.url.includes('.png') ||
        request.url.includes('.jpg') ||
        request.url.includes('.jpeg') ||
        request.url.includes('.svg') ||
        request.url.includes('.ico')) {

        event.respondWith(
            caches.match(request)
                .then(cachedResponse => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    return fetch(request)
                        .then(response => {
                            // Cache the response
                            const responseClone = response.clone();
                            caches.open(STATIC_CACHE).then(cache => {
                                cache.put(request, responseClone);
                            });
                            return response;
                        })
                        .catch(() => {
                            console.log('Failed to fetch static asset:', request.url);
                        });
                })
        );
        return;
    }

    // Default strategy: Network first, then cache
    event.respondWith(
        fetch(request)
            .then(response => {
                // Cache successful responses
                if (response.status === 200) {
                    const responseClone = response.clone();
                    caches.open(DYNAMIC_CACHE).then(cache => {
                        cache.put(request, responseClone);
                    });
                }
                return response;
            })
            .catch(() => {
                // Return from cache if network fails
                return caches.match(request);
            })
    );
});

// Handle background sync for offline data
self.addEventListener('sync', event => {
    console.log('Background sync triggered:', event.tag);

    if (event.tag === 'background-sync') {
        event.waitUntil(
            // Handle any pending offline data sync here
            syncOfflineData()
        );
    }
});

// Function to sync offline data (placeholder for future implementation)
function syncOfflineData() {
    return Promise.resolve();
    // TODO: Implement offline data synchronization
    // This could sync form submissions, location data, etc.
}

// Handle push notifications (for future use)
self.addEventListener('push', event => {
    console.log('Push message received:', event);

    if (event.data) {
        const data = event.data.json();
        const options = {
            body: data.body,
            icon: '/images/logo.png',
            badge: '/images/logo.png',
            vibrate: [100, 50, 100],
            data: {
                dateOfArrival: Date.now(),
                primaryKey: 1
            }
        };

        event.waitUntil(
            self.registration.showNotification(data.title, options)
        );
    }
});

// Handle notification clicks
self.addEventListener('notificationclick', event => {
    console.log('Notification click received.');

    event.notification.close();

    event.waitUntil(
        clients.openWindow('/')
    );
});