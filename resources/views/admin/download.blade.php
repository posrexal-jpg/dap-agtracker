@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h1 class="page-title">Download Center</h1>
                <p class="page-subtitle">Download the COTS Tracker mobile application</p>
            </div>
        </div>
    </div>

    <!-- Download Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Available Downloads</h5>
                </div>
                <div class="card-body">
                    <div class="download-item d-flex flex-column flex-md-row justify-content-between align-items-center p-3">
                        <div class="download-info text-center text-md-start mb-3 mb-md-0">
                            <h6 class="mb-1">COTS Tracker Mobile App</h6>
                            <p class="text-muted mb-0">Android application for COTS sighting reporting</p>
                        </div>
                        <a href="https://github.com/Yajzkie/Android-Cots-Tracker-app.git" class="btn btn-primary" target="_blank">
                            <i class="bx bx-download me-2"></i>Download APK
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
