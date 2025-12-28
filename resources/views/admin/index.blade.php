@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Overview of COTS tracking system</p>
            </div>
            <div class="page-actions">
                <button class="btn btn-primary" onclick="location.reload()">
                    <i class="bx bx-refresh"></i> Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="stat-icon mb-3">
                        <i class="bx bx-user text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Total Users</h5>
                    <h2 class="text-primary">{{ $userCount }}</h2>
                    <p class="text-muted">Registered users</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="stat-icon mb-3">
                        <i class="bx bx-target text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Total COTS</h5>
                    <h2 class="text-warning">{{ $totalCots }}</h2>
                    <p class="text-muted">Reported sightings</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Locations by Municipality</h5>
                </div>
                <div class="card-body">
                    <div id="pieChart" style="height: 400px;"></div>
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

var municipalities = {!! json_encode($municipalities) !!};
var totalCotsArray = {!! json_encode($totalCotsArray) !!};

var baseColors = ['#f44336', '#4caf50', '#2196f3', '#ff9800', '#9c27b0', '#3f51b5'];

var generatedColors = [];
for (var i = 0; i < municipalities.length; i++) {
    if (i < baseColors.length) {
        generatedColors.push(baseColors[i]);
    } else {
        generatedColors.push('#' + Math.floor(Math.random() * 16777215).toString(16));
    }
}

var optionsPieChart = {
    chart: {
        type: 'donut',
        height: 400,
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800
        }
    },
    series: totalCotsArray,
    labels: municipalities,
    colors: generatedColors,
    dataLabels: {
        enabled: true,
        style: {
            fontSize: '16px',
            fontWeight: 'bold',
            colors: ['#fff']
        },
        formatter: function (val, opts) {
            if (opts.series && opts.series[opts.seriesIndex] !== undefined) {
                var totalCots = opts.series[opts.seriesIndex];
                var percentage = (totalCots / opts.w.globals.seriesTotals.reduce((a, b) => a + b, 0)) * 100;
                return totalCots + ' cots (' + percentage.toFixed(2) + '%)';
            } else {
                var municipality = municipalities[opts.seriesIndex];
                return municipality;
            }
        }
    },
    tooltip: {
        theme: 'dark',
        y: {
            formatter: function (val) {
                return val + ' cots';
            }
        }
    },
    plotOptions: {
        pie: {
            donut: {
                size: '70%', // Adjust the size of the donut
                labels: {
                    show: false // Disable the total label at the center
                }
            }
        }
    },
    legend: {
        position: 'bottom',
        horizontalAlign: 'center',
        fontSize: '14px',
        fontWeight: 'bold',
        markers: {
            width: 15,
            height: 15,
            radius: 5
        }
    }
};

if (municipalities.length === totalCotsArray.length && municipalities.length > 0) {
    var chartPie = new ApexCharts(document.querySelector("#pieChart"), optionsPieChart);
    chartPie.render();
} else {
    console.error("Data mismatch or empty arrays:", municipalities.length, totalCotsArray.length);
}

</script>
@endsection