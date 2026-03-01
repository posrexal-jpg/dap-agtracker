<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">
    <title>@yield('title', 'Welcome to COTS tracker')</title>
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

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.74.0/dist/L.Control.Locate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.awesome-markers/2.0.4/leaflet.awesome-markers.css">

    <!-- Custom CSS (from build manifest) -->
    {!! manifest_styles([
        'resources/css/app.css',
        'resources/css/admin.css',
        'resources/css/mobile-menu.css',
    ]) !!}

    @stack('styles')
</head>
<body class="d-flex flex-column h-100 admin-layout">
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow-sm" id="admin-navbar">
        <div class="container-fluid px-4">
            <!-- Mobile Menu Toggle -->
            <button class="btn btn-link text-white d-lg-none p-0 me-3" type="button" id="sidebarToggle" aria-label="Toggle sidebar">
                <i class="fas fa-bars fs-5"></i>
            </button>

            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.index') }}">
                <img src="{{ asset('images/logo.png') }}" alt="COTS Tracker" class="me-2" style="height: 32px;">
                <span class="fw-bold d-none d-sm-inline">COTS Tracker</span>
            </a>

            <!-- Right Side Navigation -->
            <div class="navbar-nav ms-auto d-flex flex-row align-items-center">
                <!-- User Info -->
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div class="d-none d-md-block">
                            <div class="fw-semibold">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <small class="opacity-75">{{ Auth::user()->role->role_name ?? 'Administrator' }}</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><h6 class="dropdown-header">Account</h6></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>Profile Settings</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-bell me-2"></i>Notifications</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Layout Container -->
    <div class="d-flex flex-grow-1" style="margin-top: 60px;">
        <!-- Sidebar -->
        <aside class="sidebar bg-white shadow-sm border-end" id="adminSidebar">
            @include('admin.menu')
        </aside>

        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay d-lg-none" id="sidebarOverlay"></div>

        <!-- Main Content Area -->
        <main class="main-content flex-grow-1 bg-light">
            <div class="container-fluid p-4">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Bottom Navigation (Optional) -->
    @include('components.mobile-menu')

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.74.0/dist/L.Control.Locate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.awesome-markers/2.0.4/leaflet.awesome-markers.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript (from build manifest) -->
    {!! manifest_scripts([
        'resources/js/app.js',
        'resources/js/mobile-menu.js',
        'resources/js/service-worker.js',
    ]) !!}

    @stack('scripts')

    <!-- Admin Layout JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle functionality
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('adminSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            if (sidebarToggle && sidebar && sidebarOverlay) {
                // Toggle sidebar on mobile
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                    document.body.classList.toggle('sidebar-open');
                });

                // Close sidebar when clicking overlay
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                });

                // Close sidebar on window resize if desktop
                window.addEventListener('resize', function() {
                    if (window.innerWidth >= 992) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                        document.body.classList.remove('sidebar-open');
                    }
                });
            }

            // Mobile responsive adjustments
            function handleMobileLayout() {
                const isMobile = window.innerWidth < 992;
                const body = document.body;
                
                if (isMobile) {
                    body.classList.add('mobile-layout');
                } else {
                    body.classList.remove('mobile-layout', 'sidebar-open');
                    if (sidebar) sidebar.classList.remove('show');
                    if (sidebarOverlay) sidebarOverlay.classList.remove('show');
                }
            }

            // Initial call and event listeners
            handleMobileLayout();
            window.addEventListener('resize', handleMobileLayout);
            window.addEventListener('orientationchange', function() {
                setTimeout(handleMobileLayout, 100);
            });
        });
    </script>

</body>
</html>