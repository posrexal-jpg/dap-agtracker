@extends('layouts.user')

@section('title', 'My Account - COTS Tracker')

@section('content')
<style>
@media (min-width: 1200px) {
    .layout-menu-fixed:not(.layout-menu-collapsed) .layout-page, .layout-menu-fixed-offcanvas:not(.layout-menu-collapsed) .layout-page {
        padding-left: 0;
    }
}
</style>
<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h1 class="page-title">My Account</h1>
                <p class="page-subtitle">Manage your profile and change your password</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bx bx-user"></i> Profile Information</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.account.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save Profile</button>
                            <a href="{{ route('user.download') }}" class="btn btn-outline-secondary">Download App</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bx bx-key"></i> Change Password</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.account.password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-danger">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Location Modal -->
<div class="modal fade" id="addLocationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-plus"></i> Add New COTS Sighting
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="locationForm" action="{{ route('user-save-location') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Location Name (Optional)</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Coral Garden">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="municipality" class="form-label">Municipality <span class="text-danger">*</span></label>
                                <select class="form-select" id="municipality" name="municipality" required>
                                    <option value="">Select Municipality</option>
                                    @foreach($municipalities as $municipality)
                                        <option value="{{ $municipality->municipality_name }}">{{ $municipality->municipality_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="barangay" class="form-label">Barangay <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="barangay" name="barangay" required placeholder="Enter barangay name">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_of_sighting" class="form-label">Date of Sighting</label>
                                <input type="date" class="form-control" id="date_of_sighting" name="date_of_sighting" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="time_of_sighting" class="form-label">Time of Sighting</label>
                                <input type="time" class="form-control" id="time_of_sighting" name="time_of_sighting">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude <span class="text-danger">*</span></label>
                                <input type="number" step="any" class="form-control" id="latitude" name="latitude" required readonly>
                                <small class="text-muted">Click on map to set location</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude <span class="text-danger">*</span></label>
                                <input type="number" step="any" class="form-control" id="longitude" name="longitude" required readonly>
                                <small class="text-muted">Click on map to set location</small>
                            </div>
                        </div>
                    </div>

                    <!-- Map for location selection -->
                    <div class="mb-3">
                        <label class="form-label">Select Location on Map</label>
                        <div id="locationMap" style="height: 200px; width: 100%; border-radius: 8px; border: 1px solid #ddd;"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="number_of_cots" class="form-label">Number of COTS</label>
                                <input type="text" class="form-control" id="number_of_cots" name="number_of_cots" placeholder="e.g., 5-10">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="activity_type" class="form-label">Activity Type</label>
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="observer_category" class="form-label">Observer Category</label>
                                <select class="form-select" id="observer_category" name="observer_category">
                                    <option value="">Select Category</option>
                                    <option value="diver">Diver</option>
                                    <option value="snorkeler">Snorkeler</option>
                                    <option value="boat_observer">Boat Observer</option>
                                    <option value="fisherman">Fisherman</option>
                                    <option value="researcher">Researcher</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="photo" class="form-label">Photos</label>
                                <input type="file" class="form-control" id="photo" name="photo[]" multiple accept="image/*">
                                <small class="text-muted">You can select multiple photos</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description/Notes</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Additional observations, conditions, etc."></textarea>
                    </div>

                    <!-- COTS Size Categories -->
                    <div class="card bg-light">
                        <div class="card-header">
                            <h6 class="mb-0">COTS Size Distribution (Optional)</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="early_juvenile" class="form-label">Early Juvenile</label>
                                        <input type="number" class="form-control" id="early_juvenile" name="early_juvenile" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="juvenile" class="form-label">Juvenile</label>
                                        <input type="number" class="form-control" id="juvenile" name="juvenile" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sub_adult" class="form-label">Sub-Adult</label>
                                        <input type="number" class="form-control" id="sub_adult" name="sub_adult" min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="adult" class="form-label">Adult</label>
                                        <input type="number" class="form-control" id="adult" name="adult" min="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="late_adult" class="form-label">Late Adult</label>
                                        <input type="number" class="form-control" id="late_adult" name="late_adult" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Save Sighting
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
document.addEventListener('DOMContentLoaded', function() {
    // Initialize main map
    const map = L.map('map').setView([10.3157, 123.8854], 10); // Cebu coordinates

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add markers for user's locations
    @foreach($userLocations as $location)
        const marker{{ $location->id }} = L.marker([{{ $location->latitude }}, {{ $location->longitude }}])
            .addTo(map)
            .bindPopup(`
                <strong>{{ $location->name ?? 'Unnamed Location' }}</strong><br>
                {{ $location->barangay }}, {{ $location->municipality }}<br>
                Date: {{ $location->date_of_sighting ? \Carbon\Carbon::parse($location->date_of_sighting)->format('M d, Y') : $location->created_at->format('M d, Y') }}<br>
                COTS: {{ $location->number_of_cots ?? 'N/A' }}<br>
                @if($location->photo)
                    <img src="{{ asset('storage/' . (is_array(json_decode($location->photo)) ? json_decode($location->photo)[0] : $location->photo)) }}" style="width: 100px; height: auto;" alt="Location photo">
                @endif
            `);
    @endforeach

    // Initialize location selection map in modal
    const locationMap = L.map('locationMap').setView([10.3157, 123.8854], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(locationMap);

    let selectedMarker = null;

    locationMap.on('click', function(e) {
        const { lat, lng } = e.latlng;

        // Remove previous marker
        if (selectedMarker) {
            locationMap.removeLayer(selectedMarker);
        }

        // Add new marker
        selectedMarker = L.marker([lat, lng]).addTo(locationMap);

        // Update form fields
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
    });

    // Get user's current location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const { latitude, longitude } = position.coords;
            locationMap.setView([latitude, longitude], 15);
            map.setView([latitude, longitude], 12);
        });
    }
});

// Delete location function
function deleteLocation(id) {
    if (confirm('Are you sure you want to delete this sighting?')) {
        fetch(`/user/locations/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting location');
        });
    }
}

// View location details
function viewLocation(id) {
    // This could open a modal with detailed location info
    alert('View location details functionality can be implemented here');
}
</script>
@endpush