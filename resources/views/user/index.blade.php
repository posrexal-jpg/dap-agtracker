@extends('layouts.app')

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
        text-align: center;
        padding: 20px 16px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        margin: -20px -20px 20px -20px;
        border-radius: 0 0 20px 20px;
    }

    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 8px;
    }

    .page-header p {
        font-size: 0.95rem;
        color: #64748b;
        max-width: 600px;
        margin: 0 auto;
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
        margin-bottom: 16px;
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
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        margin: 16px;
        height: calc(100vh - 200px);
        min-height: 300px;
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

        #map {
            margin: 12px;
            height: calc(100vh - 180px);
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
        opacity: 1;
    }

    /* Modal Form */
    .form-group label {
        color: #333;
        font-weight: 500;
        margin-bottom: 8px;
    }
    .form-control {
        border-radius: 8px;
        border: 1px solid #d1d5db;
        transition: box-shadow 0.3s ease;
    }
    .form-control:focus {
        box-shadow: 0 0 8px rgba(0, 86, 179, 0.2);
    }

    /* Modal Buttons */
    .btn-primary {
        background-color: #0056b3;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #004494;
    }
    .btn-secondary {
        border: none;
        background-color: transparent;
        color: #0056b3;
        transition: color 0.3s ease;
    }
    .btn-secondary:hover {
        color: #004494;
    }
</style>

<div class="page-header">
    <h1>🏊‍♂️ COTS Sighting Map</h1>
    <p class="description">View all reported Crown-of-Thorns Starfish (COTS) sightings on the interactive map. Help protect our reefs by adding pin to report new sightings in your area.</p>

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

        <div class="content-wrapper">
            <div id="map" style="height: 80%; position: relative; margin: 0 auto; "></div>
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
                                      The Crown-of-Thorns Starfish (COTS) or locally known as Dap-ag is a marine species known for its significant impact on coral reefs. While it is a natural part of the ecosystem, during population outbreaks, COTS can devastate coral reefs by feeding on coral polyps, leading to extensive coral degradation. This species poses a major threat to coral ecosystems, especially in tropical and subtropical regions, and is considered one of the key factors in coral reef decline. Effective management and research are essential to mitigate the damage caused by COTS outbreaks and protect vital marine biodiversity.
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


                </div>
            </div>
        </div>
    </div>


    <script>
    // Fetch and display municipalities in Southern Leyte
    function populateMunicipalities() {
        fetch('https://psgc.gitlab.io/api/provinces/086400000/municipalities/')
            .then(response => response.json())
            .then(data => {
                const municipalitySelect = document.getElementById('municipality');
                municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
                data.forEach(municipality => {
                    const option = document.createElement('option');
                    option.value = municipality.name; // Use municipality name as the value
                    option.textContent = municipality.name; // Municipality name
                    municipalitySelect.appendChild(option);
                });

                // Load previously selected municipality from localStorage
                const savedMunicipality = localStorage.getItem('municipality');
                if (savedMunicipality) {
                    municipalitySelect.value = savedMunicipality;
                    populateBarangays(savedMunicipality);
                }
            })
            .catch(error => console.error('Error fetching municipalities:', error));
    }

    // Fetch and display barangays of selected municipality
    function populateBarangays(municipalityName) {
        fetch('https://psgc.gitlab.io/api/provinces/086400000/municipalities/')
            .then(response => response.json())
            .then(data => {
                const municipality = data.find(municipality => municipality.name === municipalityName);
                if (municipality) {
                    const municipalityCode = municipality.code;
                    fetch(`https://psgc.gitlab.io/api/municipalities/${municipalityCode}/barangays/`)
                        .then(response => response.json())
                        .then(barangays => {
                            const barangaySelect = document.getElementById('barangay');
                            barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                            barangays.forEach(barangay => {
                                const option = document.createElement('option');
                                option.value = barangay.name; // Use barangay name as the value
                                option.textContent = barangay.name; // Barangay name
                                barangaySelect.appendChild(option);
                            });

                            // Load previously selected barangay from localStorage
                            const savedBarangay = localStorage.getItem('barangay');
                            if (savedBarangay) {
                                barangaySelect.value = savedBarangay;
                            }
                        })
                        .catch(error => console.error('Error fetching barangays:', error));
                }
            })
            .catch(error => console.error('Error fetching municipalities:', error));
    }

    // Event listener for municipality selection
    document.addEventListener('DOMContentLoaded', () => {
        // Set up event listener to store selected municipality name in localStorage
        document.getElementById('municipality').addEventListener('change', function () {
            const municipalityName = this.value; // Get selected municipality name
            localStorage.setItem('municipality', municipalityName); // Save name to localStorage
            if (municipalityName) {
                populateBarangays(municipalityName);
            } else {
                document.getElementById('barangay').innerHTML = '<option value="">Select Barangay</option>';
                localStorage.removeItem('barangay'); // Clear selected barangay
            }
        });

        // Set up event listener to store selected barangay name in localStorage
        document.getElementById('barangay').addEventListener('change', function () {
            const barangayName = this.value; // Get selected barangay name
            localStorage.setItem('barangay', barangayName); // Save name to localStorage
        });

        populateMunicipalities(); // Load Southern Leyte municipalities on page load
    });
</script>



  
  
    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js')}}"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.74.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>


    <script>
    function switchModal(hideId, showId) {
        let hideModal = bootstrap.Modal.getInstance(document.getElementById(hideId));
        if (hideModal) hideModal.hide();
        
        let showModal = new bootstrap.Modal(document.getElementById(showId));
        showModal.show();
    }

    document.getElementById("nextBtn1").addEventListener("click", function () {
        let date = document.getElementById("date_of_sighting").value;
        let time = document.getElementById("time_of_sighting").value;
        let municipality = document.getElementById("municipality").value;
        let barangay = document.getElementById("barangay").value;

        if (date === "" || time === "" || municipality === "" || barangay === "") {
            alert("Please fill out all required fields.");
        } else {
            switchModal('modal1', 'modal2');
        }
    });

    document.getElementById("backBtn2").addEventListener("click", function () {
        switchModal('modal2', 'modal1');
    });

    document.getElementById("nextBtn2").addEventListener("click", function () {
        switchModal('modal2', 'modal3');
    });

    document.getElementById("backBtn3").addEventListener("click", function () {
        switchModal('modal3', 'modal2');
    });

    document.getElementById("nextBtn3").addEventListener("click", function () {
        switchModal('modal3', 'modal4');
    });

    document.getElementById("backBtn4").addEventListener("click", function () {
        switchModal('modal4', 'modal3');
    });
</script>


    <script>
    // Initialize the map
    var map = L.map('map').setView([10.306812602471465, 125.00810623168947], 12);

    // OSM layer
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });
    osm.addTo(map);

    // Add Locate control
    L.control.locate().addTo(map);


    var geoJsonPolygon = {
    "type": "FeatureCollection",
    "features": [
        {
            "type": "Feature",
            "properties": {},
            "geometry": {
                "type": "Polygon",
                "coordinates": [
                    [
                        [
                        124.98882706137022,10.398399643957603],
                        [124.96538337058183,10.38719952081739],
                        [124.95600589426613,10.347007542865796],
                        [124.97074192847674,10.29890218090081],
                        [124.97141174821303,10.263312667596836],
                        [124.97141174821303,10.205965592498274],
                        [124.98212886400279,10.159816761533278],
                        [124.99820453768757,10.119595918359465],
                        [125.01026129294985,10.085305317819461],
                        [125.00892165347574,10.032543423636369],
                        [125.01495003110864,9.996924282406624],
                        [125.07389416794933,9.884104645319326],
                        [125.18709370347563,9.870246924008114],
                        [125.27082117058052,9.870906828729844],
                        [125.27617972847554,9.904560213998522],
                        [125.2547454968975,9.965259545956073],
                        [125.19178244163419,10.068158647849856],
                        [125.13953650216087,10.103769941717204],
                        [125.13082884558139,10.195417877137956],
                        [125.01762931005521,10.400376094583976],
                        [125.0028932758446,10.403011342620147],
                        [124.98882706137022,10.398399643957603]  
                    ]
                ]
            }
        }
    ]
};
// Add the slightly larger GeoJSON polygon to the map
var polygon = L.geoJSON(geoJsonPolygon, {
    style: function () {
        return {
            color: "#0000FF",  // Border color (still defined, but will be invisible)
            weight: 2,         // Border thickness
            opacity: 0,        // Make the border fully transparent
            fillOpacity: 0     // No fill color
        };
    }
}).addTo(map);

// Fit map to the new polygon bounds
map.fitBounds(polygon.getBounds());

    // Loop through each location from the backend and add markers
    @foreach ($locations as $location)
        var marker{{ $location->id }} = L.marker([{{ $location->latitude }}, {{ $location->longitude }}]).addTo(map);
    @endforeach

// Global marker variable for new markers
var marker;

// Click event to place a new marker
map.on('click', function (e) {
    var clickedPoint = e.latlng;

    // Check if the clicked point is inside the polygon
    var inside = false;
    polygon.eachLayer(function (layer) {
        if (layer.getBounds().contains(clickedPoint)) {
            inside = true;
        }
    });

    if (inside) {
        if (marker) {
            map.removeLayer(marker); // Remove existing marker
        }
        marker = L.marker(clickedPoint).addTo(map); // Place new marker

        // Temporarily store the coordinates
        document.getElementById('latitude').value = clickedPoint.lat;
        document.getElementById('longitude').value = clickedPoint.lng;


        document.getElementById('latitude_display').textContent = clickedPoint.lat.toFixed(6);
        document.getElementById('longitude_display').textContent = clickedPoint.lng.toFixed(6);


        // Show the consent modal
        $('#consentModal').modal('show');
    } else {
        alert("You can only place markers inside the sogod bay.");
    }
});

// Handle "Agree" button click in consent modal
document.getElementById('agreeConsent').addEventListener('click', function () {
    $('#consentModal').modal('hide'); // Hide consent modal
    $('#modal1').modal('show'); // Show location modal
});

// Handle "Cancel" button in consent modal
document.querySelector('.btn-secondary[data-bs-dismiss="modal"]').addEventListener('click', function () {
    if (marker) {
        map.removeLayer(marker); // Remove marker if consent is not given
        marker = null;
    }
    });
</script>

<script>
    // Function to toggle custom input visibility based on selection
    document.getElementById('activity_type').addEventListener('change', function() {
        var activitySelect = document.getElementById('activity_type');
        var customActivityInput = document.getElementById('custom_activity');
        if (activitySelect.value === 'other') {
            customActivityInput.classList.remove('d-none');
        } else {
            customActivityInput.classList.add('d-none');
        }
    });

    document.getElementById('observer_category').addEventListener('change', function() {
        var observerSelect = document.getElementById('observer_category');
        var customObserverInput = document.getElementById('custom_observer');
        if (observerSelect.value === 'other') {
            customObserverInput.classList.remove('d-none');
        } else {
            customObserverInput.classList.add('d-none');
        }
    });

    // When the form is submitted, append the custom input value if provided
    document.querySelector('form').addEventListener('submit', function() {
        // If "Other" is selected for activity type and custom input is provided
        var activitySelect = document.getElementById('activity_type');
        var customActivityInput = document.getElementById('custom_activity');
        if (activitySelect.value === 'other' && customActivityInput.value) {
            activitySelect.value = customActivityInput.value; // Override the value with the custom input
        }

        // If "Other" is selected for observer category and custom input is provided
        var observerSelect = document.getElementById('observer_category');
        var customObserverInput = document.getElementById('custom_observer');
        if (observerSelect.value === 'other' && customObserverInput.value) {
            observerSelect.value = customObserverInput.value; // Override the value with the custom input
        }
    });

        document.getElementById('photo').addEventListener('change', function(event) {
        var fileList = event.target.files;
        var previewContainer = document.getElementById('photo-previews');
        previewContainer.innerHTML = ''; // Clear previous previews

        // Loop through the selected files
        for (var i = 0; i < fileList.length; i++) {
            var file = fileList[i];
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-fluid', 'rounded', 'm-2');
                img.style.maxWidth = '150px';
                previewContainer.appendChild(img);
            }

            reader.readAsDataURL(file);
        }
    });

</script>
<script>
    // Function to update the total of COTS
    function updateTotal() {
        // Get values from the input fields and parse them as integers (default to 0 if empty)
        let earlyJuvenile = parseInt(document.getElementById('early_juvenile').value) || 0;
        let juvenile = parseInt(document.getElementById('juvenile').value) || 0;
        let subAdult = parseInt(document.getElementById('sub_adult').value) || 0;
        let adult = parseInt(document.getElementById('adult').value) || 0;
        let lateadult = parseInt(document.getElementById('late_adult').value) || 0;


        // Calculate the total
        let total = earlyJuvenile + juvenile + subAdult + adult + lateadult;

        // Update the total field
        document.getElementById('number_of_cots').value = total;
    }

    // Attach the updateTotal function to the input event for each relevant field
    document.getElementById('early_juvenile').addEventListener('input', updateTotal);
    document.getElementById('juvenile').addEventListener('input', updateTotal);
    document.getElementById('sub_adult').addEventListener('input', updateTotal);
    document.getElementById('adult').addEventListener('input', updateTotal);
    document.getElementById('late_adult').addEventListener('input', updateTotal);


</script>

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

    <!-- Offline Manager -->
    <script src="{{ asset('js/offline-manager.js') }}"></script>

    <script>
        // Initialize offline functionality
        document.addEventListener('DOMContentLoaded', function() {
            const locationForm = document.getElementById('locationForm');
            const submitBtn = locationForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            // Update form submission to handle offline
            locationForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                if (!navigator.onLine && window.offlineManager) {
                    // Handle offline submission
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving Offline...';
                    submitBtn.disabled = true;

                    try {
                        const formData = new FormData(this);
                        const locationData = {};

                        // Convert FormData to object
                        for (let [key, value] of formData.entries()) {
                            if (key !== 'photo[]') {
                                locationData[key] = value;
                            }
                        }

                        // Handle photos
                        const photoFiles = formData.getAll('photo[]').filter(file => file.size > 0);
                        const photoIds = [];

                        for (const file of photoFiles) {
                            const photoId = await window.offlineManager.storePhotoOffline(file);
                            photoIds.push(photoId);
                        }

                        // Store location data offline
                        const locationId = await window.offlineManager.storeLocationOffline(locationData, photoIds);

                        // Reset form
                        this.reset();

                        // Show success message
                        showNotification('Data saved offline! Will sync when online.', 'success');

                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.disabled = false;

                        // Close modal on mobile
                        if (window.innerWidth < 768) {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('modal1'));
                            if (modal) modal.hide();
                        }

                    } catch (error) {
                        console.error('Offline save failed:', error);
                        showErrorAlert('Failed to save data offline. Please try again.');
                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.disabled = false;
                    }
                } else {
                    // Normal online submission
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                    submitBtn.disabled = true;

                    try {
                        const response = await fetch(this.action, {
                            method: 'POST',
                            body: new FormData(this),
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (response.ok) {
                            const result = await response.json();
                            showNotification('Location saved successfully!', 'success');
                            this.reset();
                            // Optionally refresh the page or update the UI
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            const error = await response.json();
                            showNotification(error.message || 'Failed to save location', 'error');
                        }
                    } catch (error) {
                        console.error('Save failed:', error);
                        showNotification('Failed to save location. Please try again.', 'error');
                    }

                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                }
            });

            // Show online/offline status
            updateConnectionStatus();
            window.addEventListener('online', updateConnectionStatus);
            window.addEventListener('offline', updateConnectionStatus);

            // Add mobile-specific event listeners
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.addEventListener('message', event => {
                    if (event.data && event.data.type === 'SYNC_COMPLETE') {
                        showNotification('Data synced successfully!', 'success');
                        updateConnectionStatus();
                    }
                });
            }
        });

        function updateConnectionStatus() {
            const statusElement = document.getElementById('connectionStatus');
            if (statusElement) {
                if (navigator.onLine) {
                    statusElement.className = 'connection-status online';
                    statusElement.innerHTML = '<i class="fas fa-wifi"></i><span>Online</span>';
                } else {
                    statusElement.className = 'connection-status offline';
                    statusElement.innerHTML = '<i class="fas fa-wifi-slash"></i><span>Offline</span>';
                }
            }
        }

        function addNewSighting() {
            // Trigger map click or open modal
            if (typeof addMarkerAtCurrentLocation === 'function') {
                addMarkerAtCurrentLocation();
            } else {
                // Fallback: open the modal
                const modal = new bootstrap.Modal(document.getElementById('modal1'));
                modal.show();
            }
        }

        function showNotification(message, type = 'info') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.notification');
            existingNotifications.forEach(notification => notification.remove());

            // Create new notification
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(notification);

            // Auto-hide after 4 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 4000);

            // Add click to dismiss
            notification.addEventListener('click', () => notification.remove());
        }

        // Manual sync button functionality
        function manualSync() {
            const syncBtn = document.getElementById('syncBtn');
            const originalHTML = syncBtn.innerHTML;

            if (window.offlineManager && navigator.onLine) {
                syncBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Syncing...';
                syncBtn.disabled = true;

                window.offlineManager.syncData().then(result => {
                    if (result.synced > 0) {
                        showNotification(`Synced ${result.synced} locations successfully!`, 'success');
                    } else {
                        showNotification('No data to sync', 'info');
                    }
                    syncBtn.innerHTML = originalHTML;
                    syncBtn.disabled = false;
                }).catch(error => {
                    showNotification('Sync failed: ' + error.message, 'error');
                    syncBtn.innerHTML = originalHTML;
                    syncBtn.disabled = false;
                });
            } else if (!navigator.onLine) {
                showNotification('Cannot sync while offline', 'warning');
            } else {
                showNotification('Sync manager not available', 'warning');
            }
        }

        // Mobile-specific enhancements
        if ('visualViewport' in window) {
            window.visualViewport.addEventListener('resize', () => {
                // Handle mobile keyboard appearance
                document.body.style.height = window.visualViewport.height + 'px';
            });
        }

        // Prevent zoom on input focus for iOS
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                if (window.innerWidth < 768) {
                    input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        });
    </script>

@endsection