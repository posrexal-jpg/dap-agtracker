<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1e3a8a" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="apple-mobile-web-app-title" content="Dap-ag Tracker" />
    <link rel="manifest" href="/manifest.json" />
    <link rel="apple-touch-icon" href="/images/logo.png" />
    <title>Install COTS Tracker - Progressive Web App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .download-container {
            padding: 19px 0;
        }

        .download-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
        }

        .download-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .download-body {
            padding: 2rem;
        }

        .download-item {
            background: #f8fafc;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .download-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .download-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .btn-download {
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-download:hover {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 58, 138, 0.3);
            color: white;
            text-decoration: none;
        }

        .back-link {
            color: #1e3a8a;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: #60a5fa;
            text-decoration: none;
            transform: translateX(-5px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Dap-ag Tracker Logo" style="height: 40px; width: auto; margin-right: 10px;">
                Dap-ag Tracker
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/sightings">COTS Sightings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#partners">Partners</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Download Section -->
    <section class="download-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <a href="/" class="back-link">
                        <i class="fas fa-arrow-left"></i>
                        Back to Home
                    </a>

                    <div class="download-card">
                        <div class="download-header">
                            <h1 class="mb-2">Install COTS Tracker</h1>
                            <p class="mb-0">Install our app for offline access and native mobile experience</p>
                        </div>
                        <div class="download-body">
                            <div class="download-item text-center">
                                <div class="download-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <h4>Install COTS Tracker App</h4>
                                <p class="text-muted mb-4">Install our Progressive Web App for the best mobile experience with offline capabilities</p>

                                <!-- Install Button (shown when app is installable) -->
                                <button id="installBtn" class="btn-download d-none">
                                    <i class="fas fa-download"></i>
                                    Install App
                                </button>

                                <!-- Alternative instructions when install button is not available -->
                                <div id="installInstructions" class="text-center">
                                    <p class="mb-3"><strong>How to install:</strong></p>
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <div class="install-step mb-3">
                                                <i class="fas fa-share text-primary mb-2" style="font-size: 2rem;"></i>
                                                <p><strong>Chrome/Android:</strong> Tap the menu (⋮) → "Add to Home screen"</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="install-step mb-3">
                                                <i class="fab fa-safari text-primary mb-2" style="font-size: 2rem;"></i>
                                                <p><strong>Safari/iOS:</strong> Tap share button → "Add to Home Screen"</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        The app will work offline and provide push notifications for new sightings.
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <p class="text-muted">
                                    <small>Already have the app installed? <a href="/" class="text-primary">Launch from home screen</a></small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- PWA Install Script -->
    <script>
        let deferredPrompt;

        // Listen for the beforeinstallprompt event
        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent the mini-infobar from appearing on mobile
            e.preventDefault();
            // Stash the event so it can be triggered later
            deferredPrompt = e;

            // Show the install button
            const installBtn = document.getElementById('installBtn');
            const installInstructions = document.getElementById('installInstructions');

            if (installBtn) {
                installBtn.classList.remove('d-none');
            }
            if (installInstructions) {
                installInstructions.classList.add('d-none');
            }
        });

        // Handle install button click
        document.getElementById('installBtn').addEventListener('click', async () => {
            if (!deferredPrompt) {
                alert('App installation is not available on this device/browser.');
                return;
            }

            // Show the install prompt
            deferredPrompt.prompt();

            // Wait for the user to respond to the prompt
            const { outcome } = await deferredPrompt.userChoice;

            // Reset the deferred prompt variable
            deferredPrompt = null;

            // Hide the install button
            document.getElementById('installBtn').classList.add('d-none');
            document.getElementById('installInstructions').classList.remove('d-none');

            if (outcome === 'accepted') {
                console.log('User accepted the install prompt');
            } else {
                console.log('User dismissed the install prompt');
            }
        });

        // Check if app is already installed
        window.addEventListener('appinstalled', (evt) => {
            console.log('App was installed successfully');
            // Hide install button if app is installed
            document.getElementById('installBtn').classList.add('d-none');
            document.getElementById('installInstructions').classList.remove('d-none');
        });

        // Check if running in standalone mode (already installed)
        if (window.matchMedia('(display-mode: standalone)').matches ||
            window.navigator.standalone === true) {
            // App is already installed, hide install options
            document.getElementById('installBtn').classList.add('d-none');
            document.getElementById('installInstructions').classList.add('d-none');

            // Show message that app is already installed
            const downloadBody = document.querySelector('.download-body');
            downloadBody.innerHTML = `
                <div class="text-center py-5">
                    <div class="download-icon mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="text-success mb-3">App Already Installed!</h4>
                    <p class="text-muted mb-4">You're already using the COTS Tracker as an installed app.</p>
                    <a href="/" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>
                        Go to Dashboard
                    </a>
                </div>
            `;
        }
    </script>
</body>
</html>