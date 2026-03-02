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
    /* Stats Cards */
    .stats-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stats-icon.read {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        color: #2C5F2D;
    }

    .stats-card h3 {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
    }

    .stats-card p {
        font-size: 0.9rem;
        margin: 0;
    }

    /* Notifications Container */
    .notifications-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* Notification Card */
    .notification-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        gap: 1rem;
        position: relative;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        overflow: hidden;
    }

    .notification-card:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }

    .notification-card.unread {
        background: linear-gradient(to right, #f7fafc 0%, #ffffff 100%);
        border-left: 4px solid #667eea;
    }

    .notification-card.read {
        background: #fff;
        border-left: 4px solid #e2e8f0;
    }

    .notification-indicator {
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .notification-card.read .notification-icon {
        background: linear-gradient(135deg, #cbd5e0 0%, #a0aec0 100%);
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
        color: #2d3748;
        margin: 0;
        flex: 1;
    }

    .badge-new {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
        color: #4a5568;
        margin-bottom: 0.75rem;
        line-height: 1.5;
    }

    .notification-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        font-size: 0.85rem;
        color: #718096;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .meta-item i {
        font-size: 1rem;
    }

    .notification-status {
        display: flex;
        align-items: center;
        color: #48bb78;
        font-size: 1.75rem;
    }

    /* Empty State */
    .empty-state {
        background: #fff;
        border-radius: 16px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #f6f8fb 0%, #e9ecef 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #a0aec0;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 1rem;
        color: #718096;
        margin-bottom: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .notification-card {
            flex-direction: column;
            padding: 1rem;
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
            flex-direction: column;
            gap: 0.5rem;
        }

        .stats-card {
            padding: 1rem;
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }

        .stats-card h3 {
            font-size: 1.5rem;
        }
    }

    /* Action Buttons */
    .btn-outline-primary {
        border-color: #667eea;
        color: #667eea;
    }

    .btn-outline-primary:hover {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }

    .btn-outline-danger {
        border-color: #f56565;
        color: #f56565;
    }

    .btn-outline-danger:hover {
        background: #f56565;
        border-color: #f56565;
        color: white;
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
