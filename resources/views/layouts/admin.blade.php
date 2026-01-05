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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.74.0/dist/L.Control.Locate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.74.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

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
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/mobile-menu.css') }}" />



    <!-- Professional Admin Pages Styling -->
</head>
<body class="admin-page">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top border-bottom" id="layout-navbar">
    <div class="container-xxl">
        <div class="layout-menu-toggle d-xl-none d-lg-none me-3">
            <i class="bx bx-menu bx-sm text-primary"></i>
        </div>

        <!-- Navbar brand for mobile -->
        <a class="navbar-brand d-lg-none" href="{{ route('admin.index') }}">
            <img src="{{ asset('images/logo.png') }}" alt="COTS Tracker Logo" style="height: 30px; width: auto;">
        </a>

        <button class="navbar-toggler d-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContentPage1" aria-controls="navbarContentPage1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContentPage1">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item d-block d-lg-none">
                    <span class="navbar-text fw-semibold text-dark me-3">
                        {{ Auth::check() && Auth::user()->role ? Auth::user()->role->role_name : 'User' }}
                    </span>
                </li>
                <li class="nav-item">
                    <span class="navbar-text fw-semibold text-dark me-3 d-none d-lg-inline">
                        {{ Auth::check() && Auth::user()->role ? Auth::user()->role->role_name : 'User' }}
                    </span>
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
    <div class="layout-container">
        @include('admin.menu')

        <div class="layout-page">
            <main class="py-4">
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

<!-- Mobile navbar position handler for admin layout -->
<script>
    (function() {
        function updateNavbarPosition() {
            const body = document.body;
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || window.innerWidth <= 768;
            const isSmall = window.innerWidth <= 768;
            if (isMobile && isSmall) {
                body.classList.add('mobile-bottom-navbar');
            } else {
                body.classList.remove('mobile-bottom-navbar');
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', updateNavbarPosition);
        } else {
            updateNavbarPosition();
        }

        window.addEventListener('orientationchange', function() { setTimeout(updateNavbarPosition, 120); });
        window.addEventListener('resize', function() { setTimeout(updateNavbarPosition, 120); });
    })();
</script>

</body>
</html>