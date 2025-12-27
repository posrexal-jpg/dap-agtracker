<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/')}}" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>COTS Tracker</title>
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
            right: 0%;
            margin-right: 20px;
            z-index: 1000;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem;
        }

        #map {
            height: 100%;
            position: relative;
            margin: 10% auto 0 auto;
            width: 90%;
            height: 10%;
            margin-left: 50px;
        }

        .layout-page {
            margin-top: 80px;
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
        .page-header {
        position: fixed;
        top: 70px; /* adjust based on navbar height */
        left: 300px;
        width: 100%;
        background-color: #fff;
        z-index: 998;
        padding: 10px 0;
    }

    .page-header h1 {
        margin: 0;
        font-size: 1.8rem;
        color: #333;
        font-weight: 700;
    }

    .page-header .description {
        margin: 5px 0 0 0;
        font-size: 1rem;
        color: #666;
    }

    .layout-page {
        margin-top: 160px; /* leave space for navbar + fixed title */
    }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand navbar-detached align-items-center bg-navbar-theme fixed-top" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <i class="bx bx-menu bx-sm"></i>
    </div>
    
    <!-- Collapsible Navbar Content -->
    <div class="collapse navbar-collapse" id="navbarContentPage1">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item inbox-dropdown dropdown">
                <a class="nav-link px-0" href="#" id="inboxDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-envelope" style="font-size: 1.5rem; margin-right: 10px;"></i> 
                    <span class="badge bg-danger"></span> 
                </a>
                <ul class="dropdown-menu" aria-labelledby="inboxDropdown">
                    <li><a class="dropdown-item" href="#">New location added in:</a></li>
                </ul>
            </li>

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <span class="user-role">
                    {{ Auth::user()->role->role_name }}
                </span>
            </li>
        </ul>
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

</body>
</html>
