
<!-- Admin Sidebar -->
<div class="admin-sidebar h-100">
    <!-- Sidebar Header -->
    <div class="sidebar-header border-bottom">
        <div class="d-flex align-items-center">
            <div class="sidebar-brand-icon bg-primary rounded-3 p-2 me-3">
                <i class="fas fa-fish text-white fs-5"></i>
            </div>
            <div class="sidebar-brand-text">
                <h6 class="mb-0 fw-bold text-dark">COTS Tracker</h6>
                <small class="text-muted">Admin Panel</small>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="sidebar-nav flex-grow-1 p-3">
        <ul class="nav flex-column">

            <!-- Dashboard -->
            <li class="nav-item mb-1">
                <a href="{{ route('admin.index') }}"
                   class="nav-link sidebar-link {{ Route::is('admin.index') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-tachometer-alt"></i></div>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Sightings Map -->
            <li class="nav-item mb-1">
                <a href="{{ route('admin.location') }}"
                   class="nav-link sidebar-link {{ Route::is('admin.location') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-map-marked-alt"></i></div>
                    <span class="nav-text">Sightings Map</span>
                </a>
            </li>

            <!-- Reports -->
            <li class="nav-item mb-1">
                <a href="{{ route('admin.report') }}"
                   class="nav-link sidebar-link {{ Route::is('admin.report') || Route::is('admin.report.export') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-chart-bar"></i></div>
                    <span class="nav-text">Reports</span>
                </a>
            </li>

            <!-- Downloads -->
            <li class="nav-item mb-1">
                <a href="{{ route('admin.download') }}"
                   class="nav-link sidebar-link {{ Route::is('admin.download') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-download"></i></div>
                    <span class="nav-text">Downloads</span>
                </a>
            </li>

            <!-- Divider -->
            <li class="nav-divider my-3">
                <hr>
                <small class="text-muted">Management</small>
            </li>

            <!-- Manage Users -->
            <li class="nav-item mb-1">
                <a href="{{ route('admin.adduser') }}"
                   class="nav-link sidebar-link {{ Route::is('admin.adduser') || Route::is('admin.adduser.create') || Route::is('admin.users.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-users"></i></div>
                    <span class="nav-text">Manage Users</span>
                </a>
            </li>

            <!-- Municipalities -->
            <li class="nav-item mb-1">
                <a href="{{ route('admin.municipal') }}"
                   class="nav-link sidebar-link {{ Route::is('admin.municipal') || Route::is('admin.municipal.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-city"></i></div>
                    <span class="nav-text">Municipalities</span>
                </a>
            </li>

        </ul>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer p-3 border-top mt-auto">
        <div class="d-flex align-items-center text-muted small">
            <i class="fas fa-shield-alt me-2"></i>
            <span>Admin Access</span>
        </div>
    </div>
</div>
