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

        /* Mobile Horizontal Draggable Menu */
        .mobile-horizontal-menu {
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
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .mobile-horizontal-menu::-webkit-scrollbar {
            display: none;
        }

        .mobile-menu-container {
            display: flex;
            align-items: center;
            padding: 0 16px;
            min-width: max-content;
        }

        .mobile-menu-item {
            flex: 0 0 auto;
            text-align: center;
            margin: 0 8px;
            min-width: 70px;
        }

        .mobile-menu-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px 4px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            min-height: 56px;
            position: relative;
        }

        .mobile-menu-link i {
            font-size: 1.2rem;
            margin-bottom: 4px;
            display: block;
        }

        .mobile-menu-link:hover,
        .mobile-menu-link.active {
            color: #1e3a8a;
            background: rgba(30, 58, 138, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(30, 58, 138, 0.2);
        }

        .mobile-menu-link:active {
            transform: scale(0.95);
        }

        .mobile-menu-drag-handle {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 4px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 2px;
            cursor: grab;
            touch-action: none;
        }

        .mobile-menu-drag-handle:active {
            cursor: grabbing;
            background: rgba(0, 0, 0, 0.4);
        }

        /* Hide regular sidebar on mobile, show horizontal menu */
        @media (max-width: 991px) {
            .layout-menu {
                display: none !important;
            }

            .mobile-horizontal-menu {
                display: block;
            }

            .layout-page {
                margin-bottom: 80px; /* Account for horizontal menu */
            }

            .layout-menu-toggle {
                display: none !important;
            }
        }

        /* Touch device optimizations for mobile menu */
        @media (pointer: coarse) and (max-width: 991px) {
            .mobile-menu-link {
                min-height: 60px;
                padding: 10px 6px;
            }

            .mobile-menu-link:active {
                background: rgba(30, 58, 138, 0.2);
            }
        }
    </style>

    <!-- Professional Admin Pages Styling -->
    <style>
        /* Import Google Fonts for Professional Typography */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap');

        /* Global Admin Styling */
        body.admin-page {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        /* Professional Page Headers */
        .page-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: none;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #3b82f6;
        }

        .page-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .page-subtitle {
            font-size: 1.125rem;
            color: #64748b;
            font-weight: 400;
            margin-bottom: 0;
        }

        .page-actions .btn {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }

        .page-actions .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }

        .page-actions .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .page-actions .btn-success:hover {
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }

        /* Enhanced Card Design */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            background: white;
            margin-bottom: 2rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1px solid #e2e8f0;
            padding: 1.5rem 2rem;
            font-weight: 600;
            color: #1e293b;
            font-size: 1.125rem;
        }

        .card-body {
            padding: 2rem;
        }

        .card-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        /* Professional Table Design */
        .table {
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 2px solid #e2e8f0;
            font-weight: 600;
            color: #374151;
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table tbody td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #475569;
        }

        .table tbody tr:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%);
        }

        /* Professional Form Elements */
        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: #ffffff;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        /* Professional Buttons */
        .btn {
            font-weight: 600;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
            transform: translateY(-1px);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
            transform: translateY(-1px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
            transform: translateY(-1px);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.4);
            transform: translateY(-1px);
        }

        /* Professional Alerts */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }

        .alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            border-left: 4px solid #3b82f6;
        }

        /* Professional Badges */
        .badge {
            font-weight: 600;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.8rem;
        }

        /* Loading States */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .page-title {
                font-size: 1.875rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .table-responsive {
                font-size: 0.85rem;
            }

            .btn {
                padding: 0.625rem 1.25rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .page-header {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .card-header, .card-body {
                padding: 1rem;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            body.admin-page {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
                color: #f1f5f9;
            }

            .page-header {
                background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
                color: #f1f5f9;
            }

            .card {
                background: #1e293b;
                color: #f1f5f9;
            }

            .card-header {
                background: linear-gradient(135deg, #334155 0%, #475569 100%);
                border-bottom-color: #475569;
            }

            .table thead th {
                background: linear-gradient(135deg, #334155 0%, #475569 100%);
                color: #f1f5f9;
            }

            .table tbody td {
                color: #cbd5e1;
                border-bottom-color: #334155;
            }

            .table tbody tr:hover {
                background: linear-gradient(135deg, #334155 0%, #475569 50%);
            }
        }
    </style></head>
<body class="{{ Route::is('admin.*') ? 'admin-page' : '' }}">
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
        @if(auth()->check() && auth()->user()->role && auth()->user()->role->role_name == 'admin')
            @include('admin.menu')
        @elseif(auth()->check() && auth()->user()->role)
            @include('user.menu')
        @else
            <!-- No menu for unauthenticated users or users without roles -->
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

<!-- Mobile Horizontal Draggable Menu -->
@if(auth()->check() && auth()->user()->role)
<nav class="mobile-horizontal-menu">
    <div class="mobile-menu-drag-handle" id="mobileMenuDragHandle"></div>
    <div class="mobile-menu-container" id="mobileMenuContainer">
        @if(auth()->user()->role->role_name == 'admin')
            <!-- Admin Menu Items -->
            <div class="mobile-menu-item">
                <a href="{{ route('admin.index') }}" class="mobile-menu-link {{ Route::is('admin.index') ? 'active' : '' }}">
                    <i class="bx bx-home-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.download') }}" class="mobile-menu-link {{ Route::is('admin.download') ? 'active' : '' }}">
                    <i class="bx bx-upload"></i>
                    <span>Install</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.location') }}" class="mobile-menu-link {{ Route::is('admin.location') ? 'active' : '' }}">
                    <i class="bx bx-location-plus"></i>
                    <span>Map</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.report') }}" class="mobile-menu-link {{ Route::is('admin.report') ? 'active' : '' }}">
                    <i class="bx bx-bar-chart-alt"></i>
                    <span>Report</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.adduser') }}" class="mobile-menu-link {{ Route::is('admin.adduser') ? 'active' : '' }}">
                    <i class="bx bx-user-circle"></i>
                    <span>Users</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.municipal') }}" class="mobile-menu-link {{ Route::is('admin.municipal') ? 'active' : '' }}">
                    <i class="bx bx-building"></i>
                    <span>Municipal</span>
                </a>
            </div>
            <div class="mobile-menu-item d-lg-none">
                <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                    @csrf
                    <button type="submit" class="mobile-menu-link w-100 text-start border-0 bg-transparent text-danger" title="Logout">
                        <i class="bx bx-log-out"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        @else
            <!-- User Menu Items -->
            <div class="mobile-menu-item">
                <a href="{{ route('user.index') }}" class="mobile-menu-link {{ Route::is('user.index') ? 'active' : '' }}">
                    <i class="bx bx-home-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('user.locations') }}" class="mobile-menu-link {{ Route::is('user.locations') ? 'active' : '' }}">
                    <i class="bx bx-location-plus"></i>
                    <span>Report</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('user.download') }}" class="mobile-menu-link {{ Route::is('user.download') ? 'active' : '' }}">
                    <i class="bx bx-upload"></i>
                    <span>Install</span>
                </a>
            </div>
        @endif
    </div>
</nav>
@endif

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Mobile Menu Drag Functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenu = document.querySelector('.mobile-horizontal-menu');
    const dragHandle = document.getElementById('mobileMenuDragHandle');
    const menuContainer = document.getElementById('mobileMenuContainer');

    if (!mobileMenu || !dragHandle || !menuContainer) return;

    let isDragging = false;
    let startY = 0;
    let currentY = 0;
    let menuHeight = mobileMenu.offsetHeight;
    let isMenuVisible = true;

    // Touch events for mobile drag
    dragHandle.addEventListener('touchstart', function(e) {
        isDragging = true;
        startY = e.touches[0].clientY;
        dragHandle.style.cursor = 'grabbing';
        mobileMenu.style.transition = 'none';
    });

    document.addEventListener('touchmove', function(e) {
        if (!isDragging) return;

        currentY = e.touches[0].clientY;
        const deltaY = currentY - startY;

        if (deltaY > 0) { // Dragging down
            const newHeight = Math.max(0, menuHeight - deltaY);
            mobileMenu.style.transform = `translateY(${menuHeight - newHeight}px)`;
        }
    });

    document.addEventListener('touchend', function(e) {
        if (!isDragging) return;

        isDragging = false;
        dragHandle.style.cursor = 'grab';
        mobileMenu.style.transition = 'transform 0.3s ease';

        const deltaY = currentY - startY;

        if (deltaY > 50) { // Hide menu if dragged down more than 50px
            mobileMenu.style.transform = `translateY(${menuHeight}px)`;
            isMenuVisible = false;

            // Auto-show after 3 seconds
            setTimeout(() => {
                if (!isMenuVisible) {
                    mobileMenu.style.transform = 'translateY(0)';
                    isMenuVisible = true;
                }
            }, 3000);
        } else {
            // Snap back to visible position
            mobileMenu.style.transform = 'translateY(0)';
            isMenuVisible = true;
        }
    });

    // Mouse events for desktop testing
    dragHandle.addEventListener('mousedown', function(e) {
        isDragging = true;
        startY = e.clientY;
        dragHandle.style.cursor = 'grabbing';
        mobileMenu.style.transition = 'none';
        e.preventDefault();
    });

    document.addEventListener('mousemove', function(e) {
        if (!isDragging) return;

        currentY = e.clientY;
        const deltaY = currentY - startY;

        if (deltaY > 0) {
            const newHeight = Math.max(0, menuHeight - deltaY);
            mobileMenu.style.transform = `translateY(${menuHeight - newHeight}px)`;
        }
    });

    document.addEventListener('mouseup', function(e) {
        if (!isDragging) return;

        isDragging = false;
        dragHandle.style.cursor = 'grab';
        mobileMenu.style.transition = 'transform 0.3s ease';

        const deltaY = currentY - startY;

        if (deltaY > 50) {
            mobileMenu.style.transform = `translateY(${menuHeight}px)`;
            isMenuVisible = false;

            setTimeout(() => {
                if (!isMenuVisible) {
                    mobileMenu.style.transform = 'translateY(0)';
                    isMenuVisible = true;
                }
            }, 3000);
        } else {
            mobileMenu.style.transform = 'translateY(0)';
            isMenuVisible = true;
        }
    });

    // Horizontal scrolling with momentum
    let scrollVelocity = 0;
    let lastScrollTime = 0;
    let scrollAnimation = null;

    menuContainer.addEventListener('touchstart', function(e) {
        if (scrollAnimation) {
            cancelAnimationFrame(scrollAnimation);
            scrollAnimation = null;
        }
        scrollVelocity = 0;
        lastScrollTime = Date.now();
    });

    menuContainer.addEventListener('touchmove', function(e) {
        const currentTime = Date.now();
        const deltaTime = currentTime - lastScrollTime;

        if (deltaTime > 0) {
            scrollVelocity = (e.touches[0].clientX - (menuContainer.lastTouchX || e.touches[0].clientX)) / deltaTime;
        }

        menuContainer.lastTouchX = e.touches[0].clientX;
        lastScrollTime = currentTime;
    });

    menuContainer.addEventListener('touchend', function(e) {
        // Apply momentum scrolling
        if (Math.abs(scrollVelocity) > 0.1) {
            const momentum = function() {
                menuContainer.scrollLeft += scrollVelocity * 16;
                scrollVelocity *= 0.95; // Friction

                if (Math.abs(scrollVelocity) > 0.01) {
                    scrollAnimation = requestAnimationFrame(momentum);
                } else {
                    scrollAnimation = null;
                }
            };
            momentum();
        }
    });
});
</script>

<!-- Service Worker Registration for PWA Offline Support -->
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('Service Worker registered successfully with scope:', registration.scope);

                // Listen for updates
                registration.addEventListener('updatefound', function() {
                    const newWorker = registration.installing;
                    newWorker.addEventListener('statechange', function() {
                        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                            // New content is available, show update notification
                            showUpdateNotification();
                        }
                    });
                });
            })
            .catch(function(error) {
                console.log('Service Worker registration failed:', error);
            });
    });

    // Listen for controller change (when new SW takes control)
    navigator.serviceWorker.addEventListener('controllerchange', function() {
        window.location.reload();
    });
}

// Function to show update notification
function showUpdateNotification() {
    // Create a simple toast notification
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #1e3a8a;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 9999;
        font-family: 'Public Sans', sans-serif;
        max-width: 300px;
        cursor: pointer;
    `;
    toast.innerHTML = `
        <div style="font-weight: 600; margin-bottom: 5px;">App Updated!</div>
        <div style="font-size: 14px;">Click to refresh and get the latest features.</div>
    `;

    toast.onclick = function() {
        window.location.reload();
    };

    document.body.appendChild(toast);

    // Auto remove after 10 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 10000);
}

// Handle online/offline status
window.addEventListener('online', function() {
    console.log('App is online');
    // You could show a notification here that the app is back online
});

window.addEventListener('offline', function() {
    console.log('App is offline');
    // The service worker will handle serving cached content
});

</script>

</body>
</html>
