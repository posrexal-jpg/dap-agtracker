@extends('layouts.app')

@section('content')

<!-- Page title -->
<div class="page-header">
    <h1>COTS Sighting Map</h1>
    <p class="description">View all reported Crown-of-thorns Starfish (COTS) Sightings on the interactive map.</p>
</div>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        <div class="content-wrapper">
            <div id="map" style="height: 80%; position: relative; margin: 0 auto; "></div>
        </div>

        <!-- Core JS -->
        <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.74.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>

        <!-- Leaflet map script -->
        <script>
    var map = L.map('map').setView([10.306812602471465, 125.00810623168947], 12);

    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });
    osm.addTo(map);

    // Locate control for centering the map on the user's location
    L.control.locate({
        setView: true,
        follow: true,
        keepCurrentZoomLevel: true
    }).addTo(map);

    // Function to remove marker
    function removeMarker(marker, id) {
        var isConfirmed = confirm("Are you sure you want to delete this location?");
        if (isConfirmed) {
            map.removeLayer(marker);
            $.ajax({
                url: '/locations/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Location deleted');
                }
            });
        } else {
            console.log('Deletion canceled');
        }
    }

    // Loop through locations and place markers
    @foreach($locations as $location)
        var popupContent = `
            <div class="popup-content" style="width: 250px;">
                <h5 class="popup-title"> <strong>Name:</strong> {{ $location->name ?? '' }}</h5>
                <p class="popup-description"><strong>Description:</strong> {{ $location->description }}</p>
                <p><strong>Date of Sighting:</strong> {{ $location->date_of_sighting }}</p>
                <p><strong>Time of Sighting:</strong> {{ $location->time_of_sighting }}</p>
                <p><strong>Municipality:</strong> {{ $location->municipality }}</p>
                <p><strong>Number of COTS:</strong> {{ $location->number_of_cots ?? 'N/A' }}</p>
                <p><strong>1-5cm:</strong> {{ $location->early_juvenile ?? 'N/A' }}</p>
                <p><strong>6-15cm:</strong> {{ $location->juvenile ?? 'N/A' }}</p>
                <p><strong>16-25cm:</strong> {{ $location->sub_adult ?? 'N/A' }}</p>
                <p><strong>26-35cm:</strong> {{ $location->adult ?? 'N/A' }}</p>
                <p><strong>>35cm:</strong> {{ $location->late_adult ?? 'N/A' }}</p>
                <p><strong>Activity Type:</strong> {{ $location->activity_type ?? 'N/A' }}</p>
                <p><strong>Observer Category:</strong> {{ $location->observer_category ?? 'N/A' }}</p>
                <small class="text-muted">Saved on: {{ \Carbon\Carbon::parse($location->created_at)->format('F j, Y, g:i a') }}</small>

                    @if($location->photo)
                        @php
                            // Decode the JSON array safely
                            $photos = json_decode($location->photo, true); // true returns an associative array
                        @endphp
                        @if(is_array($photos) && count($photos) > 0)
                            <div class="image-collage" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 8px; margin-top: 10px;">
                                @foreach($photos as $photo)
                                    <img src="{{ asset('storage/' . $photo) }}" alt="{{ $location->name }}" loading="lazy" style="width: 100%; height: 150px; border-radius: 8px; object-fit: cover;">
                                @endforeach
                            </div>
                        @else
                            <p>No valid photos available.</p>
                        @endif
                    @else
                        <p>No photos uploaded for this location.</p>
                    @endif

                <div class="text-end mt-2">
                    <button class="btn btn-danger btn-sm" onclick="removeMarker(marker{{ $location->id }}, {{ $location->id }})">
                        <i class="bx bx-trash"></i> Delete
                    </button>
                </div>
            </div>
        `;

        var marker{{ $location->id }} = L.marker([{{ $location->latitude }}, {{ $location->longitude }}]).addTo(map)
            .bindPopup(popupContent);
    @endforeach
</script>

        <!-- Vendors JS -->
        <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

        <!-- Main JS -->
        <script src="{{ asset('assets/js/main.js') }}"></script>

        <!-- Page JS -->
        <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

        <!-- GitHub buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>

        <!-- Custom CSS for Modal -->

@endsection
