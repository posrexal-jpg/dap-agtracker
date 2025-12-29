// User Location Management - Municipality and Barangay Population
document.addEventListener('DOMContentLoaded', function() {
    // Fetch and display municipalities in Southern Leyte
    populateMunicipalities();
});

function populateMunicipalities() {
    // First try to load from localStorage cache
    const cachedMunicipalities = localStorage.getItem('municipalities');
    if (cachedMunicipalities) {
        try {
            const data = JSON.parse(cachedMunicipalities);
            populateMunicipalitySelect(data);
            console.log('Loaded municipalities from cache');
            return;
        } catch (e) {
            console.warn('Failed to parse cached municipalities:', e);
        }
    }

    // Fallback municipalities for Southern Leyte if API fails
    const fallbackMunicipalities = [
        { code: '086401000', name: 'Anahawan' },
        { code: '086402000', name: 'Bontoc' },
        { code: '086403000', name: 'Hinunangan' },
        { code: '086404000', name: 'Hinundayan' },
        { code: '086405000', name: 'Libagon' },
        { code: '086406000', name: 'Liloan' },
        { code: '086407000', name: 'Limasawa' },
        { code: '086408000', name: 'Maasin City' },
        { code: '086409000', name: 'Macrohon' },
        { code: '086410000', name: 'Malitbog' },
        { code: '086411000', name: 'Padre Burgos' },
        { code: '086412000', name: 'Pintuyan' },
        { code: '086413000', name: 'Saint Bernard' },
        { code: '086414000', name: 'San Francisco' },
        { code: '086415000', name: 'San Juan' },
        { code: '086416000', name: 'San Ricardo' },
        { code: '086417000', name: 'Silago' },
        { code: '086418000', name: 'Sogod' },
        { code: '086419000', name: 'Tomas Oppus' }
    ];

    // Try to fetch from API
    fetch('https://psgc.gitlab.io/api/provinces/086400000/municipalities/')
        .then(response => {
            if (!response.ok) {
                throw new Error('API response not ok');
            }
            return response.json();
        })
        .then(data => {
            // Cache the data
            localStorage.setItem('municipalities', JSON.stringify(data));
            populateMunicipalitySelect(data);
            console.log('Loaded municipalities from API');
        })
        .catch(error => {
            console.warn('Failed to fetch municipalities from API, using fallback:', error);
            // Use fallback data
            populateMunicipalitySelect(fallbackMunicipalities);
            // Cache fallback data
            localStorage.setItem('municipalities', JSON.stringify(fallbackMunicipalities));
        });
}

function populateMunicipalitySelect(data) {
    const municipalitySelect = document.getElementById('municipality');
    if (!municipalitySelect) return;

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
}

// Fetch and display barangays of selected municipality
function populateBarangays(municipalityName) {
    if (!municipalityName) {
        document.getElementById('barangay').innerHTML = '<option value="">Select Barangay</option>';
        return;
    }

    // Check cache first
    const cacheKey = `barangays_${municipalityName}`;
    const cachedBarangays = localStorage.getItem(cacheKey);
    if (cachedBarangays) {
        try {
            const barangays = JSON.parse(cachedBarangays);
            populateBarangaySelect(barangays);
            console.log(`Loaded barangays for ${municipalityName} from cache`);
            return;
        } catch (e) {
            console.warn('Failed to parse cached barangays:', e);
        }
    }

    // Try to fetch from API
    fetch('https://psgc.gitlab.io/api/provinces/086400000/municipalities/')
        .then(response => {
            if (!response.ok) {
                throw new Error('API response not ok');
            }
            return response.json();
        })
        .then(data => {
            const municipality = data.find(municipality => municipality.name === municipalityName);
            if (municipality) {
                const municipalityCode = municipality.code;
                return fetch(`https://psgc.gitlab.io/api/municipalities/${municipalityCode}/barangays/`);
            } else {
                throw new Error('Municipality not found');
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Barangays API response not ok');
            }
            return response.json();
        })
        .then(barangays => {
            // Cache the barangays
            localStorage.setItem(cacheKey, JSON.stringify(barangays));
            populateBarangaySelect(barangays);
            console.log(`Loaded barangays for ${municipalityName} from API`);
        })
        .catch(error => {
            console.warn(`Failed to fetch barangays for ${municipalityName} from API:`, error);
            // Use fallback empty list or show message
            populateBarangaySelect([]);
            // You could add a message to the user here
        });
}

function populateBarangaySelect(barangays) {
    const barangaySelect = document.getElementById('barangay');
    if (!barangaySelect) return;

    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
    if (barangays && barangays.length > 0) {
        barangays.forEach(barangay => {
            const option = document.createElement('option');
            option.value = barangay.name; // Use barangay name as the value
            option.textContent = barangay.name; // Barangay name
            barangaySelect.appendChild(option);
        });
    } else {
        // Add a note if no barangays available
        const option = document.createElement('option');
        option.value = '';
        option.textContent = 'No barangays available';
        option.disabled = true;
        barangaySelect.appendChild(option);
    }

    // Load previously selected barangay from localStorage
    const savedBarangay = localStorage.getItem('barangay');
    if (savedBarangay) {
        barangaySelect.value = savedBarangay;
    }
}

// Event listeners for municipality and barangay selection
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
});