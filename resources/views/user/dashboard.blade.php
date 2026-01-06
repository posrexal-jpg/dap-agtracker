@extends('layouts.user')

@section('title', 'Dashboard - COTS Tracker')

@section('content')
<style>
@media (min-width: 1200px) {
    .layout-menu-fixed:not(.layout-menu-collapsed) .layout-page, .layout-menu-fixed-offcanvas:not(.layout-menu-collapsed) .layout-page {
        padding-left: 0;
    }
}
</style>

<div class="container-fluid px-0" style="height: 100%; display: flex; flex-direction: column; overflow: auto;">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h1 class="page-title">Welcome, {{ Auth::user()->name }}! 👋</h1>
                <p class="page-subtitle">Monitor COTS sightings and help protect our coral reefs</p>
            </div>
        </div>
    </div>

    <!-- Statistics Row -->
    <div class="page-content">
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body text-center">
                    <div class="stat-value">{{ $totalSightings }}</div>
                    <div class="stat-label">Total Sightings</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body text-center">
                    <div class="stat-value">{{ $userSightings }}</div>
                    <div class="stat-label">Your Reports</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body text-center">
                    <div class="stat-value">{{ Auth::user()->role->role_name ?? 'User' }}</div>
                    <div class="stat-label">User Role</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <a href="{{ route('user.locations') }}" class="btn btn-primary w-100 py-3">
                <i class="bx bx-map me-2"></i> View Sighting Map
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('user.account') }}" class="btn btn-outline-primary w-100 py-3">
                <i class="bx bx-user me-2"></i> My Account
            </a>
        </div>
    </div>

    <!-- Recent Sightings -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bx bx-list-check"></i> Recent Sightings</h5>
                </div>
                <div class="card-body">
                    @if($recentSightings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Location</th>
                                        <th>Municipality</th>
                                        <th>Barangay</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentSightings as $sighting)
                                        <tr>
                                            <td>
                                                <strong>{{ $sighting->name ?? 'Unnamed' }}</strong>
                                            </td>
                                            <td>{{ $sighting->municipality }}</td>
                                            <td>{{ $sighting->barangay }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $sighting->created_at->format('M d, Y') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bx bx-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-3">No sightings yet. Start by reporting your first COTS sighting.</p>
                            <a href="{{ route('user.locations') }}" class="btn btn-primary mt-3">
                                <i class="bx bx-plus me-1"></i> Report Sighting
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<style>
    .page-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 30px;
        margin-bottom: 24px;
        border-bottom: 1px solid #e2e8f0;
        flex-shrink: 0;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 8px;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 1rem;
        margin-bottom: 0;
    }

    .stat-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #0369a1;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #0369a1;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 0.95rem;
        color: #64748b;
        font-weight: 500;
    }

    .card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        margin-bottom: 24px;
    }

    .card-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 16px 20px;
        border-radius: 12px 12px 0 0;
    }

    .card-title {
        color: #1e3a8a;
        font-weight: 600;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
        border: none;
        font-weight: 600;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #025a96 0%, #0270b0 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(3, 105, 161, 0.3);
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }

        .page-header {
            padding: 20px 0;
            margin-bottom: 20px;
        }
    }
</style>

@endsection
