@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Comprehensive overview of COTS tracking system</p>
            </div>
            <div class="page-actions">
                <button class="btn btn-primary" onclick="location.reload()">
                    <i class="bx bx-refresh"></i> Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="stat-icon mb-3">
                        <i class="bx bx-user text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Total Users</h5>
                    <h2 class="text-primary">{{ number_format($userCount) }}</h2>
                    <p class="text-muted">Registered users</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="stat-icon mb-3">
                        <i class="bx bx-target text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Total COTS</h5>
                    <h2 class="text-warning">{{ number_format($totalCots) }}</h2>
                    <p class="text-muted">Reported sightings</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="stat-icon mb-3">
                        <i class="bx bx-map-pin text-info" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Locations</h5>
                    <h2 class="text-info">{{ number_format($locationCount) }}</h2>
                    <p class="text-muted">Sighting locations</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="stat-icon mb-3">
                        <i class="bx bx-trending-up text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Avg per Location</h5>
                    <h2 class="text-success">{{ $locationCount > 0 ? number_format($totalCots / $locationCount, 1) : 0 }}</h2>
                    <p class="text-muted">COTS per sighting</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Municipality Distribution -->
        <div class="col-xl-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">COTS Distribution by Municipality</h5>
                </div>
                <div class="card-body">
                    <div id="municipalityChart" style="height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Monthly Trends -->
        <div class="col-xl-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Monthly Trends (Last 6 Months)</h5>
                </div>
                <div class="card-body">
                    <div id="monthlyChart" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity and Observer Stats -->
    <div class="row mb-4">
        <!-- Activity Types -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Activity Types</h5>
                </div>
                <div class="card-body">
                    <div id="activityChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <!-- Observer Categories -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Observer Categories</h5>
                </div>
                <div class="card-body">
                    <div id="observerChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- COTS Size Distribution and Top Barangays -->
    <div class="row mb-4">
        <!-- COTS Size Distribution -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">COTS Size Distribution</h5>
                </div>
                <div class="card-body">
                    <div id="sizeChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <!-- Top Barangays -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Top Barangays by Sightings</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Barangay</th>
                                    <th>Sightings</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topBarangays as $barangay)
                                <tr>
                                    <td>{{ $barangay->barangay ?: 'N/A' }}</td>
                                    <td>{{ $barangay->count }}</td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                 style="width: {{ $locationCount > 0 ? ($barangay->count / $locationCount) * 100 : 0 }}%"
                                                 aria-valuenow="{{ $barangay->count }}"
                                                 aria-valuemin="0"
                                                 aria-valuemax="{{ $locationCount }}"></div>
                                        </div>
                                        {{ $locationCount > 0 ? number_format(($barangay->count / $locationCount) * 100, 1) : 0 }}%
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <!-- Recent Sightings -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Sightings (Last 7 Days)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th>Municipality</th>
                                    <th>COTS Count</th>
                                    <th>Activity</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSightings as $sighting)
                                <tr>
                                    <td>{{ $sighting->name ?: 'N/A' }}</td>
                                    <td>{{ $sighting->municipality ?: 'N/A' }}</td>
                                    <td><span class="badge bg-warning">{{ $sighting->number_of_cots ?: 0 }}</span></td>
                                    <td>{{ $sighting->activity_type ?: 'N/A' }}</td>
                                    <td>{{ $sighting->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No recent sightings</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Users</h5>
                </div>
                <div class="card-body">
                    @forelse($recentUsers as $user)
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-sm me-3">
                            <div class="avatar-initial bg-primary rounded-circle">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{ $user->name }}</h6>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </div>
                        <span class="badge bg-secondary">{{ $user->role->role_name ?? 'User' }}</span>
                    </div>
                    @empty
                    <p class="text-muted text-center">No recent users</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
// Chart data from PHP
var municipalities = {!! json_encode($municipalities) !!};
var totalCotsArray = {!! json_encode($totalCotsArray) !!};
var sightingCounts = {!! json_encode($sightingCounts) !!};
var activityLabels = {!! json_encode($activityLabels) !!};
var activityCounts = {!! json_encode($activityCounts) !!};
var observerLabels = {!! json_encode($observerLabels) !!};
var observerCounts = {!! json_encode($observerCounts) !!};
var monthlyLabels = {!! json_encode($monthlyLabels) !!};
var monthlySightings = {!! json_encode($monthlySightings) !!};
var monthlyCots = {!! json_encode($monthlyCots) !!};
var cotsSizes = {!! json_encode($cotsSizes) !!};

// Color schemes
var municipalityColors = ['#f44336', '#4caf50', '#2196f3', '#ff9800', '#9c27b0', '#3f51b5', '#009688', '#795548'];
var activityColors = ['#e91e63', '#9c27b0', '#673ab7', '#3f51b5', '#2196f3', '#00bcd4'];
var observerColors = ['#4caf50', '#8bc34a', '#cddc39', '#ffeb3b', '#ffc107'];
var sizeColors = ['#81c784', '#4caf50', '#388e3c', '#2e7d32', '#1b5e20'];

// Municipality Chart (Donut)
if (municipalities.length > 0) {
    var municipalityOptions = {
        chart: {
            type: 'donut',
            height: 350,
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        series: totalCotsArray,
        labels: municipalities,
        colors: municipalityColors.slice(0, municipalities.length),
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '14px',
                fontWeight: 'bold',
                colors: ['#fff']
            },
            formatter: function (val, opts) {
                return totalCotsArray[opts.seriesIndex] + ' cots';
            }
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function (val, opts) {
                    return val + ' cots (' + sightingCounts[opts.seriesIndex] + ' sightings)';
                }
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total COTS',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            }
                        }
                    }
                }
            }
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '12px'
        }
    };
    var municipalityChart = new ApexCharts(document.querySelector("#municipalityChart"), municipalityOptions);
    municipalityChart.render();
}

// Monthly Trends Chart (Line/Bar Combo)
if (monthlyLabels.length > 0) {
    var monthlyOptions = {
        chart: {
            type: 'line',
            height: 350,
            toolbar: {
                show: false
            }
        },
        series: [{
            name: 'Sightings',
            type: 'column',
            data: monthlySightings
        }, {
            name: 'Total COTS',
            type: 'line',
            data: monthlyCots
        }],
        colors: ['#2196f3', '#ff9800'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: [0, 3]
        },
        xaxis: {
            categories: monthlyLabels,
            labels: {
                formatter: function(value) {
                    var date = new Date(value + '-01');
                    return date.toLocaleDateString('en-US', { month: 'short', year: '2-digit' });
                }
            }
        },
        yaxis: [{
            title: {
                text: 'Sightings'
            }
        }, {
            opposite: true,
            title: {
                text: 'COTS Count'
            }
        }],
        tooltip: {
            shared: true,
            intersect: false
        },
        legend: {
            position: 'top'
        }
    };
    var monthlyChart = new ApexCharts(document.querySelector("#monthlyChart"), monthlyOptions);
    monthlyChart.render();
}

// Activity Types Chart (Bar)
if (activityLabels.length > 0) {
    var activityOptions = {
        chart: {
            type: 'bar',
            height: 300,
            toolbar: {
                show: false
            }
        },
        series: [{
            name: 'Count',
            data: activityCounts
        }],
        colors: activityColors.slice(0, activityLabels.length),
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '60%',
                distributed: true
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: activityLabels
        },
        tooltip: {
            theme: 'dark'
        }
    };
    var activityChart = new ApexCharts(document.querySelector("#activityChart"), activityOptions);
    activityChart.render();
}

// Observer Categories Chart (Pie)
if (observerLabels.length > 0) {
    var observerOptions = {
        chart: {
            type: 'pie',
            height: 300
        },
        series: observerCounts,
        labels: observerLabels,
        colors: observerColors.slice(0, observerLabels.length),
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '12px',
                colors: ['#fff']
            }
        },
        tooltip: {
            theme: 'dark'
        },
        legend: {
            position: 'bottom'
        }
    };
    var observerChart = new ApexCharts(document.querySelector("#observerChart"), observerOptions);
    observerChart.render();
}

// COTS Size Distribution Chart (Horizontal Bar)
var sizeLabels = Object.keys(cotsSizes);
var sizeValues = Object.values(cotsSizes);

if (sizeLabels.length > 0 && sizeValues.some(v => v > 0)) {
    var sizeOptions = {
        chart: {
            type: 'bar',
            height: 300,
            toolbar: {
                show: false
            }
        },
        series: [{
            name: 'Count',
            data: sizeValues
        }],
        colors: sizeColors,
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '50%'
            }
        },
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            style: {
                colors: ['#333']
            },
            formatter: function (val) {
                return val > 0 ? val : '';
            },
            offsetX: 10
        },
        xaxis: {
            categories: sizeLabels.map(label => label.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()))
        },
        tooltip: {
            theme: 'dark'
        }
    };
    var sizeChart = new ApexCharts(document.querySelector("#sizeChart"), sizeOptions);
    sizeChart.render();
}

</script>
@endsection