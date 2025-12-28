@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h1 class="page-title">Sightings Report</h1>
                <p class="page-subtitle">View and export COTS sighting reports</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.report.export', ['municipality' => request('municipality')]) }}" class="btn btn-success">
                    <i class="bx bx-download"></i> Export Report
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
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Municipality</th>
                                    <th>Number of COTS</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
            </thead>
            <tbody>
                @foreach($locations as $location)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $location->name }}</td>
                        <td>{{ $location->municipality }}</td>
                        <td>{{ $location->number_of_cots }}</td>
                        <td>{{ $location->date_of_sighting}}</td>
                        <td>{{ $location->time_of_sighting}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center my-3">
        {{ $locations->links('pagination::bootstrap-5') }}
    </div>

</div>


@endsection
