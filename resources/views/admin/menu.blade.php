
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-white text-dark border-end shadow-sm">
    <div class="app-brand demo bg-gradient-primary py-4 px-3 border-bottom">
        <a href="{{ route('admin.index') }}" class="app-brand-link d-flex align-items-center text-white text-decoration-none">
            <img src="{{ asset('images/logo.png') }}" alt="COTS Tracker Logo" class="app-brand-logo demo" style="height: 60px; width: auto;">
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
        <li class="menu-item {{ Route::is('admin.index') ? 'active' : '' }}">
            <a href="{{ route('admin.index') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1">
                <i class="menu-icon tf-icons bx bx-home-alt fs-5"></i>
                <div data-i18n="Analytics" class="fw-semibold">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.location') ? 'active' : '' }}">
            <a href="{{ route('admin.location') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1">
                <i class="menu-icon tf-icons bx bx-location-plus fs-5"></i>
                <div data-i18n="Locations" class="fw-semibold">Sightings Map</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.report') ? 'active' : '' }}">
            <a href="{{ route('admin.report') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt fs-5"></i>
                <div class="fw-semibold">Reports</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.adduser') ? 'active' : '' }}">
            <a href="{{ route('admin.adduser') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1">
                <i class="menu-icon tf-icons bx bx-user-circle fs-5"></i>
                <div data-i18n="Users" class="fw-semibold">Manage Users</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.municipal') ? 'active' : '' }}">
            <a href="{{ route('admin.municipal') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none py-3 px-4 rounded-3 mx-2 mb-1">
                <i class="menu-icon tf-icons bx bx-building fs-5"></i>
                <div data-i18n="Municipal" class="fw-semibold">Municipalities</div>
            </a>
        </li>
        <!-- <li class="menu-item {{ Route::is('admin.municipal') ? 'active' : '' }}">
            <a href="{{ route('admin.municipal') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none">
                <i class="menu-icon tf-icons bx bx-building"></i>
                <div data-i18n="Analytics">Municipal</div>
            </a>
        </li> -->
    </ul>
</aside>

<style>
/* Professional Admin Menu Styling */
.bg-gradient-primary {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
}

.menu-link {
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
    position: relative;
    overflow: hidden;
}

.menu-link:hover {
    background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%) !important;
    color: white !important;
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.menu-link:hover::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background: #60a5fa;
}

.menu-item.active .menu-link {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%) !important;
    color: white !important;
    border-left-color: #60a5fa;
    box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
}

.menu-icon {
    margin-right: 12px;
    width: 20px;
    text-align: center;
}

.menu-text {
    letter-spacing: 0.5px;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.layout-menu-toggle {
    transition: all 0.3s ease;
}

.layout-menu-toggle:hover {
    background-color: rgba(255,255,255,0.2) !important;
    transform: scale(1.05);
}

/* Responsive adjustments */
@media (max-width: 1199px) {
    .menu-link {
        padding: 0.75rem 1rem;
        margin: 0.25rem;
    }

    .menu-icon {
        margin-right: 8px;
        font-size: 1.1rem;
    }
}
</style>
