@if(auth()->check() && auth()->user()->role)
<nav class="mobile-horizontal-menu">
    <div class="mobile-menu-drag-handle" id="mobileMenuDragHandle"></div>
    <div class="mobile-menu-container" id="mobileMenuContainer">
        @if(auth()->user()->role->role_name == 'admin')
            <!-- Admin Menu Items -->
            <div class="mobile-menu-item">
                <a href="{{ route('admin.index') }}" class="mobile-menu-link {{ Route::is('admin.index') ? 'active' : '' }}">
                    <i class="bx bx-home-circle"></i>
                    <span>Home</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.location') }}" class="mobile-menu-link {{ Route::is('admin.location') ? 'active' : '' }}">
                    <i class="bx bx-map"></i>
                    <span>Map</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.report') }}" class="mobile-menu-link {{ Route::is('admin.report') ? 'active' : '' }}">
                    <i class="bx bx-line-chart"></i>
                    <span>Reports</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.adduser') }}" class="mobile-menu-link {{ Route::is('admin.adduser') ? 'active' : '' }}">
                    <i class="bx bx-group"></i>
                    <span>Users</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.municipal') }}" class="mobile-menu-link {{ Route::is('admin.municipal') ? 'active' : '' }}">
                    <i class="bx bx-buildings"></i>
                    <span>Areas</span>
                </a>
            </div>
        @else
            <!-- User Menu Items -->
            <div class="mobile-menu-item">
                <a href="{{ route('user.dashboard') }}" class="mobile-menu-link {{ Route::is('user.dashboard') ? 'active' : '' }}">
                    <i class="bx bx-home-circle"></i>
                    <span>Home</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('user.sightings-map') }}" class="mobile-menu-link {{ Route::is('user.sightings-map') ? 'active' : '' }}">
                    <i class="bx bx-map"></i>
                    <span>Map</span>
                </a>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('user.account') }}" class="mobile-menu-link {{ Route::is('user.account') ? 'active' : '' }}">
                    <i class="bx bx-user-circle"></i>
                    <span>Account</span>
                </a>
            </div>
        @endif
    </div>
</nav>
@endif