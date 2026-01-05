<!-- User Sidebar Menu -->
<aside id="user-sidebar" class="user-sidebar layout-menu menu-vertical menu bg-white text-dark border-end shadow-sm">
    <div class="app-brand demo bg-gradient-primary py-4 px-3 border-bottom">
        <a href="{{ route('user.dashboard') }}" class="app-brand-link d-flex align-items-center text-white text-decoration-none">
            <img src="{{ asset('images/logo.png') }}" alt="Dap-ag Tracker Logo" class="app-brand-logo demo" style="height: 45px; width: auto;">
            <span class="menu-text fw-bold ms-3 fs-5">COTS Tracker</span>
        </a>
        <a href="javascript:void(0);"
        class="layout-menu-toggle menu-link text-white ms-auto d-block d-xl-none rounded-pill"
        style="background-color: rgba(255,255,255,0.1);">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow bg-light"></div>
    <ul class="menu-inner py-2">
        <!-- Sightings Map -->
        <li class="menu-item {{ Route::is('user.locations') ? 'active' : '' }}">
            <a href="{{ route('user.locations') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1">
                <i class="menu-icon tf-icons bx bx-home-circle fs-5"></i>
                <div class="fw-semibold">Sighting Map</div>
            </a>
        </li>

        <!-- My Account -->
        <li class="menu-item {{ Route::is('user.account') ? 'active' : '' }}">
            <a href="{{ route('user.account') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1">
                <i class="menu-icon tf-icons bx bx-user fs-5"></i>
                <div class="fw-semibold">My Account</div>
            </a>
        </li>

        <!-- Logout -->
        <li class="menu-item">
            <form action="{{ route('logout') }}" method="POST" class="w-100">
                @csrf
                <button type="submit" class="menu-link w-100 text-start text-dark hover-bg-danger hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1 border-0 bg-transparent">
                    <i class="menu-icon tf-icons bx bx-log-out fs-5"></i>
                    <div class="fw-semibold">Logout</div>
                </button>
            </form>
        </li>
    </ul>
</aside>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="user-sidebar-overlay"></div>

<style>
/* User Sidebar Styles - Similar to Admin but with different colors */
.user-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 280px;
    height: 100vh;
    background: #ffffff;
    box-shadow: 2px 0 20px rgba(0, 0, 0, 0.08);
    z-index: 1050;
    border-right: 1px solid #e2e8f0;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 1.5rem 0;
}

.app-brand {
    background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%) !important;
}

.menu-link {
    transition: all 0.3s ease;
    padding: 1rem 1.5rem;
    margin: 0.25rem 1rem;
    border-radius: 8px;
}

.menu-link:hover {
    background-color: rgba(3, 105, 161, 0.1) !important;
    color: #0369a1 !important;
}

.menu-item.active .menu-link {
    background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%) !important;
    color: white !important;
}

/* Layout spacing for main content */
.layout-page {
    margin-left: 280px;
    padding: 1rem;
    transition: margin-left 0.3s ease;
}

.layout-page main {
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin: 0;
}

/* Mobile responsiveness */
@media (max-width: 1199.98px) {
    .user-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 0;
    }

    .user-sidebar.open {
        transform: translateX(0);
    }

    .sidebar-overlay.active {
        display: block;
    }

    .layout-page {
        margin-left: 0;
    }
}

/* Desktop layout adjustments */
@media (min-width: 1200px) {
    .layout-menu-fixed:not(.layout-menu-collapsed) .layout-page, .layout-menu-fixed-offcanvas:not(.layout-menu-collapsed) .layout-page {
        /* padding-left: 16.25rem; */
    }
}

.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1049;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .user-sidebar {
        background: #1f2937;
        border-color: #374151;
    }

    .menu-link {
        color: #d1d5db !important;
    }

    .menu-link:hover {
        background: rgba(3, 105, 161, 0.1) !important;
        color: #38bdf8 !important;
    }

    .menu-item.active .menu-link {
        background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%) !important;
    }
}

/* Print styles */
@media print {
    .user-sidebar,
    .sidebar-overlay {
        display: none !important;
    }
}
</style>

<script>
// User sidebar functionality - simplified to work like admin sidebar
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('user-sidebar');
    const overlay = document.getElementById('user-sidebar-overlay');
    const menuToggle = document.querySelector('.layout-menu-toggle');

    // Function to open sidebar
    function openSidebar() {
        if (sidebar) {
            sidebar.classList.add('open');
            if (overlay) overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }

    // Function to close sidebar
    function closeSidebar() {
        if (sidebar) {
            sidebar.classList.remove('open');
            if (overlay) overlay.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    // Menu toggle button
    if (menuToggle) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            if (sidebar && sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    // Overlay click
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });

    // Close sidebar and ensure navigation when clicking on nav links (mobile & desktop)
    if (sidebar) {
        const navLinks = sidebar.querySelectorAll('.menu-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Allow opening in new tab or modifier-click
                if (e.metaKey || e.ctrlKey || this.target === '_blank') return;

                // Prevent any other handlers from stopping navigation
                e.preventDefault();

                const href = this.getAttribute('href');
                if (!href) return;

                if (window.innerWidth < 1200) {
                    closeSidebar();
                    // small delay to allow close animation
                    setTimeout(() => { window.location.href = href; }, 250);
                } else {
                    window.location.href = href;
                }
            });
        });
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1200) {
            closeSidebar();
        }
    });
});
</script>