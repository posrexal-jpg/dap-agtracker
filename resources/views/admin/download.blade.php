@extends('layouts.admin')

@section('title', 'Downloads - Install App')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bx bx-download me-2"></i>Install COTS Tracker
            </h1>
            <p class="text-muted mb-0">Install the app on your device for easy access</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- PWA Installation Card -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-gradient text-white">
                    <h5 class="mb-0">
                        <i class="bx bx-mobile-alt me-2"></i>Install as Progressive Web App (PWA)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bx bx-info-circle me-2"></i>
                        <strong>Recommended:</strong> Install this app directly to your device for the best experience!
                    </div>

                    <h6 class="fw-bold mb-3"><i class="bx bx-mobile me-2"></i>For Android/Chrome:</h6>
                    <ol class="mb-4">
                        <li>Open this website in <strong>Chrome browser</strong></li>
                        <li>Tap the <strong>3-dot menu</strong> (⋮) in the top-right corner</li>
                        <li>Select <strong>"Install app"</strong> or <strong>"Add to Home screen"</strong></li>
                        <li>Tap <strong>"Install"</strong> when prompted</li>
                        <li>The app icon will appear on your home screen</li>
                    </ol>

                    <h6 class="fw-bold mb-3"><i class="bx bxl-apple me-2"></i>For iOS/Safari:</h6>
                    <ol class="mb-4">
                        <li>Open this website in <strong>Safari browser</strong></li>
                        <li>Tap the <strong>Share button</strong> (square with arrow pointing up)</li>
                        <li>Scroll down and tap <strong>"Add to Home Screen"</strong></li>
                        <li>Enter a name and tap <strong>"Add"</strong></li>
                        <li>The app icon will appear on your home screen</li>
                    </ol>

                    <h6 class="fw-bold mb-3"><i class="bx bxl-windows me-2"></i>For Desktop (Chrome/Edge):</h6>
                    <ol class="mb-0">
                        <li>Look for the <strong>install icon</strong> <i class="bx bx-plus-circle"></i> in the address bar</li>
                        <li>Click it and select <strong>"Install"</strong></li>
                        <li>Or use the 3-dot menu → <strong>"Install COTS Tracker"</strong></li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Features Card -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-gradient text-white">
                    <h5 class="mb-0">
                        <i class="bx bx-star me-2"></i>Why Install the App?
                    </h5>
                </div>
                <div class="card-body">
                    <div class="feature-item mb-3">
                        <div class="d-flex align-items-start">
                            <div class="feature-icon bg-primary text-white rounded-circle p-3 me-3">
                                <i class="bx bx-zap fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Instant Access</h6>
                                <p class="text-muted mb-0">Launch directly from your home screen without opening a browser</p>
                            </div>
                        </div>
                    </div>

                    <div class="feature-item mb-3">
                        <div class="d-flex align-items-start">
                            <div class="feature-icon bg-success text-white rounded-circle p-3 me-3">
                                <i class="bx bx-wifi-off fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Works Offline</h6>
                                <p class="text-muted mb-0">View cached data even without an internet connection</p>
                            </div>
                        </div>
                    </div>

                    <div class="feature-item mb-3">
                        <div class="d-flex align-items-start">
                            <div class="feature-icon bg-warning text-white rounded-circle p-3 me-3">
                                <i class="bx bx-bell fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Push Notifications</h6>
                                <p class="text-muted mb-0">Get instant alerts about COTS outbreaks and updates</p>
                            </div>
                        </div>
                    </div>

                    <div class="feature-item mb-3">
                        <div class="d-flex align-items-start">
                            <div class="feature-icon bg-info text-white rounded-circle p-3 me-3">
                                <i class="bx bx-mobile-landscape fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Native App Experience</h6>
                                <p class="text-muted mb-0">Full-screen mode with smooth navigation like a native app</p>
                            </div>
                        </div>
                    </div>

                    <div class="feature-item mb-0">
                        <div class="d-flex align-items-start">
                            <div class="feature-icon bg-danger text-white rounded-circle p-3 me-3">
                                <i class="bx bx-memory-card fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Low Storage</h6>
                                <p class="text-muted mb-0">Takes minimal space compared to traditional apps</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Install Button (for PWA prompt) -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <i class="bx bx-download display-1 text-primary mb-3"></i>
                    <h4 class="mb-3">Ready to Install?</h4>
                    <p class="text-muted mb-4">Click the button below if your browser supports installation</p>
                    <button id="installButton" class="btn btn-primary btn-lg px-5 py-3" style="display: none;">
                        <i class="bx bx-download me-2"></i>Install COTS Tracker Now
                    </button>
                    <div id="installNotSupported" class="alert alert-warning d-inline-block">
                        <i class="bx bx-info-circle me-2"></i>
                        Follow the instructions above to install on your device
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Force Light Mode */
    html, body {
        color-scheme: light !important;
        background: #f8fafc !important;
        color: #1f2937 !important;
    }

    .container-fluid {
        background: transparent !important;
    }

    /* Page Header */
    .h3 {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937 !important;
    }

    .text-gray-800 {
        color: #1f2937 !important;
    }

    .text-muted {
        color: #6b7280 !important;
    }

    /* Cards */
    .card {
        border: none !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08) !important;
        background: #ffffff !important;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12) !important;
        transform: translateY(-4px);
    }

    .bg-gradient {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
    }

    .card-header {
        padding: 1.5rem !important;
        border-bottom: none !important;
    }

    .card-header h5 {
        color: #ffffff !important;
        font-weight: 700;
    }

    .card-body {
        padding: 1.5rem !important;
        background: #ffffff !important;
        color: #1f2937 !important;
    }

    /* Alert */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        font-weight: 500;
    }

    .alert-info {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
        color: #1e40af !important;
    }

    .alert-success {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important;
        color: #166534 !important;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%) !important;
        color: #92400e !important;
    }

    /* Lists */
    ol {
        padding-left: 1.5rem;
    }

    ol li {
        margin-bottom: 0.75rem;
        line-height: 1.7;
        color: #1f2937 !important;
        font-weight: 500;
    }

    h6 {
        color: #1f2937 !important;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    h6 i {
        color: #3b82f6 !important;
    }

    strong {
        color: #1e40af !important;
        font-weight: 700;
    }

    /* Feature Items */
    .feature-icon {
        min-width: 50px;
        min-height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: #ffffff !important;
        border-radius: 12px;
        font-size: 1.5rem;
    }

    .feature-item {
        padding: 1rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: #f8fafc;
        margin-bottom: 0.75rem;
        border: 2px solid transparent;
    }

    .feature-item:hover {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-color: #3b82f6;
        transform: translateX(8px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }

    .feature-item strong {
        color: #1f2937 !important;
        display: block;
        margin-bottom: 0.25rem;
    }

    .feature-item p {
        margin-bottom: 0;
        color: #6b7280 !important;
        font-size: 0.9rem;
    }

    /* Buttons */
    .btn {
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        padding: 0.75rem 1.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 64, 175, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    #installButton {
        display: none;
    }

    #installButton.show {
        display: inline-block;
    }

    /* Mobile Responsive - Material-UI */
    @media (max-width: 768px) {
        body {
            background: #f5f5f5 !important;
        }

        .container-fluid {
            padding-left: 16px !important;
            padding-right: 16px !important;
        }

        .h3 {
            font-size: 1.25rem;
            font-weight: 500;
            letter-spacing: 0.0125em;
        }

        /* Material-UI Card */
        .card {
            border-radius: 12px !important;
            margin-bottom: 16px;
            box-shadow: 0 2px 1px -1px rgba(0,0,0,.2), 0 1px 1px 0 rgba(0,0,0,.14), 0 1px 3px 0 rgba(0,0,0,.12) !important;
        }

        .card-header {
            padding: 16px !important;
        }

        .card-body {
            padding: 16px !important;
        }

        /* Material-UI Typography */
        ol li {
            font-size: 0.875rem;
            line-height: 1.43;
            letter-spacing: 0.01071em;
        }

        h6 {
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 0.0125em;
        }

        /* Material-UI List Item */
        .feature-item {
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.14), 0 1px 3px 0 rgba(0,0,0,.12);
        }

        .feature-icon {
            min-width: 40px;
            min-height: 40px;
            font-size: 1.25rem;
            border-radius: 8px;
        }

        /* Material-UI Button */
        .btn {
            width: 100%;
            margin-bottom: 12px;
            height: 48px;
            text-transform: uppercase;
            letter-spacing: 0.0892857143em;
            font-weight: 500;
            box-shadow: 0 3px 1px -2px rgba(0,0,0,.2), 0 2px 2px 0 rgba(0,0,0,.14), 0 1px 5px 0 rgba(0,0,0,.12) !important;
        }

        .btn:active {
            box-shadow: 0 5px 5px -3px rgba(0,0,0,.2), 0 8px 10px 1px rgba(0,0,0,.14), 0 3px 14px 2px rgba(0,0,0,.12) !important;
        }
    }

    /* Dark Mode Prevention */
    @media (prefers-color-scheme: dark) {
        html, body, .card, .card-body {
            background: #ffffff !important;
            color: #1f2937 !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // PWA Installation Prompt
    let deferredPrompt;
    const installButton = document.getElementById('installButton');
    const installNotSupported = document.getElementById('installNotSupported');

    // Listen for the beforeinstallprompt event
    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent the mini-infobar from appearing on mobile
        e.preventDefault();
        // Stash the event so it can be triggered later
        deferredPrompt = e;
        // Show the install button
        installButton.style.display = 'inline-block';
        installNotSupported.style.display = 'none';
    });

    // Handle install button click
    installButton.addEventListener('click', async () => {
        if (!deferredPrompt) {
            return;
        }

        // Show the install prompt
        deferredPrompt.prompt();

        // Wait for the user to respond to the prompt
        const { outcome } = await deferredPrompt.userChoice;
        
        if (outcome === 'accepted') {
            console.log('User accepted the install prompt');
            // Show success message
            installButton.innerHTML = '<i class="bx bx-check me-2"></i>Installing...';
            installButton.disabled = true;
        } else {
            console.log('User dismissed the install prompt');
        }

        // Clear the deferredPrompt
        deferredPrompt = null;
    });

    // Check if app is already installed
    window.addEventListener('appinstalled', () => {
        console.log('COTS Tracker was installed');
        installButton.innerHTML = '<i class="bx bx-check-circle me-2"></i>App Installed!';
        installButton.disabled = true;
        installButton.classList.remove('btn-primary');
        installButton.classList.add('btn-success');
        
        // Hide after 3 seconds
        setTimeout(() => {
            installButton.style.display = 'none';
        }, 3000);
    });

    // Check if running as PWA
    if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
        console.log('App is running in standalone mode');
        installNotSupported.innerHTML = '<i class="bx bx-check-circle me-2"></i>App is already installed!';
        installNotSupported.classList.remove('alert-warning');
        installNotSupported.classList.add('alert-success');
    }
</script>
@endpush
@endsection
