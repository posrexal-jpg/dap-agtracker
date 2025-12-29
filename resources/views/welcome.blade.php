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
    <title>Dap-ag Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }

        /* Device and Orientation Detection */
        .mobile-device {
            /* Mobile-specific styles will be applied via JavaScript */
        }

        .mobile-portrait {
            /* Portrait orientation styles */
        }

        .mobile-landscape {
            /* Landscape orientation styles */
        }

        /* Base Hero Styles */
        .hero {
            position: relative;
            padding: 100px 0;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e3a8ac8 0%, #000000c8 100%);
            z-index: -1;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn-download {
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            border: none;
            padding: 15px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            color: white !important;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
            transition: all 0.3s ease;
        }

        .btn-download:hover {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
        }

        .hero-buttons {
            margin-top: 2rem;
        }

        .hero-buttons .btn {
            margin: 0 10px 10px 0;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: 2px solid;
        }

        .hero-buttons .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.8) !important;
            color: white !important;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .hero-buttons .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: white !important;
            transform: translateY(-2px);
        }

        .hero-buttons .btn-light {
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(255, 255, 255, 0.9);
            color: #1e3a8a !important;
        }

        .hero-buttons .btn-light:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Mobile Bottom Navigation */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding: 8px 0;
            z-index: 1030;
            display: none;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }

        .mobile-bottom-nav .nav-item {
            flex: 1;
            text-align: center;
        }

        .mobile-bottom-nav .nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px 4px;
            color: #64748b !important;
            font-size: 0.75rem;
            text-decoration: none;
            transition: all 0.3s ease;
            min-height: 56px;
            border-radius: 8px;
            margin: 0 2px;
        }

        .mobile-bottom-nav .nav-link i {
            font-size: 1.2rem;
            margin-bottom: 4px;
            display: block;
        }

        .mobile-bottom-nav .nav-link:hover,
        .mobile-bottom-nav .nav-link.active {
            color: #1e3a8a !important;
            background: rgba(30, 58, 138, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(30, 58, 138, 0.2);
        }

        .mobile-bottom-nav .nav-link:active {
            transform: scale(0.95);
        }

        /* Hide regular navbar on mobile */
        .mobile-device .navbar {
            display: none;
        }

        .mobile-device .mobile-bottom-nav {
            display: flex;
        }

        /* Adjust body padding for bottom nav */
        .mobile-device {
            padding-bottom: 80px;
        }

        /* Sections */
        .description {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .description h2 {
            margin-bottom: 30px;
            font-weight: 700;
            color: #1e3a8a;
            position: relative;
        }

        .description h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            border-radius: 2px;
        }

        .description ul {
            list-style: none;
            padding: 0;
        }

        .description li {
            margin-bottom: 15px;
            padding-left: 30px;
            position: relative;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .description li::before {
            content: '🐠';
            position: absolute;
            left: 0;
            top: 0;
            font-size: 1.2rem;
        }

        .partners {
            padding: 80px 0;
            background: white;
        }

        .partners h2 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .logo {
            max-width: 120px;
            height: auto;
            margin: 20px 0;
            filter: grayscale(20%);
            transition: all 0.3s ease;
        }

        .logo:hover {
            filter: grayscale(0%) brightness(1.1);
            transform: scale(1.05);
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e3a8a;
            text-align: center;
            margin-bottom: 1rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #64748b;
            text-align: center;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        }

        .feature-card h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: #64748b;
            line-height: 1.6;
            margin: 0;
        }

        .footer {
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .footer p {
            margin: 0;
            font-size: 0.95rem;
        }

        /* Mobile-First Responsive Design */
        /* Extra small devices (phones, < 576px) */
        @media (max-width: 575.98px) {
            .hero {
                padding: 60px 0;
                min-height: 100vh;
            }

            .hero h1 {
                font-size: 2.2rem;
                margin-bottom: 1rem;
            }

            .hero p {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }

            .btn-download {
                padding: 12px 24px;
                font-size: 1rem;
                width: 100%;
                max-width: 280px;
            }

            .hero-buttons {
                margin-top: 1.5rem;
            }

            .hero-buttons .btn {
                display: block;
                width: 100%;
                max-width: 280px;
                margin: 0 auto 10px auto;
                padding: 12px 20px;
                font-size: 0.9rem;
            }

            .navbar-brand img {
                height: 32px;
            }

            .description {
                padding: 60px 0;
            }

            .description h2 {
                font-size: 1.8rem;
                margin-bottom: 25px;
            }

            .description li {
                font-size: 1rem;
                padding-left: 35px;
            }

            .partners {
                padding: 60px 0;
            }

            .partners h2 {
                font-size: 1.8rem;
            }

            .features {
                padding: 60px 0;
            }

            .section-title {
                font-size: 2rem;
            }

            .section-subtitle {
                font-size: 1rem;
                margin-bottom: 2rem;
            }

            .feature-card {
                padding: 1.5rem;
                margin-bottom: 1rem;
            }

            .feature-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            .feature-card h3 {
                font-size: 1.1rem;
            }

            .logo {
                max-width: 80px;
            }

            .footer {
                padding: 30px 0;
            }
        }

        /* Small devices (phones, 576px - 767px) */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .btn-download {
                padding: 14px 28px;
                font-size: 1.05rem;
            }

            .hero-buttons .btn {
                padding: 12px 22px;
                font-size: 0.95rem;
            }

            .description h2 {
                font-size: 2rem;
            }

            .partners h2 {
                font-size: 2rem;
            }
        }

        /* Medium devices (tablets, 768px - 991px) */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .hero h1 {
                font-size: 2.8rem;
            }

            .hero p {
                font-size: 1.15rem;
            }

            .description h2 {
                font-size: 2.2rem;
            }

            .partners h2 {
                font-size: 2.2rem;
            }
        }

        /* Orientation-specific styles */
        @media (orientation: landscape) and (max-height: 500px) {
            .hero {
                padding: 40px 0;
                min-height: auto;
            }

            .hero h1 {
                font-size: 2rem;
                margin-bottom: 0.5rem;
            }

            .hero p {
                font-size: 1rem;
                margin-bottom: 1rem;
            }

            .btn-download {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .hero-buttons {
                margin-top: 1rem;
            }

            .hero-buttons .btn {
                padding: 8px 16px;
                font-size: 0.8rem;
                margin-right: 5px;
            }
        }

        /* Touch device optimizations */
        @media (pointer: coarse) {
            .btn-download,
            .hero-buttons .btn {
                min-height: 48px;
                padding: 12px 24px;
            }

            .navbar-brand,
            .nav-link {
                padding: 12px 16px;
                min-height: 48px;
                display: flex;
                align-items: center;
            }
        }

        /* High DPI displays */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .hero h1 {
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            }

            .logo {
                image-rendering: -webkit-optimize-contrast;
                image-rendering: crisp-edges;
            }
        }

        /* Mobile Bottom Navigation Landscape Adjustments */
        .mobile-landscape .mobile-bottom-nav {
            padding: 4px 0;
        }

        .mobile-landscape .mobile-bottom-nav .nav-link {
            padding: 6px 2px;
            font-size: 0.7rem;
            min-height: 48px;
        }

        .mobile-landscape .mobile-bottom-nav .nav-link i {
            font-size: 1rem;
            margin-bottom: 2px;
        }

        .mobile-landscape {
            padding-bottom: 70px;
        }

        /* Touch device optimizations for bottom nav */
        .touch-device .mobile-bottom-nav .nav-link {
            min-height: 60px;
        }

        .touch-device .mobile-bottom-nav .nav-link:active {
            background: rgba(30, 58, 138, 0.2);
        }

        /* Orientation-specific adjustments */
        .mobile-landscape .hero {
            padding: 40px 0;
            min-height: 80vh;
        }

        .mobile-landscape .hero h1 {
            font-size: 1.8rem;
        }

        .mobile-landscape .hero p {
            font-size: 0.9rem;
        }

        .mobile-landscape .features {
            padding: 40px 0;
        }

        .mobile-landscape .section-title {
            font-size: 1.8rem;
        }

        .mobile-landscape .feature-card {
            padding: 1rem;
        }

        /* Material Design inspired animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Mobile-specific icon changes */
        .mobile-device .fas {
            font-size: 1.2em;
        }

        .mobile-device .hero-buttons .btn i {
            margin-right: 8px;
        }

        /* Flutter-like design elements */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Dap-ag Tracker Logo" style="height: 40px; width: auto; margin-right: 10px;">
                Dap-ag Tracker
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/sightings">COTS Sightings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#partners">Partners</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottom-nav">
        <div class="container-fluid">
            <ul class="navbar-nav d-flex flex-row justify-content-around">
                <li class="nav-item">
                    <a class="nav-link" href="#about">
                        <i class="fas fa-info-circle"></i>
                        <span>About</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/sightings">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Sightings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#partners">
                        <i class="fas fa-handshake"></i>
                        <span>Partners</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/login">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <video autoplay muted loop class="hero-video">
            <source src="{{ asset('videos/background-video.mp4') }}" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content fade-in-up">
            <h1>Welcome to Dap-ag Tracker</h1>
            <p>Monitor and track Crown-of-Thorns Starfish (COTS), locally known as Dap-ag, infestations to protect our coral reefs. Join us in preserving marine biodiversity.</p>
            <a href="/download" class="btn btn-download btn-lg">
                <i class="fas fa-mobile-alt"></i> Install App
            </a>
            <div class="hero-buttons">
                <p class="mb-3">Ready to join the reef rescue squad?</p>
                <a href="/login" class="btn btn-light btn-lg">
                    <i class="fas fa-eye"></i>&nbsp; Start Monitoring &nbsp;<span style="opacity:0.6">|</span>&nbsp; <i class="fas fa-exclamation-triangle"></i>&nbsp; Report an Outbreak
                </a>
            </div>
        </div>
    </section>

    <!-- Features section removed per request -->

    <!-- Description Section -->
    <section class="description" id="about">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>About the App</h2>
                    <p>The Dap-ag (COTS) Tracker is a mobile application designed to help researchers, conservationists, and the public monitor and report sightings of Crown-of-Thorns Starfish (COTS), locally known as Dap-ag. This invasive species poses a significant threat to coral reefs worldwide.</p>
                    <p>Our app allows users to:</p>
                    <ul>
                        <li>Report COTS (Dap-ag) sightings with GPS coordinates</li>
                        <li>View infestation maps</li>
                        <li>Access educational resources</li>
                        <li>Contribute to scientific research</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('images/cots-image.jpg') }}" alt="Crown of Thorns Starfish" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners" id="partners">
        <div class="container text-center">
            <h2>Partner Agencies</h2>
            <p>We collaborate with leading organizations to advance marine conservation efforts.</p>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <img src="{{ asset('images/dost-logo.png') }}" alt="DOST Logo" class="logo">
                    <p>Department of Science and Technology</p>
                </div>
                <div class="col-md-3">
                    <img src="{{ asset('images/slsu-logo.png') }}" alt="SLSU Bontoc Logo" class="logo">
                    <p>Southern Leyte State University - Bontoc</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Dap-ag Tracker. All rights reserved.</p>
            <p>Developed in partnership with DOST and SLSU Bontoc.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Device Detection and Mobile Optimization -->
    <script>
        // Device and orientation detection
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

        // Add staggered animation delays for feature cards
        document.addEventListener('DOMContentLoaded', function() {
            const featureCards = document.querySelectorAll('.feature-card');
            featureCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });

            // Mobile bottom navigation active state management
            const mobileNavLinks = document.querySelectorAll('.mobile-bottom-nav .nav-link');
            const currentPath = window.location.pathname;

            mobileNavLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPath || (href.startsWith('#') && currentPath === '/')) {
                    link.classList.add('active');
                }
            });

            // Smooth scrolling for anchor links in mobile bottom nav
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href.startsWith('#')) {
                        e.preventDefault();
                        const target = document.querySelector(href);
                        if (target) {
                            const offset = 20; // Small offset from top
                            const targetPosition = target.offsetTop - offset;
                            window.scrollTo({
                                top: targetPosition,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            });

            // Smooth scrolling for navbar anchor links
            const navbarLinks = document.querySelectorAll('.navbar-nav .nav-link');
            navbarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href.startsWith('#')) {
                        e.preventDefault();
                        const target = document.querySelector(href);
                        if (target) {
                            const offset = 80; // Account for navbar height
                            const targetPosition = target.offsetTop - offset;
                            window.scrollTo({
                                top: targetPosition,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            });
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