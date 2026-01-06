// User Map Initialization
function initializeMap() {
    // Check if Leaflet is available
    if (typeof L === 'undefined') {
        console.error('Leaflet library not loaded');
        setTimeout(initializeMap, 500); // Retry after 500ms
        return;
    }

    // Check if map container exists
    var mapElement = document.getElementById('map');
    if (!mapElement) {
        console.error('Map container element not found');
        return;
    }

    console.log('Map container found, initializing Leaflet map...');

    // Initialize the map with error handling
    try {
        var map = L.map('map').setView([10.306812602471465, 125.00810623168947], 12);
        console.log('Leaflet map created successfully');

        // OSM layer
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });
        osm.addTo(map);
        console.log('OSM tiles added');

        // Add Locate control (with error handling)
        try {
            L.control.locate().addTo(map);
        } catch (locateError) {
            console.warn('Locate control not available:', locateError);
        }

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

        // Add the polygon to the map
        var polygon = L.geoJSON(geoJsonPolygon, {
            style: function () {
                return {
                    color: "#0000FF",
                    weight: 2,
                    opacity: 0,
                    fillOpacity: 0
                };
            }
        }).addTo(map);

        // Fit map to the polygon bounds
        map.fitBounds(polygon.getBounds());

        // Add markers from window.SIGHTINGS if available
        if (window.SIGHTINGS && Array.isArray(window.SIGHTINGS)) {
            window.SIGHTINGS.forEach(function(loc) {
                try {
                    if (loc.latitude && loc.longitude) {
                        var m = L.marker([parseFloat(loc.latitude), parseFloat(loc.longitude)]).addTo(map);
                        var popup = '<strong>' + (loc.name || 'Unnamed') + '</strong><br/>' +
                                    (loc.municipality ? loc.municipality + ' - ' : '') + (loc.barangay || '') + '<br/>' +
                                    (loc.date_of_sighting ? loc.date_of_sighting : (loc.created_at || ''));
                        m.bindPopup(popup);
                    }
                } catch (markerError) {
                    console.warn('Failed to add marker for location:', markerError, loc);
                }
            });
        } else {
            console.warn('No SIGHTINGS data found for markers.');
        }

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
                if (typeof $ !== 'undefined' && $('#consentModal').modal) {
                    $('#consentModal').modal('show');
                } else {
                    console.warn('jQuery or modal not available');
                }
            } else {
                alert("You can only place markers inside the sogod bay.");
            }
        });

        // Handle "Agree" button click in consent modal
        var agreeBtn = document.getElementById('agreeConsent');
        if (agreeBtn) {
            agreeBtn.addEventListener('click', function () {
                if (typeof $ !== 'undefined' && $('#consentModal').modal && $('#modal1').modal) {
                    $('#consentModal').modal('hide'); // Hide consent modal
                    $('#modal1').modal('show'); // Show location modal
                }
            });
        }

        // Handle "Cancel" button in consent modal
        var cancelBtn = document.querySelector('.btn-secondary[data-bs-dismiss="modal"]');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function () {
                if (marker) {
                    map.removeLayer(marker); // Remove marker if consent is not given
                    marker = null;
                }
            });
        }

        console.log('Map initialized successfully');

    } catch (mapError) {
        console.error('Failed to initialize map:', mapError);
        // Show error message in map container
        const mapElement = document.getElementById('map');
        if (mapElement) {
            mapElement.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: #f8f9fa; border-radius: 16px; flex-direction: column;">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3 text-warning"></i>
                    <h5 class="text-muted">Map Loading Error</h5>
                    <p class="text-muted text-center px-3">Unable to load the map. Please check your internet connection and refresh the page.</p>
                    <button class="btn btn-primary btn-sm mt-2" onclick="location.reload()">Refresh Page</button>
                </div>
            `;
        }
    }
}

// Initialize map when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing map...');
        setTimeout(initializeMap, 100); // Small delay to ensure all scripts are loaded
    });
} else {
    console.log('DOM already ready, initializing map...');
    setTimeout(initializeMap, 100);
}