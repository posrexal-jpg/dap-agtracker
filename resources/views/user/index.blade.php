@extends('layouts.user')

@section('content')
<style>
    /* Mobile-First Responsive Design */
    :root {
        --primary-color: #1e3a8a;
        --secondary-color: #60a5fa;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --touch-target-size: 44px;
    }

    /* Touch-friendly interactions */
    .btn, button, .form-control, select, input, textarea {
        min-height: var(--touch-target-size);
        touch-action: manipulation;
    }

    /* Modal Overlay - Mobile Optimized */
    .modal.fade .modal-dialog {
        transform: scale(0.95);
        opacity: 0;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }
    .modal.fade.show .modal-dialog {
        transform: scale(1);
        opacity: 1;
    }

    /* Modal Content - Mobile Enhanced */
    .modal-content {
        border-radius: 16px;
        border: none;
        padding: 24px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        background: linear-gradient(145deg, #f8fafc, #ffffff);
        margin: 16px;
        max-height: calc(100vh - 32px);
        overflow-y: auto;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        border-bottom: none;
        padding: 20px 24px;
        margin: -24px -24px 20px -24px;
    }

    .modal-title {
        font-weight: 600;
        font-size: 1.25rem;
        margin: 0;
    }

    .btn-close {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        width: 32px;
        height: 32px;
        padding: 8px;
        margin: 0;
    }

    /* Form Controls - Mobile Optimized */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        color: #374151;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-control, select {
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        padding: 12px 16px;
        font-size: 16px; /* Prevents zoom on iOS */
        transition: all 0.3s ease;
        background: white;
        width: 100%;
    }

    .form-control:focus, select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        outline: none;
    }

    /* Button Styles - Mobile Enhanced */
    .btn {
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 16px;
        min-height: var(--touch-target-size);
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        touch-action: manipulation;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
    }

    .btn-primary:hover, .btn-primary:active {
        background: linear-gradient(135deg, #1e293b 0%, #3b82f6 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-secondary:hover, .btn-secondary:active {
        background: #e5e7eb;
        transform: translateY(-1px);
    }

    /* Page Header - Mobile Responsive */
    .page-header {
        padding: 24px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        flex-shrink: 0;
    }

    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 8px;
    }

    .page-header p {
        font-size: 0.95rem;
        color: #64748b;
        margin-bottom: 16px;
    }

    /* Status Indicators - Mobile Friendly */
    .connection-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .connection-status.online {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .connection-status.offline {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    /* Map Container - Mobile Optimized */
    #map {
        flex: 1;
        border-radius: 0;
        box-shadow: none;
        margin: 0 !important;
        padding: 0 !important;
        height: 100% !important;
        width: 100% !important;
        min-height: 300px;
    }

    .content-wrapper {
        display: flex;
        flex-direction: column;
        flex: 1;
        width: 100%;
        height: 100%;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Notification Styles */
    .notification {
        position: fixed;
        top: 20px;
        left: 16px;
        right: 16px;
        z-index: 9999;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
        animation: slideIn 0.3s ease;
    }

    .notification.success {
        background: rgba(16, 185, 129, 0.95);
        color: white;
    }

    .notification.warning {
        background: rgba(245, 158, 11, 0.95);
        color: white;
    }

    .notification.error {
        background: rgba(239, 68, 68, 0.95);
        color: white;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Loading States */
    .loading {
        position: relative;
        pointer-events: none;
        opacity: 0.7;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Mobile-specific adjustments */
    @media (max-width: 768px) {
        .modal-content {
            margin: 8px;
            padding: 20px;
        }

        .modal-header {
            padding: 16px 20px;
            margin: -20px -20px 16px -20px;
        }

        .page-header {
            padding: 16px 12px;
            margin: -16px -16px 16px -16px;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .page-header {
            padding: 16px;
        }

        #map {
            margin: 0;
            height: 100%;
        }

        .btn {
            width: 100%;
            margin-bottom: 8px;
        }

        .connection-status {
            font-size: 0.8rem;
            padding: 6px 12px;
        }
    }

    /* iOS-specific fixes */
    @supports (-webkit-touch-callout: none) {
        .form-control, select {
            font-size: 16px !important; /* Prevent zoom */
        }

        .btn {
            -webkit-appearance: none;
            appearance: none;
        }
    }

    /* Android-specific fixes */
    @supports (-webkit-appearance: none) and (not (-webkit-touch-callout: none)) {
        .form-control, select {
            font-size: 16px !important;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .modal-content {
            background: linear-gradient(145deg, #1e293b, #334155);
            color: #f1f5f9;
        }

        .form-control, select {
            background: #334155;
            border-color: #475569;
            color: #f1f5f9;
        }

        .form-control:focus, select:focus {
            border-color: var(--secondary-color);
        }
    }
</style>

<div class="container-fluid" style="height: 100%; display: flex; flex-direction: column; overflow: hidden; padding: 0; margin: 0;">
<div class="page-header">
    <h1>🏊‍♂️ COTS Sighting Map</h1>
    <p class="description">View all reported Crown-of-Thorns Starfish (COTS), locally known as Dap-ag, sightings on the interactive map. Help protect our reefs by adding pin to report new sightings in your area.</p>

    <!-- Mobile-Optimized Status and Sync Controls -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">
        <div class="connection-status online" id="connectionStatus">
            <i class="fas fa-wifi"></i>
            <span>Online</span>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="manualSync()" id="syncBtn">
                <i class="fas fa-sync-alt me-1"></i>Sync Data
            </button>
            <button type="button" class="btn btn-success btn-sm" onclick="addNewSighting()" id="addSightingBtn">
                <i class="fas fa-plus me-1"></i>Add Sighting
            </button>
        </div>
    </div>
</div>

<div class="page-content" style="flex: 1; overflow: hidden; padding: 0; margin: 0; display: flex; flex-direction: column;">
    <div class="content-wrapper">
            <div id="map"></div>
            <div class="modal fade" id="consentModal" tabindex="-1" aria-labelledby="consentModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="consentModalLabel">Data Privacy Consent</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="fs-5">
                                        All of the information that the respondents will provide will be treated as confidential and will only be used for research purposes.
                                        We are committed to protecting your personal information and respecting your privacy.
                                        Any personal information provided will be treated with confidentiality.
                                    </p> 
                                    
                                    <p class="text-muted">
                                        By clicking <strong>"I Agree"</strong>, you consent to the collection and processing of your data for research and monitoring purposes, in accordance with applicable data privacy laws.
                                    </p>
                                    <div class="row g-2 my-3">
                                        <div class="col-6">
                                            <img src="{{ asset('images/img1.jpg') }}" class="img-fluid rounded" alt="Species 1">
                                        </div>
                                        <div class="col-6">
                                            <img src="{{ asset('images/img2.jpg') }}" class="img-fluid rounded" alt="Species 2">
                                        </div>
                                        <div class="col-6">
                                            <img src="{{ asset('images/img3.jpg') }}" class="img-fluid rounded" alt="Species 3">
                                        </div>
                                        <div class="col-6">
                                            <img src="{{ asset('images/img4.jpg') }}" class="img-fluid rounded" alt="Species 3">
                                        </div>
                                    </div>

                                    <p>
                                      The Crown-of-Thorns Starfish (COTS), locally known as Dap-ag, is a marine species known for its significant impact on coral reefs. While it is a natural part of the ecosystem, during population outbreaks, COTS can devastate coral reefs by feeding on coral polyps, leading to extensive coral degradation. This species poses a major threat to coral ecosystems, especially in tropical and subtropical regions, and is considered one of the key factors in coral reef decline. Effective management and research are essential to mitigate the damage caused by COTS outbreaks and protect vital marine biodiversity.
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="agreeConsent">I Agree</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="locationForm" action="{{ route('user-save-location') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Modal 1: Sighting Details -->
    <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal1Label">Sighting Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                

                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="optional">
                    </div>
                    <div class="form-group">
                        <label for="date_of_sighting">Date of COTS Sighting:</label>
                        <input type="date" class="form-control" id="date_of_sighting" name="date_of_sighting" required>
                    </div>
                    <div class="form-group">
                        <label for="time_of_sighting">Time of COTS Sighting:</label>
                        <input type="time" class="form-control" id="time_of_sighting" name="time_of_sighting" required>
                    </div>
                    <div class="form-group">
                        <label for="municipality">Municipality:</label>
                        <select class="form-control" id="municipality" name="municipality" required>
                            <option value="">Select Municipality</option>
                            <!-- Municipalities will be populated here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="barangay">Barangay:</label>
                        <select class="form-control" id="barangay" name="barangay" required>
                            <option value="">Select Barangay</option>
                            <!-- Barangays will be populated here -->
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="nextBtn1">Next</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2: COTS Count -->
    <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="modal2Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal2Label">COTS Count</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="early_juvenile">1-5cm:</label>
                        <input type="number" class="form-control" id="early_juvenile" name="early_juvenile" min="0">
                    </div>
                    <div class="form-group">
                        <label for="juvenile">6-15cm:</label>
                        <input type="number" class="form-control" id="juvenile" name="juvenile" min="0">
                    </div>
                    <div class="form-group">
                        <label for="sub_adult">15-25cm:</label>
                        <input type="number" class="form-control" id="sub_adult" name="sub_adult" min="0">
                    </div>
                    <div class="form-group">
                        <label for="adult">25-35cm:</label>
                        <input type="number" class="form-control" id="adult" name="adult" min="0">
                    </div>
                    <div class="form-group">
                        <label for="late_adult">>35cm:</label>
                        <input type="number" class="form-control" id="late_adult" name="late_adult" min="0">
                    </div>
                    <div class="form-group">
                        <label for="number_of_cots">Total COTS:</label>
                        <input type="number" class="form-control" id="number_of_cots" name="number_of_cots" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="backBtn2">Back</button>
                <button type="button" class="btn btn-primary" id="nextBtn2">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3: Activity & Observer Info -->
    <div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="modal3Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal3Label">Activity & Observer Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="activity_type">Type of Activity:</label>
                        <select class="form-control" id="activity_type" name="activity_type" required>
                            <option value="">Select Activity</option>
                            <option value="Fishing">Fishing</option>
                            <option value="Recreational diving">Recreational Diving</option>
                            <option value="Research">Research</option>
                            <option value="Cots collection">COTS Collection</option>
                            <option value="other">Other</option>
                        </select>
                        <input type="text" class="form-control mt-2 d-none" id="custom_activity" name="custom_activity" placeholder="Please specify activity">
                    </div>
                    <div class="form-group">
                        <label for="observer_category">Observer Category:</label>
                        <select class="form-control" id="observer_category" name="observer_category" required>
                            <option value="">Select Observer</option>
                            <option value="Fisherfolks">Fisherfolks</option>
                            <option value="Barangay residents">Barangay Residents</option>
                            <option value="Local government">Local Government</option>
                            <option value="Advocacy groups">Advocacy Group</option>
                            <option value="Researcher">Researcher</option>
                            <option value="other">Other</option>
                        </select>
                        <input type="text" class="form-control mt-2 d-none" id="custom_observer" name="custom_observer" placeholder="Please specify observer">
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="backBtn3">Back</button>
                <button type="button" class="btn btn-primary" id="nextBtn3">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 4: Location & Media -->
    <div class="modal fade" id="modal4" tabindex="-1" aria-labelledby="modal4Label" aria-hidden="true">
        <div class="modal-dialog"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal4Label">Location & Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Latitude:</label>
                        <p id="latitude_display">Not selected</p>
                        <input type="hidden" id="latitude" name="latitude" required>
                    </div>

                    <div class="form-group">
                        <label>Longitude:</label>
                        <p id="longitude_display">Not selected</p>
                        <input type="hidden" id="longitude" name="longitude" required>
                    </div>

                    <div class="form-group">
                        <label for="photo">Photos:</label>
                        <input type="file" class="form-control" id="photo" name="photo[]" accept="image/*" multiple>
                    </div>
                    <div class="form-group">
                        <label for="description">Additional Comments:</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="backBtn4">Back</button>
                <button type="submit" class="btn btn-success">Submit</button>
                </div>
                </form>   
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js')}}"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.74.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>

    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js')}}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- User-specific JavaScript files -->
    <script src="{{ asset('js/user-location.js') }}"></script>
    <script src="{{ asset('js/user-modal.js') }}"></script>

    <script>
        // Embed server-side sightings data for the map
        window.SIGHTINGS = @json(isset($locations) ? $locations->toArray() : []);
    </script>

    <script src="{{ asset('js/user-map.js') }}"></script>
    <script src="{{ asset('js/user-form.js') }}"></script>
    <script src="{{ asset('js/user-offline.js') }}"></script>
    <script src="{{ asset('js/offline-manager.js') }}"></script>
    <script src="{{ asset('js/pwa-install.js') }}"></script>
</div>
</div>

@endsection