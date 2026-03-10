@extends('layouts.admin')
@section('title', 'COTS Sightings Map - Admin Dashboard')

@push('styles')
<style>
    /* Force Light Mode - Prevent System Dark Mode */
    html, body {
        color-scheme: light !important;
        background: #f8fafc !important;
        color: #1f2937 !important;
    }

    /* Override Bootstrap Dark Mode */
    [data-bs-theme="dark"],
    [data-theme="dark"] {
        color-scheme: light !important;
        background: #f8fafc !important;
        color: #1f2937 !important;
    }

    /* Fullscreen Map View - Matching /sightings page */
    body.admin-page {
        overflow: hidden;
        background: #ffffff !important;
    }

    .layout-page {
        margin-left: 280px;
        padding: 0 !important;
        overflow: hidden;
    }

    .layout-page main {
        padding: 0 !important;
        height: 100vh;
        overflow: hidden;
    }

    #map {
        height: 100vh !important;
        width: 100% !important;
        position: fixed !important;
        top: 0 !important;
        left: 280px !important;
        right: 0 !important;
        z-index: 1 !important;
    }

    /* Mobile Adjustments */
    @media (max-width: 1199.98px) {
        .layout-page {
            margin-left: 0;
        }

        #map {
            left: 0 !important;
        }

        body.admin-page {
            padding-bottom: 80px;
        }
    }

    /* Pulse animation for outbreak markers (red) */
    @keyframes pulseOutbreak {
        0% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(220, 53, 69, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
        }
    }

    .marker-outbreak {
        animation: pulseOutbreak 2s infinite;
    }

    /* Stats Overlay */
    .stats-overlay {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #ffffff !important;
        backdrop-filter: blur(10px);
        padding: 20px 24px;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        z-index: 1000;
        min-width: 220px;
        border: 1px solid #e5e7eb;
    }

    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .stat-item:last-child {
        border-bottom: none;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #6b7280 !important;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Map Controls */
    .map-controls {
        position: fixed;
        bottom: 100px;
        right: 20px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .map-control-btn {
        background: #ffffff !important;
        border: 1px solid #e5e7eb;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #1e40af !important;
        transition: all 0.3s ease;
    }

    .map-control-btn:hover {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 64, 175, 0.3);
        border-color: transparent;
    }

    /* Popup Styles */
    .sighting-info {
        max-width: 300px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: #ffffff !important;
        color: #1f2937 !important;
    }

    .sighting-info h6 {
        color: #1e40af !important;
        margin-bottom: 14px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.1rem;
    }

    .sighting-detail {
        margin-bottom: 8px;
        font-size: 0.9rem;
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .sighting-detail:last-child {
        border-bottom: none;
    }

    .sighting-detail strong {
        color: #374151 !important;
        font-weight: 600;
    }

    .sighting-detail span {
        color: #6b7280 !important;
    }

    .delete-btn-popup {
        margin-top: 12px;
        width: 100%;
    }

    .leaflet-popup-content-wrapper {
        border-radius: 16px !important;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15) !important;
        background: #ffffff !important;
        border: 1px solid #e5e7eb;
    }

    .leaflet-popup-content {
        color: #1f2937 !important;
    }

    .leaflet-popup-tip {
        background: #ffffff !important;
    }

    /* Mobile responsive */
    @media (max-width: 991px) {
        .stats-overlay {
            top: 10px;
            right: 10px;
            left: 10px;
            min-width: auto;
            padding: 10px 15px;
        }

        .map-controls {
            bottom: 90px;
            right: 10px;
            flex-direction: row;
        }

        .map-control-btn {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
    }

    /* Custom circle icon styling - remove default divIcon background */
    .custom-circle-icon {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }

    .marker-outbreak {
        animation: pulseOutbreak 2s infinite;
    }

    @keyframes pulseOutbreak {
        0% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(220, 53, 69, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
        }
    }
</style>
@endpush

@section('content')
<!-- Stats Overlay -->
<div class="stats-overlay">
    <div class="stat-item">
        <span class="stat-label">Total Sightings</span>
        <span class="stat-value">{{ $locations->count() }}</span>
    </div>
    <div class="stat-item">
        <span class="stat-label">Total COTS</span>
        <span class="stat-value">{{ $locations->sum('number_of_cots') }}</span>
    </div>
    <div class="stat-item">
        <span class="stat-label">Municipalities</span>
        <span class="stat-value">{{ $locations->pluck('municipality')->unique()->count() }}</span>
    </div>
</div>

<!-- Map Controls -->
<div class="map-controls">
    <button class="map-control-btn" onclick="refreshMap()" title="Refresh Map">
        <i class="bx bx-refresh"></i>
    </button>
    <button class="map-control-btn" onclick="centerMap()" title="Center Map">
        <i class="bx bx-crosshairs"></i>
    </button>
    <button class="map-control-btn" onclick="toggleFullscreen()" title="Toggle Fullscreen">
        <i class="bx bx-fullscreen"></i>
    </button>
</div>

<!-- Fullscreen Map -->
<div id="map"></div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map centered on Philippines
    const map = L.map('map').setView([10.3157, 123.8854], 8);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Function to create circle SVG icon
    function createCircleIcon(color) {
        const svg = `
            <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <circle cx="16" cy="16" r="12" fill="${color}" stroke="white" stroke-width="3"/>
                <ellipse cx="16" cy="28" rx="10" ry="2" fill="rgba(0,0,0,0.15)"/>
            </svg>
        `;
        return L.divIcon({
            html: svg,
            className: 'custom-circle-icon',
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });
    }

    // Store all markers for later reference
    const allMarkers = [];

    // Add markers for each sighting
    @foreach($locations as $location)
    (function() {
        // Determine marker color based on COTS count
        // Red if count > 15 (outbreak), Green otherwise
        const cotsCount = {{ $location->number_of_cots }};
        const markerColor = cotsCount > 15 ? '#dc3545' : '#28a745';
        const isOutbreak = cotsCount > 15;
        
        const markerIcon = createCircleIcon(markerColor);

        const marker = L.marker([{{ $location->latitude }}, {{ $location->longitude }}], {
            icon: markerIcon
        }).addTo(map);

        // Add pulse class to marker element if outbreak
        if (isOutbreak) {
            marker._icon.classList.add('marker-outbreak');
        }

        // Create popup content
        const popupContent = `
            <div class="sighting-info">
                <h6><i class="bx bx-map-pin"></i> COTS Sighting</h6>
                <div class="sighting-detail">
                    <strong>Location:</strong>
                    <span>{{ $location->name }}</span>
                </div>
                <div class="sighting-detail">
                    <strong>Municipality:</strong>
                    <span>{{ $location->municipality }}</span>
                </div>
                <div class="sighting-detail">
                    <strong>Barangay:</strong>
                    <span>{{ $location->barangay }}</span>
                </div>
                <div class="sighting-detail">
                    <strong>COTS Count:</strong>
                    <span class="badge bg-${isOutbreak ? 'danger' : 'success'}">{{ $location->number_of_cots }}</span>
                </div>
                @if($location->early_juvenile || $location->juvenile || $location->sub_adult || $location->adult || $location->late_adult)
                <div class="sighting-detail mt-2">
                    <strong>Size Distribution:</strong>
                </div>
                <div style="font-size: 0.8rem; margin-left: 10px;">
                    @if($location->early_juvenile) <div>1-5cm: {{ $location->early_juvenile }}</div>@endif
                    @if($location->juvenile) <div>6-15cm: {{ $location->juvenile }}</div>@endif
                    @if($location->sub_adult) <div>16-25cm: {{ $location->sub_adult }}</div>@endif
                    @if($location->adult) <div>26-35cm: {{ $location->adult }}</div>@endif
                    @if($location->late_adult) <div>>35cm: {{ $location->late_adult }}</div>@endif
                </div>
                @endif
                <div class="sighting-detail mt-2">
                    <strong>Activity:</strong>
                    <span>{{ $location->activity_type ?: 'Not specified' }}</span>
                </div>
                <div class="sighting-detail">
                    <strong>Observer:</strong>
                    <span>{{ $location->observer_category ?: 'Not specified' }}</span>
                </div>
                <div class="sighting-detail">
                    <strong>Date:</strong>
                    <span>{{ $location->date_of_sighting ? \Carbon\Carbon::parse($location->date_of_sighting)->format('M d, Y') : 'Not specified' }}</span>
                </div>
                <div class="sighting-detail">
                    <strong>Time:</strong>
                    <span>{{ $location->time_of_sighting ?: 'Not specified' }}</span>
                </div>
                @if($location->description)
                <div class="sighting-detail mt-2">
                    <strong>Description:</strong>
                </div>
                <div style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">{{ $location->description }}</div>
                @endif
                <button class="btn btn-danger btn-sm delete-btn-popup" onclick="deleteLocation({{ $location->id }})">
                    <i class="bx bx-trash"></i> Delete Sighting
                </button>
            </div>
        `;

        marker.bindPopup(popupContent, {
            maxWidth: 300,
            className: 'custom-popup'
        });

        allMarkers.push(marker);
    })();
    @endforeach

    // Fit map to show all markers
    @if($locations->count() > 0)
    const group = new L.featureGroup(allMarkers);
    map.fitBounds(group.getBounds().pad(0.1));
    @endif

    // Map control functions
    window.refreshMap = function() {
        location.reload();
    };

    window.centerMap = function() {
        @if($locations->count() > 0)
        const group = new L.featureGroup(allMarkers);
        map.fitBounds(group.getBounds().pad(0.1));
        @else
        map.setView([10.3157, 123.8854], 8);
        @endif
    };

    window.toggleFullscreen = function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    };

    // Delete location function
    window.deleteLocation = function(id) {
        if (confirm('Are you sure you want to delete this COTS sighting?')) {
            fetch(`/admin/locations/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                alert('Location deleted successfully!');
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting location');
            });
        }
    };

    // Handle window resize
    window.addEventListener('resize', function() {
        setTimeout(() => {
            map.invalidateSize();
        }, 100);
    });

    console.log('COTS Map initialized with', {{ $locations->count() }}, 'locations');
});
</script>
@endpush
