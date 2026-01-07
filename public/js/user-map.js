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

        // Base layers
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        var esriSat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        });

        var esriTopo = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> contributors'
        });

        var baseMaps = {
            "OpenStreetMap": osm,
            "Satellite": esriSat,
            "Topographic": esriTopo
        };

        osm.addTo(map); // Default
        L.control.layers(baseMaps, null, { position: 'topright', collapsed: false }).addTo(map);
        console.log('Map layers and controls added');

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

        // Check for previously stored user location (to restore view quickly on refresh)
        var storedLocation = null;
        try {
            var stored = localStorage.getItem('user_location');
            if (stored) {
                var parsed = JSON.parse(stored);
                if (parsed && parsed.lat && parsed.lng) {
                    storedLocation = parsed;
                }
            }
        } catch (err) {
            console.warn('Failed to read stored user location:', err);
        }

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

        // Fit map to the polygon bounds unless we have a stored user location
        if (storedLocation) {
            try {
                map.setView([parseFloat(storedLocation.lat), parseFloat(storedLocation.lng)], 15);
            } catch (vErr) {
                console.warn('Failed to set view from stored location:', vErr);
                map.fitBounds(polygon.getBounds());
            }
        } else {
            map.fitBounds(polygon.getBounds());
        }

        // Ask for user's location and zoom to it (will prompt for permission)
        try {
            if (navigator && navigator.geolocation) {
                // Use Leaflet's locate which triggers browser permission dialog
                map.locate({ setView: true, maxZoom: 15, watch: false, enableHighAccuracy: true });

                // Once location found, add a marker + accuracy circle and set view
                map.on('locationfound', function(e) {
                    try {
                        // Center map on the freshly found location and save it for next load
                        try { map.setView(e.latlng, 15); } catch(se) {}
                        try {
                            var saveObj = { lat: e.latlng.lat, lng: e.latlng.lng, accuracy: e.accuracy, ts: Date.now() };
                            localStorage.setItem('user_location', JSON.stringify(saveObj));
                        } catch(saveErr) { console.warn('Could not save user location:', saveErr); }

                        var radius = e.accuracy || 0;
                        // Add a subtle marker for the user's location
                        var userMarker = L.circleMarker(e.latlng, { radius: 6, fillColor: '#2b8aef', color: '#fff', weight: 2, fillOpacity: 0.9 }).addTo(map);
                        var accuracyCircle = L.circle(e.latlng, { radius: radius, color: '#2b8aef', weight: 1, opacity: 0.25, fillOpacity: 0.05 }).addTo(map);
                        // Remove after 10s to reduce clutter
                        setTimeout(function(){
                            try { map.removeLayer(userMarker); } catch(err){}
                            try { map.removeLayer(accuracyCircle); } catch(err){}
                        }, 10000);
                    } catch (locErr) {
                        console.warn('Error handling locationfound:', locErr);
                    }
                });

                map.on('locationerror', function(err) {
                    console.warn('Location error or permission denied:', err.message || err);
                });
            } else {
                console.warn('Geolocation not available in this browser');
            }
        } catch (locInitErr) {
            console.warn('Failed to initiate location request:', locInitErr);
        }

        // Add a small 'Center on me' control to allow users to re-request location
        try {
            var CenterControl = L.Control.extend({
                options: { position: 'topright' },
                onAdd: function(map) {
                    var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
                    var link = L.DomUtil.create('a', '', container);
                    link.href = '#';
                    link.title = 'Center on me';
                    link.innerHTML = '<i class="fas fa-location-arrow"></i>';
                    L.DomEvent.on(link, 'click', function(e) {
                        L.DomEvent.stopPropagation(e);
                        L.DomEvent.preventDefault(e);
                        try {
                            map.locate({ setView: true, maxZoom: 15, enableHighAccuracy: true });
                        } catch (err) {
                            console.warn('Locate request failed:', err);
                        }
                    });
                    return container;
                }
            });
            map.addControl(new CenterControl());
            // Auto-click the control after a short delay to request location on initial load
            try {
                setTimeout(function() {
                    function doLocate() {
                        var btn = document.querySelector('.leaflet-control a[title="Center on me"]');
                        if (btn) {
                            try { btn.click(); } catch(e) { try { map.locate({ setView: true, maxZoom: 15, enableHighAccuracy: true }); } catch(err){} }
                        } else {
                            try { map.locate({ setView: true, maxZoom: 15, enableHighAccuracy: true }); } catch(e){}
                        }
                    }

                    // If Permissions API is available, only auto-trigger when permission isn't denied
                    if (navigator.permissions && navigator.permissions.query) {
                        try {
                            navigator.permissions.query({ name: 'geolocation' }).then(function(result) {
                                if (result.state === 'granted' || result.state === 'prompt') {
                                    doLocate();
                                } else {
                                    console.warn('Geolocation permission is denied; skipping auto-locate.');
                                }
                            }).catch(function(){
                                // If query fails, fallback to locating
                                doLocate();
                            });
                        } catch (permErr) {
                            doLocate();
                        }
                    } else {
                        // No Permissions API — attempt locate (browser will prompt)
                        doLocate();
                    }
                }, 700);
            } catch (autoClickErr) {
                console.warn('Auto-trigger for Center control failed:', autoClickErr);
            }
        } catch (ctrlErr) {
            console.warn('Could not add Center control:', ctrlErr);
        }

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