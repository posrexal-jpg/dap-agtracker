<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1e3a8a" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="apple-mobile-web-app-title" content="COTS Tracker" />
    <link rel="manifest" href="/manifest.json" />
    <link rel="apple-touch-icon" href="/images/logo.png" />
    <title>COTS Sightings - COTS Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }

        #map {
            height: 100vh;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
        }

        body {
            overflow: hidden;
        }

        .top-overlay {
            position: fixed;
            top: 56px;
            left: 0;
            right: 0;
            z-index: 1020;
        }

        .hero-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 10px 0;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .hero-logo {
            display: none;
        }

        @media (min-width: 768px) {
            .hero-logo {
                display: block;
            }

            .hero-logo img {
                height: 50px;
                width: auto;
            }
        }

        .hero-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .stats-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .stats-toggle {
            width: 100%;
            background: rgba(255,255,255,0.95);
            border: none;
            border-bottom: 1px solid rgba(0,0,0,0.07);
            padding: 5px 12px;
            font-size: 0.75rem;
            color: #1e3a8a;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            z-index: 1022;
        }

        .stats-body {
            overflow: hidden;
            transition: max-height 0.3s ease;
            max-height: 200px;
        }

        .stats-body.collapsed {
            max-height: 0;
        }

        .stats-card {
            background: transparent;
            border-radius: 6px;
            padding: 8px 10px;
            margin: 0;
            box-shadow: none;
        }

        .map-section {
            width: 100%;
            height: 100vh;
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

        /* Pulse animation for outbreak markers (red) */
        @keyframes pulseOutbreak {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(220, 53, 69, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }

        .marker-outbreak {
            animation: pulseOutbreak 2s infinite;
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
            .top-overlay {
                top: 0;
            }

            .hero-section {
                padding: 6px 0;
            }

            .hero-section h1 {
                font-size: 1.1rem;
                margin: 0;
            }

            .hero-section p {
                font-size: 0.75rem;
                margin: 2px 0 0 0;
                width: 257px;
            }

            .stats-card {
                padding: 4px 8px;
            }

            .stats-card h3 {
                font-size: 1rem;
                margin: 0;
            }

            .stats-card p {
                font-size: 0.7rem;
                margin: 1px 0 0 0;
            }
        }

        @media (min-width: 576px) {
            .hero-section h1 {
                font-size: 1.5rem;
                margin: 0;
            }

            .hero-section p {
                font-size: 0.9rem;
                margin: 4px 0 0 0;
            }
        }

        /* Navbar z-index */
        .navbar {
            z-index: 1019;
        }

        /* Footer overlay styling on mobile */
        footer {
            position: relative;
            z-index: 1000;
        }

        /* Custom circle icon styling - remove default divIcon background */
        .custom-circle-icon {
            background: transparent !important;
            border: none !important;
        }

        .marker-outbreak {
            animation: pulseOutbreak 2s infinite;
            border-radius: 50%;
        }

        @keyframes pulseOutbreak {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(220, 53, 69, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="COTS Tracker Logo">
                COTS Tracker
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

    <!-- Top Overlay: Hero + Stats stacked -->
    <div class="top-overlay">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-logo">
            <img src="{{ asset('images/logo.png') }}" alt="COTS Tracker Logo">
        </div>
        <div class="hero-content">
            <h1>COTS Sightings Map</h1>
            <p>View reported Crown-of-Thorns Starfish (Dap-ag) sightings across monitored areas</p>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <button class="stats-toggle" id="statsToggle" onclick="toggleStats()">
            <span id="statsToggleLabel">&#9650; Statistics</span>
        </button>
        <div class="stats-body" id="statsBody">
        <div class="container-fluid" style="padding: 6px 0;">
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="stats-card text-center">
                        <h3 class="text-primary" style="margin: 0;">{{ $locations->count() }}</h3>
                        <p class="mb-0" style="font-size: 0.9rem;">Total Sightings</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card text-center">
                        <h3 class="text-success" style="margin: 0;">{{ $locations->sum('number_of_cots') }}</h3>
                        <p class="mb-0" style="font-size: 0.9rem;">Total COTS Count</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card text-center">
                        <h3 class="text-warning" style="margin: 0;">{{ $locations->unique('municipality')->count() }}</h3>
                        <p class="mb-0" style="font-size: 0.9rem;">Municipalities Affected</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    </div><!-- /.top-overlay -->

    <!-- Map Section -->
    <section class="map-section">
        <div id="map"></div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2025 COTS Tracker. All rights reserved.</p>
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

        // Function to create circle SVG icon using divIcon (more reliable on mobile)
        const outbreakThreshold = {{ $outbreakThreshold ?? 15 }};

        function createCircleIcon(color) {
            const svg = `
                <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="16" cy="16" r="12" fill="${color}" stroke="white" stroke-width="3"/>
                    <ellipse cx="16" cy="28" rx="10" ry="2" fill="rgba(0,0,0,0.15)"/>
                </svg>
            `;
            return L.divIcon({
                html: svg,
                className: 'custom-circle-icon',
                iconSize: [32, 32],
                iconAnchor: [16, 16],
                popupAnchor: [0, -16]
            });
        }

        // Add markers for each sighting
        @foreach($locations as $location)
        @if($location->latitude && $location->longitude)
        // Determine marker color based on COTS count
        const cotsCount{{ $location->id }} = {{ $location->number_of_cots ?? 0 }};
        const markerColor{{ $location->id }} = cotsCount{{ $location->id }} >= outbreakThreshold ? '#dc3545' : '#28a745';
        const isOutbreak{{ $location->id }} = cotsCount{{ $location->id }} >= outbreakThreshold;
        
        const marker{{ $location->id }}Icon = createCircleIcon(markerColor{{ $location->id }});

        const marker{{ $location->id }} = L.marker([{{ $location->latitude }}, {{ $location->longitude }}], {
            icon: marker{{ $location->id }}Icon
        }).addTo(map);

        // Add pulse class to marker element if outbreak
        if (isOutbreak{{ $location->id }}) {
            marker{{ $location->id }}._icon.classList.add('marker-outbreak');
        }

        // Create popup content
        const popupContent{{ $location->id }} =
            '<div class="sighting-info">' +
            '<h6><i class="fas fa-map-marker-alt text-danger"></i> COTS Sighting</h6>' +
            '<div class="sighting-detail"><strong>Location:</strong> ' + @json($location->location_name ?: 'Not specified') + '</div>' +
            '<div class="sighting-detail"><strong>Municipality:</strong> ' + @json($location->municipality ?: 'Not specified') + '</div>' +
            '<div class="sighting-detail"><strong>Barangay:</strong> ' + @json($location->barangay ?: 'Not specified') + '</div>' +
            '<div class="sighting-detail"><strong>COTS Count:</strong> {{ $location->number_of_cots ?? 0 }}</div>' +
            '<div class="sighting-detail"><strong>Date:</strong> {{ $location->date_of_sighting ? \Carbon\Carbon::parse($location->date_of_sighting)->format("M d, Y") : "Not specified" }}</div>' +
            '<div class="sighting-detail"><strong>Time:</strong> {{ $location->time_of_sighting ? \Carbon\Carbon::parse("1970-01-01 " . $location->time_of_sighting)->format("g:i A") : "Not specified" }}</div>' +
            '</div>';

        marker{{ $location->id }}.bindPopup(popupContent{{ $location->id }});
        @endif
        @endforeach

        // Fit map to show all markers
        @if($locations->where('latitude', '!=', null)->where('longitude', '!=', null)->count() > 0)
        const group = new L.featureGroup([
            @foreach($locations->whereNotNull('latitude')->whereNotNull('longitude') as $location)
            L.marker([{{ $location->latitude }}, {{ $location->longitude }}]),
            @endforeach
        ]);
        map.fitBounds(group.getBounds().pad(0.1));
        @endif
    </script>

    <!-- Device Detection and Mobile Optimization -->
    <script>
        // Stats toggle
        function toggleStats() {
            const body = document.getElementById('statsBody');
            const label = document.getElementById('statsToggleLabel');
            const collapsed = body.classList.toggle('collapsed');
            label.innerHTML = collapsed ? '&#9660; Statistics' : '&#9650; Statistics';
        }

        // Collapse stats by default on mobile
        (function() {
            const isMobile = window.innerWidth <= 768;
            if (isMobile) {
                const body = document.getElementById('statsBody');
                const label = document.getElementById('statsToggleLabel');
                if (body) body.classList.add('collapsed');
                if (label) label.innerHTML = '&#9660; Statistics';
            }
        })();

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