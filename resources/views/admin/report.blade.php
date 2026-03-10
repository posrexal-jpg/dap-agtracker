@extends('layouts.admin')

@push('styles')
<style>
    /* Force Light Mode - Override System Dark Mode */
    html, body {
        color-scheme: light !important;
    }

    body {
        background: #f8fafc !important;
        color: #1f2937 !important;
    }

    .container-fluid {
        background: transparent !important;
    }

    /* Page Header Styling */
    .page-header {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        border-radius: 16px;
        padding: 2rem;
        color: #ffffff !important;
        box-shadow: 0 8px 24px rgba(30, 64, 175, 0.25);
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

    .page-actions .btn {
        background: #ffffff !important;
        color: #1e40af !important;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .page-actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        background: #f0f9ff !important;
    }

    .page-actions .btn i {
        color: #1e40af !important;
    }

    /* Cards */
    .card {
        border: none !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08) !important;
        background: #ffffff !important;
        color: #1f2937 !important;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12) !important;
        transform: translateY(-2px);
    }

    .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
        border-bottom: 1px solid #e5e7eb !important;
        padding: 1.5rem !important;
        color: #1f2937 !important;
    }

    .card-title {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0 !important;
        color: #1f2937 !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-body {
        padding: 1.5rem !important;
        background: #ffffff !important;
        color: #1f2937 !important;
    }

    /* Filter Section */
    .filter-section {
        background: #ffffff;
        padding: 1rem 1.25rem;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .filter-section:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-section label {
        color: #1f2937 !important;
        font-weight: 600;
        margin-bottom: 0;
    }

    .filter-section .form-select {
        border: 2px solid #e5e7eb !important;
        border-radius: 10px !important;
        padding: 0.625rem 1rem !important;
        font-weight: 500;
        color: #1f2937 !important;
        background: #ffffff !important;
        transition: all 0.3s ease;
        min-width: 200px;
    }

    .filter-section .form-select:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        outline: none;
    }

    /* Table Styling */
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff !important;
    }

    .table {
        margin-bottom: 0 !important;
        color: #1f2937 !important;
        background: #ffffff !important;
    }

    .table thead {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
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
        color: #1f2937 !important;
    }

    .table tbody tr:hover {
        background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 100%) !important;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table tbody td {
        padding: 1rem !important;
        vertical-align: middle;
        color: #1f2937 !important;
        border: none !important;
        font-weight: 500;
    }

    .table tbody td:first-child {
        font-weight: 700;
        color: #3b82f6 !important;
    }

    /* Badge Styling */
    .badge {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .badge.bg-danger {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;
        color: #ffffff !important;
    }

    .badge.bg-success {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%) !important;
        color: #ffffff !important;
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%) !important;
        color: #ffffff !important;
    }

    .badge.bg-info {
        background: linear-gradient(135deg, #06b6d4 0%, #22d3ee 100%) !important;
        color: #ffffff !important;
    }

    /* Pagination */
    .pagination {
        margin-top: 1.5rem;
        gap: 0.5rem;
    }

    .page-link {
        border: 2px solid #e5e7eb !important;
        border-radius: 10px !important;
        color: #1f2937 !important;
        background: #ffffff !important;
        padding: 0.625rem 1rem !important;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 0 0.25rem;
    }

    .page-link:hover {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
        border-color: transparent !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
        border-color: transparent !important;
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .page-item.disabled .page-link {
        background: #f1f5f9 !important;
        color: #9ca3af !important;
        border-color: #e5e7eb !important;
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

    .empty-state h4 {
        color: #6b7280 !important;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #9ca3af !important;
    }

    /* Mobile Responsive - Material-UI Components */
    @media (max-width: 768px) {
        body {
            background: #f5f5f5 !important;
        }

        /* Material-UI App Bar (Header) */
        .page-header {
            padding: 1rem 1.25rem;
            border-radius: 0 0 16px 16px;
            margin-left: -1rem;
            margin-right: -1rem;
            margin-top: -1rem;
            box-shadow: 0 2px 4px -1px rgba(0,0,0,.2), 0 4px 5px 0 rgba(0,0,0,.14), 0 1px 10px 0 rgba(0,0,0,.12) !important;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 500;
            letter-spacing: 0.0125em;
        }

        .page-subtitle {
            font-size: 0.875rem;
            font-weight: 400;
            letter-spacing: 0.0178em;
        }

        /* Material-UI Floating Action Button (FAB) */
        .page-actions .btn {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            position: fixed;
            bottom: 16px;
            right: 16px;
            z-index: 1050;
            box-shadow: 0 3px 5px -1px rgba(0,0,0,.2), 0 6px 10px 0 rgba(0,0,0,.14), 0 1px 18px 0 rgba(0,0,0,.12) !important;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fabEntrance 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
        }

        .page-actions .btn i {
            font-size: 1.5rem;
            margin: 0 !important;
        }

        .page-actions .btn:active {
            transform: scale(0.95);
            box-shadow: 0 2px 4px -1px rgba(0,0,0,.2), 0 4px 5px 0 rgba(0,0,0,.14), 0 1px 10px 0 rgba(0,0,0,.12) !important;
        }

        @keyframes fabEntrance {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Material-UI Card */
        .card {
            border-radius: 12px !important;
            margin-bottom: 1rem;
            box-shadow: 0 2px 1px -1px rgba(0,0,0,.2), 0 1px 1px 0 rgba(0,0,0,.14), 0 1px 3px 0 rgba(0,0,0,.12) !important;
        }

        .card-header {
            padding: 1rem 1.25rem !important;
            background: #ffffff !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.12) !important;
        }

        .card-body {
            padding: 0 !important;
            background: #ffffff !important;
        }

        /* Material-UI Chip (Filter) */
        .filter-section {
            padding: 1rem 1.25rem;
            flex-direction: column;
            gap: 0.75rem;
            background: #ffffff;
            border: none;
            border-radius: 0;
            margin: 0;
        }

        .filter-section label {
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.0893em;
            color: rgba(0, 0, 0, 0.6) !important;
        }

        .filter-section .form-select {
            min-width: 100%;
            width: 100%;
            height: 56px;
            border-radius: 4px;
            border: 1px solid rgba(0, 0, 0, 0.23) !important;
            padding: 16px 14px !important;
            font-size: 1rem;
            transition: all 0.2s cubic-bezier(0.4, 0.0, 0.2, 1);
        }

        .filter-section .form-select:focus {
            border-width: 2px !important;
            padding: 15px 13px !important;
        }

        /* Material Design Table for Mobile */
        .table-responsive {
            border-radius: 12px;
        }

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
            background: #ffffff !important;
        }

        .table tbody tr:hover {
            transform: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .table tbody td {
            padding: 0.625rem 0 !important;
            text-align: left;
            border: none !important;
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
            letter-spacing: 0.5px;
        }

        .table tbody td:first-child {
            padding-top: 0.75rem !important;
            font-size: 1.125rem;
            color: #1e40af !important;
        }

        /* Pagination Mobile */
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }

        .page-link {
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 1.25rem;
        }

        .page-title i {
            font-size: 1.25rem;
        }

        .table tbody td {
            font-size: 0.875rem;
        }

        .table tbody td::before {
            font-size: 0.7rem;
        }
    }

    /* Dark Mode Prevention */
    @media (prefers-color-scheme: dark) {
        html, body {
            color-scheme: light !important;
        }

        body {
            background: #f8fafc !important;
            color: #1f2937 !important;
        }

        .card,
        .table,
        .table tbody tr,
        .filter-section,
        .page-link,
        .card-body,
        .table-responsive {
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
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h1 class="page-title">
                    <i class="bx bx-bar-chart-alt me-3 text-primary"></i>
                    Sightings Report
                </h1>
                <p class="page-subtitle">View and export comprehensive COTS sighting reports</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.report.export', ['municipality' => request('municipality')]) }}" class="btn btn-success">
                    <i class="bx bx-download me-2"></i>Export Report
                </a>
            </div>
        </div>
    </div>

    <!-- Report Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <h5 class="card-title mb-3 mb-md-0">Sightings Data</h5>
                        <div class="filter-section">
                            <form method="GET" action="{{ route('admin.report') }}" class="d-flex align-items-center">
                                <label class="me-2 fw-bold">Filter by Municipality:</label>
                                <select name="municipality" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="">All Municipalities</option>
                                    @foreach($municipalities as $municipality)
                                        <option value="{{ $municipality }}" {{ request('municipality') == $municipality ? 'selected' : '' }}>
                                            {{ $municipality }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($locations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Municipality</th>
                                        <th>COTS Count</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($locations as $location)
                                        <tr>
                                            <td data-label="#">{{ $loop->iteration + ($locations->currentPage() - 1) * $locations->perPage() }}</td>
                                            <td data-label="Name">{{ $location->name }}</td>
                                            <td data-label="Municipality">{{ $location->municipality }}</td>
                                            <td data-label="COTS Count">
                                                @if($location->number_of_cots > 15)
                                                    <span class="badge bg-danger">{{ $location->number_of_cots }}</span>
                                                @else
                                                    <span class="badge bg-success">{{ $location->number_of_cots }}</span>
                                                @endif
                                            </td>
                                            <td data-label="Date">{{ $location->date_of_sighting ? \Carbon\Carbon::parse($location->date_of_sighting)->format('M d, Y') : 'N/A' }}</td>
                                            <td data-label="Time">{{ $location->time_of_sighting ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center">
                            {{ $locations->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bx bx-data"></i>
                            <h4>No Sighting Records Found</h4>
                            <p>There are no sighting records{{ request('municipality') ? ' for the selected municipality' : '' }}.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
