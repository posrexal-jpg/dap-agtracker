@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h1 class="page-title">App Installation</h1>
                <p class="page-subtitle">Install the COTS Tracker Progressive Web App</p>
            </div>
        </div>
    </div>

    <!-- Download Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Install Progressive Web App</h5>
                </div>
                <div class="card-body">
                    <div class="download-item d-flex flex-column flex-md-row justify-content-between align-items-center p-3">
                        <div class="download-info text-center text-md-start mb-3 mb-md-0">
                            <h6 class="mb-1">COTS Tracker PWA</h6>
                            <p class="text-muted mb-0">Progressive Web App for offline COTS sighting reporting</p>
                        </div>
                        <a href="{{ route('download') }}" class="btn btn-primary">
                            <i class="bx bx-mobile me-2"></i>Install App
                        </a>
                    </div>

                    <div class="mt-3 p-3 bg-light rounded">
                        <h6 class="text-muted mb-2"><i class="bx bx-info-circle me-1"></i>Installation Instructions</h6>
                        <ul class="text-muted small mb-0">
                            <li>Visit the <a href="{{ route('download') }}" target="_blank">install page</a> on a mobile device</li>
                            <li>Tap "Install App" or follow browser instructions to add to home screen</li>
                            <li>The app works offline and syncs data when online</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
