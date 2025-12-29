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
    <title>Dap-ag Tracker - Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Prevent body scrolling on mobile when modal is open */
        .mobile-device {
            overflow: hidden;
        }

        .mobile-device .login-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1055;
        }

        .login-modal .modal-dialog {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }

        .login-modal .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .login-modal .modal-body {
            padding: 0;
        }

        .login-modal {
            z-index: 1055; /* Standard Bootstrap modal z-index */
        }

        .left-panel {
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            color: white;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 400px;
        }

        .left-panel h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .left-panel h1 img {
            height: 50px;
            width: auto;
        }

        .left-panel p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .logos {
            display: flex;
            gap: 20px;
            margin-top: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .logo {
            max-width: 80px;
            height: auto;
        }

        .right-panel {
            background: white;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 400px;
        }

        .right-panel h3 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 10px;
            text-align: center;
        }

        .right-panel > p {
            font-size: 0.95rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #1e3a8a;
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            width: 100%;
            font-weight: 600;
            font-size: 1rem;
            min-height: 48px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        }

        .btn-google {
            border: 2px solid #dadce0;
            background: white;
            color: #3c4043;
            border-radius: 50px;
            padding: 12px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            min-height: 48px;
            font-size: 1rem;
        }

        .btn-google:hover {
            background: #f8f9fa;
            border-color: #c4c7c5;
            color: #202124;
            text-decoration: none;
        }

        .alert {
            border-radius: 10px;
            font-size: 0.9rem;
        }

        .text-center.mt-3 a {
            color: #1e3a8a;
            font-weight: 500;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #374151;
        }

        /* Modal responsiveness */
        @media (max-width: 991.98px) {
            .login-modal .modal-dialog {
                max-width: 95vw;
            }

            .left-panel,
            .right-panel {
                padding: 20px;
            }

            .left-panel h1 {
                font-size: 2rem;
            }

            .left-panel h1 img {
                height: 40px;
            }
        }

        @media (max-width: 767.98px) {
            body {
                padding: 10px;
            }

            .login-modal .modal-dialog {
                max-width: 100vw;
                margin: 0;
            }

            .login-modal .modal-content {
                border-radius: 10px;
            }

            .left-panel {
                padding: 20px 15px;
                min-height: 250px;
            }

            .left-panel h1 {
                font-size: 1.8rem;
                flex-direction: column;
            }

            .left-panel h1 img {
                height: 35px;
                margin-bottom: 10px;
            }

            .left-panel p {
                font-size: 0.95rem;
                margin-bottom: 20px;
            }

            .logos {
                gap: 15px;
                margin-top: 20px;
            }

            .logo {
                max-width: 50px;
            }

            .right-panel {
                padding: 20px 15px;
                min-height: 300px;
            }

            .right-panel h3 {
                font-size: 1.5rem;
                margin-bottom: 8px;
            }

            .right-panel > p {
                font-size: 0.9rem;
                margin-bottom: 20px;
            }

            .form-control {
                padding: 10px 14px;
                font-size: 16px; /* Prevents zoom on iOS */
                min-height: 44px;
            }

            .btn-login,
            .btn-google {
                padding: 12px 20px;
                min-height: 48px;
                font-size: 16px;
            }
        }

        /* Mobile Phone - Full Viewport Modal */
        .mobile-device .login-modal .modal-dialog {
            max-width: 100vw;
            margin: 0;
            height: 100vh;
            max-height: 100vh;
        }

        .mobile-device .login-modal .modal-content {
            height: 100vh;
            max-height: 100vh;
            border-radius: 0;
            display: flex;
            flex-direction: column;
        }

        .mobile-device .login-modal .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 0;
        }

        .mobile-device .row.g-0 {
            height: 100%;
            flex-direction: column;
        }

        .mobile-device .left-panel,
        .mobile-device .right-panel {
            flex: 1;
            min-height: auto;
            padding: 20px 15px;
        }

        .mobile-device .left-panel {
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            order: 2; /* Move to bottom on mobile */
        }

        .mobile-device .right-panel {
            background: white;
            order: 1; /* Move to top on mobile */
            flex: 1.2; /* Give more space to form */
        }

        /* Mobile Portrait Specific */
        .mobile-portrait .left-panel h1 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .mobile-portrait .left-panel p {
            font-size: 0.9rem;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .mobile-portrait .logos {
            margin-top: 15px;
            gap: 10px;
        }

        .mobile-portrait .logo {
            max-width: 40px;
        }

        .mobile-portrait .right-panel h3 {
            font-size: 1.4rem;
            margin-bottom: 15px;
        }

        .mobile-portrait .right-panel > p {
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        .mobile-portrait .form-group {
            margin-bottom: 15px;
        }

        .mobile-portrait .btn-login,
        .mobile-portrait .btn-google {
            margin-bottom: 10px;
            min-height: 44px;
        }

        /* Mobile Landscape Specific */
        .mobile-landscape .row.g-0 {
            flex-direction: row;
        }

        .mobile-landscape .left-panel,
        .mobile-landscape .right-panel {
            flex: 1;
            min-height: 100%;
            padding: 15px;
            overflow-y: auto;
        }

        .mobile-landscape .left-panel {
            order: 1;
        }

        .mobile-landscape .right-panel {
            order: 2;
        }

        .mobile-landscape .left-panel h1 {
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .mobile-landscape .left-panel p {
            font-size: 0.8rem;
            margin-bottom: 10px;
        }

        .mobile-landscape .right-panel h3 {
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .mobile-landscape .right-panel > p {
            font-size: 0.8rem;
            margin-bottom: 15px;
        }

        .mobile-landscape .logos {
            margin-top: 10px;
            gap: 8px;
        }

        .mobile-landscape .logo {
            max-width: 35px;
        }

        .mobile-landscape .form-group {
            margin-bottom: 12px;
        }

        .mobile-landscape .btn-login,
        .mobile-landscape .btn-google {
            padding: 10px 16px;
            min-height: 40px;
            font-size: 14px;
        }

            .logos {
                margin-top: 15px;
            }

            .logo {
                max-width: 40px;
            }
        }
    </style>
    <style>
        #errorModal ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        #errorModal li {
            margin-bottom: 5px;
        }
        #errorModal .modal-content {
            border-radius: 15px;
        }
        #errorModal .modal-dialog {
            /* Removed margin to allow proper centering */
        }
        #errorModal {
            z-index: 1060; /* Higher than default Bootstrap modal z-index */
        }

        /* Modal responsiveness */
        @media (max-width: 575.98px) {
            #errorModal .modal-dialog {
                margin: 1rem;
                max-width: none;
            }
            #errorModal .modal-content {
                border-radius: 10px;
            }
            #errorModal .modal-body {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Login Modal -->
    <div class="modal fade login-modal show" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="false" style="display: block;" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <!-- Left Panel -->
                        <div class="col-lg-6 left-panel">
                            <h1>
                                <img src="{{ asset('images/logo.png') }}" alt="Dap-ag Tracker Logo">
                                <span>Dap-ag Tracker</span>
                            </h1>
                            <p>Monitor and track Crown-of-Thorns Starfish (COTS), locally known as Dap-ag, infestations to protect our coral reefs. Join us in preserving marine biodiversity.</p>
                            <div class="logos">
                                <img src="{{ asset('images/logo1.png') }}" alt="DOST Logo" class="logo">
                                <img src="{{ asset('images/logo3.png') }}" alt="SLSU Bontoc Logo" class="logo">
                            </div>
                        </div>

                        <!-- Right Panel -->
                        <div class="col-lg-6 right-panel">
                            <h3 class="text-center mb-4">Welcome Back</h3>
                            <p class="text-center text-muted mb-4">Please sign in to your account</p>

                            <!-- Display login error message if available -->
                            @if(session('error'))
                                <div class="alert alert-danger" id="session-error">{{ session('error') }}</div>
                            @endif

                            <!-- Display validation errors -->
                            @if($errors->any())
                                <div class="alert alert-danger" id="validation-errors">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autocomplete="email">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                                </div>
                                <button type="submit" class="btn btn-primary btn-login">Login</button>
                            </form>

                            <div class="text-center my-3">
                                <span class="text-muted">or</span>
                            </div>

                            <a href="{{ route('google.login') }}" class="btn btn-outline-secondary btn-google w-100 mb-3">
                                <i class="fab fa-google me-2"></i>Continue with Google
                            </a>

                            <div class="text-center mt-3">
                                <a href="/" class="text-decoration-none">← Back to Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title" id="errorModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Authentication Failed
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4" id="errorModalBody">
                    <!-- Error message will be inserted here -->
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Try Again
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Device Detection and Mobile Optimization -->
    <script>
        // Device and orientation detection for login page
        function updateDeviceClasses() {
            const body = document.body;
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ||
                           (window.innerWidth <= 768 && window.innerHeight > window.innerWidth);
            const isPortrait = window.innerHeight > window.innerWidth;

            // Remove existing classes
            body.classList.remove('mobile-device', 'mobile-portrait', 'mobile-landscape');

            // Add appropriate classes
            if (isMobile) {
                body.classList.add('mobile-device');
                if (isPortrait) {
                    body.classList.add('mobile-portrait');
                } else {
                    body.classList.add('mobile-landscape');
                }
            }
        }

        // Initial check
        updateDeviceClasses();

        // Listen for orientation changes
        window.addEventListener('orientationchange', function() {
            setTimeout(updateDeviceClasses, 100);
        });

        // Listen for resize events
        window.addEventListener('resize', updateDeviceClasses);

        // Touch device optimizations
        if ('ontouchstart' in window) {
            document.body.classList.add('touch-device');
        }

        // Force modal resize on mobile devices
        function resizeModal() {
            const modal = document.getElementById('loginModal');
            if (modal && document.body.classList.contains('mobile-device')) {
                // Small delay to ensure DOM is ready
                setTimeout(() => {
                    const modalDialog = modal.querySelector('.modal-dialog');
                    if (modalDialog) {
                        modalDialog.style.height = '100vh';
                        modalDialog.style.maxHeight = '100vh';
                    }
                }, 100);
            }
        }

        // Resize modal on orientation change
        window.addEventListener('orientationchange', function() {
            setTimeout(resizeModal, 200);
        });

        // Initial modal sizing
        document.addEventListener('DOMContentLoaded', function() {
            resizeModal();
        });
    </script>
    <script>
        // Initialize and show the login modal
        document.addEventListener('DOMContentLoaded', function() {
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'), {
                backdrop: 'static',
                keyboard: false
            });
            loginModal.show();

            // Show error modal if there are errors
            const sessionError = document.getElementById('session-error');
            const validationErrors = document.getElementById('validation-errors');

            let errorMessage = '';

            if (sessionError) {
                errorMessage = sessionError.innerHTML;
                sessionError.style.display = 'none';
            } else if (validationErrors) {
                errorMessage = validationErrors.innerHTML;
                validationErrors.style.display = 'none';
            }

            if (errorMessage) {
                document.getElementById('errorModalBody').innerHTML = errorMessage;
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            }
        });
    </script>
    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('Service Worker registered:', registration);
                    })
                    .catch(error => {
                        console.log('Service Worker registration failed:', error);
                    });
            });
        }
    </script>
</body>
</html>
