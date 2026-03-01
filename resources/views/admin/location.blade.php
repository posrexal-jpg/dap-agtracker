@extends('layouts.admin')
@section('title', 'COTS Sightings Map - Admin Dashboard')

@push('styles')
<style>
    /* Fullscreen Map View - Matching /sightings page */
    body.admin-page {
        overflow: hidden;
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
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 15px 20px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        min-width: 200px;
    }

    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .stat-item:last-child {
        border-bottom: none;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 500;
    }

    .stat-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e40af;
    }

    /* Map Controls */
    .map-controls {
        position: fixed;
        bottom: 100px;
        right: 20px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .map-control-btn {
        background: white;
        border: none;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #1e40af;
        transition: all 0.3s ease;
    }

    .map-control-btn:hover {
        background: #1e40af;
        color: white;
        transform: scale(1.1);
    }

    /* Popup Styles */
    .sighting-info {
        max-width: 280px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .sighting-info h6 {
        color: #1e40af;
        margin-bottom: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sighting-detail {
        margin-bottom: 6px;
        font-size: 0.9rem;
        display: flex;
        justify-content: space-between;
    }

    .sighting-detail strong {
        color: #374151;
        font-weight: 600;
    }

    .sighting-detail span {
        color: #6b7280;
    }

    .delete-btn-popup {
        margin-top: 12px;
        width: 100%;
    }

    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
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

    // Function to create starfish SVG icon (matching sightings page)
    function createStarfishIcon(color) {
        const svg = `
            <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <circle cx="16" cy="16" r="6" fill="${color}" stroke="white" stroke-width="1.5"/>
                <path d="M 16 2 Q 14 8 16 10" stroke="${color}" stroke-width="4" fill="none" stroke-linecap="round"/>
                <path d="M 24 6 Q 21 10 20 12" stroke="${color}" stroke-width="4" fill="none" stroke-linecap="round"/>
                <path d="M 26 18 Q 22 18 20 20" stroke="${color}" stroke-width="4" fill="none" stroke-linecap="round"/>
                <path d="M 20 26 Q 18 22 16 20" stroke="${color}" stroke-width="4" fill="none" stroke-linecap="round"/>
                <path d="M 8 18 Q 10 18 12 20" stroke="${color}" stroke-width="4" fill="none" stroke-linecap="round"/>
                <path d="M 6 6 Q 10 10 12 12" stroke="${color}" stroke-width="4" fill="none" stroke-linecap="round"/>
                <circle cx="16" cy="2" r="1.5" fill="${color}"/>
                <circle cx="26" cy="8" r="1.5" fill="${color}"/>
                <circle cx="28" cy="18" r="1.5" fill="${color}"/>
                <circle cx="20" cy="28" r="1.5" fill="${color}"/>
                <circle cx="12" cy="28" r="1.5" fill="${color}"/>
                <circle cx="4" cy="18" r="1.5" fill="${color}"/>
                <circle cx="6" cy="8" r="1.5" fill="${color}"/>
                <ellipse cx="16" cy="30" rx="8" ry="1.5" fill="rgba(0,0,0,0.2)"/>
            </svg>
        `;
        return `data:image/svg+xml;base64,${btoa(svg)}`;
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
        
        const markerIcon = L.icon({
            iconUrl: createStarfishIcon(markerColor),
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

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
