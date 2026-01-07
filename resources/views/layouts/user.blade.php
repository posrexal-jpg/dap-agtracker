<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/')}}" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>@yield('title', 'Dap-ag Tracker')</title>
    <meta name="description" content="" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- API Token for PWA -->
    <meta name="api-token" content="{{ Auth::check() ? Auth::user()->currentAccessToken()?->plainTextToken : '' }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png')}}" />

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.74.0/dist/L.Control.Locate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.74.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Leaflet Awesome Markers -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.awesome-markers/2.0.4/leaflet.awesome-markers.js"></script>    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.awesome-markers/2.0.4/leaflet.awesome-markers.css" />
 


    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js')}}"></script>
    <script src="{{ asset('assets/js/main.js')}}"></script>

    <!-- Config -->
    <script src="{{ asset('assets/js/config.js')}}"></script>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/mobile-menu.css') }}" />

    <!-- Professional User Pages Styling -->
    <style>
        /* Sidebar fixed, content scrollable, clear separation, prevent horizontal scroll */
        html, body {
            width: 100vw;
            max-width: 100vw;
            overflow-x: hidden;
        }
        .layout-wrapper {
            display: flex;
            flex-direction: row;
            width: 100vw;
            min-height: 100vh;
            background: #f8fafc;
            overflow-x: hidden;
        }
        .user-sidebar {
            width: 280px;
            min-width: 280px;
            max-width: 280px;
            flex-shrink: 0;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1001;
            box-shadow: 2px 0 8px rgba(0,0,0,0.04);
            background: #fff;
            border-right: 1px solid #e5e7eb;
            overflow-x: hidden;
        }
        .layout-container {
            display: flex;
            flex-direction: row;
            width: 100vw;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .layout-page {
            flex: 1 1 0%;
            min-width: 0;
            margin-left: 280px;
            display: flex;
            flex-direction: column;
            background: #f8fafc;
            min-height: 100vh;
            position: relative;
            z-index: 1;
            max-width: calc(100vw - 280px);
            overflow-x: hidden;
        }
        /* Offset content to account for fixed navbar height */
        :root { --navbar-height: 64px; }
        .layout-page { padding-top: var(--navbar-height); }
        .layout-page main {
            flex: 1 1 0%;
            min-width: 0;
            padding: 2rem 2vw 2rem 2vw !important;
            overflow-x: hidden;
            overflow-y: auto;
            background: transparent;
            max-width: 100%;
        }
        @media (max-width: 1199.98px) {
            .user-sidebar {
                position: fixed;
                left: 0;
                top: 0;
                width: 100vw;
                min-width: 0;
                max-width: 100vw;
                height: auto;
                z-index: 1001;
            }
            .layout-page {
                margin-left: 0;
                min-width: 0;
                width: 100vw;
                max-width: 100vw;
            }
            .layout-container {
                flex-direction: column;
                overflow-x: hidden;
            }
        }
        /* Fullscreen map mode for sightings page: show top navbar and keep modals above map */
        body.map-fullscreen {
            overflow: hidden;
        }
        body.map-fullscreen #layout-navbar {
            display: block !important;
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            z-index: 2147483647 !important;
        }
        body.map-fullscreen .user-sidebar {
            display: none !important;
        }
        body.map-fullscreen .layout-page {
            margin-left: 0 !important;
            padding-top: 0 !important;
        }
        body.map-fullscreen #map {
            position: fixed !important;
            top: var(--navbar-height) !important;
            left: 0 !important;
            width: 100vw !important;
            height: calc(100vh - var(--navbar-height)) !important;
            z-index: 2147483645 !important;
        }
        /* Ensure modals always appear in front of all page elements */
        /* Backdrop should sit above the map but below the modal. Use very large
           z-index values to ensure the modal is always in front of the map. */
        .modal-backdrop {
            z-index: 2147483646 !important;
            background-color: rgba(0,0,0,0.65) !important;
            opacity: 1 !important;
        }
        .modal {
            z-index: 2147483647 !important;
        }
        /* Map-fullscreen specific: backdrop sits between the map and modal */
        /* On the fullscreen map page we remove the backdrop so the map stays
           fully interactive while the modal is open. */
        body.map-fullscreen .modal-backdrop {
            display: none !important;
            z-index: 0 !important;
            background-color: transparent !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }
        /* Place modals below the fixed top navbar on fullscreen map pages */
        body.map-fullscreen .modal {
            /* ensure navbar stays above modals */
            z-index: 2147483646 !important;
        }
        body.map-fullscreen .modal.show {
            position: fixed !important;
            top: calc(var(--navbar-height) + -24px) !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            margin: 0 !important;
            max-height: calc(100vh - var(--navbar-height) - 28px) !important;
        }
        body.map-fullscreen .modal .modal-dialog {
            margin: 0 auto !important;
            width: min(920px, 95vw) !important;
            max-height: calc(100vh - var(--navbar-height) - 64px) !important;
        }
        /* Consent modal should also appear below the navbar */
        body.map-fullscreen #consentModal {
            z-index: 2147483646 !important;
        }
        body.map-fullscreen .modal {
            z-index: 2147483647 !important;
        }
        /* Consent modal highest priority */
        #consentModal {
            z-index: 2147483649 !important;
        }
        #consentModal + .modal-backdrop {
            z-index: 2147483648 !important;
        }

        /* Ensure modals are fixed and perfectly centered on screen and that
           modal content uses flex so body can scroll while footer stays visible. */
        .modal.show {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            margin: 0 !important;
            pointer-events: auto !important;
            padding: 16px; /* keep small gap on very small screens */
        }
        .modal .modal-dialog {
            max-width: 920px;
            width: min(920px, 95vw);
            max-height: calc(100vh - 120px);
            display: flex;
            flex-direction: column;
            margin: 0;
        }
        .modal .modal-content {
            display: flex;
            flex-direction: column;
            max-height: inherit;
            overflow: hidden;
        }
        .modal .modal-body {
            overflow: auto;
            flex: 1 1 auto;
            padding: 20px 24px;
        }
        .modal .modal-footer {
            flex-shrink: 0;
            padding: 12px 20px;
        }
    </style>
</head>
<body class="{{ Route::is('admin.*') ? 'admin-page' : '' }} {{ Route::is('user.sightings-map') ? 'map-fullscreen' : '' }}">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top border-bottom" id="layout-navbar">
    <div class="container-xxl">
        <div class="layout-menu-toggle d-xl-none d-lg-none me-3">
            <i class="bx bx-menu bx-sm text-primary"></i>
        </div>

        <!-- Navbar brand for mobile - professional app style -->
        <a class="navbar-brand d-lg-none d-flex align-items-center justify-content-start" href="{{ route('user.dashboard') }}" style="margin: 0;">
            <img src="{{ asset('images/logo.png') }}" alt="COTS Tracker Logo" style="height: 36px; width: auto;">
            <span class="fw-bold text-white" style="font-size: 0.85rem; letter-spacing: 0.5px; margin-left: 0.5rem; white-space: nowrap;">COTS</span>
        </a>

        <button class="navbar-toggler d-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContentPage1" aria-controls="navbarContentPage1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContentPage1">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a href="{{ route('user.dashboard') }}" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.sightings-map') }}" class="nav-link">Sightings Map</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.account') }}" class="nav-link">My Account</a>
                </li>
                <li class="nav-item d-none d-lg-block">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Logout">
                            <i class="bx bx-log-out"></i>
                            <span class="d-none d-lg-inline ms-1">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
 
<!-- Page Content -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container d-flex flex-row" style="min-height: 100vh;">
        @if(auth()->check() && auth()->user()->role)
            <aside class="d-block d-lg-none">
                @include('user.menu')
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

@include('components.mobile-menu')

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript -->
<script src="{{ asset('js/mobile-menu.js') }}"></script>
<script src="{{ asset('js/service-worker.js') }}"></script>

</body>
</html>