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
    <title>Page Not Found - Dag-ag Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }
        .navbar-brand img {
            height: 40px;
            width: auto;
            margin-right: 10px;
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

        /* Show horizontal menu on mobile */
        @media (max-width: 991px) {
            .mobile-horizontal-menu {
                display: block;
            }

            .error-404-container {
                margin-bottom: 80px; /* Account for horizontal menu */
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
    .error-404-container {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .error-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: none;
        max-width: 500px;
        width: 100%;
    }

    .error-number {
        font-size: 8rem;
        font-weight: 700;
        color: #1e3a8a;
        line-height: 1;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .error-title {
        font-size: 2rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 1rem;
    }

    .error-description {
        color: #6b7280;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .btn-go-home {
        background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 1.1rem;
        color: white;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
    }

    .btn-go-home:hover {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-go-back {
        border: 2px solid #d1d5db;
        background: white;
        color: #6b7280;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 1.1rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        margin-left: 10px;
    }

    .btn-go-back:hover {
        border-color: #9ca3af;
        background: #f9fafb;
        color: #374151;
        text-decoration: none;
    }

    .logo-404 {
        max-width: 100px;
        height: auto;
        margin-bottom: 2rem;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
    }

    .fun-element {
        margin-top: 3rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .fun-element p {
        color: #374151;
        font-weight: 500;
        margin: 0;
    }

    @media (max-width: 768px) {
        .error-number {
            font-size: 6rem;
        }

        .error-title {
            font-size: 1.5rem;
        }

        .btn-go-home,
        .btn-go-back {
            padding: 10px 20px;
            font-size: 1rem;
            margin-left: 0;
            margin-top: 10px;
        }

        .logo-404 {
            max-width: 80px;
        }
    }

    @media (max-width: 576px) {
        .error-404-container {
            padding: 10px;
        }

        .error-card .card-body {
            padding: 2rem 1.5rem;
        }

        .error-number {
            font-size: 5rem;
        }

        .btn-go-home,
        .btn-go-back {
            width: 100%;
            margin-left: 0;
        }
    }
</style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Dag-ag Tracker Logo">
                Dag-ag Tracker
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
                        <a class="nav-link" href="/sightings">COTS Sightings</a>
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

<div class="error-404-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Dag-ag Tracker Logo" class="logo-404">
                </div>

                <!-- Error Card -->
                <div class="error-card">
                    <div class="card-body text-center">
                        <div class="error-number">404</div>
                        <h2 class="error-title">Oops! Page Not Found</h2>
                        <p class="error-description">
                            The page you're looking for seems to have wandered off into the coral reefs.
                            Don't worry, let's get you back on track!
                        </p>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-2">
                            <a href="{{ url('/') }}" class="btn-go-home">
                                <i class="fas fa-home me-2"></i>Go Home
                            </a>
                            <button onclick="history.back()" class="btn-go-back">
                                <i class="fas fa-arrow-left me-2"></i>Go Back
                            </button>
                        </div>

                        <!-- Help Text -->
                        <div class="mt-4 pt-3 border-top border-light">
                            <p class="text-muted small mb-1">Need assistance?</p>
                            <p class="text-muted small">
                                If you believe this is an error, please contact our support team or try navigating from the home page.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Fun Element -->
                <div class="fun-element text-center">
                    <p>🐠 Help protect our coral reefs by reporting COTS sightings with Dag-ag Tracker!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
        <p>&copy; 2025 Dag-ag Tracker. All rights reserved.</p>
        <p>Developed in partnership with DOST and SLSU Bontoc.</p>
    </div>
</footer>

<!-- Mobile Horizontal Draggable Menu -->
@if(auth()->check() && auth()->user()->role)
<nav class="mobile-horizontal-menu">
    <div class="mobile-menu-drag-handle" id="mobileMenuDragHandle"></div>
    <div class="mobile-menu-container" id="mobileMenuContainer">
        @if(auth()->user()->role->role_name == 'admin')
            <!-- Admin Menu Items -->
            <div class="mobile-menu-item">
                <a href="{{ route('admin.index') }}" class="mobile-menu-link">
                    <i class="bx bx-home-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.download') }}" class="mobile-menu-link">
                    <i class="bx bx-upload"></i>
                    <span>Install</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.location') }}" class="mobile-menu-link">
                    <i class="bx bx-location-plus"></i>
                    <span>Map</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.report') }}" class="mobile-menu-link">
                    <i class="bx bx-bar-chart-alt"></i>
                    <span>Report</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.adduser') }}" class="mobile-menu-link">
                    <i class="bx bx-user-circle"></i>
                    <span>Users</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.municipal') }}" class="mobile-menu-link">
                    <i class="bx bx-building"></i>
                    <span>Municipal</span>
                </a>
            </div>
        @else
            <!-- User Menu Items -->
            <div class="mobile-menu-item">
                <a href="{{ route('user.index') }}" class="mobile-menu-link">
                    <i class="bx bx-home-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('user.locations') }}" class="mobile-menu-link">
                    <i class="bx bx-location-plus"></i>
                    <span>Report</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('user.download') }}" class="mobile-menu-link">
                    <i class="bx bx-upload"></i>
                    <span>Install</span>
                </a>
            </div>
        @endif
    </div>
</nav>
@else
<!-- Unauthenticated User Menu -->
<nav class="mobile-horizontal-menu">
    <div class="mobile-menu-drag-handle" id="mobileMenuDragHandle"></div>
    <div class="mobile-menu-container" id="mobileMenuContainer">
        <div class="mobile-menu-item">
            <a href="/" class="mobile-menu-link">
                <i class="bx bx-home-alt"></i>
                <span>Home</span>
            </a>
        </div>
        <div class="mobile-menu-item">
            <a href="/sightings" class="mobile-menu-link">
                <i class="bx bx-map"></i>
                <span>Sightings</span>
            </a>
        </div>
        <div class="mobile-menu-item">
            <a href="/download" class="mobile-menu-link">
                <i class="bx bx-upload"></i>
                <span>Install</span>
            </a>
        </div>
        <div class="mobile-menu-item">
            <a href="/login" class="mobile-menu-link">
                <i class="bx bx-log-in"></i>
                <span>Login</span>
            </a>
        </div>
    </div>
</nav>
@endif

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
</body>
</html>
