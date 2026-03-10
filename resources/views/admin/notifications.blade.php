@extends('layouts.admin')

@section('title', 'Notifications - Admin Dashboard')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="mb-1 fw-bold text-dark">
                        <i class="bx bx-bell text-primary me-2"></i>Notifications
                    </h2>
                    <p class="text-muted mb-0">Stay updated with latest COTS sightings</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" id="markAllReadBtn">
                        <i class="bx bx-check-double"></i> Mark All Read
                    </button>
                    <button class="btn btn-outline-danger btn-sm" id="clearReadBtn">
                        <i class="bx bx-trash"></i> Clear Read
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if($notifications->count() > 0)
        <!-- Stats Summary -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="stats-card">
                    <div class="stats-icon unread">
                        <i class="bx bx-bell"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $notifications->where('is_read', false)->count() }}</h3>
                        <p class="text-muted mb-0">Unread</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stats-card">
                    <div class="stats-icon read">
                        <i class="bx bx-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $notifications->where('is_read', true)->count() }}</h3>
                        <p class="text-muted mb-0">Read</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="row">
            <div class="col-12">
                <div class="notifications-container">
                    @foreach($notifications as $notification)
                        <div class="notification-card {{ !$notification->is_read ? 'unread' : 'read' }}" 
                             data-id="{{ $notification->id }}">
                            <div class="notification-indicator"></div>
                            <div class="notification-icon">
                                <i class="bx bx-map-pin"></i>
                            </div>
                            <div class="notification-content">
                                <div class="notification-header">
                                    <h5 class="notification-title">{{ $notification->title }}</h5>
                                    @if(!$notification->is_read)
                                        <span class="badge-new">New</span>
                                    @endif
                                </div>
                                <p class="notification-message">{{ $notification->message }}</p>
                                <div class="notification-meta">
                                    <span class="meta-item">
                                        <i class="bx bx-time-five"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    @if($notification->user)
                                        <span class="meta-item">
                                            <i class="bx bx-user"></i>
                                            {{ $notification->user->name }}
                                        </span>
                                    @endif
                                    @if($notification->location)
                                        <span class="meta-item">
                                            <i class="bx bx-map"></i>
                                            {{ $notification->location->municipality }}, {{ $notification->location->barangay }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if($notification->is_read)
                                <div class="notification-status">
                                    <i class="bx bx-check-circle"></i>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bx bx-bell-off"></i>
                    </div>
                    <h3>No notifications yet</h3>
                    <p>You'll be notified when there are new COTS sightings</p>
                    <a href="{{ route('admin.location') }}" class="btn btn-primary mt-3">
                        <i class="bx bx-map"></i> View Sightings Map
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    /* Force Light Mode */
    html, body {
        color-scheme: light !important;
        background: #f8fafc !important;
        color: #1f2937 !important;
    }

    .container-fluid {
        background: transparent !important;
    }

    /* Page Header */
    h2 {
        color: #1f2937 !important;
    }

    .text-dark {
        color: #1f2937 !important;
    }

    .text-muted {
        color: #6b7280 !important;
    }

    .text-primary {
        color: #3b82f6 !important;
    }

    /* Buttons */
    .btn {
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-outline-primary {
        border: 2px solid #3b82f6 !important;
        color: #3b82f6 !important;
        background: #ffffff !important;
    }

    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        border-color: transparent !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .btn-outline-danger {
        border: 2px solid #dc2626 !important;
        color: #dc2626 !important;
        background: #ffffff !important;
    }

    .btn-outline-danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;
        border-color: transparent !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    .btn-primary {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 64, 175, 0.4);
    }

    /* Stats Cards */
    .stats-card {
        background: #ffffff !important;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }

    .stats-icon.unread {
        background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
        color: white;
    }

    .stats-icon.read {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: white;
    }

    .stats-card h3 {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937 !important;
    }

    .stats-card p {
        font-size: 0.9rem;
        margin: 0;
        color: #6b7280 !important;
    }

    /* Notifications Container */
    .notifications-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* Notification Card */
    .notification-card {
        background: #ffffff !important;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        gap: 1rem;
        position: relative;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        overflow: hidden;
    }

    .notification-card:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12);
    }

    .notification-card.unread {
        background: linear-gradient(to right, #eff6ff 0%, #ffffff 100%) !important;
        border-left: 4px solid #8b5cf6;
    }

    .notification-card.read {
        background: #ffffff !important;
        border-left: 4px solid #e5e7eb;
    }

    .notification-indicator {
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #8b5cf6 0%, #a78bfa 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .notification-card.unread .notification-indicator {
        opacity: 1;
    }

    .notification-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .notification-card.read .notification-icon {
        background: linear-gradient(135deg, #9ca3af 0%, #d1d5db 100%);
    }

    .notification-content {
        flex: 1;
        min-width: 0;
    }

    .notification-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .notification-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937 !important;
        margin: 0;
        flex: 1;
    }

    .badge-new {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        color: white;
        font-size: 0.7rem;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    .notification-message {
        font-size: 0.95rem;
        color: #4b5563 !important;
        margin-bottom: 0.75rem;
        line-height: 1.5;
    }

    .notification-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        font-size: 0.85rem;
        color: #6b7280 !important;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        color: #6b7280 !important;
    }

    .meta-item i {
        font-size: 1rem;
    }

    .notification-status {
        display: flex;
        align-items: center;
        color: #10b981 !important;
        font-size: 1.75rem;
    }

    /* Empty State */
    .empty-state {
        background: #ffffff !important;
        border-radius: 16px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #9ca3af !important;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937 !important;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 1rem;
        color: #6b7280 !important;
        margin-bottom: 0;
    }

    /* Responsive - Material Design for Mobile */
    @media (max-width: 768px) {
        h2 {
            font-size: 1.5rem !important;
        }

        .btn {
            font-size: 0.875rem;
            padding: 0.625rem 1rem;
        }

        .notification-card {
            flex-direction: row;
            padding: 1rem;
            border-radius: 12px;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            font-size: 1.25rem;
        }

        .notification-title {
            font-size: 1rem;
        }

        .notification-message {
            font-size: 0.9rem;
        }

        .notification-meta {
            font-size: 0.8rem;
            gap: 0.75rem;
        }

        .stats-card {
            padding: 1.25rem;
            border-radius: 12px;
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }

        .stats-card h3 {
            font-size: 1.5rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            font-size: 2.5rem;
        }

        .empty-state {
            padding: 3rem 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .notification-card {
            padding: 0.875rem;
        }

        .notification-meta {
            flex-direction: column;
            gap: 0.5rem;
        }
    }

    /* Dark Mode Prevention */
    @media (prefers-color-scheme: dark) {
        html, body, .stats-card, .notification-card, .empty-state {
            background: #ffffff !important;
            color: #1f2937 !important;
        }

        .notification-title, .notification-message, .meta-item, .stats-card h3, .stats-card p, .empty-state h3, .empty-state p {
            color: #1f2937 !important;
        }
    }
</style>

@push('scripts')
<script>
$(document).ready(function() {
    // Mark notification as read on click
    $('.notification-card').on('click', function() {
        const notificationId = $(this).data('id');
        const notificationCard = $(this);

        if (notificationCard.hasClass('unread')) {
            $.ajax({
                url: `/admin/notifications/${notificationId}/read`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    notificationCard.removeClass('unread').addClass('read');
                    notificationCard.find('.badge-new').fadeOut(300, function() {
                        $(this).remove();
                    });
                    notificationCard.find('.notification-icon').css({
                        'background': 'linear-gradient(135deg, #cbd5e0 0%, #a0aec0 100%)'
                    });
                    notificationCard.append('<div class="notification-status"><i class="bx bx-check-circle"></i></div>');
                    
                    // Update stats
                    updateStatsCount();
                }
            });
        }
    });

    // Mark all as read
    $('#markAllReadBtn').on('click', function() {
        const btn = $(this);
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Processing...');

        $.ajax({
            url: '{{ route("admin.notifications.mark-all-read") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                location.reload();
            },
            error: function() {
                btn.prop('disabled', false);
                btn.html('<i class="bx bx-check-double"></i> Mark All Read');
                alert('Failed to mark all notifications as read');
            }
        });
    });

    // Clear read notifications
    $('#clearReadBtn').on('click', function() {
        if (confirm('Are you sure you want to delete all read notifications? This action cannot be undone.')) {
            const btn = $(this);
            btn.prop('disabled', true);
            btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Deleting...');

            $.ajax({
                url: '{{ route("admin.notifications.clear-read") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    location.reload();
                },
                error: function() {
                    btn.prop('disabled', false);
                    btn.html('<i class="bx bx-trash"></i> Clear Read');
                    alert('Failed to delete read notifications');
                }
            });
        }
    });

    // Update stats count
    function updateStatsCount() {
        const unreadCount = $('.notification-card.unread').length;
        const readCount = $('.notification-card.read').length;
        
        // Optionally update the stats cards dynamically
        $('.stats-card').eq(0).find('h3').text(unreadCount);
        $('.stats-card').eq(1).find('h3').text(readCount);
    }
});
</script>
@endpush
@endsection
