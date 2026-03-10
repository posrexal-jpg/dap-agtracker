@extends('layouts.admin')
@section('title', 'Admin Activity Logs - COTS Tracker')

@section('content')
<div class="activity-logs-page">
    <!-- Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="page-header-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <h1 class="page-title mb-0">Admin Activity Logs</h1>
                        <p class="page-subtitle mb-0">Track all administrative actions and changes</p>
                    </div>
                </div>
                <a href="{{ route('admin.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="container-fluid py-4">
        <!-- Filter Card -->
        <div class="filter-card mb-4">
            <form method="GET" action="{{ route('admin.activity-logs') }}" class="row g-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Activity Type</label>
                    <select name="activity_type" class="form-select">
                        <option value="">All Types</option>
                        @foreach($activityTypes as $type)
                            <option value="{{ $type }}" {{ $activityType === $type ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label">Admin User</label>
                    <select name="user_id" class="form-select">
                        <option value="">All Users</option>
                        @foreach($adminUsers as $admin)
                            <option value="{{ $admin->id }}" {{ $userId == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-6 col-lg-2">
                    <label class="form-label">From Date</label>
                    <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
                </div>

                <div class="col-12 col-md-6 col-lg-2">
                    <label class="form-label">To Date</label>
                    <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
                </div>

                <div class="col-12 col-lg-2">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ $search }}">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-2"></i>Apply Filters
                    </button>
                    <a href="{{ route('admin.activity-logs') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Activity Logs Table -->
        <div class="logs-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Type</th>
                            <th style="width: 150px;">Admin User</th>
                            <th>Description</th>
                            <th style="width: 120px;">IP Address</th>
                            <th style="width: 180px;">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activityLogs as $log)
                        <tr class="log-row" onclick="toggleDetails({{ $log->id }})">
                            <td>
                                <span class="badge activity-badge activity-{{ $log->activity_type }}">
                                    <i class="fas 
                                        @if($log->activity_type === 'create') fa-plus
                                        @elseif($log->activity_type === 'update') fa-edit
                                        @elseif($log->activity_type === 'delete') fa-trash
                                        @elseif($log->activity_type === 'approve') fa-check
                                        @elseif($log->activity_type === 'reject') fa-times
                                        @elseif($log->activity_type === 'export') fa-download
                                        @elseif($log->activity_type === 'bulk_approve') fa-check-double
                                        @elseif($log->activity_type === 'settings_change') fa-cog
                                        @elseif($log->activity_type === 'mark_read') fa-eye
                                        @else fa-info-circle
                                        @endif me-1"></i>
                                    {{ ucfirst(str_replace('_', ' ', $log->activity_type)) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2">
                                        {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <strong>{{ $log->user->name ?? 'System' }}</strong>
                                </div>
                            </td>
                            <td>
                                <div class="log-description">{{ $log->description }}</div>
                                @if($log->model_type)
                                <small class="text-muted">
                                    <i class="fas fa-cube me-1"></i>{{ class_basename($log->model_type) }} #{{ $log->model_id }}
                                </small>
                                @endif
                            </td>
                            <td>
                                <code class="small">{{ $log->ip_address }}</code>
                            </td>
                            <td>
                                <div class="small">
                                    <strong>{{ $log->created_at->format('M d, Y') }}</strong>
                                    <br>
                                    <span class="text-muted">{{ $log->created_at->format('h:i A') }}</span>
                                    <br>
                                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                        </tr>
                        @if($log->old_values || $log->new_values)
                        <tr id="details-{{ $log->id }}" class="details-row" style="display: none;">
                            <td colspan="5" class="details-content">
                                <div class="row g-3">
                                    @if($log->old_values)
                                    <div class="col-12 col-md-6">
                                        <strong class="text-danger">
                                            <i class="fas fa-minus-circle me-2"></i>Old Values:
                                        </strong>
                                        <pre class="code-block mt-2">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                    @endif
                                    @if($log->new_values)
                                    <div class="col-12 col-md-6">
                                        <strong class="text-success">
                                            <i class="fas fa-plus-circle me-2"></i>New Values:
                                        </strong>
                                        <pre class="code-block mt-2">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                    @endif
                                </div>
                                @if($log->user_agent)
                                <div class="mt-3">
                                    <strong><i class="fas fa-browser me-2"></i>User Agent:</strong>
                                    <div class="code-block mt-1">{{ $log->user_agent }}</div>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-clipboard fa-3x text-muted mb-3 d-block opacity-50"></i>
                                <p class="text-muted">No activity logs found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($activityLogs->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $activityLogs->firstItem() }} to {{ $activityLogs->lastItem() }} of {{ $activityLogs->total() }} logs
                    </div>
                    {{ $activityLogs->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Activity Logs Styles */
.activity-logs-page {
    background: #f1f5f9;
    min-height: 100vh;
}

.page-header {
    background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
    color: white;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.page-header-icon {
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
}

.page-subtitle {
    font-size: 0.9rem;
    opacity: 0.9;
}

.filter-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.logs-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
}

.table thead {
    background: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
}

.table thead th {
    font-weight: 600;
    color: #475569;
    border: none;
    padding: 1rem;
}

.table tbody td {
    padding: 1rem;
    border-bottom: 1px solid #f1f5f9;
}

.log-row {
    cursor: pointer;
    transition: background-color 0.2s;
}

.log-row:hover {
    background: #f8fafc;
}

.activity-badge {
    font-size: 0.75rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-weight: 600;
    white-space: nowrap;
}

.activity-create { background: #10b981; color: white; }
.activity-update { background: #3b82f6; color: white; }
.activity-delete { background: #ef4444; color: white; }
.activity-approve { background: #8b5cf6; color: white; }
.activity-reject { background: #f59e0b; color: white; }
.activity-export { background: #06b6d4; color: white; }
.activity-bulk_approve { background: #a855f7; color: white; }
.activity-settings_change { background: #6366f1; color: white; }
.activity-mark_read { background: #14b8a6; color: white; }

.user-avatar {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.75rem;
}

.log-description {
    color: #334155;
    line-height: 1.5;
}

.details-row .details-content {
    background: #f8fafc;
    padding: 1.5rem;
}

.code-block {
    background: #1e293b;
    color: #e2e8f0;
    padding: 1rem;
    border-radius: 8px;
    font-size: 0.8rem;
    line-height: 1.5;
    max-height: 300px;
    overflow-y: auto;
    margin: 0;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 12px;
    }

    .page-title {
        font-size: 1.15rem;
    }

    .page-subtitle {
        font-size: 0.813rem;
    }

    .filter-card {
        padding: 12px;
    }

    .table {
        font-size: 0.875rem;
    }

    .table thead th,
    .table tbody td {
        padding: 0.75rem 0.5rem;
    }

    .activity-badge {
        font-size: 0.65rem;
        padding: 0.25rem 0.5rem;
    }

    .user-avatar {
        width: 28px;
        height: 28px;
        font-size: 0.7rem;
    }
}
</style>

<script>
function toggleDetails(logId) {
    const detailsRow = document.getElementById('details-' + logId);
    if (detailsRow) {
        if (detailsRow.style.display === 'none') {
            detailsRow.style.display = 'table-row';
        } else {
            detailsRow.style.display = 'none';
        }
    }
}
</script>
@endsection
