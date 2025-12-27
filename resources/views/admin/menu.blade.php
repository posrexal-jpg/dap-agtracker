
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-white text-dark border-end">
    <div class="app-brand demo bg-light py-3 px-2 border-bottom">
        <a href="{{ route('admin.index') }}" class="app-brand-link d-flex align-items-center text-dark text-decoration-none">
            <img src="{{ asset('images/logo.png') }}" alt="COTS Tracker Logo" class="app-brand-logo demo" style="height: 70px; width: auto;">
            <span class="menu-text fw-bolder ms-2 fs-4">COTS Tracker</span>
        </a>
        <a href="javascript:void(0);" 
        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none" 
        style="background-color: #1ab2a0;">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow bg-light"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item {{ Route::is('admin.index') ? 'active' : '' }}">
            <a href="{{ route('admin.index') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none">
                <i class="menu-icon tf-icons bx bx-home-alt"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.download') ? 'active' : '' }}">
            <a href="{{ route('admin.download') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none">
                <i class="menu-icon tf-icons bx bx-upload"></i>
                <div data-i18n="Locations">Download</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.location') ? 'active' : '' }}">
            <a href="{{ route('admin.location') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none">
                <i class="menu-icon tf-icons bx bx-location-plus"></i>
                <div data-i18n="Locations">Sightings Map</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.report') ? 'active' : '' }}">
            <a href="{{ route('admin.report') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt"></i>
                <div>Report</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin.adduser') ? 'active' : '' }}">
            <a href="{{ route('admin.adduser') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Users">Manage Users</div>
            </a>
        </li>
        <!-- <li class="menu-item {{ Route::is('admin.municipal') ? 'active' : '' }}">
            <a href="{{ route('admin.municipal') }}" class="menu-link text-dark hover-bg-primary hover-text-white text-decoration-none">
                <i class="menu-icon tf-icons bx bx-building"></i>
                <div data-i18n="Analytics">Municipal</div>
            </a>
        </li> -->
        <li class="menu-item mt-4">
            <a href="{{ route('logout') }}" class="menu-link text-dark hover-bg-danger hover-text-white text-decoration-none" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div data-i18n="Logout">Logout</div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</aside>
