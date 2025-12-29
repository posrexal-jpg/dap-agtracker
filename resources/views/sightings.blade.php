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
    <title>COTS Sightings - Dap-ag Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }

        #map {
            height: 600px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .hero-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 50px 0;
            text-align: center;
        }

        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand img {
            height: 40px;
            width: auto;
            margin-right: 10px;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 8px;
        }

        .leaflet-popup-content {
            margin: 10px;
        }

        .sighting-info {
            max-width: 250px;
        }

        .sighting-info h6 {
            color: #1e3a8a;
            margin-bottom: 8px;
        }

        .sighting-detail {
            margin-bottom: 4px;
            font-size: 0.9rem;
        }

        .sighting-detail strong {
            color: #374151;
        }

        .cots-marker {
            background: transparent !important;
            border: none !important;
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

        /* Mobile responsive adjustments */
        @media (max-width: 575.98px) {
            #map {
                height: 400px;
            }

            .hero-section {
                padding: 30px 0;
            }

            .stats-card {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Dap-ag Tracker Logo">
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
                        <a class="nav-link active" href="/sightings">COTS Sightings</a>
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

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottom-nav">
        <div class="container-fluid">
            <ul class="navbar-nav d-flex flex-row justify-content-around">
                <li class="nav-item">
                    <a class="nav-link" href="/#about">
                        <i class="fas fa-info-circle"></i>
                        <span>About</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/sightings">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Sightings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#partners">
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
    <section class="hero-section">
        <div class="container">
            <h1>COTS Sightings Map</h1>
            <p>View reported Crown-of-Thorns Starfish (Dap-ag) sightings across monitored areas</p>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="stats-card text-center">
                        <h3 class="text-primary">{{ $locations->count() }}</h3>
                        <p class="mb-0">Total Sightings</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card text-center">
                        <h3 class="text-success">{{ $locations->sum('number_of_cots') }}</h3>
                        <p class="mb-0">Total COTS Count</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card text-center">
                        <h3 class="text-warning">{{ $locations->unique('municipality')->count() }}</h3>
                        <p class="mb-0">Municipalities Affected</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-4">
        <div class="container">
            <div id="map"></div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2025 Dap-ag Tracker. All rights reserved.</p>
            <p>Developed in partnership with DOST and SLSU Bontoc.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Initialize map centered on Philippines
        const map = L.map('map').setView([10.3157, 123.8854], 8);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Custom icon for COTS sightings
        const cotsIcon = L.divIcon({
            className: 'cots-marker',
            html: '<div style="background-color: #dc3545; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
            iconSize: [26, 26],
            iconAnchor: [13, 13]
        });

        // Add markers for each sighting
        @foreach($locations as $location)
        const marker{{ $location->id }} = L.marker([{{ $location->latitude }}, {{ $location->longitude }}], {
            icon: cotsIcon
        }).addTo(map);

        // Create popup content
        const popupContent{{ $location->id }} = `
            <div class="sighting-info">
                <h6><i class="fas fa-map-marker-alt text-danger"></i> COTS Sighting</h6>
                <div class="sighting-detail"><strong>Location:</strong> {{ $location->name }}</div>
                <div class="sighting-detail"><strong>Municipality:</strong> {{ $location->municipality }}</div>
                <div class="sighting-detail"><strong>Barangay:</strong> {{ $location->barangay }}</div>
                <div class="sighting-detail"><strong>COTS Count:</strong> {{ $location->number_of_cots }}</div>
                @if($location->early_juvenile || $location->juvenile || $location->sub_adult || $location->adult)
                <div class="sighting-detail"><strong>Size Distribution:</strong></div>
                <div style="font-size: 0.8rem; margin-left: 10px;">
                    @if($location->early_juvenile) Early Juvenile: {{ $location->early_juvenile }}<br>@endif
                    @if($location->juvenile) Juvenile: {{ $location->juvenile }}<br>@endif
                    @if($location->sub_adult) Sub-adult: {{ $location->sub_adult }}<br>@endif
                    @if($location->adult) Adult: {{ $location->adult }}<br>@endif
                </div>
                @endif
                <div class="sighting-detail"><strong>Activity:</strong> {{ $location->activity_type ?: 'Not specified' }}</div>
                <div class="sighting-detail"><strong>Observer:</strong> {{ $location->observer_category ?: 'Not specified' }}</div>
                <div class="sighting-detail"><strong>Date:</strong> {{ $location->date_of_sighting ? \Carbon\Carbon::parse($location->date_of_sighting)->format('M d, Y') : 'Not specified' }}</div>
                <div class="sighting-detail"><strong>Time:</strong> {{ $location->time_of_sighting ?: 'Not specified' }}</div>
                @if($location->description)
                <div class="sighting-detail"><strong>Description:</strong> {{ $location->description }}</div>
                @endif
            </div>
        `;

        marker{{ $location->id }}.bindPopup(popupContent{{ $location->id }});
        @endforeach

        // Fit map to show all markers
        @if($locations->count() > 0)
        const group = new L.featureGroup([
            @foreach($locations as $location)
            L.marker([{{ $location->latitude }}, {{ $location->longitude }}]),
            @endforeach
        ]);
        map.fitBounds(group.getBounds().pad(0.1));
        @endif
    </script>

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

        // Mobile bottom navigation active state management
        document.addEventListener('DOMContentLoaded', function() {
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