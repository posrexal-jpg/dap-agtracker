<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/')}}" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>@yield('title', 'Dag-ag Tracker')</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png')}}" />

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

    <!-- Config -->
    <script src="{{ asset('assets/js/config.js')}}"></script>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.75rem 1rem;
            height: 70px;
        }

        .navbar .container-xxl {
            padding-left: 0;
            padding-right: 0;
        }

        .layout-page {
            margin-top: 90px; /* Account for fixed navbar height */
        }

        /* Navbar responsive adjustments */
        @media (max-width: 991px) {
            .navbar .container-xxl {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .layout-menu-toggle {
                cursor: pointer;
                padding: 0.5rem;
                border-radius: 0.375rem;
                transition: background-color 0.15s ease-in-out;
            }

            .layout-menu-toggle:hover {
                background-color: #f8f9fa;
            }
        }

        @media (max-width: 576px) {
            .navbar {
                padding: 0.5rem 0.75rem;
                height: 60px;
            }

            .layout-page {
                margin-top: 80px; /* Adjust for smaller navbar on mobile */
            }

            .navbar-text {
                font-size: 0.9rem;
            }
        }

        .user-role {
            font-weight: 600;
            color: #333;
        }

        .navbar-nav-right {
            align-items: center;
            flex-basis: 100%;
        }

        .navbar-nav-right .nav-item {
            margin-left: 15px;
        }

        .navbar-nav {
            flex-wrap: wrap; 
        }

        .navbar {
            padding: 1rem 1.5rem;
        }

        .navbar-toggler {
            border-color: transparent;
        }
    </style>
    <style>
        /* Clean, subtle styling with welcome page colors */
        .page-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 1.5rem 1rem;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        .page-actions .btn {
            margin-left: 0.5rem;
            background-color: #1e3a8a;
            border-color: #1e3a8a;
            color: white;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .page-actions .btn:hover {
            background-color: #1e40af;
            border-color: #1e40af;
        }

        /* Card styling - clean and minimal */
        .card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: #1e3a8a;
            color: white;
            border-bottom: none;
            padding: 1rem 1.25rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* Button styling */
        .btn-primary {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
        }

        .btn-primary:hover {
            background-color: #1e40af;
            border-color: #1e40af;
        }

        .btn-outline-primary {
            color: #1e3a8a;
            border-color: #1e3a8a;
        }

        .btn-outline-primary:hover {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
        }

        /* Table styling */
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #1e3a8a;
            color: #1e3a8a;
            font-weight: 600;
            padding: 0.75rem;
        }

        .table tbody td {
            padding: 0.75rem;
            vertical-align: middle;
        }

        /* Download item styling */
        .download-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            transition: all 0.2s ease;
        }

        .download-item:hover {
            background: #ffffff;
            border-color: #1e3a8a;
            box-shadow: 0 2px 8px rgba(30, 58, 138, 0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }

            .page-subtitle {
                font-size: 0.9rem;
            }

            .page-actions {
                margin-top: 1rem;
                width: 100%;
            }

            .page-actions .btn {
                margin-left: 0;
                margin-right: 0.5rem;
                margin-bottom: 0.5rem;
                flex: 1;
                min-width: 120px;
            }

            .card-body {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }

            .page-header {
                padding: 1rem 0;
            }

            .page-title {
                font-size: 1.25rem;
            }

            .page-actions .btn {
                font-size: 0.85rem;
                padding: 0.4rem 0.8rem;
                min-width: 100px;
            }
        }
    </style></head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top border-bottom" id="layout-navbar">
    <div class="container-xxl">
        <div class="layout-menu-toggle d-xl-none me-3">
            <i class="bx bx-menu bx-sm text-primary"></i>
        </div>

        <!-- Collapsible Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContentPage1">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <span class="navbar-text fw-semibold text-dark me-3">
                        {{ Auth::user()->role->role_name }}
                    </span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Logout">
                            <i class="bx bx-log-out"></i>
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
        @if(auth()->user()->role->role_name == 'admin')
            @include('admin.menu')
        @else
            @include('user.menu')
        @endif

        <div class="layout-page">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>
</div>

<!-- Layout overlay for mobile menu -->
<div class="layout-overlay"></div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
