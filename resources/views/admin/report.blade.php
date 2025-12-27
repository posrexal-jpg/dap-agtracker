@extends('layouts.app')

@section('content')

<!-- Card for Location Report -->
<div class="card shadow-sm mt-4">
    <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white p-3 rounded-top">
        <h5 class="m-0">
            <i class="bx bx-map"></i> Sightings Report
        </h5>
        <a href="{{ route('admin.report.export', ['municipality' => request('municipality')]) }}" class="btn btn-success">
            <i class="bx bx-download"></i> Export
        </a>
    </div>

    <!-- Filter Dropdown at the Upper Left -->
    <div class="dropdown p-3">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-filter"></i> Filter
        </button>
        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
            <li>
                <form method="GET" action="{{ route('admin.report') }}" class="mb-3">
                    <div class="d-flex">
                        <select name="municipality" class="form-select" onchange="this.form.submit()">
                            <option value="">Select Municipality</option>
                            @foreach($municipalities as $municipality)
                                <option value="{{ $municipality }}" {{ request('municipality') == $municipality ? 'selected' : '' }}>
                                    {{ $municipality }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </li>
        </ul>
    </div>

    <!-- Table for Locations -->
    <div class="table-responsive text-nowrap p-3">
        <table class="table table-hover table-striped table-sm table-bordered m-0">
            <thead class="table-dark">
                <tr>
                    <th style="width: 5%; color: white;">#</th>
                    <th style="width: 10%; color: white;">Name</th>
                    <th style="width: 15%; color: white;">Municipality where COTS are Sighted</th>
                    <th style="width: 5%; color: white;">Number of Cots</th>
                    <th style="width: 5%; color: white;">Date of COTS Sighted</th>
                    <th style="width: 5%; color: white;">Time of COTS Sighted</th>
                </tr>
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
