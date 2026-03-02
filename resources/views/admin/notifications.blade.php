@extends('layouts.admin')

@section('title', 'Notifications - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bx bx-bell me-2"></i>Notifications
                    </h4>
                    <div>
                        <button class="btn btn-sm btn-light me-2" id="markAllReadBtn">
                            <i class="bx bx-check-double"></i> Mark All Read
                        </button>
                        <button class="btn btn-sm btn-light" id="clearReadBtn">
                            <i class="bx bx-trash"></i> Clear Read
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($notifications->count() > 0)
                        <div class="list-group">
                            @foreach($notifications as $notification)
                                <div class="list-group-item notification-item {{ !$notification->is_read ? 'bg-light border-start border-primary border-3' : '' }}" 
                                     data-id="{{ $notification->id }}"
                                     style="cursor: pointer;">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bx bx-map-pin text-primary fs-4 me-3"></i>
                                                <div>
                                                    <h5 class="mb-1 fw-semibold">{{ $notification->title }}</h5>
                                                    <p class="mb-1 text-muted">{{ $notification->message }}</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center text-muted small">
                                                <i class="bx bx-time-five me-1"></i>
                                                <span>{{ $notification->created_at->diffForHumans() }}</span>
                                                
                                                @if($notification->user)
                                                    <span class="mx-2">•</span>
                                                    <i class="bx bx-user me-1"></i>
                                                    <span>{{ $notification->user->name }}</span>
                                                @endif

                                                @if($notification->location)
                                                    <span class="mx-2">•</span>
                                                    <i class="bx bx-map me-1"></i>
                                                    <span>{{ $notification->location->municipality }}, {{ $notification->location->barangay }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            @if(!$notification->is_read)
                                                <span class="badge bg-primary rounded-pill">New</span>
                                            @else
                                                <span class="text-success"><i class="bx bx-check-circle"></i></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bx bx-bell-off display-1 text-muted"></i>
                            <h5 class="mt-3 text-muted">No notifications yet</h5>
                            <p class="text-muted">You'll be notified when there are new sightings</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .notification-item {
        transition: all 0.3s ease;
    }

    .notification-item:hover {
        background-color: #f8f9fa !important;
        transform: translateX(5px);
    }

    .list-group-item {
        border-left-width: 3px !important;
    }
</style>

@push('scripts')
<script>
$(document).ready(function() {
    // Mark notification as read on click
    $('.notification-item').on('click', function() {
        const notificationId = $(this).data('id');
        const notification = $(this);

        $.ajax({
            url: `/admin/notifications/${notificationId}/read`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                notification.removeClass('bg-light border-primary border-3');
                notification.find('.badge-primary').remove();
                notification.find('.flex-shrink-0').html('<span class="text-success"><i class="bx bx-check-circle"></i></span>');
            }
        });
    });

    // Mark all as read
    $('#markAllReadBtn').on('click', function() {
        $.ajax({
            url: '{{ route("admin.notifications.mark-all-read") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                location.reload();
            }
        });
    });

    // Clear read notifications
    $('#clearReadBtn').on('click', function() {
        if (confirm('Are you sure you want to delete all read notifications?')) {
            $.ajax({
                url: '{{ route("admin.notifications.clear-read") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    location.reload();
                }
            });
        }
    });
});
</script>
@endpush
@endsection
