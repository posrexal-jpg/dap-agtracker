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
        * {
            -webkit-user-select: none;
            -webkit-tap-highlight-color: transparent;
        }

        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Prevent body scrolling on mobile when modal is open */
        body.mobile-device {
            overflow: hidden;
            padding: 0;
        }

        .login-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex !important;
            align-items: center;
            justify-content: center;
            z-index: 1055;
            padding: 20px;
        }

        .login-modal .modal-dialog {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            height: auto;
            max-height: none;
        }

        .login-modal .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            overflow: visible;
            height: auto;
            max-height: none;
        }

        .login-modal .modal-body {
            padding: 0;
            overflow: visible;
            max-height: none;
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
                max-height: 95vh;
            }

            .left-panel,
            .right-panel {
                padding: 30px 20px;
                min-height: auto;
            }

            .left-panel h1 {
                font-size: 1.8rem;
            }

            .left-panel h1 img {
                height: 35px;
            }

            .left-panel p {
                font-size: 0.95rem;
            }
        }

        /* Tablet and Small Tablets */
        @media (max-width: 768px) {
            body {
                padding: 0;
                background-attachment: fixed;
            }

            .login-modal {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                padding: 0 !important;
                background: rgba(0, 0, 0, 0.5);
                align-items: flex-start;
                justify-content: flex-start;
            }

            .login-modal .modal-dialog {
                max-width: 100vw;
                width: 100vw;
                margin: 0;
                max-height: none;
                height: 100vh;
            }

            .login-modal .modal-content {
                border-radius: 0;
                height: 100vh;
                max-height: none;
                display: flex;
                flex-direction: column;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .login-modal .modal-body {
                flex: 0 1 auto;
                display: flex;
                overflow: visible;
                padding: 0;
            }

            .row.g-0 {
                width: 100%;
                height: auto;
                flex-direction: column;
            }

            /* Hide left panel on mobile devices */
            .left-panel {
                display: none !important;
            }

            .right-panel {
                width: 100%;
                padding: 25px 15px;
                min-height: 100vh;
                flex: 0 1 auto;
                overflow: visible;
                background: white;
                order: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .right-panel h3 {
                font-size: 1.5rem;
                margin-bottom: 10px;
            }

            .right-panel > p {
                font-size: 0.9rem;
                margin-bottom: 20px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-control {
                padding: 10px 14px;
                font-size: 16px; /* Prevents zoom on iOS */
                min-height: 44px;
            }

            .form-label {
                font-size: 0.95rem;
            }

            .btn-login,
            .btn-google {
                padding: 12px 20px;
                min-height: 48px;
                font-size: 16px;
                border-radius: 50px;
            }

            .btn-login {
                margin-bottom: 15px;
            }

            .text-center.mt-3 {
                margin-top: 20px !important;
            }

            .text-center.mt-3 a {
                font-size: 0.95rem;
            }
        }

        /* Mobile Portrait - Small phones */
        @media (max-width: 576px) {
            .login-modal {
                padding: 0;
                align-items: flex-start;
                justify-content: flex-start;
            }

            .login-modal .modal-dialog {
                max-height: none;
                height: 100vh;
                margin-top: 0;
            }

            .login-modal .modal-content {
                height: 100vh;
                border-radius: 0;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .login-modal .modal-body {
                overflow: visible;
            }

            /* Left panel stays hidden on mobile */
            .left-panel {
                display: none !important;
            }

            .right-panel {
                padding: 20px 15px;
                flex: 0 1 auto;
                overflow: visible;
                width: 100%;
                background: white;
                display: flex;
                flex-direction: column;
                justify-content: center;
                min-height: 100vh;
            }

            .right-panel h3 {
                font-size: 1.25rem;
                margin-bottom: 6px;
            }

            .right-panel > p {
                font-size: 0.8rem;
                margin-bottom: 12px;
            }

            .form-group {
                margin-bottom: 10px;
            }

            .form-control {
                padding: 9px 11px;
                font-size: 15px;
                min-height: 40px;
                border-radius: 6px;
            }

            .form-label {
                font-size: 0.88rem;
                margin-bottom: 5px;
            }

            .btn-login,
            .btn-google {
                padding: 9px 14px;
                min-height: 40px;
                font-size: 14px;
            }

            .btn-login {
                margin-bottom: 10px;
            }

            .text-center {
                font-size: 0.8rem;
            }

            .text-center.my-3 {
                margin: 10px 0 !important;
            }

            .text-center.mt-3 {
                margin-top: 10px !important;
                margin-bottom: 0;
            }

            .text-center.mt-3 a {
                font-size: 0.85rem;
            }

            .alert {
                padding: 8px 10px;
                font-size: 0.8rem;
                margin-bottom: 10px;
            }
        }

        /* Mobile Landscape Mode */
        @media (max-width: 991.98px) and (orientation: landscape) {
            .login-modal {
                padding: 0;
                align-items: flex-start;
                justify-content: flex-start;
            }

            .login-modal .modal-dialog {
                max-height: none;
                height: 100vh;
            }

            .login-modal .modal-content {
                height: 100vh;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .row.g-0 {
                flex-direction: column;
            }

            /* Hide left panel on landscape too */
            .left-panel {
                display: none !important;
            }

            .right-panel {
                width: 100%;
                min-height: 100vh;
                overflow: visible;
                padding: 20px 15px;
                background: white;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .right-panel h3 {
                font-size: 1.3rem;
                margin-bottom: 10px;
            }

            .right-panel > p {
                font-size: 0.85rem;
                margin-bottom: 15px;
            }

            .form-control {
                padding: 10px 12px;
                font-size: 15px;
                min-height: 42px;
            }

            .btn-login,
            .btn-google {
                padding: 10px 16px;
                min-height: 42px;
                font-size: 14px;
            }
        }

        /* Very Small Phones (iPhone SE, etc) */
        @media (max-width: 400px) {
            .left-panel h1 {
                font-size: 1.1rem;
                flex-direction: column;
            }

            .left-panel p {
                font-size: 0.8rem;
            }

            .right-panel h3 {
                font-size: 1.15rem;
            }

            .form-control,
            .btn-login,
            .btn-google {
                font-size: 14px;
            }
        }

        /* Foldable devices and larger screens */
        @media (min-width: 1024px) {
            body {
                padding: 20px;
            }

            .login-modal .modal-dialog {
                max-height: 90vh;
            }

            .login-modal .modal-content {
                max-height: 90vh;
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
    <style>
        /* Mobile drawer styles for left panel reveal */
        .left-panel.mobile-drawer {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 85%;
            max-width: 420px;
            z-index: 1065;
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            color: #fff;
            transform: translateX(-110%);
            transition: transform 280ms ease;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .left-panel.mobile-drawer.open {
            transform: translateX(0);
        }

        .drawer-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1060;
            opacity: 0;
            pointer-events: none;
            transition: opacity 220ms ease;
        }

        .drawer-backdrop.visible {
            opacity: 1;
            pointer-events: auto;
        }

        /* Prevent body scroll when drawer open */
        body.drawer-open {
            overflow: hidden !important;
            height: 100% !important;
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
        // Enhanced device and orientation detection for login page
        function updateDeviceClasses() {
            const body = document.body;
            const width = window.innerWidth;
            const height = window.innerHeight;
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ||
                           (width <= 768);
            const isPortrait = height > width;

            // Remove existing orientation classes
            body.classList.remove('mobile-device', 'mobile-portrait', 'mobile-landscape');

            // Add appropriate classes
            if (isMobile) {
                body.classList.add('mobile-device');
                if (isPortrait) {
                    body.classList.add('mobile-portrait');
                } else {
                    body.classList.add('mobile-landscape');
                }
                document.documentElement.style.overflow = 'hidden';
                body.style.overflow = 'hidden';
            } else {
                document.documentElement.style.overflow = 'auto';
                body.style.overflow = 'auto';
            }
        }

        // Initial check on page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', updateDeviceClasses);
        } else {
            updateDeviceClasses();
        }

        // Listen for orientation changes
        window.addEventListener('orientationchange', function() {
            setTimeout(updateDeviceClasses, 100);
        });

        // Listen for resize events (important for PWA when soft keyboard appears)
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(updateDeviceClasses, 150);
        });

        // Viewport meta tag adjustment for iOS
        window.addEventListener('load', function() {
            // Ensure proper viewport settings
            let viewport = document.querySelector('meta[name="viewport"]');
            if (!viewport) {
                viewport = document.createElement('meta');
                viewport.name = 'viewport';
                viewport.content = 'width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover';
                document.head.appendChild(viewport);
            }
        });

        // Touch device optimizations
        if ('ontouchstart' in window) {
            document.body.classList.add('touch-device');
        }

        // Handle viewport height changes (soft keyboard on mobile)
        let lastWindowHeight = window.innerHeight;
        window.addEventListener('resize', function() {
            const currentHeight = window.innerHeight;
            const heightDifference = Math.abs(lastWindowHeight - currentHeight);
            
            // Only update if height changed significantly (not just minor oscillations)
            if (heightDifference > 50) {
                lastWindowHeight = currentHeight;
                const modal = document.getElementById('loginModal');
                if (modal) {
                    const modalBody = modal.querySelector('.modal-body');
                    if (modalBody) {
                        modalBody.style.maxHeight = (window.innerHeight - 40) + 'px';
                    }
                }
            }
        });

        // Prevent input zoom on iOS
        document.addEventListener('touchstart', function(e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                e.target.style.fontSize = '16px';
            }
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
    <script>
        // Mobile drawer touch handlers for revealing left panel
        (function() {
            const bodyEl = document.body;
            const leftPanel = document.querySelector('.left-panel');
            if (!leftPanel) return;

            // Make the left panel a mobile drawer when on mobile devices
            function enableDrawerIfMobile() {
                if (!bodyEl.classList.contains('mobile-device')) {
                    leftPanel.classList.remove('mobile-drawer');
                    return;
                }
                leftPanel.classList.add('mobile-drawer');
                // ensure it's hidden initially
                leftPanel.classList.remove('open');
            }

            enableDrawerIfMobile();
            window.addEventListener('resize', enableDrawerIfMobile);
            window.addEventListener('orientationchange', function() { setTimeout(enableDrawerIfMobile, 120); });

            // create backdrop
            let backdrop = document.createElement('div');
            backdrop.className = 'drawer-backdrop';
            document.body.appendChild(backdrop);

            function openDrawer() {
                leftPanel.classList.add('open');
                backdrop.classList.add('visible');
                bodyEl.classList.add('drawer-open');
            }

            function closeDrawer() {
                leftPanel.classList.remove('open');
                backdrop.classList.remove('visible');
                bodyEl.classList.remove('drawer-open');
                leftPanel.style.transform = '';
            }

            backdrop.addEventListener('click', closeDrawer);

            // Touch gesture detection
            let startX = 0;
            let startY = 0;
            let tracking = false;
            let drawerOpen = false;

            document.addEventListener('touchstart', function(e) {
                if (!bodyEl.classList.contains('mobile-device')) return;
                if (e.touches.length !== 1) return;
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
                tracking = true;
                drawerOpen = leftPanel.classList.contains('open');
            }, {passive: true});

            document.addEventListener('touchmove', function(e) {
                if (!tracking) return;
                const touch = e.touches[0];
                const dx = touch.clientX - startX;
                const dy = touch.clientY - startY;

                // ignore vertical scrolls
                if (Math.abs(dy) > Math.abs(dx)) return;

                // If drawer closed and starting near left edge, translate panel with finger
                if (!drawerOpen && startX < 60 && dx > 0) {
                    e.preventDefault();
                    const percent = Math.min(dx / (leftPanel.offsetWidth || window.innerWidth), 1);
                    leftPanel.style.transform = `translateX(${(-1 + percent) * 100}%)`;
                }

                // If drawer open and user drags left, follow finger
                if (drawerOpen && dx < 0) {
                    e.preventDefault();
                    const percent = Math.max(0, 1 + dx / (leftPanel.offsetWidth || window.innerWidth));
                    leftPanel.style.transform = `translateX(${(-1 + percent) * 100}%)`;
                }
            }, {passive: false});

            document.addEventListener('touchend', function(e) {
                if (!tracking) return;
                tracking = false;
                const endX = (e.changedTouches && e.changedTouches[0]) ? e.changedTouches[0].clientX : startX;
                const dx = endX - startX;

                // open if dragged sufficiently right from edge
                if (!drawerOpen && startX < 80 && dx > 80) {
                    openDrawer();
                } else if (!drawerOpen) {
                    // restore closed state
                    leftPanel.style.transform = '';
                }

                // if drawer open and dragged left enough, close it
                if (drawerOpen && dx < -80) {
                    closeDrawer();
                } else if (drawerOpen) {
                    // ensure open class remains
                    leftPanel.style.transform = '';
                }
            });

            // allow closing with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeDrawer();
            });
        })();
    </script>
</body>
</html>
