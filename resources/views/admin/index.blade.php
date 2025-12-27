@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <div class="container d-flex justify-content-center align-items-center flex-column mt-5">
        <div class="row w-100 justify-content-center">
            <div class="col-md-3 mb-4">
                <div class="card shadow-lg rounded-lg text-center" style="background-color: #f7f7f7; border: none;">
                    <div class="card-body" style="padding: 30px;">
                        <h5 class="mb-3" style="font-weight: 600; color: #333;">Total Users</h5>
                        <p style="font-size: 1.5rem; font-weight: bold; color: #4caf50;">{{ $userCount }} users</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card shadow-lg rounded-lg text-center" style="background-color: #f7f7f7; border: none;">
                    <div class="card-body" style="padding: 30px;">
                        <h5 class="mb-3" style="font-weight: 600; color: #333;">Total Cots</h5>
                        <p style="font-size: 1.5rem; font-weight: bold; color: #ff9800;">{{ $totalCots }} cots</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row w-100 justify-content-center">
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg rounded-lg" style="border: none;">
                    <div class="card-body">
                        <h5 class="text-center" style="font-weight: 600; color: #333;">Locations by Municipality</h5>
                        <div id="pieChart" style="height: 350px;"></div>
                    </div>
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
        height: 350,
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