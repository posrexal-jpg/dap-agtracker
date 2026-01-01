// Service Worker Registration for PWA Offline Support
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('Service Worker registered successfully with scope:', registration.scope);

                // Listen for updates
                registration.addEventListener('updatefound', function() {
                    const newWorker = registration.installing;
                    newWorker.addEventListener('statechange', function() {
                        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                            // New content is available, show update notification
                            showUpdateNotification();
                        }
                    });
                });
            })
            .catch(function(error) {
                console.log('Service Worker registration failed:', error);
            });
    });

    // Listen for controller change (when new SW takes control)
    navigator.serviceWorker.addEventListener('controllerchange', function() {
        window.location.reload();
    });
}

// Function to show update notification
function showUpdateNotification() {
    // Create a simple toast notification
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #1e3a8a;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 9999;
        font-family: 'Public Sans', sans-serif;
        max-width: 300px;
        cursor: pointer;
    `;
    toast.innerHTML = `
        <div style="font-weight: 600; margin-bottom: 5px;">App Updated!</div>
        <div style="font-size: 14px;">Click to refresh and get the latest features.</div>
    `;

    toast.onclick = function() {
        window.location.reload();
    };

    document.body.appendChild(toast);

    // Auto remove after 10 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 10000);
}

// Handle online/offline status
window.addEventListener('online', function() {
    console.log('App is online');
    // You could show a notification here that the app is back online
});

window.addEventListener('offline', function() {
    console.log('App is offline');
    // The service worker will handle serving cached content
});