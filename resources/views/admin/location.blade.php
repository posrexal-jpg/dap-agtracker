@extends('layouts.app')
@section('title', 'COTS Sightings Map - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header - Hidden on Mobile/Tablet -->
    <div class="page-header mb-4 d-none d-lg-block">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h1 class="page-title">
                    <i class="bx bx-map me-3 text-primary"></i>
                    Sightings Map
                </h1>
                <p class="page-subtitle">Interactive map showing all reported COTS sightings with detailed analytics</p>
            </div>
            <div class="page-actions">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="stat-pill bg-light px-3 py-2 rounded">
                        <i class="bx bx-map-pin me-2 text-primary"></i>
                        <span>{{ count($locations) }} Locations</span>
                    </div>
                    <button class="btn btn-outline-primary" onclick="refreshMap()">
                        <i class="bx bx-refresh"></i>
                        <span class="d-none d-sm-inline ms-1">Refresh</span>
                    </button>
                    <button class="btn btn-outline-secondary" onclick="toggleFullscreen()">
                        <i class="bx bx-fullscreen"></i>
                        <span class="d-none d-sm-inline ms-1">Fullscreen</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile/Tablet Top Menu -->
    <div class="mobile-map-menu d-lg-none">
        <div class="mobile-menu-header">
            <div class="mobile-menu-brand">
                <i class="bx bx-map text-primary me-2"></i>
                <span class="fw-semibold">Sightings Map</span>
            </div>
            <div class="mobile-menu-actions">
                <div class="stat-pill bg-light px-2 py-1 rounded-pill me-2">
                    <i class="bx bx-map-pin me-1 text-primary"></i>
                    <span class="small">{{ count($locations) }}</span>
                </div>
                <button class="btn btn-outline-primary btn-sm me-1" onclick="refreshMap()" title="Refresh">
                    <i class="bx bx-refresh"></i>
                </button>
                <button class="btn btn-outline-secondary btn-sm me-1" onclick="toggleMobileFilters()" title="Filters & Legend">
                    <i class="bx bx-filter"></i>
                </button>
                <button class="btn btn-outline-secondary btn-sm" onclick="toggleFullscreen()" title="Fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Filters & Legend Panel (Collapsible) -->
        <div class="mobile-filters-panel" id="mobileFiltersPanel" style="display: none;">
            <div class="mobile-filters-content">
                <!-- Municipality Filter -->
                <div class="filter-group">
                    <label class="filter-label">Municipality</label>
                    <select class="form-select form-select-sm" id="municipalityFilterMobile">
                        <option value="">All Municipalities</option>
                        @foreach($locations->pluck('municipality')->unique() as $municipality)
                            <option value="{{ $municipality }}">{{ $municipality }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Barangay Filter -->
                <div class="filter-group">
                    <label class="filter-label">Barangay</label>
                    <select class="form-select form-select-sm" id="barangayFilterMobile">
                        <option value="">All Barangays</option>
                        @foreach($locations->pluck('barangay')->unique()->filter() as $barangay)
                            <option value="{{ $barangay }}">{{ $barangay }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Activity Type Filter -->
                <div class="filter-group">
                    <label class="filter-label">Activity Type</label>
                    <select class="form-select form-select-sm" id="activityFilterMobile">
                        <option value="">All Activities</option>
                        @foreach($locations->pluck('activity_type')->unique()->filter() as $activity)
                            <option value="{{ $activity }}">{{ $activity }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Observer Category Filter -->
                <div class="filter-group">
                    <label class="filter-label">Observer Category</label>
                    <select class="form-select form-select-sm" id="observerFilterMobile">
                        <option value="">All Categories</option>
                        @foreach($locations->pluck('observer_category')->unique()->filter() as $observer)
                            <option value="{{ $observer }}">{{ $observer }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range Filter -->
                <div class="filter-group">
                    <label class="filter-label">Date Range</label>
                    <div class="date-inputs">
                        <input type="date" class="form-control form-control-sm" id="startDateMobile" placeholder="Start Date">
                        <input type="date" class="form-control form-control-sm" id="endDateMobile" placeholder="End Date">
                    </div>
                </div>

                <!-- Legend -->
                <div class="legend-section">
                    <h6 class="legend-title">COTS Size Categories</h6>
                    <div class="legend-items">
                        <div class="legend-item">
                            <div class="legend-color" style="background: #10b981;"></div>
                            <span>1-5cm (Juvenile)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #f59e0b;"></div>
                            <span>6-15cm (Sub-adult)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #ef4444;"></div>
                            <span>16-25cm (Adult)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #8b5cf6;"></div>
                            <span>26-35cm (Large Adult)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #1e40af;"></div>
                            <span>>35cm (Giant)</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="mobile-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ $locations->sum('number_of_cots') ?? 0 }}</div>
                        <div class="stat-label">Total COTS</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $locations->count() }}</div>
                        <div class="stat-label">Sightings</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $locations->pluck('municipality')->unique()->count() }}</div>
                        <div class="stat-label">Municipalities</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Container -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <!-- Desktop Layout -->
                    <div class="map-wrapper d-none d-lg-flex">
        <div class="map-sidebar">
            <div class="sidebar-header">
                <h6 class="sidebar-title">
                    <i class="fas fa-filter"></i>
                    Filters & Legend
                </h6>
            </div>
            <div class="sidebar-content">
                <!-- Municipality Filter -->
                <div class="filter-group">
                    <label class="filter-label">Municipality</label>
                    <select class="form-select form-select-sm" id="municipalityFilter">
                        <option value="">All Municipalities</option>
                        @foreach($locations->pluck('municipality')->unique() as $municipality)
                            <option value="{{ $municipality }}">{{ $municipality }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Barangay Filter -->
                <div class="filter-group">
                    <label class="filter-label">Barangay</label>
                    <select class="form-select form-select-sm" id="barangayFilter">
                        <option value="">All Barangays</option>
                        @foreach($locations->pluck('barangay')->unique()->filter() as $barangay)
                            <option value="{{ $barangay }}">{{ $barangay }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Activity Type Filter -->
                <div class="filter-group">
                    <label class="filter-label">Activity Type</label>
                    <select class="form-select form-select-sm" id="activityFilter">
                        <option value="">All Activities</option>
                        @foreach($locations->pluck('activity_type')->unique()->filter() as $activity)
                            <option value="{{ $activity }}">{{ $activity }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Observer Category Filter -->
                <div class="filter-group">
                    <label class="filter-label">Observer Category</label>
                    <select class="form-select form-select-sm" id="observerFilter">
                        <option value="">All Categories</option>
                        @foreach($locations->pluck('observer_category')->unique()->filter() as $observer)
                            <option value="{{ $observer }}">{{ $observer }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range Filter -->
                <div class="filter-group">
                    <label class="filter-label">Date Range</label>
                    <div class="date-inputs">
                        <input type="date" class="form-control form-control-sm" id="startDate" placeholder="Start Date">
                        <input type="date" class="form-control form-control-sm" id="endDate" placeholder="End Date">
                    </div>
                </div>

                <!-- Legend -->
                <div class="legend-section">
                    <h6 class="legend-title">COTS Size Categories</h6>
                    <div class="legend-items">
                        <div class="legend-item">
                            <div class="legend-color" style="background: #10b981;"></div>
                            <span>1-5cm (Juvenile)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #f59e0b;"></div>
                            <span>6-15cm (Sub-adult)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #ef4444;"></div>
                            <span>16-25cm (Adult)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #8b5cf6;"></div>
                            <span>26-35cm (Large Adult)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #1e40af;"></div>
                            <span>>35cm (Giant)</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="stats-summary">
                    <div class="stat-summary-item">
                        <div class="stat-value">{{ $locations->sum('number_of_cots') ?? 0 }}</div>
                        <div class="stat-label">Total COTS</div>
                    </div>
                    <div class="stat-summary-item">
                        <div class="stat-value">{{ $locations->count() }}</div>
                        <div class="stat-label">Sightings</div>
                    </div>
                    <div class="stat-summary-item">
                        <div class="stat-value">{{ $locations->pluck('municipality')->unique()->count() }}</div>
                        <div class="stat-label">Municipalities</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="map-content">
            <div id="map" class="main-map"></div>

            <!-- Map Controls -->
            <div class="map-controls-panel">
                <button class="control-btn" onclick="centerMap()" title="Center Map">
                    <i class="fas fa-crosshairs"></i>
                </button>
                <button class="control-btn" onclick="toggleLayer()" title="Toggle Satellite">
                    <i class="fas fa-layer-group"></i>
                </button>
                <button class="control-btn" onclick="exportMap()" title="Export Map">
                    <i class="fas fa-download"></i>
                </button>
            </div>
        </div>
    </div>

                    <!-- Mobile/Tablet Full Screen Map -->
                    <div class="mobile-map-container d-lg-none">
                        <div id="mobileMap" class="mobile-fullscreen-map"></div>

                        <!-- Mobile Map Controls -->
                        <div class="mobile-map-controls">
                            <button class="mobile-control-btn" onclick="centerMap()" title="Center Map">
                                <i class="bx bx-crosshair"></i>
                            </button>
                            <button class="mobile-control-btn" onclick="toggleLayer()" title="Toggle Satellite">
                                <i class="bx bx-layer"></i>
                            </button>
                            <button class="mobile-control-btn" onclick="exportMap()" title="Export Map">
                                <i class="bx bx-download"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
/* Modern Map View Styles */
.map-container {
    min-height: 100vh;
    background: #f8fafc;
}

.map-header {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: white;
    padding: 2rem 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    backdrop-filter: blur(10px);
}

.header-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.header-subtitle {
    font-size: 1rem;
    opacity: 0.9;
    font-weight: 400;
}

.map-stats .stat-pill {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    backdrop-filter: blur(10px);
    font-size: 0.875rem;
    font-weight: 500;
}

.map-controls .btn {
    border-radius: 8px;
    padding: 0.5rem;
    margin-left: 0.5rem;
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
    transition: all 0.3s ease;
}

.map-controls .btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
}

/* Map Layout */
.map-wrapper {
    display: flex;
    height: calc(100vh - 110px); /* Account for navbar (70px) + some spacing */
    position: relative;
    margin: 0;
    padding: 0;
    width: 100%;
    overflow: hidden;
}

.map-sidebar {
    width: 320px;
    background: white;
    border-right: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
    margin: 0;
    padding: 0;
}

.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: #f8fafc;
}

.sidebar-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1e40af;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.sidebar-content {
    flex: 1;
    padding: 1.5rem;
    overflow-y: auto;
}

.filter-group {
    margin-bottom: 1.5rem;
}

.filter-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-select, .form-control {
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.form-select:focus, .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.date-inputs {
    display: flex;
    gap: 0.5rem;
}

.date-inputs .form-control {
    flex: 1;
}

/* Legend */
.legend-section {
    margin-bottom: 1.5rem;
}

.legend-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 1rem;
}

.legend-items {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    flex-shrink: 0;
}

/* Stats Summary */
.stats-summary {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    padding: 1rem 0;
    border-top: 1px solid #e2e8f0;
}

.stat-summary-item {
    text-align: center;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.stat-summary-item .stat-value {
    display: block;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e40af;
    margin-bottom: 0.25rem;
}

.stat-summary-item .stat-label {
    font-size: 0.75rem;
    color: #6b7280;
    font-weight: 500;
}

/* Main Map */
.map-content {
    flex: 1;
    position: relative;
}

.main-map {
    height: 100%;
    width: 100%;
    border: none;
}

/* Map Controls */
.map-controls-panel {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.control-btn {
    width: 40px;
    height: 40px;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    color: #6b7280;
}

.control-btn:hover {
    background: #1e40af;
    color: white;
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 1200px) {
    .map-sidebar {
        width: 280px;
    }

    .header-title {
        font-size: 1.75rem;
    }
}

@media (max-width: 992px) {
    .map-wrapper {
        flex-direction: column;
        height: calc(100vh - 120px);
    }

    .map-sidebar {
        width: 100%;
        height: auto;
        max-height: 300px;
        border-right: none;
        border-bottom: 1px solid #e2e8f0;
    }

    .map-content {
        flex: 1;
    }

    .main-map {
        height: calc(100vh - 440px);
    }
}

@media (max-width: 768px) {
    .map-header {
        padding: 1.5rem 0;
    }

    .header-content {
        margin-bottom: 1rem;
    }

    .header-title {
        font-size: 1.5rem;
    }

    .header-subtitle {
        font-size: 0.875rem;
    }

    .header-actions {
        justify-content: center !important;
    }

    .map-stats {
        display: none;
    }

    .sidebar-content {
        padding: 1rem;
    }

    .stats-summary {
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
    }

    .stat-summary-item {
        padding: 0.5rem;
    }

    .stat-summary-item .stat-value {
        font-size: 1rem;
    }

    .stat-summary-item .stat-label {
        font-size: 0.7rem;
    }

    .map-controls-panel {
        top: 10px;
        right: 10px;
    }

    .control-btn {
        width: 35px;
        height: 35px;
    }
}

@media (max-width: 576px) {
    .map-header {
        padding: 1rem 0;
    }

    .header-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }

    .header-title {
        font-size: 1.25rem;
    }

    .date-inputs {
        flex-direction: column;
        gap: 0.25rem;
    }

    .legend-item {
        font-size: 0.8rem;
    }

    .stats-summary {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }

    .main-map {
        height: calc(100vh - 500px);
    }
}

/* Additional responsive improvements */
@media (max-width: 768px) {
    .page-title {
        font-size: 1.5rem;
    }

    .page-subtitle {
        font-size: 0.9rem;
    }

    .page-actions .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }

    .stat-pill {
        padding: 0.25rem 0.75rem;
        font-size: 0.8rem;
    }

    .map-wrapper {
        height: calc(100vh - 160px);
    }
}

@media (max-width: 576px) {
    .page-header {
        padding: 1rem 0;
    }

    .page-title {
        font-size: 1.25rem;
    }

    .page-actions {
        margin-top: 1rem;
    }

    .page-actions .btn {
        margin-bottom: 0.5rem;
        margin-left: 0 !important;
        margin-right: 0.5rem !important;
    }

    .map-wrapper {
        height: calc(100vh - 180px);
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .map-container {
        background: #1f2937;
    }

    .map-sidebar {
        background: #374151;
        border-color: #4b5563;
    }

    .sidebar-header {
        background: #4b5563;
        border-color: #6b7280;
    }

    .sidebar-title {
        color: #f9fafb;
    }

    .filter-label, .legend-title {
        color: #f9fafb;
    }

    .form-select, .form-control {
        background: #4b5563;
        border-color: #6b7280;
        color: #f9fafb;
    }

    .form-select option {
        background: #374151;
        color: #f9fafb;
    }

    .legend-item {
        color: #e5e7eb;
    }

    .stat-summary-item {
        background: #4b5563;
        border-color: #6b7280;
    }

    .control-btn {
        background: #374151;
        border-color: #4b5563;
        color: #e5e7eb;
    }

    .control-btn:hover {
        background: #1e40af;
    }
}

/* Loading states */
.map-loading {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.map-loading::after {
    content: '';
    width: 40px;
    height: 40px;
    border: 4px solid #e2e8f0;
    border-top: 4px solid #1e40af;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Fullscreen mode */
.map-fullscreen .map-sidebar {
    display: none;
}

.map-fullscreen .map-content {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2000;
}

.map-fullscreen .main-map {
    height: 100vh !important;
}

/* Print styles */
@media print {
    .map-header,
    .map-sidebar,
    .map-controls-panel {
        display: none;
    }

    .map-content {
        position: static;
    }

    .main-map {
        height: 600px;
        page-break-inside: avoid;
    }
}

/* Mobile/Tablet Full Screen Map Styles */
.mobile-map-menu {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.mobile-menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1rem;
    min-height: 60px;
}

.mobile-menu-brand {
    display: flex;
    align-items: center;
    font-size: 1.1rem;
}

.mobile-menu-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.mobile-filters-panel {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    max-height: 200px;
    overflow-y: auto;
}

.mobile-filters-content {
    padding: 1rem;
}

.mobile-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.stat-item {
    text-align: center;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 8px;
}

.stat-item .stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e40af;
    margin-bottom: 0.25rem;
}

.stat-item .stat-label {
    font-size: 0.75rem;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.mobile-map-container {
    position: fixed;
    top: 120px; /* Account for mobile menu */
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 999;
}

.mobile-fullscreen-map {
    height: 100%;
    width: 100%;
}

.mobile-map-controls {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 1001;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.mobile-control-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #374151;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.mobile-control-btn:hover {
    background: white;
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

/* Adjust layout for mobile menu */
@media (max-width: 991px) {
    .layout-page {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }

    .container-fluid {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .card {
        border: none !important;
        border-radius: 0 !important;
        margin-bottom: 0 !important;
    }

    .card-body {
        padding: 0 !important;
    }
}

/* Desktop layout fixes */
@media (min-width: 992px) {
    .layout-page {
        margin-top: 90px;
        padding: 0;
        overflow-x: hidden; /* Prevent horizontal scroll */
    }

    .container-fluid {
        padding-left: 0;
        padding-right: 0;
        margin: 0;
        max-width: 100vw; /* Ensure it doesn't exceed viewport */
    }

    .map-container {
        margin: 0;
        padding: 0;
        width: 100vw; /* Full viewport width */
        overflow: hidden;
    }

    .card {
        margin-bottom: 0;
        border: none;
        box-shadow: none;
        border-radius: 0;
    }

    .card-body {
        padding: 0;
        overflow: hidden;
    }

    .map-wrapper {
        width: 100vw; /* Ensure full width */
        max-width: 100vw;
    }
}

/* Mobile filters animation */
.mobile-filters-panel {
    transition: all 0.3s ease;
}

.mobile-filters-panel.show {
    max-height: 300px;
}
</style>

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
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on mobile/tablet
    const isMobile = window.innerWidth < 992;

    // Initialize appropriate map
    let map;
    if (isMobile) {
        // Mobile fullscreen map
        map = L.map('mobileMap', {
            center: [10.306812602471465, 125.00810623168947],
            zoom: 12,
            zoomControl: true,
            scrollWheelZoom: true,
            doubleClickZoom: true,
            boxZoom: true,
            keyboard: true,
            dragging: true,
            touchZoom: true
        });
    } else {
        // Desktop map with sidebar
        map = L.map('map', {
            center: [10.306812602471465, 125.00810623168947],
            zoom: 12,
            zoomControl: true,
            scrollWheelZoom: true,
            doubleClickZoom: true,
            boxZoom: true,
            keyboard: true,
            dragging: true,
            touchZoom: true
        });
    }

    // Add modern tile layers
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    });

    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
        maxZoom: 19
    });

    // Start with OSM layer
    osmLayer.addTo(map);

    // Layer control
    const baseLayers = {
        "OpenStreetMap": osmLayer,
        "Satellite": satelliteLayer
    };

    L.control.layers(baseLayers).addTo(map);

    // Add locate control
    L.control.locate({
        position: 'bottomright',
        setView: true,
        follow: true,
        keepCurrentZoomLevel: true,
        icon: 'fas fa-crosshairs',
        iconLoading: 'fas fa-spinner fa-spin'
    }).addTo(map);

    // Store all markers
    let allMarkers = [];
    let markerClusterGroup = L.markerClusterGroup({
        chunkedLoading: true,
        spiderfyOnMaxZoom: true,
        showCoverageOnHover: false,
        zoomToBoundsOnClick: true,
        removeOutsideVisibleBounds: true,
        animate: true,
        maxClusterRadius: 50
    });

    // Function to get marker color based on COTS size
    function getMarkerColor(location) {
        const maxSize = Math.max(
            location.early_juvenile || 0,
            location.juvenile || 0,
            location.sub_adult || 0,
            location.adult || 0,
            location.late_adult || 0
        );

        if (maxSize <= 5) return '#10b981'; // Green - Juvenile
        if (maxSize <= 15) return '#f59e0b'; // Orange - Sub-adult
        if (maxSize <= 25) return '#ef4444'; // Red - Adult
        if (maxSize <= 35) return '#8b5cf6'; // Purple - Large Adult
        return '#1e40af'; // Blue - Giant
    }

    // Function to create custom marker icon
    function createCustomIcon(color) {
        return L.divIcon({
            html: `<div style="
                width: 20px;
                height: 20px;
                background-color: ${color};
                border: 3px solid white;
                border-radius: 50%;
                box-shadow: 0 2px 8px rgba(0,0,0,0.3);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 10px;
                color: white;
                font-weight: bold;
            ">★</div>`,
            className: 'custom-cots-marker',
            iconSize: [26, 26],
            iconAnchor: [13, 13],
            popupAnchor: [0, -13]
        });
    }

    // Function to create popup content
    function createPopupContent(location) {
        const photos = location.photo ? JSON.parse(location.photo) : [];
        const date = new Date(location.created_at).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        return `
            <div class="modern-popup">
                <div class="popup-header">
                    <h6 class="popup-title">
                        <i class="fas fa-star-half-alt"></i>
                        ${location.name || 'Unnamed Location'}
                    </h6>
                    <div class="popup-meta">
                        <span class="meta-item">
                            <i class="fas fa-calendar"></i>
                            ${location.date_of_sighting}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-clock"></i>
                            ${location.time_of_sighting}
                        </span>
                    </div>
                </div>

                <div class="popup-body">
                    <div class="popup-section">
                        <h6 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Details
                        </h6>
                        <div class="details-grid">
                            <div class="detail-item">
                                <span class="detail-label">Municipality:</span>
                                <span class="detail-value">${location.municipality}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Total COTS:</span>
                                <span class="detail-value">${location.number_of_cots || 'N/A'}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Activity:</span>
                                <span class="detail-value">${location.activity_type || 'N/A'}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Observer:</span>
                                <span class="detail-value">${location.observer_category || 'N/A'}</span>
                            </div>
                        </div>
                    </div>

                    <div class="popup-section">
                        <h6 class="section-title">
                            <i class="fas fa-ruler"></i>
                            Size Distribution
                        </h6>
                        <div class="size-distribution">
                            ${location.early_juvenile ? `<div class="size-item"><span class="size-label">1-5cm:</span><span class="size-value">${location.early_juvenile}</span></div>` : ''}
                            ${location.juvenile ? `<div class="size-item"><span class="size-label">6-15cm:</span><span class="size-value">${location.juvenile}</span></div>` : ''}
                            ${location.sub_adult ? `<div class="size-item"><span class="size-label">16-25cm:</span><span class="size-value">${location.sub_adult}</span></div>` : ''}
                            ${location.adult ? `<div class="size-item"><span class="size-label">26-35cm:</span><span class="size-value">${location.adult}</span></div>` : ''}
                            ${location.late_adult ? `<div class="size-item"><span class="size-label">>35cm:</span><span class="size-value">${location.late_adult}</span></div>` : ''}
                        </div>
                    </div>

                    ${location.description ? `
                        <div class="popup-section">
                            <h6 class="section-title">
                                <i class="fas fa-comment"></i>
                                Description
                            </h6>
                            <p class="description-text">${location.description}</p>
                        </div>
                    ` : ''}

                    ${photos.length > 0 ? `
                        <div class="popup-section">
                            <h6 class="section-title">
                                <i class="fas fa-images"></i>
                                Photos (${photos.length})
                            </h6>
                            <div class="photo-gallery">
                                ${photos.slice(0, 3).map(photo => `
                                    <img src="/storage/${photo}" alt="COTS sighting" class="gallery-image" loading="lazy">
                                `).join('')}
                                ${photos.length > 3 ? `<div class="more-photos">+${photos.length - 3} more</div>` : ''}
                            </div>
                        </div>
                    ` : ''}
                </div>

                <div class="popup-footer">
                    <small class="timestamp">
                        <i class="fas fa-save"></i>
                        Saved on ${date}
                    </small>
                    <button class="btn btn-danger btn-sm delete-btn" onclick="deleteLocation(${location.id})">
                        <i class="fas fa-trash"></i>
                        Delete
                    </button>
                </div>
            </div>
        `;
    }

    // Add locations to map
    @foreach($locations as $location)
        (function() {
            const locationData = @json($location);
            const markerColor = getMarkerColor(locationData);
            const customIcon = createCustomIcon(markerColor);

            const marker = L.marker([{{ $location->latitude }}, {{ $location->longitude }}], {
                icon: customIcon
            });

            marker.bindPopup(createPopupContent(locationData), {
                maxWidth: 350,
                className: 'modern-popup-container'
            });

            allMarkers.push({
                marker: marker,
                location: locationData
            });

            markerClusterGroup.addLayer(marker);
        })();
    @endforeach

    map.addLayer(markerClusterGroup);

    // Filter functionality
    function applyFilters() {
        const isMobile = window.innerWidth < 992;

        // Get filter values from appropriate elements
        const municipalityFilter = isMobile
            ? document.getElementById('municipalityFilterMobile')?.value
            : document.getElementById('municipalityFilter')?.value;
        const barangayFilter = isMobile
            ? document.getElementById('barangayFilterMobile')?.value
            : document.getElementById('barangayFilter')?.value;
        const activityFilter = isMobile
            ? document.getElementById('activityFilterMobile')?.value
            : document.getElementById('activityFilter')?.value;
        const observerFilter = isMobile
            ? document.getElementById('observerFilterMobile')?.value
            : document.getElementById('observerFilter')?.value;
        const startDate = isMobile
            ? document.getElementById('startDateMobile')?.value
            : document.getElementById('startDate')?.value;
        const endDate = isMobile
            ? document.getElementById('endDateMobile')?.value
            : document.getElementById('endDate')?.value;

        // Clear existing markers
        markerClusterGroup.clearLayers();

        // Filter and add markers
        const filteredMarkers = allMarkers.filter(item => {
            const location = item.location;

            // Municipality filter
            if (municipalityFilter && location.municipality !== municipalityFilter) {
                return false;
            }

            // Barangay filter
            if (barangayFilter && location.barangay !== barangayFilter) {
                return false;
            }

            // Activity type filter
            if (activityFilter && location.activity_type !== activityFilter) {
                return false;
            }

            // Observer category filter
            if (observerFilter && location.observer_category !== observerFilter) {
                return false;
            }

            // Date filter
            if (startDate || endDate) {
                const sightingDate = new Date(location.date_of_sighting);
                if (startDate && sightingDate < new Date(startDate)) return false;
                if (endDate && sightingDate > new Date(endDate)) return false;
            }

            return true;
        });

        // Add filtered markers
        filteredMarkers.forEach(item => {
            markerClusterGroup.addLayer(item.marker);
        });

        // Update stats
        updateVisibleStats(filteredMarkers.length);

        // Fit map to filtered markers if any
        if (filteredMarkers.length > 0) {
            const group = new L.featureGroup(filteredMarkers.map(item => item.marker));
            map.fitBounds(group.getBounds().pad(0.1));
        }
    }

    function updateVisibleStats(count) {
        // Update the visible locations count in the header
        const statPill = document.querySelector('.stat-pill span:last-child');
        if (statPill) {
            statPill.textContent = count + ' Locations';
        }
    }

    // Event listeners for filters
    // Set up filter event listeners for both desktop and mobile
    const municipalityFilter = document.getElementById('municipalityFilter');
    const municipalityFilterMobile = document.getElementById('municipalityFilterMobile');
    const barangayFilter = document.getElementById('barangayFilter');
    const barangayFilterMobile = document.getElementById('barangayFilterMobile');
    const activityFilter = document.getElementById('activityFilter');
    const activityFilterMobile = document.getElementById('activityFilterMobile');
    const observerFilter = document.getElementById('observerFilter');
    const observerFilterMobile = document.getElementById('observerFilterMobile');
    const startDate = document.getElementById('startDate');
    const startDateMobile = document.getElementById('startDateMobile');
    const endDate = document.getElementById('endDate');
    const endDateMobile = document.getElementById('endDateMobile');

    if (municipalityFilter) municipalityFilter.addEventListener('change', applyFilters);
    if (municipalityFilterMobile) municipalityFilterMobile.addEventListener('change', applyFilters);
    if (barangayFilter) barangayFilter.addEventListener('change', applyFilters);
    if (barangayFilterMobile) barangayFilterMobile.addEventListener('change', applyFilters);
    if (activityFilter) activityFilter.addEventListener('change', applyFilters);
    if (activityFilterMobile) activityFilterMobile.addEventListener('change', applyFilters);
    if (observerFilter) observerFilter.addEventListener('change', applyFilters);
    if (observerFilterMobile) observerFilterMobile.addEventListener('change', applyFilters);
    if (startDate) startDate.addEventListener('change', applyFilters);
    if (startDateMobile) startDateMobile.addEventListener('change', applyFilters);
    if (endDate) endDate.addEventListener('change', applyFilters);
    if (endDateMobile) endDateMobile.addEventListener('change', applyFilters);

    // Map control functions
    window.centerMap = function() {
        if (allMarkers.length > 0) {
            const group = new L.featureGroup(allMarkers.map(item => item.marker));
            map.fitBounds(group.getBounds().pad(0.1));
        }
    };

    window.refreshMap = function() {
        // Show loading state
        const mapContainer = document.getElementById('map');
        mapContainer.classList.add('map-loading');

        setTimeout(() => {
            map.invalidateSize();
            mapContainer.classList.remove('map-loading');
        }, 500);
    };

    window.toggleLayer = function() {
        if (map.hasLayer(osmLayer)) {
            map.removeLayer(osmLayer);
            map.addLayer(satelliteLayer);
        } else {
            map.removeLayer(satelliteLayer);
            map.addLayer(osmLayer);
        }
    };

    window.toggleFullscreen = function() {
        const mapContainer = document.querySelector('.map-container');
        mapContainer.classList.toggle('map-fullscreen');
        setTimeout(() => {
            map.invalidateSize();
        }, 300);
    };

    window.exportMap = function() {
        // Simple export functionality - could be enhanced
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 800;
        canvas.height = 600;

        // Add title
        ctx.fillStyle = '#1e40af';
        ctx.fillRect(0, 0, 800, 80);
        ctx.fillStyle = 'white';
        ctx.font = '24px Arial';
        ctx.fillText('COTS Sightings Map', 20, 35);
        ctx.font = '16px Arial';
        ctx.fillText('Generated on ' + new Date().toLocaleDateString(), 20, 60);

        // Trigger download
        const link = document.createElement('a');
        link.download = 'cots-sightings-map.png';
        link.href = canvas.toDataURL();
        link.click();
    };

    // Mobile filters & legend toggle function
    window.toggleMobileFilters = function() {
        const panel = document.getElementById('mobileFiltersPanel');
        if (panel.style.display === 'none' || panel.style.display === '') {
            panel.style.display = 'block';
            panel.classList.add('show');
        } else {
            panel.style.display = 'none';
            panel.classList.remove('show');
        }
    };

    // Delete location function
    window.deleteLocation = function(id) {
        if (confirm('Are you sure you want to delete this COTS sighting location?')) {
            fetch(`/locations/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove marker from map and arrays
                    allMarkers = allMarkers.filter(item => {
                        if (item.location.id === id) {
                            markerClusterGroup.removeLayer(item.marker);
                            return false;
                        }
                        return true;
                    });

                    // Update stats
                    updateVisibleStats(allMarkers.length);

                    // Show success message
                    showNotification('Location deleted successfully', 'success');
                } else {
                    showNotification('Error deleting location', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error deleting location', 'error');
            });
        }
    };

    // Notification system
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
            <span>${message}</span>
        `;

        // Add to page
        document.body.appendChild(notification);

        // Show and hide animation
        setTimeout(() => notification.classList.add('show'), 100);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => document.body.removeChild(notification), 300);
        }, 3000);
    }

    // Add notification styles dynamically
    const notificationStyles = `
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            border-left: 4px solid #1e40af;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification-success {
            border-left-color: #10b981;
        }

        .notification-error {
            border-left-color: #ef4444;
        }

        .notification i {
            font-size: 1.25rem;
        }

        .notification-success i {
            color: #10b981;
        }

        .notification-error i {
            color: #ef4444;
        }
    `;

    const style = document.createElement('style');
    style.textContent = notificationStyles;
    document.head.appendChild(style);

    // Add popup styles
    const popupStyles = `
        .modern-popup {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 350px;
        }

        .popup-header {
            margin-bottom: 1rem;
        }

        .popup-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .popup-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .popup-section {
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #374151;
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
        }

        .detail-label {
            color: #6b7280;
            font-weight: 500;
        }

        .detail-value {
            color: #374151;
            font-weight: 600;
        }

        .size-distribution {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .size-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            padding: 0.25rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .description-text {
            font-size: 0.85rem;
            color: #374151;
            line-height: 1.4;
            margin: 0;
        }

        .photo-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .gallery-image {
            width: 100%;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .gallery-image:hover {
            transform: scale(1.05);
        }

        .more-photos {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            border-radius: 4px;
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 500;
        }

        .popup-footer {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .timestamp {
            font-size: 0.75rem;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .delete-btn {
            font-size: 0.8rem;
            padding: 0.25rem 0.75rem;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .leaflet-popup-content {
            margin: 0;
        }
    `;

    const popupStyle = document.createElement('style');
    popupStyle.textContent = popupStyles;
    document.head.appendChild(popupStyle);

    // Initialize filters on load
    applyFilters();

    // Handle window resize
    window.addEventListener('resize', function() {
        setTimeout(() => {
            map.invalidateSize();
        }, 100);
    });

    console.log('COTS Map initialized with', allMarkers.length, 'locations');
});
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
