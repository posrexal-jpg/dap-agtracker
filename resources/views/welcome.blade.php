<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1e3a8a" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="apple-mobile-web-app-title" content="Dag-ag Tracker" />
    <link rel="manifest" href="/manifest.json" />
    <link rel="apple-touch-icon" href="/images/logo.png" />
    <title>Dag-ag Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }
        .hero {
            position: relative;
            padding: 100px 0;
            overflow: hidden;
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
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
        }
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        .btn-download {
            background-color: #60a5fa;
            border: none;
            padding: 15px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            color: white !important;
        }
        .btn-download:hover {
            background-color: #3b82f6;
        }
        .partners {
            padding: 50px 0;
            background-color: #f8f9fa;
        }
        .partners h2 {
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
            height: auto;
        }
        .description {
            padding: 50px 0;
        }
        .description h2 {
            margin-bottom: 20px;
        }
        .footer {
            background-color: #000000;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Dag-ag Tracker Logo" style="height: 40px; width: auto; margin-right: 10px;">
                Dag-ag Tracker
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
                        <a class="nav-link" href="#partners">Partners</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <video autoplay muted loop class="hero-video">
            <source src="{{ asset('videos/background-video.mp4') }}" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Welcome to Dag-ag Tracker</h1>
            <p>Monitor and track Crown-of-Thorns Starfish (COTS), locally known as Dap-ag, infestations to protect our coral reefs. Join us in preserving marine biodiversity.</p>
            <a href="/download" class="btn btn-download btn-lg">
                <i class="fas fa-download"></i> Download App
            </a>
            <div class="mt-4">
                <p class="mb-3">Ready to join the reef rescue squad?</p>
                <a href="/login" class="btn btn-outline-light me-2">
                    <i class="fas fa-eye"></i> Start Monitoring
                </a>
                <a href="/login" class="btn btn-light">
                    <i class="fas fa-exclamation-triangle"></i> Report an Outbreak
                </a>
            </div>
        </div>
    </section>

    <!-- Description Section -->
    <section class="description" id="about">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>About the App</h2>
                    <p>The Dag-ag (COTS) Tracker is a mobile application designed to help researchers, conservationists, and the public monitor and report sightings of Crown-of-Thorns Starfish (COTS), locally known as Dap-ag. This invasive species poses a significant threat to coral reefs worldwide.</p>
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
            <p>&copy; 2025 Dag-ag Tracker. All rights reserved.</p>
            <p>Developed in partnership with DOST and SLSU Bontoc.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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