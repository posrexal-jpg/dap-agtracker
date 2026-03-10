@extends('layouts.admin')
@section('title', 'Admin Dashboard - COTS Tracker')

@section('content')
<div class="admin-dashboard">

    <!-- Header -->
    <div class="dash-header">
        <div class="container-fluid">
            @php
                $hour = date('H');
                $greeting = 'Good morning';
                if ($hour >= 12 && $hour < 17) { $greeting = 'Good afternoon'; }
                elseif ($hour >= 17) { $greeting = 'Good evening'; }
                $userName = auth()->user()->name ?? 'Admin';
            @endphp
            <div class="d-flex align-items-center gap-3">
                <div class="dash-header-icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <div>
                    <h1 class="dash-title mb-0">Admin Dashboard</h1>
                    <p class="dash-subtitle mb-0">{{ $greeting }}, <strong>{{ $userName }}</strong> &mdash; Monitor and manage COTS tracking data</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="container-fluid py-4">

        <!-- Stats Row -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="dash-stat-card">
                    <div class="dash-stat-icon" style="background: linear-gradient(135deg,#1e40af,#3b82f6);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="dash-stat-body">
                        <div class="dash-stat-number">{{ $userCount }}</div>
                        <div class="dash-stat-label">Total Users</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="dash-stat-card">
                    <div class="dash-stat-icon" style="background: linear-gradient(135deg,#ef4444,#f87171);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="dash-stat-body">
                        <div class="dash-stat-number">{{ $totalCots }}</div>
                        <div class="dash-stat-label">Total COTS</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="dash-stat-card">
                    <div class="dash-stat-icon" style="background: linear-gradient(135deg,#06b6d4,#22d3ee);">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="dash-stat-body">
                        <div class="dash-stat-number">{{ $locationCount }}</div>
                        <div class="dash-stat-label">Sightings</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="dash-stat-card">
                    <div class="dash-stat-icon" style="background: linear-gradient(135deg,#10b981,#34d399);">
                        <i class="fas fa-city"></i>
                    </div>
                    <div class="dash-stat-body">
                        <div class="dash-stat-number">{{ count($municipalities ?? []) }}</div>
                        <div class="dash-stat-label">Municipalities</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart + Quick Actions -->
        <div class="row g-3 mb-4">
            <!-- Pie Chart -->
            <div class="col-12 col-lg-8">
                <div class="dash-card h-100">
                    <div class="dash-card-header">
                        <i class="fas fa-chart-pie text-primary me-2"></i>
                        <span>COTS Distribution by Municipality</span>
                        <button class="btn btn-sm btn-outline-secondary ms-auto" onclick="refreshChart()">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                    <div class="dash-card-body">
                        <div id="pieChart" style="min-height: 350px;"></div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-12 col-lg-4">
                <div class="dash-card h-100">
                    <div class="dash-card-header">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        <span>Quick Actions</span>
                    </div>
                    <div class="dash-card-body p-2">
                        <a href="{{ route('admin.location') }}" class="quick-action-btn">
                            <div class="qa-icon" style="background:rgba(59,130,246,.12);color:#1e40af;">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <div class="qa-text">
                                <span class="qa-label">Sightings Map</span>
                                <span class="qa-desc">View and edit sighting data</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted small"></i>
                        </a>
                        <a href="{{ route('admin.adduser') }}" class="quick-action-btn">
                            <div class="qa-icon" style="background:rgba(16,185,129,.12);color:#10b981;">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="qa-text">
                                <span class="qa-label">Manage Users</span>
                                <span class="qa-desc">Add and manage accounts</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted small"></i>
                        </a>
                        <a href="{{ route('admin.report') }}" class="quick-action-btn">
                            <div class="qa-icon" style="background:rgba(6,182,212,.12);color:#06b6d4;">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="qa-text">
                                <span class="qa-label">Reports</span>
                                <span class="qa-desc">Export data and analytics</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted small"></i>
                        </a>
                        <a href="{{ route('admin.notifications') }}" class="quick-action-btn">
                            <div class="qa-icon" style="background:rgba(139,92,246,.12);color:#8b5cf6;">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="qa-text">
                                <span class="qa-label">Notifications</span>
                                <span class="qa-desc">View recent alerts</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted small"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Sightings -->
        <div class="row g-3 mb-4">
            <div class="col-12">
                <div class="dash-card">
                    <div class="dash-card-header">
                        <i class="fas fa-history text-primary me-2"></i>
                        <span>Recent Sightings <span class="text-muted fw-normal small">(Last 7 Days)</span></span>
                        <a href="{{ route('admin.location') }}" class="btn btn-sm btn-outline-primary ms-auto">View All</a>
                    </div>
                    <div class="dash-card-body p-0">
                        @forelse($recentSightings as $sighting)
                        <div class="recent-item">
                            <div class="recent-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="recent-content">
                                <div class="recent-text">
                                    <strong>{{ $sighting->barangay ?? 'Unknown' }}</strong>, {{ $sighting->municipality ?? '—' }}
                                    <span class="badge bg-danger ms-2">{{ $sighting->number_of_cots ?? 0 }} COTS</span>
                                </div>
                                <div class="recent-time">{{ $sighting->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                            No sightings in the last 7 days.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Activity Logs -->
        <div class="row g-3">
            <div class="col-12">
                <div class="dash-card">
                    <div class="dash-card-header">
                        <i class="fas fa-clipboard-list text-warning me-2"></i>
                        <span>Admin Activity Logs <span class="text-muted fw-normal small">(Recent Activities)</span></span>
                        <a href="{{ route('admin.activity-logs') }}" class="btn btn-sm btn-outline-primary ms-auto">View All</a>
                    </div>
                    <div class="dash-card-body p-0">
                        @forelse($recentActivityLogs as $log)
                        <div class="recent-item">
                            <div class="recent-icon" style="background: 
                                @if($log->activity_type === 'create') linear-gradient(135deg, #10b981, #34d399)
                                @elseif($log->activity_type === 'update') linear-gradient(135deg, #3b82f6, #60a5fa)
                                @elseif($log->activity_type === 'delete') linear-gradient(135deg, #ef4444, #f87171)
                                @elseif($log->activity_type === 'approve') linear-gradient(135deg, #8b5cf6, #a78bfa)
                                @elseif($log->activity_type === 'reject') linear-gradient(135deg, #f59e0b, #fbbf24)
                                @elseif($log->activity_type === 'export') linear-gradient(135deg, #06b6d4, #22d3ee)
                                @else linear-gradient(135deg, #6b7280, #9ca3af)
                                @endif;">
                                <i class="fas 
                                    @if($log->activity_type === 'create') fa-plus
                                    @elseif($log->activity_type === 'update') fa-edit
                                    @elseif($log->activity_type === 'delete') fa-trash
                                    @elseif($log->activity_type === 'approve') fa-check
                                    @elseif($log->activity_type === 'reject') fa-times
                                    @elseif($log->activity_type === 'export') fa-download
                                    @else fa-info-circle
                                    @endif"></i>
                            </div>
                            <div class="recent-content">
                                <div class="recent-text">
                                    <strong>{{ $log->user->name ?? 'System' }}</strong> 
                                    <span class="badge badge-sm" style="background: 
                                        @if($log->activity_type === 'create') #10b981
                                        @elseif($log->activity_type === 'update') #3b82f6
                                        @elseif($log->activity_type === 'delete') #ef4444
                                        @elseif($log->activity_type === 'approve') #8b5cf6
                                        @elseif($log->activity_type === 'reject') #f59e0b
                                        @elseif($log->activity_type === 'export') #06b6d4
                                        @else #6b7280
                                        @endif;">{{ ucfirst(str_replace('_', ' ', $log->activity_type)) }}</span>
                                    <br>
                                    <span class="text-muted" style="font-size: 0.875rem;">{{ $log->description }}</span>
                                </div>
                                <div class="recent-time">
                                    {{ $log->created_at->diffForHumans() }}
                                    <span class="text-muted" style="font-size: 0.75rem;">• {{ $log->ip_address }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-clipboard fa-2x mb-2 d-block opacity-50"></i>
                            No admin activity recorded yet.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
/* ============ Dashboard Styles ============ */
.admin-dashboard {
    background: #f1f5f9;
    min-height: 100vh;
}

/* Header */
.dash-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    color: white;
    padding: 1.5rem;
    margin-bottom: 0;
}

.dash-header-icon {
    width: 52px;
    height: 52px;
    background: rgba(255,255,255,.15);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}

.dash-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff;
}

.dash-subtitle {
    font-size: 0.9rem;
    color: rgba(255,255,255,.85);
}

/* Stat Cards */
.dash-stat-card {
    background: #fff;
    border-radius: 0.875rem;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.08);
    border: 1px solid #e2e8f0;
    transition: box-shadow .2s, transform .2s;
}

.dash-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
}

.dash-stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.dash-stat-number {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
    margin-bottom: 0.2rem;
}

.dash-stat-label {
    font-size: 0.8rem;
    color: #64748b;
    font-weight: 500;
}

/* Generic Card */
.dash-card {
    background: #fff;
    border-radius: 0.875rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.08);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.dash-card-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    flex-shrink: 0;
}

.dash-card-body {
    padding: 1.25rem;
    flex: 1;
}

/* Quick Actions */
.quick-action-btn {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 0.75rem 1rem;
    border-radius: 0.625rem;
    text-decoration: none;
    color: #1f2937;
    transition: background .15s;
    margin-bottom: 0.25rem;
}

.quick-action-btn:hover {
    background: #f1f5f9;
    color: #1f2937;
}

.qa-icon {
    width: 38px;
    height: 38px;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.qa-text {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.qa-label {
    font-weight: 600;
    font-size: 0.875rem;
    line-height: 1.2;
}

.qa-desc {
    font-size: 0.75rem;
    color: #94a3b8;
}

/* Recent Sightings */
.recent-item {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 0.875rem 1.25rem;
    border-bottom: 1px solid #f1f5f9;
    transition: background .15s;
}

.recent-item:last-child { border-bottom: none; }
.recent-item:hover { background: #f8fafc; }

.recent-icon {
    width: 34px;
    height: 34px;
    border-radius: 0.5rem;
    background: rgba(59,130,246,.1);
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    flex-shrink: 0;
}

.recent-text {
    font-size: 0.875rem;
    font-weight: 500;
    color: #1f2937;
    margin-bottom: 0.15rem;
}

.recent-time {
    font-size: 0.75rem;
    color: #94a3b8;
}

/* Responsive */
@media (max-width: 576px) {
    .dash-stat-card { padding: 1rem; gap: 0.75rem; }
    .dash-stat-number { font-size: 1.4rem; }
    .dash-title { font-size: 1.2rem; }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
var municipalities = {!! json_encode($municipalities) !!};
var totalCotsArray = {!! json_encode($totalCotsArray) !!};

var baseColors = ['#1e40af','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#f97316','#84cc16'];
var colors = municipalities.map((_, i) => baseColors[i % baseColors.length]);

var chartPie = null;

if (municipalities.length > 0 && municipalities.length === totalCotsArray.length) {
    var options = {
        chart: { type: 'donut', height: 350, background: 'transparent', animations: { speed: 600 } },
        series: totalCotsArray,
        labels: municipalities,
        colors: colors,
        dataLabels: {
            enabled: true,
            style: { fontSize: '12px', fontWeight: '600', colors: ['#fff'] },
            formatter: function(val) { return val.toFixed(1) + '%'; }
        },
        tooltip: { y: { formatter: v => v + ' COTS' } },
        plotOptions: {
            pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total COTS', color: '#1e40af' } } } }
        },
        legend: { position: 'bottom', fontSize: '12px', itemMargin: { horizontal: 8, vertical: 4 } },
        responsive: [{ breakpoint: 768, options: { legend: { fontSize: '10px' } } }]
    };
    chartPie = new ApexCharts(document.querySelector("#pieChart"), options);
    chartPie.render();
} else {
    document.querySelector("#pieChart").innerHTML = '<p class="text-center text-muted py-5">No data available.</p>';
}

function refreshChart() {
    if (chartPie) chartPie.updateOptions({});
}
</script>

@endsection
