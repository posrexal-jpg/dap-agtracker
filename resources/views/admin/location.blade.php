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
            padding-bottom: 60px;
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
        border-radius: 50%;
    }

    /* Stats Overlay */
    .stats-overlay {
        position: fixed;
        top: 20px;
        left: 300px;
        background: #ffffff !important;
        backdrop-filter: blur(10px);
        padding: 10px 14px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        z-index: 1000;
        min-width: 180px;
        border: 1px solid #e5e7eb;
    }

    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px 0;
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

    /* Stats overlay collapse */
    .stats-toggle-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        user-select: none;
        padding: 2px 0;
    }

    .stats-toggle-header .stats-title {
        font-size: 0.875rem;
        color: #374151;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .stats-toggle-icon {
        font-size: 1.1rem;
        color: #6b7280;
        transition: transform 0.3s ease;
    }

    .stats-overlay.expanded .stats-toggle-icon {
        transform: rotate(180deg);
    }

    .stats-body {
        display: none;
        overflow: hidden;
    }

    .stats-overlay.expanded .stats-body {
        display: block;
        margin-top: 8px;
        border-top: 1px solid #f3f4f6;
        padding-top: 4px;
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
        max-width: 260px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: #ffffff !important;
        color: #1f2937 !important;
    }

    .sighting-info h6 {
        color: #1e40af !important;
        margin-bottom: 8px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.95rem;
    }

    .sighting-detail {
        margin-bottom: 2px;
        font-size: 0.8rem;
        display: flex;
        justify-content: space-between;
        padding: 3px 0;
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

    /* Badge text visibility - ensure white text on colored backgrounds */
    .sighting-detail .badge {
        color: #ffffff !important;
        font-weight: 600 !important;
        padding: 0.5rem 0.75rem !important;
        font-size: 0.875rem !important;
    }

    .sighting-detail .badge.bg-danger {
        background-color: #dc3545 !important;
        color: #ffffff !important;
    }

    .sighting-detail .badge.bg-success {
        background-color: #28a745 !important;
        color: #ffffff !important;
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
    @media (max-width: 1199.98px) {
        .stats-overlay {
            top: 10px;
            left: 10px;
            min-width: auto;
            max-width: 160px;
            padding: 8px 12px;
        }

        .month-filter-control {
            top: 10px;
            right: 10px;
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
    }

    .marker-outbreak {
        animation: pulseOutbreak 2s infinite;
        border-radius: 50%;
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

    /* Month Filter Control */
    .month-filter-control {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1001;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 12px;
        padding: 12px 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        cursor: move;
        user-select: none;
        touch-action: none;
        transition: all 0.3s ease;
    }

    .month-filter-control.dragging {
        opacity: 0.85;
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.2);
    }

    .month-filter-control label {
        color: #ffffff;
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        cursor: move;
    }

    .month-filter-control label::before {
        content: '⋮⋮';
        font-size: 1rem;
        opacity: 0.7;
        letter-spacing: -2px;
    }
    .filter-row {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .filter-group {
        flex: 1;
        min-width: 0;
    }

    .filter-group label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 4px;
        cursor: default;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }

    .filter-group label::before {
        content: none;
    }
    .month-filter-control select {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }

    .month-filter-control select option {
        background: #1e40af;
        color: #ffffff;
    }

    .month-filter-control select:hover {
        background: rgba(255, 255, 255, 0.35);
        border-color: rgba(255, 255, 255, 0.6);
    }

    .month-filter-control select:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.35);
        border-color: rgba(255, 255, 255, 0.7);
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.2);
    }

    /* Material-UI for Mobile */
    @media (max-width: 991px) {
        * {
            box-sizing: border-box !important;
        }

        body {
            background: #f5f5f5 !important;
            overflow-x: hidden !important;
            width: 100vw !important;
        }

        /* Material-UI Card (Filter) */
        .month-filter-control {
            top: 12px;
            right: 12px;
            left: 12px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            max-width: calc(100vw - 24px) !important;
            overflow: hidden !important;
        }

        .month-filter-control label {
            font-size: 0.688rem;
            font-weight: 600;
            letter-spacing: 0.0893em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .filter-row {
            gap: 8px;
        }

        .month-filter-control select {
            font-size: 0.875rem;
            padding: 10px;
            width: 100%;
            height: 44px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 4px;
            box-shadow: none;
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            line-height: 1.43;
            letter-spacing: 0.01071em;
        }

        .month-filter-control select:focus {
            border-width: 2px;
            padding: 9px;
            border-color: rgba(255, 255, 255, 0.7);
        }

        /* Material-UI Stats Card */
        .stats-overlay {
            box-shadow: 0 2px 4px -1px rgba(0,0,0,.2), 0 4px 5px 0 rgba(0,0,0,.14), 0 1px 10px 0 rgba(0,0,0,.12) !important;
            border-radius: 12px;
        }

        /* Material-UI FAB (Map Controls) */
        .map-controls {
            box-shadow: 0 3px 5px -1px rgba(0,0,0,.2), 0 6px 10px 0 rgba(0,0,0,.14), 0 1px 18px 0 rgba(0,0,0,.12) !important;
        }

        .map-control-btn {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            box-shadow: 0 2px 4px -1px rgba(0,0,0,.2), 0 4px 5px 0 rgba(0,0,0,.14), 0 1px 10px 0 rgba(0,0,0,.12) !important;
        }

        .map-control-btn:active {
            box-shadow: 0 5px 5px -3px rgba(0,0,0,.2), 0 8px 10px 1px rgba(0,0,0,.14), 0 3px 14px 2px rgba(0,0,0,.12) !important;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.0893em;
            text-transform: uppercase;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 400;
            letter-spacing: 0em;
        }
    }
</style>
@endpush

@section('content')
<!-- Stats Overlay -->
<div class="stats-overlay" id="statsOverlay">
    <div class="stats-toggle-header" onclick="toggleStats()">
        <span class="stats-title"><i class="bx bx-bar-chart-alt-2"></i> Statistics</span>
        <i class="bx bx-chevron-down stats-toggle-icon"></i>
    </div>
    <div class="stats-body" id="statsBody">
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

<!-- Month Filter -->
<div class="month-filter-control" id="monthFilterAdminContainer">
    <label for="monthFilterAdmin">Filter Sightings</label>
    <div class="filter-row">
        <div class="filter-group">
            <label for="yearFilterAdmin">Year</label>
            <select id="yearFilterAdmin" onchange="filterMarkersByMonth()">
                <option value="all">All</option>
                <option value="2026" selected>2026</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="monthFilterAdmin">Month</label>
            <select id="monthFilterAdmin" onchange="filterMarkersByMonth()">
                <option value="all">All</option>
                <option value="01">Jan</option>
                <option value="02">Feb</option>
                <option value="03">Mar</option>
                <option value="04">Apr</option>
                <option value="05">May</option>
                <option value="06">Jun</option>
                <option value="07">Jul</option>
                <option value="08">Aug</option>
                <option value="09">Sep</option>
                <option value="10">Oct</option>
                <option value="11">Nov</option>
                <option value="12">Dec</option>
            </select>
        </div>
    </div>
</div>

<!-- Fullscreen Map -->
<div id="map"></div>

@endsection

@push('scripts')
<script>
function toggleStats() {
    const overlay = document.getElementById('statsOverlay');
    overlay.classList.toggle('expanded');
}

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
        const cotsCount = {{ $location->number_of_cots }};
        const markerColor = cotsCount >= {{ $outbreakThreshold ?? 15 }} ? '#dc3545' : '#28a745';
        const isOutbreak = cotsCount >= {{ $outbreakThreshold ?? 15 }};
        
        const markerIcon = createCircleIcon(markerColor);

        const marker = L.marker([{{ $location->latitude }}, {{ $location->longitude }}], {
            icon: markerIcon
        }).addTo(map);

        // Add pulse class to marker element if outbreak
        if (isOutbreak) {
            marker._icon.classList.add('marker-outbreak');
        }

        // Create popup content
        @php
            $szParts = collect([
                '1-5cm' => $location->early_juvenile,
                '6-15cm' => $location->juvenile,
                '16-25cm' => $location->sub_adult,
                '26-35cm' => $location->adult,
                '>35cm' => $location->late_adult,
            ])->filter()->map(fn($v,$k) => "$k: $v")->implode(' ');

            $popupLoc   = $location->location_name ?: ($location->name ?: 'Not specified');
            $popupMun   = $location->municipality ?: 'Not specified';
            $popupBrgy  = $location->barangay ?: 'Not specified';
            $popupAct   = $location->activity_type ?: 'Not specified';
            $popupObs   = $location->observer_category ?: 'Not specified';
            $popupDate  = $location->date_of_sighting
                            ? \Carbon\Carbon::parse($location->date_of_sighting)->format('M d, Y')
                            : 'Not specified';
            $popupTime  = $location->time_of_sighting
                            ? \Carbon\Carbon::parse('1970-01-01 ' . $location->time_of_sighting)->format('g:i A')
                            : 'Not specified';
            $popupDesc  = $location->description
                            ? \Illuminate\Support\Str::limit($location->description, 80)
                            : '';
        @endphp
        const popupContent =
            '<div class="sighting-info">' +
            '<h6><i class="bx bx-map-pin"></i> COTS Sighting</h6>' +
            '<div class="sighting-detail"><strong>Location:</strong><span>' + @json($popupLoc) + '</span></div>' +
            '<div class="sighting-detail"><strong>Municipality:</strong><span>' + @json($popupMun) + '</span></div>' +
            '<div class="sighting-detail"><strong>Barangay:</strong><span>' + @json($popupBrgy) + '</span></div>' +
            '<div class="sighting-detail"><strong>COTS Count:</strong><span class="badge bg-' + (isOutbreak ? 'danger' : 'success') + '">{{ $location->number_of_cots ?? 0 }}</span></div>' +
            @if($szParts)
            '<div class="sighting-detail"><strong>Size Distribution:</strong><span>' + @json($szParts) + '</span></div>' +
            @endif
            '<div class="sighting-detail"><strong>Activity:</strong><span>' + @json($popupAct) + '</span></div>' +
            '<div class="sighting-detail"><strong>Observer:</strong><span>' + @json($popupObs) + '</span></div>' +
            '<div class="sighting-detail"><strong>Date:</strong><span>' + @json($popupDate) + '</span></div>' +
            '<div class="sighting-detail"><strong>Time:</strong><span>' + @json($popupTime) + '</span></div>' +
            @if($popupDesc)
            '<div class="sighting-detail" style="flex-direction:column;gap:2px;"><strong>Description:</strong><span style="font-size:0.75rem;color:#6b7280;">' + @json($popupDesc) + '</span></div>' +
            @endif
            '<button class="btn btn-danger btn-sm delete-btn-popup" onclick="deleteLocation({{ $location->id }})"><i class="bx bx-trash"></i> Delete Sighting</button>' +
            '</div>';

        marker.bindPopup(popupContent, {
            maxWidth: 300,
            className: 'custom-popup'
        });

        // Store marker with date information for filtering
        allMarkers.push({
            marker: marker,
            date: '{{ addslashes($location->date_of_sighting ?? '') }}',
            data: {
                id: {{ $location->id }},
                name: '{{ $location->name }}',
                municipality: '{{ $location->municipality }}',
                barangay: '{{ $location->barangay }}',
                cotsCount: {{ $location->number_of_cots }}
            }
        });
    })();
    @endforeach

    // Fit map to show all markers
    @if($locations->count() > 0)
    const group = new L.featureGroup(allMarkers.map(item => item.marker));
    map.fitBounds(group.getBounds().pad(0.1));
    @endif

    // Map control functions
    window.refreshMap = function() {
        location.reload();
    };

    window.centerMap = function() {
        @if($locations->count() > 0)
        const group = new L.featureGroup(allMarkers.map(item => item.marker));
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

    // Filter markers by selected year and month
    window.filterMarkersByMonth = function() {
        const monthFilter = document.getElementById('monthFilterAdmin');
        const yearFilter = document.getElementById('yearFilterAdmin');
        if (!monthFilter || !yearFilter) return;

        const selectedMonth = monthFilter.value; // "all", "01", "02", etc.
        const selectedYear = yearFilter.value; // "all", "2026", "2025", etc.

        allMarkers.forEach(function(item) {
            const { marker, date } = item;

            if (selectedMonth === 'all' && selectedYear === 'all') {
                // Show all markers
                marker.setOpacity(1);
                if (marker._icon) {
                    marker._icon.style.display = '';
                }
            } else {
                // Parse date and check if it matches selected month/year
                let showMarker = false;

                if (date) {
                    try {
                        // Try to parse date in various formats
                        // Format examples: "2026-01-15", "Jan 15, 2026"
                        let dateObj;

                        if (date.includes('-') && date.match(/^\d{4}-\d{2}-\d{2}/)) {
                            // ISO format: "2026-01-15"
                            dateObj = new Date(date);
                        } else {
                            // Text format or other format
                            dateObj = new Date(date);
                        }

                        if (!isNaN(dateObj.getTime())) {
                            // Get month as two-digit string (01-12) and year as string
                            const markerMonth = ('0' + (dateObj.getMonth() + 1)).slice(-2);
                            const markerYear = dateObj.getFullYear().toString();

                            // Check both year and month filters
                            const monthMatches = (selectedMonth === 'all' || markerMonth === selectedMonth);
                            const yearMatches = (selectedYear === 'all' || markerYear === selectedYear);
                            
                            showMarker = monthMatches && yearMatches;
                        }
                    } catch (parseError) {
                        console.warn('Failed to parse date:', date, parseError);
                    }
                }

                if (showMarker) {
                    marker.setOpacity(1);
                    if (marker._icon) {
                        marker._icon.style.display = '';
                    }
                } else {
                    marker.setOpacity(0);
                    if (marker._icon) {
                        marker._icon.style.display = 'none';
                    }
                }
            }
        });
    };

    // Make month filter draggable (works on both mobile and desktop)
    (function() {
        const filterElement = document.getElementById('monthFilterAdminContainer');
        if (!filterElement) return;

        let isDragging = false;
        let currentX;
        let currentY;
        let initialX;
        let initialY;
        let xOffset = 0;
        let yOffset = 0;

        // Get initial position from CSS
        const computedStyle = window.getComputedStyle(filterElement);
        const right = parseInt(computedStyle.right);
        const top = parseInt(computedStyle.top);
        
        // Convert right position to left position
        xOffset = window.innerWidth - right - filterElement.offsetWidth;
        yOffset = top;

        // Mouse events for desktop
        filterElement.addEventListener('mousedown', dragStart);
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', dragEnd);

        // Touch events for mobile
        filterElement.addEventListener('touchstart', dragStart, { passive: false });
        document.addEventListener('touchmove', drag, { passive: false });
        document.addEventListener('touchend', dragEnd);

        function dragStart(e) {
            // Don't drag if clicking on select element
            if (e.target.tagName === 'SELECT' || e.target.tagName === 'OPTION') {
                return;
            }

            if (e.type === 'touchstart') {
                initialX = e.touches[0].clientX - xOffset;
                initialY = e.touches[0].clientY - yOffset;
            } else {
                initialX = e.clientX - xOffset;
                initialY = e.clientY - yOffset;
            }

            isDragging = true;
            filterElement.classList.add('dragging');
            filterElement.style.right = 'auto';
            filterElement.style.top = 'auto';
            filterElement.style.left = xOffset + 'px';
            filterElement.style.top = yOffset + 'px';
        }

        function drag(e) {
            if (isDragging) {
                e.preventDefault();

                if (e.type === 'touchmove') {
                    currentX = e.touches[0].clientX - initialX;
                    currentY = e.touches[0].clientY - initialY;
                } else {
                    currentX = e.clientX - initialX;
                    currentY = e.clientY - initialY;
                }

                xOffset = currentX;
                yOffset = currentY;

                // Boundary constraints
                const maxX = window.innerWidth - filterElement.offsetWidth;
                const maxY = window.innerHeight - filterElement.offsetHeight;

                xOffset = Math.max(0, Math.min(xOffset, maxX));
                yOffset = Math.max(0, Math.min(yOffset, maxY));

                setTranslate(xOffset, yOffset, filterElement);
            }
        }

        function dragEnd(e) {
            if (isDragging) {
                initialX = currentX;
                initialY = currentY;
                isDragging = false;
                filterElement.classList.remove('dragging');
            }
        }

        function setTranslate(xPos, yPos, el) {
            el.style.left = xPos + 'px';
            el.style.top = yPos + 'px';
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            const maxX = window.innerWidth - filterElement.offsetWidth;
            const maxY = window.innerHeight - filterElement.offsetHeight;
            xOffset = Math.max(0, Math.min(xOffset, maxX));
            yOffset = Math.max(0, Math.min(yOffset, maxY));
            setTranslate(xOffset, yOffset, filterElement);
        });
    })();

    console.log('COTS Map initialized with', {{ $locations->count() }}, 'locations');
});
</script>
@endpush
