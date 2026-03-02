
<!-- Admin Sidebar Menu -->
<aside id="admin-sidebar" class="admin-sidebar layout-menu menu-vertical menu bg-white text-dark border-end shadow-sm">
    <div class="app-brand demo bg-gradient-admin py-4 px-3 border-bottom">
        <a href="{{ route('admin.index') }}" class="app-brand-link d-flex align-items-center text-white text-decoration-none">
            <img src="{{ asset('images/logo.png') }}" alt="COTS Tracker Logo" class="app-brand-logo demo" style="height: 45px; width: auto;">
            <span class="menu-text fw-bold ms-3 fs-5">Admin Panel</span>
        </a>
        <a href="javascript:void(0);"
        class="layout-menu-toggle menu-link text-white ms-auto d-block d-xl-none rounded-pill"
        style="background-color: rgba(255,255,255,0.1);">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow bg-light"></div>
    <ul class="menu-inner py-2" style="list-style: none;">
        <!-- Dashboard -->
        <li class="menu-item {{ Route::is('admin.index') ? 'active' : '' }}">
            <a href="{{ route('admin.index') }}" class="menu-link text-dark hover-bg-admin hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1">
                <i class="menu-icon tf-icons bx bx-grid-alt fs-5"></i>
                <div class="fw-semibold">Dashboard</div>
            </a>
        </li>

        <!-- Sightings Map -->
        <li class="menu-item {{ Route::is('admin.location') ? 'active' : '' }}">
            <a href="{{ route('admin.location') }}" class="menu-link text-dark hover-bg-admin hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1">
                <i class="menu-icon tf-icons bx bx-map-alt fs-5"></i>
                <div class="fw-semibold">Sightings Map</div>
            </a>
        </li>

        <!-- Reports -->
        <li class="menu-item {{ Route::is('admin.report') || Route::is('admin.report.export') ? 'active' : '' }}">
            <a href="{{ route('admin.report') }}" class="menu-link text-dark hover-bg-admin hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2 fs-5"></i>
                <div class="fw-semibold">Reports</div>
            </a>
        </li>

        <!-- Downloads -->
        <li class="menu-item {{ Route::is('admin.download') ? 'active' : '' }}">
            <a href="{{ route('admin.download') }}" class="menu-link text-dark hover-bg-admin hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1">
                <i class="menu-icon tf-icons bx bx-download fs-5"></i>
                <div class="fw-semibold">Downloads</div>
            </a>
        </li>

        <!-- Notifications -->
        <li class="menu-item {{ Route::is('admin.notifications') ? 'active' : '' }}">
            <a href="{{ route('admin.notifications') }}" class="menu-link text-dark hover-bg-admin hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1 position-relative">
                <i class="menu-icon tf-icons bx bx-bell fs-5"></i>
                <div class="fw-semibold">Notifications</div>
                <span class="position-absolute top-50 end-0 translate-middle-y badge rounded-pill bg-danger me-4" id="sidebarNotificationBadge" style="display: none; font-size: 0.65rem;">
                    0
                </span>
            </a>
        </li>

        <!-- Section Divider -->
        <li class="menu-section mt-3 mb-2">
            <div class="menu-section-title px-4 text-muted small fw-semibold">
                <span>Management</span>
            </div>
        </li>

        <!-- Manage Users -->
        <li class="menu-item {{ Route::is('admin.adduser') || Route::is('admin.adduser.create') || Route::is('admin.users.*') ? 'active' : '' }}">
            <a href="{{ route('admin.adduser') }}" class="menu-link text-dark hover-bg-admin hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1">
                <i class="menu-icon tf-icons bx bx-user fs-5"></i>
                <div class="fw-semibold">Manage Users</div>
            </a>
        </li>

        <!-- Municipalities -->
        <li class="menu-item {{ Route::is('admin.municipal') || Route::is('admin.municipal.*') ? 'active' : '' }}">
            <a href="{{ route('admin.municipal') }}" class="menu-link text-dark hover-bg-admin hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1">
                <i class="menu-icon tf-icons bx bx-buildings fs-5"></i>
                <div class="fw-semibold">Municipalities</div>
            </a>
        </li>

        <!-- Logout (visible on mobile only) -->
        <li class="menu-item d-block d-xl-none mt-3">
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
<div class="sidebar-overlay" id="admin-sidebar-overlay"></div>

<style>
/* Admin Sidebar Styles - Similar to User but with admin colors */
.admin-sidebar {
    position: fixed;
    top: 70px;
    left: 0;
    width: 280px;
    height: calc(100vh - 70px);
    background: #ffffff;
    box-shadow: 2px 0 20px rgba(0, 0, 0, 0.08);
    z-index: 1050;
    border-right: 1px solid #e2e8f0;
    overflow-y: auto;
    overflow-x: hidden;
}

/* Sidebar overlay - should be below notification bell */
.sidebar-overlay {
    z-index: 1049 !important;
}

/* Admin gradient - professional blue gradient */
.bg-gradient-admin {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
}

.app-brand {
    position: relative;
}

.menu-link {
    transition: all 0.3s ease;
    padding: 1rem 1.5rem;
    margin: 0.25rem 1rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.menu-link:hover {
    background-color: rgba(30, 64, 175, 0.1) !important;
    color: #1e40af !important;
}

.menu-item.active .menu-link {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
    color: white !important;
}

.menu-section-title {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.5rem 0;
}

/* Layout spacing for main content */
.layout-wrapper {
    display: flex;
    flex-direction: row;
    width: 100vw;
    min-height: 100vh;
}

.layout-page {
    flex: 1;
    padding: 1rem;
    min-width: 0;
    display: flex;
    flex-direction: column;
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
    .admin-sidebar {
        top: 0;
        height: 100vh;
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 0;
    }

    .admin-sidebar.open {
        transform: translateX(0);
    }

    .sidebar-overlay {
        top: 0;
        height: 100%;
    }

    .sidebar-overlay.active {
        display: block;
    }

    .layout-wrapper {
        flex-direction: column;
    }
    .layout-page {
        min-width: 0;
        width: 100vw;
        padding: 1rem;
    }
}

.sidebar-overlay {
    display: none;
    position: fixed;
    top: 70px;
    left: 0;
    width: 100%;
    height: calc(100% - 70px);
    background: rgba(0, 0, 0, 0.5);
    z-index: 1049;
}

/* Menu icon styles */
.menu-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .admin-sidebar {
        background: #1f2937;
        border-color: #374151;
    }

    .menu-link {
        color: #d1d5db !important;
    }

    .menu-link:hover {
        background: rgba(30, 64, 175, 0.1) !important;
        color: #60a5fa !important;
    }

    .menu-item.active .menu-link {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
    }
}

/* Print styles */
@media print {
    .admin-sidebar,
    .sidebar-overlay {
        display: none !important;
    }
}
</style>

<script>
// Admin sidebar functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('admin-sidebar-overlay');
    const menuToggle = document.querySelector('.layout-menu-toggle');

    // Function to open sidebar
    function openSidebar() {
        if (sidebar) {
            sidebar.classList.add('open');
            if (overlay) {
                overlay.classList.add('active');
                overlay.style.display = 'block';
            }
            document.body.style.overflow = 'hidden';
        }
    }

    // Function to close sidebar
    function closeSidebar() {
        if (sidebar) {
            sidebar.classList.remove('open');
            if (overlay) {
                overlay.classList.remove('active');
                overlay.style.display = 'none';
            }
            document.body.style.overflow = '';
        }
    }

    // Global toggle function for navbar button
    window.toggleAdminSidebar = function() {
        if (sidebar && sidebar.classList.contains('open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    };

    // Toggle menu on mobile
    if (menuToggle) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            closeSidebar();
        });
    }

    // Close sidebar when clicking overlay
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1200) {
            closeSidebar();
        }
    });
});
</script>
