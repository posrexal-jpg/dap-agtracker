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

<div class="container-fluid px-3 py-4" style="height: 100%; display: flex; flex-direction: column; overflow: auto; background: #f6f9fc;">
    <!-- Page Header -->
    <div class="page-header shadow-sm">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <h1 class="page-title mb-2">Welcome, <span style="color:#0284c7">{{ Auth::user()->name }}</span>! <span class="wave">👋</span></h1>
                <p class="page-subtitle mb-0">Monitor <b>COTS</b> sightings and help protect our coral reefs</p>
            </div>
        </div>
    </div>

    <!-- Statistics Row -->
    <div class="page-content">
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-12">
            <div class="card stat-card stat-card-blue text-center">
                <div class="card-body">
                    <div class="stat-icon mb-2"><i class="bx bx-map-pin" style="font-size:2rem;color:#0284c7;"></i></div>
                    <div class="stat-value">{{ $totalSightings }}</div>
                    <div class="stat-label">Total Sightings</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="card stat-card stat-card-green text-center">
                <div class="card-body">
                    <div class="stat-icon mb-2"><i class="bx bx-user-check" style="font-size:2rem;color:#10b981;"></i></div>
                    <div class="stat-value">{{ $userSightings }}</div>
                    <div class="stat-label">Your Reports</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="card stat-card stat-card-orange text-center">
                <div class="card-body">
                    <div class="stat-icon mb-2"><i class="bx bx-id-card" style="font-size:2rem;color:#f59e0b;"></i></div>
                    <div class="stat-value">{{ Auth::user()->role->role_name ?? 'User' }}</div>
                    <div class="stat-label">User Role</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3 mb-4 quick-actions-row">
        <div class="col-md-6 col-12">
            <a href="{{ route('user.locations') }}" class="btn btn-primary w-100 py-3 quick-action-btn mb-2 mb-md-0">
                <i class="bx bx-map me-2"></i> View Sighting Map
            </a>
        </div>
        <div class="col-md-6 col-12">
            <a href="{{ route('user.account') }}" class="btn btn-outline-primary w-100 py-3 quick-action-btn">
                <i class="bx bx-user me-2"></i> My Account
            </a>
        </div>
    </div>

    <!-- Recent Sightings -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm recent-sightings-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0"><i class="bx bx-list-check"></i> Recent Sightings</h5>
                    <a href="{{ route('user.locations') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($recentSightings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
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
        padding: 30px 24px;
        margin-bottom: 24px;
        border-bottom: 1px solid #e2e8f0;
        flex-shrink: 0;
        border-radius: 12px;
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
        min-height: 140px;
        margin-bottom: 0;
    }
    .stat-card-blue { border-left-color: #0284c7; }
    .stat-card-green { border-left-color: #10b981; }
    .stat-card-orange { border-left-color: #f59e0b; }
    .stat-icon { line-height: 1; }
    .stat-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px) scale(1.02);
    }
    .quick-action-btn {
        font-size: 1.1rem;
        border-radius: 10px;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .quick-action-btn:hover {
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.15);
        transform: translateY(-2px) scale(1.01);
    }
    .quick-actions-row { margin-bottom: 32px; }

    .recent-sightings-card .card-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 16px 20px;
        border-radius: 12px 12px 0 0;
    }
    .recent-sightings-card .card-title {
        color: #1e3a8a;
        font-weight: 600;
    }
    .recent-sightings-card .btn-outline-primary {
        border-radius: 8px;
        font-size: 0.95rem;
        padding: 4px 14px;
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
        padding: 12px 18px;
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
            font-size: 1.3rem;
        }
        .page-header {
            padding: 12px 4px;
            margin-bottom: 16px;
        }
        .card {
            padding: 6px 2px;
        }
        .container-fluid {
            padding-left: 2px !important;
            padding-right: 2px !important;
        }
        .stat-card { min-height: 110px; }
        .quick-actions-row { margin-bottom: 18px; }
    }

    .wave { display: inline-block; animation: wave 1.2s infinite linear alternate; }
    @keyframes wave { 0% { transform: rotate(-10deg);} 100% { transform: rotate(10deg);} }
</style>

@endsection
