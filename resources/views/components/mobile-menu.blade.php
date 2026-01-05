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
                <a href="{{ route('user.dashboard') }}" class="mobile-menu-link {{ Route::is('user.dashboard') ? 'active' : '' }}">
                    <i class="bx bx-home-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('user.locations') }}" class="mobile-menu-link {{ Route::is('user.locations') ? 'active' : '' }}">
                    <i class="bx bx-location-plus"></i>
                    <span>Sighting Map</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('user.account') }}" class="mobile-menu-link {{ Route::is('user.account') ? 'active' : '' }}">
                    <i class="bx bx-user"></i>
                    <span>My Account</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                    @csrf
                    <button type="submit" class="mobile-menu-link w-100 text-start border-0 bg-transparent text-danger" title="Logout">
                        <i class="bx bx-log-out"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        @endif
    </div>
</nav>
@endif