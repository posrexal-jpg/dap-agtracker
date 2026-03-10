@extends('layouts.admin')

@push('styles')
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

    /* Page Design */
    .container-fluid {
        background: #f8fafc !important;
        color: #1f2937 !important;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        padding: 32px 24px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        border: 1px solid #e5e7eb;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1e3a8a !important;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-subtitle {
        color: #6b7280 !important;
        font-size: 1rem;
        margin: 0;
    }

    /* Cards */
    .card {
        border-radius: 16px !important;
        border: 1px solid #e5e7eb !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
        background: #ffffff !important;
        color: #1f2937 !important;
        margin-bottom: 1.5rem;
    }

    .card-header {
        background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%) !important;
        border-bottom: 2px solid #e5e7eb !important;
        padding: 1.25rem 1.5rem;
        border-radius: 16px 16px 0 0 !important;
    }

    .card-title {
        color: #1e3a8a !important;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .card-body {
        padding: 1.5rem;
        background: #ffffff !important;
    }

    .card.border-info {
        border: 2px solid #3b82f6 !important;
        background: linear-gradient(135deg, #dbeafe 0%, #ffffff 100%) !important;
    }

    .card.border-warning {
        border: 2px solid #f59e0b !important;
        background: #fef3c7 !important;
    }

    /* Table */
    .table {
        background: #ffffff !important;
        color: #1f2937 !important;
    }

    .table thead {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%) !important;
    }

    .table thead th {
        color: #1e3a8a !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #d1d5db !important;
        padding: 1rem 0.75rem;
    }

    .table tbody tr {
        background: #ffffff !important;
        border-bottom: 1px solid #f3f4f6 !important;
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background: #f9fafb !important;
        transform: translateX(4px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        color: #374151 !important;
    }

    .table-warning {
        background: #fef3c7 !important;
    }

    .table-warning:hover {
        background: #fde68a !important;
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
    }

    .btn-warning {
        background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(217, 119, 6, 0.4);
    }

    .btn-danger,
    .btn-outline-danger {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        border: none !important;
    }

    .btn-danger:hover,
    .btn-outline-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
    }

    .btn-outline-warning {
        background: #ffffff !important;
        color: #d97706 !important;
        border: 2px solid #f59e0b !important;
    }

    .btn-outline-warning:hover {
        background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%) !important;
        color: #ffffff !important;
        border-color: transparent !important;
    }

    .btn-outline-primary {
        background: #ffffff !important;
        color: #1e40af !important;
        border: 2px solid #3b82f6 !important;
    }

    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
        border-color: transparent !important;
    }

    .btn-secondary {
        background: #6b7280 !important;
        color: #ffffff !important;
    }

    .btn-secondary:hover {
        background: #4b5563 !important;
        transform: translateY(-2px);
    }

    /* Badges */
    .badge {
        font-weight: 600;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge.bg-primary {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
    }

    .badge.bg-success {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important;
        color: #ffffff !important;
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%) !important;
        color: #ffffff !important;
    }

    .badge.text-dark {
        color: #ffffff !important;
    }

    /* Alerts */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.25rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%) !important;
        color: #065f46 !important;
        border-left: 4px solid #10b981;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%) !important;
        color: #991b1b !important;
        border-left: 4px solid #ef4444;
    }

    /* Modals */
    .modal-content {
        border-radius: 16px !important;
        border: 1px solid #e5e7eb !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
        background: #ffffff !important;
    }

    .modal-header {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
        border-radius: 16px 16px 0 0 !important;
        padding: 1.5rem;
        border-bottom: none !important;
    }

    .modal-title {
        color: #ffffff !important;
        font-weight: 700;
    }

    .modal-body {
        padding: 1.5rem;
        background: #ffffff !important;
        color: #1f2937 !important;
    }

    .modal-footer {
        background: #f9fafb !important;
        border-top: 1px solid #e5e7eb !important;
        border-radius: 0 0 16px 16px !important;
        padding: 1rem 1.5rem;
    }

    /* Form Controls */
    .form-control,
    .form-select {
        background: #ffffff !important;
        color: #1f2937 !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 8px;
        padding: 0.625rem 0.875rem;
    }

    .form-control:focus,
    .form-select:focus {
        background: #ffffff !important;
        color: #1f2937 !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    .form-label {
        color: #374151 !important;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .input-group-text {
        background: #f3f4f6 !important;
        color: #6b7280 !important;
        border: 2px solid #e5e7eb !important;
        border-right: none !important;
    }

    /* Form Switch */
    .form-check-input {
        background-color: #d1d5db !important;
        border-color: #9ca3af !important;
    }

    .form-check-input:checked {
        background-color: #3b82f6 !important;
        border-color: #3b82f6 !important;
    }

    /* Mobile Cards */
    @media (max-width: 767.98px) {
        .page-title {
            font-size: 1.5rem;
        }

        .card {
            margin-bottom: 1rem;
        }
    }

    /* Text Colors */
    .text-muted {
        color: #6b7280 !important;
    }

    .text-primary {
        color: #1e40af !important;
    }

    .text-success {
        color: #059669 !important;
    }

    .text-warning {
        color: #d97706 !important;
    }

    .text-danger {
        color: #dc2626 !important;
    }

    .text-info {
        color: #0891b2 !important;
    }

    /* Pagination */
    .pagination {
        margin-top: 1.5rem;
    }

    .page-link {
        background: #ffffff !important;
        color: #1e40af !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 8px;
        margin: 0 4px;
        padding: 0.5rem 0.75rem;
    }

    .page-link:hover {
        background: #f3f4f6 !important;
        color: #1e3a8a !important;
        border-color: #d1d5db !important;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
        border-color: transparent !important;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h1 class="page-title">
                    <i class="bx bx-user-circle me-3 text-primary"></i>
                    Manage Users
                </h1>
                <p class="page-subtitle">Add, edit, and manage system users with ease</p>
            </div>
            <div class="page-actions d-flex gap-2">
                @if(\App\Models\User::where('is_approved', false)->count() > 0)
                <form action="{{ route('admin.users.approve-all') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Approve all pending users?');">
                        <i class="bx bx-check-double me-2"></i>Approve All Pending
                        <span class="badge bg-white text-success ms-1">{{ \App\Models\User::where('is_approved', false)->count() }}</span>
                    </button>
                </form>
                @endif
                <button type="button" class="btn btn-primary" onclick="openAddUserModal()">
                    <i class="bx bx-plus me-2"></i>Add New User
                </button>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error-circle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Auto-Approve Settings Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-info">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">
                                <i class="bx bx-cog text-info me-2"></i>
                                Auto-Approve New Registrations
                            </h6>
                            <p class="text-muted mb-0 small">
                                When enabled, new user accounts will be automatically approved without admin intervention
                            </p>
                        </div>
                        <div class="form-check form-switch" style="font-size: 1.5rem;">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                role="switch" 
                                id="autoApproveToggle"
                                {{ \App\Models\Setting::isAutoApproveEnabled() ? 'checked' : '' }}
                                onchange="toggleAutoApprove(this)"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                    <h5 class="card-title mb-0">Users List <span class="text-muted fs-6">({{ $users->total() }} total)</span></h5>
                    <form method="GET" action="{{ route('admin.adduser') }}" class="d-flex gap-2" style="min-width: 260px;">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Search name or email..." value="{{ $search ?? '' }}">
                            @if(!empty($search))
                                <a href="{{ route('admin.adduser') }}" class="btn btn-outline-secondary btn-sm" title="Clear search"><i class="bx bx-x"></i></a>
                            @endif
                            <button type="submit" class="btn btn-primary btn-sm">Search</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">

                    <!-- Desktop Table (hidden on mobile) -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                            <tr class="{{ !$user->is_approved ? 'table-warning' : '' }}">
                                <td>
                                    {{ $user->name }}
                                    @if(!$user->is_approved)
                                        <span class="badge bg-warning text-dark ms-2"><i class="bx bx-time"></i> Pending</span>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $user->role->role_name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    @if($user->is_approved)
                                        <span class="badge bg-success"><i class="bx bx-check-circle"></i> Approved</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="bx bx-time-five"></i> Pending Approval</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if(!$user->is_approved)
                                            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Approve User">
                                                    <i class="bx bx-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" title="Revoke Approval" onclick="return confirm('Revoke approval for this user?');">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}" title="Edit User">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete User">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards (shown only on mobile) -->
                    <div class="d-md-none">
                        @foreach ($users as $user)
                        <div class="card mb-3 {{ !$user->is_approved ? 'border-warning' : 'border-0 shadow-sm' }}">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                                    @if($user->is_approved)
                                        <span class="badge bg-success"><i class="bx bx-check-circle"></i> Approved</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="bx bx-time-five"></i> Pending</span>
                                    @endif
                                </div>
                                <p class="text-muted small mb-1">{{ $user->email }}</p>
                                <p class="mb-2">
                                    <span class="badge bg-primary">{{ $user->role->role_name ?? 'N/A' }}</span>
                                </p>
                                <hr class="my-2">
                                <div class="d-flex gap-2 flex-wrap">
                                    @if(!$user->is_approved)
                                        <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="bx bx-check me-1"></i>Approve
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Revoke approval for this user?');">
                                                <i class="bx bx-x me-1"></i>Revoke
                                            </button>
                                        </form>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">
                                        <i class="bx bx-edit me-1"></i>Edit
                                    </button>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?');">
                                            <i class="bx bx-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Edit User Modals (shared by both table and card views) -->
                    @foreach ($users as $user)
                    <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel-{{ $user->id }}">Edit User: {{ $user->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="name-{{ $user->id }}" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name-{{ $user->id }}" name="name" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email-{{ $user->id }}" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email-{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password-{{ $user->id }}" class="form-label">New Password (leave blank if no change)</label>
                                            <input type="password" class="form-control" id="password-{{ $user->id }}" name="password">
                                        </div>
                                        <div class="mb-3">
                                            <label for="password_confirmation-{{ $user->id }}" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="password_confirmation-{{ $user->id }}" name="password_confirmation">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update User</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Pagination -->
                    {{ $users->links() }}

                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role Dropdown -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select @error('role_id') is-invalid @enderror" id="role" name="role_id" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Add User Button -->
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
function openAddUserModal() {
    const modalElement = document.getElementById('addUserModal');
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }
}

// Password confirmation validation
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const form = document.querySelector('#addUserModal form');

    // Real-time password confirmation validation
    passwordConfirmation.addEventListener('input', function() {
        if (password.value !== passwordConfirmation.value) {
            passwordConfirmation.setCustomValidity('Passwords do not match');
            passwordConfirmation.classList.add('is-invalid');
        } else {
            passwordConfirmation.setCustomValidity('');
            passwordConfirmation.classList.remove('is-invalid');
            passwordConfirmation.classList.add('is-valid');
        }
    });

    // Password strength validation
    password.addEventListener('input', function() {
        const value = password.value;
        if (value.length < 8) {
            password.setCustomValidity('Password must be at least 8 characters long');
            password.classList.add('is-invalid');
        } else {
            password.setCustomValidity('');
            password.classList.remove('is-invalid');
            password.classList.add('is-valid');
        }

        // Re-validate confirmation if password changes
        if (passwordConfirmation.value) {
            passwordConfirmation.dispatchEvent(new Event('input'));
        }
    });

    // Email validation
    const email = document.getElementById('email');
    email.addEventListener('input', function() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            email.setCustomValidity('Please enter a valid email address');
            email.classList.add('is-invalid');
        } else {
            email.setCustomValidity('');
            email.classList.remove('is-invalid');
            email.classList.add('is-valid');
        }
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        // Check if passwords match
        if (password.value !== passwordConfirmation.value) {
            e.preventDefault();
            passwordConfirmation.setCustomValidity('Passwords do not match');
            passwordConfirmation.classList.add('is-invalid');
            passwordConfirmation.focus();
            return false;
        }

        // Check password length
        if (password.value.length < 8) {
            e.preventDefault();
            password.setCustomValidity('Password must be at least 8 characters long');
            password.classList.add('is-invalid');
            password.focus();
            return false;
        }

        // Check email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            e.preventDefault();
            email.setCustomValidity('Please enter a valid email address');
            email.classList.add('is-invalid');
            email.focus();
            return false;
        }
    });

    // Clear validation on modal close
    const modal = document.getElementById('addUserModal');
    modal.addEventListener('hidden.bs.modal', function() {
        form.reset();
        // Clear validation classes
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.classList.remove('is-invalid', 'is-valid');
            input.setCustomValidity('');
        });
    });

    // Reopen modal if there are validation errors
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            openAddUserModal();
        });
    @endif
});

// Toggle auto-approve setting
function toggleAutoApprove(checkbox) {
    const isEnabled = checkbox.checked ? 1 : 0;
    
    fetch('{{ route("admin.users.toggle-auto-approve") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ enabled: isEnabled })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="bx bx-check-circle me-2"></i>
                ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.page-header').nextSibling);
            
            // Auto-dismiss after 3 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert checkbox on error
        checkbox.checked = !checkbox.checked;
        alert('Failed to update setting. Please try again.');
    });
}
</script>
