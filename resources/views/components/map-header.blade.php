{{-- COTS Sightings Map Header Component --}}
<div class="page-header">
    <div class="page-header-logo">
        <img src="{{ asset('images/logo.png') }}" alt="COTS Tracker Logo" loading="lazy">
    </div>
    <div class="page-header-content">
        <h1>
            <i class="fas fa-map-marked-alt me-2" style="color: #3b82f6;"></i>
            COTS Sighting Map
        </h1>
        <p class="description">
            <i class="fas fa-info-circle me-1" style="font-size: 0.85rem; color: #64748b;"></i>
            View all reported Crown-of-Thorns Starfish (COTS), locally known as <strong>Dap-ag</strong>, sightings on the interactive map. Help protect our reefs by reporting new sightings.
        </p>

        {{-- Status and Controls --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-3">
            {{-- Connection Status --}}
            <div class="connection-status online" id="connectionStatus">
                <i class="fas fa-wifi"></i>
                <span>Online</span>
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="manualSync()" id="syncBtn" title="Sync offline data with server">
                    <i class="fas fa-sync-alt me-1"></i>
                    <span class="d-none d-sm-inline">Sync Data</span>
                    <span class="d-inline d-sm-none">Sync</span>
                </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="$('#modal1').modal('show')" title="Report a new COTS sighting">
                    <i class="fas fa-plus-circle me-1"></i>
                    <span class="d-none d-sm-inline">Report Sighting</span>
                    <span class="d-inline d-sm-none">Report</span>
                </button>
            </div>
        </div>
    </div>
</div>
