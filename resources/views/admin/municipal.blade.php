@extends('layouts.admin')

@push('styles')
<style>
    /* Force Light Mode */
    html, body {
        color-scheme: light !important;
        background: #f8fafc !important;
        color: #1f2937 !important;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        border-radius: 16px;
        padding: 2rem;
        color: #ffffff !important;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.25);
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #ffffff !important;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        font-size: 1rem;
        opacity: 0.95;
        margin-bottom: 0;
        color: #ffffff !important;
    }

    .page-actions .btn-primary {
        background: #ffffff !important;
        color: #10b981 !important;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .page-actions .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        background: #f0fdf4 !important;
    }

    /* Cards */
    .card {
        border: none !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08) !important;
        background: #ffffff !important;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12) !important;
    }

    .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
        border-bottom: 1px solid #e5e7eb !important;
        padding: 1.5rem !important;
    }

    .card-title {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0 !important;
        color: #1f2937 !important;
    }

    .card-body {
        padding: 1.5rem !important;
        background: #ffffff !important;
    }

    /* Alerts */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        font-weight: 500;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%) !important;
        color: #991b1b !important;
    }

    .alert-success {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important;
        color: #166534 !important;
    }

    /* Table */
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }

    .table {
        margin-bottom: 0 !important;
        color: #1f2937 !important;
        background: #ffffff !important;
    }

    .table thead {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%) !important;
    }

    .table thead th {
        color: #ffffff !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        padding: 1rem !important;
        border: none !important;
    }

    .table tbody tr {
        border-bottom: 1px solid #f1f5f9 !important;
        transition: all 0.2s ease;
        background: #ffffff !important;
    }

    .table tbody tr:hover {
        background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 100%) !important;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table tbody td {
        padding: 1rem !important;
        vertical-align: middle;
        color: #1f2937 !important;
        font-weight: 500;
        border: none !important;
    }

    /* Buttons */
    .btn {
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
    }

    .btn-outline-danger {
        border: 2px solid #dc2626 !important;
        color: #dc2626 !important;
        background: #ffffff !important;
    }

    .btn-outline-danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    /* Modal */
    .modal-content {
        border-radius: 16px !important;
        border: none !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
        background: #ffffff !important;
    }

    .modal-header {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%) !important;
        color: #ffffff !important;
        border-bottom: none !important;
        padding: 1.5rem 2rem !important;
        border-radius: 16px 16px 0 0 !important;
    }

    .modal-title {
        font-weight: 700;
        color: #ffffff !important;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 1;
    }

    .modal-body {
        padding: 2rem !important;
        background: #ffffff !important;
    }

    .modal-footer {
        border-top: 1px solid #e5e7eb !important;
        padding: 1.5rem 2rem !important;
        background: #f8fafc !important;
    }

    .form-label {
        font-weight: 600;
        color: #1f2937 !important;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 2px solid #e5e7eb !important;
        border-radius: 10px !important;
        padding: 0.75rem 1rem !important;
        font-weight: 500;
        transition: all 0.3s ease;
        background: #ffffff !important;
        color: #1f2937 !important;
    }

    .form-control:focus {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        outline: none;
    }

    .modal-footer .btn-secondary {
        background: #6b7280 !important;
        color: #ffffff !important;
    }

    .modal-footer .btn-secondary:hover {
        background: #4b5563 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
    }

    .modal-footer .btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%) !important;
        color: #ffffff !important;
    }

    .modal-footer .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #9ca3af !important;
    }

    .empty-state i {
        font-size: 4rem;
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
            border-radius: 12px;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .page-subtitle {
            font-size: 0.875rem;
        }

        .page-actions .btn-primary {
            width: 100%;
            margin-top: 1rem;
        }

        .card {
            border-radius: 12px !important;
        }

        /* Material Design Table for Mobile */
        .table thead {
            display: none;
        }

        .table,
        .table tbody,
        .table tr,
        .table td {
            display: block;
            width: 100%;
        }

        .table tbody tr {
            margin-bottom: 1rem;
            border-radius: 12px !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 1rem;
        }

        .table tbody td {
            padding: 0.625rem 0 !important;
            text-align: left;
            position: relative;
            padding-left: 45% !important;
        }

        .table tbody td::before {
            content: attr(data-label);
            position: absolute;
            left: 0;
            width: 40%;
            padding-right: 10px;
            font-weight: 700;
            color: #6b7280 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        .table tbody td:first-child {
            padding-top: 0.75rem !important;
            font-size: 1.125rem;
            color: #10b981 !important;
        }

        .alert {
            font-size: 0.875rem;
        }
    }

    /* Dark Mode Prevention */
    @media (prefers-color-scheme: dark) {
        html, body, .card, .table, .modal-content, .form-control, .modal-body {
            background: #ffffff !important;
            color: #1f2937 !important;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="bx bx-building me-3 text-primary"></i>
                    Municipalities
                </h1>
                <p class="page-subtitle">Manage and organize municipality locations</p>
            </div>
            <div class="page-actions">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#municipalityModal">
                    <i class="bx bx-plus me-2"></i>Add Municipality
                </button>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Municipalities Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Municipalities List</h5>
                </div>
                <div class="card-body">
                    @if($municipalities->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Municipality Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($municipalities as $municipality)
                                    <tr>
                                        <td data-label="Municipality">{{ $municipality->name }}</td>
                                        <td data-label="Actions">
                                            <form action="{{ route('admin.municipal.destroy', $municipality->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this municipality?');" title="Delete Municipality">
                                                    <i class="bx bx-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bx bx-building"></i>
                            <h4>No Municipalities Added</h4>
                            <p>Click "Add Municipality" to get started.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="municipalityModal" tabindex="-1" aria-labelledby="municipalityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="municipalityModalLabel">Create Municipality</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.municipal.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Municipality Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Municipality</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Include Bootstrap JS (if not already included in your layout) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endpush
