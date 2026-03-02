@extends('layouts.user')

@section('content')
<style>
    /* Root Variables */
    :root {
        --primary-color: #1e3a8a;
        --secondary-color: #3b82f6;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --light-gray: #f8fafc;
        --border-color: #e2e8f0;
        --text-muted: #64748b;
        --navbar-height: 64px;
    }

    * {
        box-sizing: border-box;
    }

    /* Main Layout Container */
    .sightings-map-container {
        display: flex;
        flex-direction: column;
        height: 100%;
        min-height: 100vh;
        background: #ffffff;
    }

    /* Desktop Grid Layout */
    @media (min-width: 992px) {
        .sightings-map-container {
            flex-direction: row;
            padding: 20px;
            gap: 20px;
            background: var(--light-gray);
            height: auto;
            min-height: calc(100vh - var(--navbar-height));
            padding-top: calc(var(--navbar-height) + 20px);
            margin-top: calc(-1 * var(--navbar-height));
        }
    }

    /* Map Container */
    .map-container {
        flex: 1;
        min-height: 400px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background: #ffffff;
    }

    @media (max-width: 991px) {
        .map-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            min-height: 100vh;
            border-radius: 0;
            box-shadow: none;
            z-index: 1;
        }
    }

    #map {
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    /* Sidebar Panel */
    .sidebar-panel {
        width: 100%;
        background: transparent;
    }

    @media (min-width: 992px) {
        .sidebar-panel {
            width: 320px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-height: calc(100vh - 120px);
            overflow-y: auto;
        }
    }

    /* Card Base Styles */
    .card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 16px;
        font-size: 0.95rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-body {
        padding: 16px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .stat-item {
        background: linear-gradient(135deg, var(--light-gray) 0%, #f1f5f9 100%);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 12px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
    }

    .stat-label {
        font-size: 0.7rem;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin: 0;
        margin-top: 4px;
    }

    .stat-item.danger .stat-value {
        color: var(--danger-color);
    }

    .stat-item.success .stat-value {
        color: var(--success-color);
    }

    /* Filter Section */
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 12px;
    }

    .filter-group:last-child {
        margin-bottom: 0;
    }

    .filter-group label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary-color);
        display: block;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.875rem;
        background: #ffffff;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    /* Legend */
    .legend-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.85rem;
    }

    .legend-item:last-child {
        border-bottom: none;
    }

    .legend-marker {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        flex-shrink: 0;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }

    .legend-marker.high {
        background: var(--danger-color);
    }

    .legend-marker.moderate {
        background: var(--warning-color);
    }

    .legend-marker.low {
        background: var(--success-color);
    }

    .legend-text strong {
        display: block;
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 2px;
    }

    .legend-text span {
        color: var(--text-muted);
        font-size: 0.8rem;
    }

    /* Action Buttons */
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn {
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: #e5e7eb;
        transform: translateY(-2px);
    }

    /* Mobile: Hide Sidebar */
    @media (max-width: 991px) {
        .sidebar-panel {
            display: none;
        }
    }

    /* Floating Action Button (Mobile Only) */
    .fab-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--danger-color) 0%, #ef4444 100%);
        color: white;
        border: none;
        box-shadow: 0 8px 24px rgba(220, 38, 38, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        z-index: 999;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .fab-button:hover {
        transform: scale(1.1);
        box-shadow: 0 12px 32px rgba(220, 38, 38, 0.45);
    }

    .fab-button:active {
        transform: scale(0.95);
    }

    @media (min-width: 992px) {
        .fab-button {
            display: none;
        }
    }

    /* Modal Styles */
    .modal-dialog {
        max-width: 100vw;
        margin: 0;
        height: 100vh;
    }

    .modal-content {
        border-radius: 0;
        border: none;
        height: 100vh;
        display: flex;
        flex-direction: column;
        background: #ffffff;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 20px;
        border-bottom: none;
    }

    .modal-body {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
    }

    .modal-footer {
        padding: 16px 20px;
        border-top: 1px solid var(--border-color);
        background: var(--light-gray);
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.9rem;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.95rem;
        background: #ffffff;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    /* Scrollbar Styling */
    .sidebar-panel::-webkit-scrollbar,
    .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-panel::-webkit-scrollbar-track,
    .modal-body::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-panel::-webkit-scrollbar-thumb,
    .modal-body::-webkit-scrollbar-thumb {
        background: rgba(30, 58, 138, 0.2);
        border-radius: 3px;
    }

    .sidebar-panel::-webkit-scrollbar-thumb:hover,
    .modal-body::-webkit-scrollbar-thumb:hover {
        background: rgba(30, 58, 138, 0.4);
    }

    /* Responsive Grid Adjustments */
    @media (min-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    /* Orientation: Tablet */
    @media (min-width: 768px) and (max-width: 991px) {
        .sightings-map-container {
            padding: 0;
            background: #ffffff;
        }

        .map-container {
            border-radius: 0;
        }
    }
</style>

<div class="sightings-map-container">
    <!-- Map Container -->
    <div class="map-container">
        <div id="map"></div>
    </div>

    <!-- Sidebar Panel -->
    <div class="sidebar-panel">
        <!-- Stats Card -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-line"></i>
                Statistics
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-item">
                        <p class="stat-value" id="totalSightings">0</p>
                        <p class="stat-label">Total</p>
                    </div>
                    <div class="stat-item danger">
                        <p class="stat-value" id="highRiskCount">0</p>
                        <p class="stat-label">High Risk</p>
                    </div>
                    <div class="stat-item success">
                        <p class="stat-value" id="lowRiskCount">0</p>
                        <p class="stat-label">Low Risk</p>
                    </div>
                    <div class="stat-item">
                        <p class="stat-value" id="thisWeekCount">0</p>
                        <p class="stat-label">This Week</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-filter"></i>
                Filters
            </div>
            <div class="card-body">
                <div class="filter-group">
                    <label for="municipalityFilter">Municipality</label>
                    <select class="form-select" id="municipalityFilter" onchange="applyFilters()">
                        <option value="">All Municipalities</option>
                        @if(isset($municipalities))
                            @foreach($municipalities as $mun)
                                <option value="{{ $mun }}">{{ $mun }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="filter-group">
                    <label for="riskFilter">Risk Level</label>
                    <select class="form-select" id="riskFilter" onchange="applyFilters()">
                        <option value="">All Levels</option>
                        <option value="high">High Risk (15+ COTS)</option>
                        <option value="moderate">Moderate (5-15 COTS)</option>
                        <option value="low">Low Risk (&lt;5 COTS)</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="dateFilter">Date Range</label>
                    <input type="date" class="form-control" id="dateFilter" onchange="applyFilters()">
                </div>
            </div>
        </div>

        <!-- Legend Card -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-map-marker-alt"></i>
                Map Legend
            </div>
            <div class="card-body">
                <ul class="legend-list">
                    <li class="legend-item">
                        <div class="legend-marker high"></div>
                        <div class="legend-text">
                            <strong>High Risk</strong>
                            <span>15+ COTS</span>
                        </div>
                    </li>
                    <li class="legend-item">
                        <div class="legend-marker moderate"></div>
                        <div class="legend-text">
                            <strong>Moderate</strong>
                            <span>5-15 COTS</span>
                        </div>
                    </li>
                    <li class="legend-item">
                        <div class="legend-marker low"></div>
                        <div class="legend-text">
                            <strong>Low Risk</strong>
                            <span>&lt;5 COTS</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-cogs"></i>
                Actions
            </div>
            <div class="card-body">
                <div class="btn-group">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reportModal">
                        <i class="fas fa-plus"></i>
                        Report Sighting
                    </button>
                    <button class="btn btn-secondary" onclick="syncData()">
                        <i class="fas fa-sync-alt"></i>
                        Sync Data
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Button (Mobile) -->
<button class="fab-button" data-bs-toggle="modal" data-bs-target="#reportModal" title="Report Sighting">
    <i class="fas fa-plus"></i>
</button>

<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-location-crosshairs me-2"></i>
                    Report COTS Sighting
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="reportForm" action="{{ route('user-save-location') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Location Name (Optional)</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Coral Garden">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="municipality">Municipality *</label>
                                <select class="form-select" id="municipality" name="municipality" required>
                                    <option value="">Select Municipality</option>
                                    @if(isset($municipalities))
                                        @foreach($municipalities as $mun)
                                            <option value="{{ $mun }}">{{ $mun }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="barangay">Barangay *</label>
                        <input type="text" class="form-control" id="barangay" name="barangay" required placeholder="Enter barangay name">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_of_sighting">Date of Sighting</label>
                                <input type="date" class="form-control" id="date_of_sighting" name="date_of_sighting" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time_of_sighting">Time of Sighting</label>
                                <input type="time" class="form-control" id="time_of_sighting" name="time_of_sighting">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="number_of_cots">Number of COTS</label>
                                <input type="text" class="form-control" id="number_of_cots" name="number_of_cots" placeholder="e.g., 5-10">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="activity_type">Activity Type</label>
                                <select class="form-select" id="activity_type" name="activity_type">
                                    <option value="">Select Activity</option>
                                    <option value="feeding">Feeding</option>
                                    <option value="moving">Moving</option>
                                    <option value="resting">Resting</option>
                                    <option value="spawning">Spawning</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="latitude">Latitude *</label>
                        <input type="number" step="any" class="form-control" id="latitude" name="latitude" required placeholder="Click on map to set">
                    </div>

                    <div class="form-group">
                        <label for="longitude">Longitude *</label>
                        <input type="number" step="any" class="form-control" id="longitude" name="longitude" required placeholder="Click on map to set">
                    </div>

                    <div class="form-group">
                        <label for="photo">Photos</label>
                        <input type="file" class="form-control" id="photo" name="photo[]" multiple accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="description">Description/Notes</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Additional observations..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Save Sighting
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map;
    let sightingsData = @json(isset($locations) ? $locations->toArray() : []);
    let mapMarkers = [];

    // Initialize Map
    document.addEventListener('DOMContentLoaded', function() {
        initializeMap();
        updateStatistics();
    });

    function initializeMap() {
        map = L.map('map').setView([10.3157, 123.8854], 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add markers
        sightingsData.forEach(sighting => {
            addMarker(sighting);
        });

        // Click to set coordinates
        map.on('click', e => {
            document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
            document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
        });
    }

    function addMarker(sighting) {
        const cots = sighting.number_of_cots || 0;
        const color = cots > 15 ? '#dc2626' : (cots >= 5 ? '#f59e0b' : '#10b981');

        const marker = L.circleMarker([sighting.latitude, sighting.longitude], {
            radius: 8,
            fillColor: color,
            color: '#fff',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.8
        }).addTo(map);

        marker.bindPopup(`
            <strong>${sighting.name || 'Unnamed'}</strong><br>
            ${sighting.barangay}, ${sighting.municipality}<br>
            COTS: ${cots}<br>
            Date: ${new Date(sighting.created_at).toLocaleDateString()}
        `);

        mapMarkers.push(marker);
    }

    function updateStatistics() {
        const total = sightingsData.length;
        const highRisk = sightingsData.filter(s => (s.number_of_cots || 0) > 15).length;
        const lowRisk = sightingsData.filter(s => (s.number_of_cots || 0) < 5).length;
        const thisWeek = sightingsData.filter(s => {
            const date = new Date(s.created_at);
            const weekAgo = new Date(Date.now() - 7 * 24 * 60 * 60 * 1000);
            return date > weekAgo;
        }).length;

        document.getElementById('totalSightings').textContent = total;
        document.getElementById('highRiskCount').textContent = highRisk;
        document.getElementById('lowRiskCount').textContent = lowRisk;
        document.getElementById('thisWeekCount').textContent = thisWeek;
    }

    function applyFilters() {
        const municipality = document.getElementById('municipalityFilter').value;
        const risk = document.getElementById('riskFilter').value;

        mapMarkers.forEach(marker => {
            marker.setOpacity(0.3);
        });

        sightingsData.forEach((sighting, index) => {
            let show = true;

            if (municipality && sighting.municipality !== municipality) show = false;

            if (risk) {
                const cots = sighting.number_of_cots || 0;
                if (risk === 'high' && cots <= 15) show = false;
                if (risk === 'moderate' && (cots < 5 || cots > 15)) show = false;
                if (risk === 'low' && cots >= 5) show = false;
            }

            if (mapMarkers[index]) {
                mapMarkers[index].setOpacity(show ? 0.8 : 0.2);
            }
        });
    }

    function syncData() {
        alert('Syncing data...');
        location.reload();
    }
</script>
@endpush
