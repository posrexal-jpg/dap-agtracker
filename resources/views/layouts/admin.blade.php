<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">
    <title>@yield('title', 'Admin Dashboard - COTS Tracker')</title>
    <meta name="description" content="COTS Tracker Admin Dashboard - Monitor and manage Crown-of-Thorns Starfish sightings">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- API Token for PWA -->
    <meta name="api-token" content="{{ Auth::check() ? Auth::user()->currentAccessToken()?->plainTextToken : '' }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.74.0/dist/L.Control.Locate.min.css">

    <!-- Custom CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/css/mobile-menu.css'])

    @stack('styles')

    <style>
        /* Force Light Mode - Prevent System Dark Mode */
        html, body {
            color-scheme: light !important;
            background: #f8fafc !important;
            color: #1f2937 !important;
        }

        /* Override Bootstrap Dark Mode */
        [data-bs-theme="dark"],
        [data-theme="dark"] {
            color-scheme: light !important;
            background: #f8fafc !important;
            color: #1f2937 !important;
        }

        /* Base Layout Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow-x: hidden;
            position: relative;
        }

        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background: #f8fafc !important;
            color: #1f2937 !important;
        }

        /* Layout Wrapper - matches user layout */
        .layout-wrapper {
            display: flex;
            flex-direction: row;
            min-height: 100vh;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        .layout-container {
            display: flex;
            flex: 1;
            min-height: 100vh;
            position: relative;
        }

        .layout-page {
            flex: 1;
            margin-left: 280px;
            margin-top: 0 !important;
            min-width: 0;
            display: flex;
            flex-direction: column;
            background: #f8fafc !important;
            color: #1f2937 !important;
            position: relative;
        }

        .layout-page main {
            flex: 1;
            padding: 2rem;
            padding-top: 0;
            position: relative;
            background: transparent;
        }



        /* Mobile Responsive */
        @media (max-width: 1199.98px) {
            * {
                box-sizing: border-box !important;
            }

            body {
                overflow-x: hidden !important;
                width: 100vw !important;
            }

            .layout-page {
                margin-left: 0;
                margin-top: 0 !important;
                min-width: 0;
                width: 100vw;
                max-width: 100vw;
                padding: 12px;
                overflow-x: hidden !important;
            }

            .layout-wrapper {
                flex-direction: column;
                overflow-x: hidden !important;
            }
        }

        /* Ensure content is always above mobile menu */
        @media (max-width: 991px) {
            body {
                padding-bottom: 80px; /* Space for mobile menu */
                overflow-x: hidden !important;
            }

            .layout-page main {
                padding: 0.75rem;
                padding-bottom: 100px; /* Extra space for mobile menu */
                max-width: 100vw;
                overflow-x: hidden !important;
            }
        }

        /* Material-UI Bottom Navigation Styles */
        @media (max-width: 991px) {
            .mui-bottom-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: #ffffff;
                box-shadow: 0 -2px 4px -1px rgba(0,0,0,.2), 0 -4px 5px 0 rgba(0,0,0,.14), 0 -1px 10px 0 rgba(0,0,0,.12) !important;
                z-index: 1050;
                height: 64px;
                display: flex;
                align-items: center;
                border-radius: 0;
            }

            .mui-nav-container {
                display: flex;
                width: 100%;
                justify-content: space-around;
                align-items: center;
                padding: 0 8px;
            }

            .mobile-menu-item {
                flex: 1;
                display: flex;
                justify-content: center;
            }

            .mobile-menu-link {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 8px 12px;
                text-decoration: none;
                color: rgba(0, 0, 0, 0.6) !important;
                min-width: 64px;
                max-width: 168px;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                border-radius: 8px;
            }

            .mobile-menu-link i {
                font-size: 1.5rem;
                margin-bottom: 4px;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .mobile-menu-link span {
                font-size: 0.75rem;
                font-weight: 500;
                letter-spacing: 0.0892857143em;
                text-transform: none;
                line-height: 1.2;
            }

            .mobile-menu-link.active {
                color: #1976d2 !important;
                background: rgba(25, 118, 210, 0.08);
            }

            .mobile-menu-link.active i {
                transform: scale(1.1);
            }

            .mobile-menu-link:active {
                background: rgba(25, 118, 210, 0.12);
            }

            /* Notification badge */
            .mobile-menu-link .badge {
                position: absolute;
                top: 4px;
                right: 8px;
                min-width: 18px;
                height: 18px;
                border-radius: 9px;
                font-size: 0.625rem;
                padding: 0 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #d32f2f;
                color: #ffffff;
                font-weight: 500;
            }

            /* Hide drag handle on Material UI mode */
            .mobile-menu-drag-handle {
                display: none;
            }
        }

        /* Print Styles */
        @media print {
            .admin-sidebar,
            .sidebar-overlay,
            .mobile-horizontal-menu {
                display: none !important;
            }

            .layout-page {
                margin-left: 0 !important;
            }
        }
        /* Mobile Menu Notification Styles */
        .mobile-menu-item .mobile-menu-link {
            position: relative;
        }

        .mobile-menu-item #notificationBadge {
            z-index: 1;
        }
        
        .mobile-menu-item .mobile-menu-link .badge {
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="admin-page">

<!-- Page Content -->
<div class="layout-wrapper layout-content-navbar" style="position: relative; z-index: 1;">
    <div class="layout-container d-flex flex-row">
        @if(auth()->check() && auth()->user()->isAdmin())
            <aside class="d-none d-lg-block">
                @include('admin.menu')
            </aside>
        @endif
        <div class="layout-page flex-grow-1 d-flex flex-column">
            <main class="pb-4 flex-grow-1 d-flex flex-column">
                @yield('content')
            </main>
        </div>
    </div>
</div>

<!-- Layout overlay for mobile menu -->
<div class="layout-overlay"></div>

<!-- Mobile Menu -->
@include('components.mobile-menu')

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.74.0/dist/L.Control.Locate.min.js"></script>

<!-- jQuery (required for notification system) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript (Vite) -->
@vite(['resources/js/app.js', 'resources/js/mobile-menu.js', 'resources/js/service-worker.js'])

<!-- Notification Script -->
<script>
$(document).ready(function() {
    // Fetch notifications on page load
    fetchNotifications();

    // Poll for new notifications every 30 seconds
    setInterval(fetchNotifications, 30000);

    // Fetch notifications function
    function fetchNotifications() {
        $.ajax({
            url: '{{ route("admin.notifications.recent") }}',
            method: 'GET',
            success: function(response) {
                updateNotificationBadge(response.unread_count);
                updateNotificationList(response.notifications);
            },
            error: function(xhr) {
                console.error('Failed to fetch notifications:', xhr);
            }
        });
    }

    // Update notification badge
    function updateNotificationBadge(count) {
        const badge = $('#notificationBadge');
        const sidebarBadge = $('#sidebarNotificationBadge');
        
        if (count > 0) {
            badge.text(count).show();
            sidebarBadge.text(count).show();
        } else {
            badge.hide();
            sidebarBadge.hide();
        }
    }

    // Update notification list
    function updateNotificationList(notifications) {
        const list = $('#notificationList');
        list.empty();

        if (notifications.length === 0) {
            list.html(`
                <li class="text-center py-4 text-muted">
                    <i class="bx bx-bell-off fs-3 d-block mb-2"></i>
                    <small>No notifications</small>
                </li>
            `);
            return;
        }

        notifications.forEach(function(notification) {
            const isRead = notification.is_read;
            const bgClass = isRead ? '' : 'bg-light';
            const timeAgo = getTimeAgo(notification.created_at);
            
            list.append(`
                <li class="dropdown-item ${bgClass} notification-item" data-id="${notification.id}" style="cursor: pointer; padding: 12px 16px; border-bottom: 1px solid #f0f0f0;">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="bx bx-map-pin text-primary fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 fw-semibold" style="font-size: 0.9rem;">${notification.title}</h6>
                            <p class="mb-1 text-muted" style="font-size: 0.85rem;">${notification.message}</p>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="bx bx-time-five"></i> ${timeAgo}
                            </small>
                        </div>
                        ${!isRead ? '<div class="ms-2"><span class="badge bg-primary rounded-circle" style="width: 8px; height: 8px; padding: 0;"></span></div>' : ''}
                    </div>
                </li>
            `);
        });
    }

    // Get time ago string
    function getTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);

        if (seconds < 60) return 'Just now';
        if (seconds < 3600) return Math.floor(seconds / 60) + ' minutes ago';
        if (seconds < 86400) return Math.floor(seconds / 3600) + ' hours ago';
        if (seconds < 604800) return Math.floor(seconds / 86400) + ' days ago';
        return date.toLocaleDateString();
    }

    // Mark notification as read on click
    $(document).on('click', '.notification-item', function() {
        const notificationId = $(this).data('id');
        const notification = $(this);

        $.ajax({
            url: `/admin/notifications/${notificationId}/read`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                notification.removeClass('bg-light');
                notification.find('.badge').remove();
                fetchNotifications(); // Refresh to update badge count
            }
        });
    });

    // Mark all as read
    $('#markAllReadBtn').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        $.ajax({
            url: '{{ route("admin.notifications.mark-all-read") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                fetchNotifications();
            }
        });
    });
});
</script>

@stack('scripts')

</body>
</html>