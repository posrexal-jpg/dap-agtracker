<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#1e3a8a" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="default" />
        <meta name="apple-mobile-web-app-title" content="Dap-ag Tracker" />
        <link rel="manifest" href="/manifest.json" />
        <link rel="apple-touch-icon" href="/images/logo.png" />

        <title>@yield('title')</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <!-- BoxIcons -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}code{font-family:monospace,monospace;font-size:1em}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}code{font-family:Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-gray-400{--border-opacity:1;border-color:#cbd5e0;border-color:rgba(203,213,224,var(--border-opacity))}.border-t{border-top-width:1px}.border-r{border-right-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-xl{max-width:36rem}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-4{padding-left:1rem;padding-right:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.uppercase{text-transform:uppercase}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.tracking-wider{letter-spacing:.05em}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@-webkit-keyframes spin{0%{transform:rotate(0deg)}to{transform:rotate(1turn)}}@keyframes spin{0%{transform:rotate(0deg)}to{transform:rotate(1turn)}}@-webkit-keyframes ping{0%{transform:scale(1);opacity:1}75%,to{transform:scale(2);opacity:0}}@keyframes ping{0%{transform:scale(1);opacity:1}75%,to{transform:scale(2);opacity:0}}@-webkit-keyframes pulse{0%,to{opacity:1}50%{opacity:.5}}@keyframes pulse{0%,to{opacity:1}50%{opacity:.5}}@-webkit-keyframes bounce{0%,to{transform:translateY(-25%);-webkit-animation-timing-function:cubic-bezier(.8,0,1,1);animation-timing-function:cubic-bezier(.8,0,1,1)}50%{transform:translateY(0);-webkit-animation-timing-function:cubic-bezier(0,0,.2,1);animation-timing-function:cubic-bezier(0,0,.2,1)}}@keyframes bounce{0%,to{transform:translateY(-25%);-webkit-animation-timing-function:cubic-bezier(.8,0,1,1);animation-timing-function:cubic-bezier(.8,0,1,1)}50%{transform:translateY(0);-webkit-animation-timing-function:cubic-bezier(0,0,.2,1);animation-timing-function:cubic-bezier(0,0,.2,1)}}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}            /* Mobile Horizontal Draggable Menu */
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

                .error-container {
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

        <style>
            body {
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0 error-container">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
                    <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">
                        @yield('code')
                    </div>

                    <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                        @yield('message')
                    </div>
                </div>
        </div>

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
                    // Snap back to visible position
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
