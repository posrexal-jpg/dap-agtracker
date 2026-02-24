
<!-- Modern Admin Sidebar -->
<div class="admin-sidebar h-100">
    <!-- Sidebar Header -->
    <div class="sidebar-header p-4 border-bottom">
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
                <a href="{{ route('admin.index') }}" class="nav-link sidebar-link {{ Route::is('admin.index') ? 'active' : '' }}">
                    <div class="d-flex align-items-center">
                        <div class="nav-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <span class="nav-text">Dashboard</span>
                    </div>
                </a>
            </li>

            <!-- Sightings Map -->
            <li class="nav-item mb-1">
                <a href="{{ route('admin.location') }}" class="nav-link sidebar-link {{ Route::is('admin.location') ? 'active' : '' }}">
                    <div class="d-flex align-items-center">
                        <div class="nav-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <span class="nav-text">Sightings Map</span>
                    </div>
                </a>
            </li>

            <!-- Reports -->
            <li class="nav-item mb-1">
                <a href="{{ route('admin.report') }}" class="nav-link sidebar-link {{ Route::is('admin.report') ? 'active' : '' }}">
                    <div class="d-flex align-items-center">
                        <div class="nav-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <span class="nav-text">Reports</span>
                    </div>
                </a>
            </li>

            <!-- Section Divider -->
            <li class="nav-divider my-3">
                <hr class="border-light">
                <small class="text-muted px-3">Management</small>
            </li>

            <!-- Manage Users -->
            <li class="nav-item mb-1">
                <a href="{{ route('admin.adduser') }}" class="nav-link sidebar-link {{ Route::is('admin.adduser') ? 'active' : '' }}">
                    <div class="d-flex align-items-center">
                        <div class="nav-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="nav-text">Manage Users</span>
                    </div>
                </a>
            </li>

            <!-- Municipalities -->
            <li class="nav-item mb-1">
                <a href="{{ route('admin.municipal') }}" class="nav-link sidebar-link {{ Route::is('admin.municipal') ? 'active' : '' }}">
                    <div class="d-flex align-items-center">
                        <div class="nav-icon">
                            <i class="fas fa-city"></i>
                        </div>
                        <span class="nav-text">Municipalities</span>
                    </div>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer p-3 border-top">
        <div class="d-flex align-items-center text-muted">
            <i class="fas fa-shield-alt me-2"></i>
            <small>Admin Access</small>
        </div>
    </div>
</div>

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
