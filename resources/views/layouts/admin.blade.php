<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">
    <title>@yield('title', 'Admin Dashboard - COTS Tracker')</title>
    <meta name="description" content="COTS Tracker Admin Dashboard - Monitor and manage Crown-of-Thorns Starfish sightings">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- API Token for PWA -->
    <meta name="api-token" content="{{ Auth::check() ? Auth::user()->currentAccessToken()?->plainTextToken : '' }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.74.0/dist/L.Control.Locate.min.css">

    <!-- Custom CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/css/mobile-menu.css'])

    @stack('styles')

    <style>
        /* Base Layout Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background: #f8fafc;
        }

        /* Layout Wrapper - matches user layout */
        .layout-wrapper {
            display: flex;
            flex-direction: row;
            min-height: 100vh;
            width: 100%;
        }

        .layout-container {
            display: flex;
            flex: 1;
            min-height: 100vh;
        }

        .layout-page {
            flex: 1;
            margin-left: 280px;
            min-width: 0;
            display: flex;
            flex-direction: column;
            background: #f8fafc;
        }

        .layout-page main {
            flex: 1;
            padding: 2rem;
        }

        /* Mobile Responsive */
        @media (max-width: 1199.98px) {
            .layout-page {
                margin-left: 0;
                width: 100%;
            }

            .layout-wrapper {
                flex-direction: column;
            }
        }

        /* Ensure content is always above mobile menu */
        @media (max-width: 991px) {
            body {
                padding-bottom: 80px; /* Space for mobile menu */
            }

            .layout-page main {
                padding: 1rem;
                padding-bottom: 100px; /* Extra space for mobile menu */
            }
        }

        /* Print Styles */
        @media print {
            .admin-sidebar,
            .sidebar-overlay,
            .mobile-horizontal-menu {
                display: none !important;
            }

            .layout-page {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="admin-page">
<!-- Page Content -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container d-flex flex-row">
        @if(auth()->check() && auth()->user()->isAdmin())
            <aside class="d-none d-lg-block">
                @include('admin.menu')
            </aside>
        @endif
        <div class="layout-page flex-grow-1 d-flex flex-column">
            <main class="py-4 flex-grow-1 d-flex flex-column">
                @yield('content')
            </main>
        </div>
    </div>
</div>

<!-- Layout overlay for mobile menu -->
<div class="layout-overlay"></div>

<!-- Mobile Menu -->
@include('components.mobile-menu')

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.74.0/dist/L.Control.Locate.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript (Vite) -->
@vite(['resources/js/app.js', 'resources/js/mobile-menu.js', 'resources/js/service-worker.js'])

@stack('scripts')

</body>
</html>