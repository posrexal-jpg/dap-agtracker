// PWA Installation Manager
class PWAInstallManager {
    constructor() {
        this.deferredPrompt = null;
        this.installButton = null;
        this.init();
    }

    init() {
        // Listen for the beforeinstallprompt event
        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent the mini-infobar from appearing on mobile
            e.preventDefault();
            // Stash the event so it can be triggered later
            this.deferredPrompt = e;

            // Show install button
            this.showInstallButton();
        });

        // Listen for successful installation
        window.addEventListener('appinstalled', (evt) => {
            console.log('PWA was installed successfully');
            this.hideInstallButton();
        });

        // Check if already installed
        if (window.matchMedia('(display-mode: standalone)').matches) {
            console.log('PWA is already installed');
            this.hideInstallButton();
        }
    }

    showInstallButton() {
        // Remove existing button if any
        this.hideInstallButton();

        // Create install button
        this.installButton = document.createElement('button');
        this.installButton.id = 'pwa-install-btn';
        this.installButton.className = 'btn btn-success btn-sm me-2';
        this.installButton.innerHTML = '<i class="fas fa-download me-1"></i>Install App';
        this.installButton.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.3);';

        // Add click handler
        this.installButton.addEventListener('click', () => {
            this.installPWA();
        });

        document.body.appendChild(this.installButton);

        // Auto-hide after 10 seconds
        setTimeout(() => {
            this.hideInstallButton();
        }, 10000);
    }

    hideInstallButton() {
        if (this.installButton && this.installButton.parentNode) {
            this.installButton.remove();
            this.installButton = null;
        }
    }

    async installPWA() {
        if (!this.deferredPrompt) {
            console.log('Install prompt not available');
            return;
        }

        // Show the install prompt
        this.deferredPrompt.prompt();

        // Wait for the user to respond to the prompt
        const { outcome } = await this.deferredPrompt.userChoice;

        // Reset the deferred prompt
        this.deferredPrompt = null;

        if (outcome === 'accepted') {
            console.log('User accepted the install prompt');
        } else {
            console.log('User dismissed the install prompt');
        }

        this.hideInstallButton();
    }
}

// Initialize PWA install manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new PWAInstallManager();
});