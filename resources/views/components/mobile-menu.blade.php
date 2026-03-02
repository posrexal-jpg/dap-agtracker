@if(auth()->check() && auth()->user()->role)
<nav class="mobile-horizontal-menu">
    <div class="mobile-menu-drag-handle" id="mobileMenuDragHandle"></div>
    <div class="mobile-menu-container" id="mobileMenuContainer">
        @if(auth()->user()->role->role_name == 'admin')
            <!-- Admin Menu Items -->
            <!-- Notification Bell -->
            <div class="mobile-menu-item">
                <div class="dropup">
                    <button class="mobile-menu-link position-relative w-100 text-start border-0 bg-transparent" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-bell"></i>
                        <span>Notifications</span>
                        <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger" id="notificationBadge" style="display: none; margin-left: 10px; margin-top: 5px;">
                            0
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="notificationDropdown" style="width: 360px; max-height: 500px; overflow-y: auto; margin-bottom: 10px;">
                        <li class="dropdown-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                            <h6 class="mb-0">Notifications</h6>
                            <button class="btn btn-sm btn-link text-primary p-0" id="markAllReadBtn" style="font-size: 0.8rem;">Mark all read</button>
                        </li>
                        <div id="notificationList">
                            <li class="text-center py-4 text-muted">
                                <i class="bx bx-bell-off fs-3 d-block mb-2"></i>
                                <small>No notifications</small>
                            </li>
                        </div>
                        <li class="dropdown-divider"></li>
                        <li class="text-center">
                            <a class="dropdown-item text-primary fw-semibold" href="{{ route('admin.notifications') }}">
                                View All Notifications
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mobile-menu-item">
                <a href="{{ route('admin.index') }}" class="mobile-menu-link {{ Route::is('admin.index') ? 'active' : '' }}">
                    <i class="bx bx-home-alt"></i>
                    <span>Dashboard</span>
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
                <a href="{{ route('user.sightings-map') }}" class="mobile-menu-link {{ Route::is('user.sightings-map') ? 'active' : '' }}">
                    <i class="bx bx-location-plus"></i>
                    <span>Sightings Map</span>
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