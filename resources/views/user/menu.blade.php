
@extends('layouts.app')
@section('sidebar')
<!-- User Sidebar Menu -->
<aside id="user-sidebar" class="user-sidebar">
    <div class="sidebar-header">
        <a href="{{ route('user.index') }}" class="brand-link">
            <div class="brand-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Dag-ag Tracker Logo" class="logo-img">
            </div>
            <div class="brand-text">
                <span class="brand-title">Dag-ag Tracker</span>
                <div class="brand-subtitle">User Panel</div>
            </div>
        </a>
        <button class="sidebar-close" id="user-sidebar-close">
            <i class="bx bx-x"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <!-- Sightings Map -->
            <li class="nav-item {{ Route::is('user.index') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="nav-link">
                    <div class="nav-icon">
                        <i class="bx bx-home-circle"></i>
                    </div>
                    <span class="nav-text">Sightings Map</span>
                    <small class="nav-desc">Interactive Map View</small>
                </a>
            </li>

            <!-- Download -->
            <li class="nav-item {{ Route::is('user.download') ? 'active' : '' }}">
                <a href="{{ route('user.download') }}" class="nav-link">
                    <div class="nav-icon">
                        <i class="bx bx-upload"></i>
                    </div>
                    <span class="nav-text">Download</span>
                    <small class="nav-desc">Data Export</small>
                </a>
            </li>
        </ul>
    </nav>
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
    background: linear-gradient(180deg, #ffffff 0%, #f0f9ff 100%);
    box-shadow: 2px 0 20px rgba(0, 0, 0, 0.08);
    z-index: 1050;
    transform: translateX(-100%);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-right: 1px solid #e2e8f0;
    overflow-y: auto;
    overflow-x: hidden;
}

.user-sidebar.open {
    transform: translateX(0);
}

.sidebar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: #ffffff;
    position: sticky;
    top: 0;
    z-index: 10;
}

.brand-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #0369a1;
    flex: 1;
    min-width: 0;
}

.brand-logo {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
}

.logo-img {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    object-fit: cover;
}

.brand-text {
    min-width: 0;
    flex: 1;
}

.brand-title {
    display: block;
    font-size: 1.25rem;
    font-weight: 700;
    color: #0369a1;
    line-height: 1.2;
    margin-bottom: 0.125rem;
}

.brand-subtitle {
    font-size: 0.75rem;
    color: #64748b;
    font-weight: 500;
}

.sidebar-close {
    width: 40px;
    height: 40px;
    border: none;
    background: transparent;
    border-radius: 8px;
    color: #64748b;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.sidebar-close:hover {
    background: #f1f5f9;
    color: #0369a1;
}

.sidebar-nav {
    padding: 1rem 0;
    height: calc(100vh - 100px);
    display: flex;
    flex-direction: column;
}

.nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
    flex: 1;
}

.nav-item {
    margin: 0.25rem 0;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 0.875rem 1.5rem;
    text-decoration: none;
    color: #475569;
    transition: all 0.3s ease;
    border-radius: 0 25px 25px 0;
    margin: 0 0.5rem 0 0;
    position: relative;
    border: none;
    background: transparent;
}

.nav-link:hover {
    background: rgba(3, 105, 161, 0.08);
    color: #0369a1;
    transform: translateX(4px);
}

.nav-item.active .nav-link {
    background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(3, 105, 161, 0.3);
}

.nav-item.active .nav-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 60%;
    background: white;
    border-radius: 0 4px 4px 0;
}

.nav-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.25rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.nav-item.active .nav-icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.nav-link:hover .nav-icon {
    background: rgba(3, 105, 161, 0.1);
    transform: scale(1.05);
}

.nav-text {
    font-size: 0.95rem;
    font-weight: 600;
    line-height: 1.2;
    margin-bottom: 0.125rem;
}

.nav-desc {
    font-size: 0.75rem;
    opacity: 0.8;
    line-height: 1.2;
    display: block;
}

.sidebar-footer {
    margin-top: auto;
    padding: 1rem 0;
    border-top: 1px solid #e2e8f0;
}

.logout-link {
    display: flex;
    align-items: center;
    padding: 0.875rem 1.5rem;
    text-decoration: none;
    color: #dc2626;
    transition: all 0.3s ease;
    border-radius: 0 25px 25px 0;
    margin: 0 0.5rem 0 0;
    border: none;
    background: transparent;
}

.logout-link:hover {
    background: rgba(220, 38, 38, 0.1);
    color: #b91c1c;
    transform: translateX(4px);
}

.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1040;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.sidebar-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* Desktop Styles */
@media (min-width: 1200px) {
    .user-sidebar {
        position: fixed;
        transform: translateX(0);
        z-index: 1000;
    }

    .sidebar-close {
        display: none;
    }

    .sidebar-overlay {
        display: none;
    }
}

/* Tablet Styles */
@media (max-width: 1199px) and (min-width: 768px) {
    .user-sidebar {
        width: 260px;
    }

    .brand-title {
        font-size: 1.1rem;
    }

    .nav-link {
        padding: 0.75rem 1.25rem;
    }
}

/* Mobile Styles */
@media (max-width: 767px) {
    .user-sidebar {
        width: 100%;
        max-width: 320px;
    }

    .sidebar-header {
        padding: 1.25rem;
    }

    .brand-logo {
        width: 40px;
        height: 40px;
    }

    .logo-img {
        width: 28px;
        height: 28px;
    }

    .brand-title {
        font-size: 1.1rem;
    }

    .nav-link {
        padding: 1rem 1.25rem;
    }

    .nav-icon {
        width: 36px;
        height: 36px;
        font-size: 1.1rem;
    }

    .nav-text {
        font-size: 0.9rem;
    }

    .nav-desc {
        font-size: 0.7rem;
    }
}

/* Small Mobile */
@media (max-width: 480px) {
    .user-sidebar {
        max-width: 280px;
    }

    .sidebar-header {
        padding: 1rem;
    }

    .brand-text {
        display: none;
    }

    .nav-link {
        justify-content: center;
        padding: 1rem;
    }

    .nav-icon {
        margin-right: 0;
        margin-bottom: 0.25rem;
    }

    .nav-text,
    .nav-desc {
        text-align: center;
        margin-bottom: 0.125rem;
    }

    .nav-desc {
        font-size: 0.65rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .user-sidebar {
        background: linear-gradient(180deg, #1f2937 0%, #0f172a 100%);
        border-color: #374151;
    }

    .sidebar-header {
        background: #1f2937;
        border-color: #374151;
    }

    .brand-title {
        color: #f9fafb;
    }

    .brand-subtitle {
        color: #9ca3af;
    }

    .sidebar-close {
        color: #9ca3af;
    }

    .sidebar-close:hover {
        background: #374151;
        color: #f9fafb;
    }

    .nav-link {
        color: #d1d5db;
    }

    .nav-link:hover {
        background: rgba(3, 105, 161, 0.1);
        color: #38bdf8;
    }

    .nav-item.active .nav-link {
        background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
    }

    .sidebar-footer {
        border-color: #374151;
    }

    .logout-link {
        color: #f87171;
    }

    .logout-link:hover {
        background: rgba(248, 113, 113, 0.1);
        color: #fca5a5;
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
// User sidebar functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('user-sidebar');
    const overlay = document.getElementById('user-sidebar-overlay');
    const closeBtn = document.getElementById('user-sidebar-close');
    const menuToggle = document.querySelector('.layout-menu-toggle');

    // Function to open sidebar
    function openSidebar() {
        if (sidebar) {
            sidebar.classList.add('open');
            if (overlay) overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    // Function to close sidebar
    function closeSidebar() {
        if (sidebar) {
            sidebar.classList.remove('open');
            if (overlay) overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Menu toggle button
    if (menuToggle) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            openSidebar();
        });
    }

    // Close button
    if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
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

    // Close sidebar when clicking on nav links (mobile)
    if (sidebar) {
        const navLinks = sidebar.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 1200) {
                    setTimeout(closeSidebar, 300);
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

    // Prevent sidebar from closing when clicking inside it
    if (sidebar) {
        sidebar.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>
@endsection