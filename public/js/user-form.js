// User Form Enhancements
document.addEventListener('DOMContentLoaded', function() {
    setupCustomInputs();
    setupPhotoPreview();
    setupTotalCalculation();
});

// Function to toggle custom input visibility based on selection
function setupCustomInputs() {
    try {
        const activitySelect = document.getElementById('activity_type');
        const observerSelect = document.getElementById('observer_category');
        const customActivityInput = document.getElementById('custom_activity');
        const customObserverInput = document.getElementById('custom_observer');

        if (activitySelect && customActivityInput) {
            activitySelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    customActivityInput.classList.remove('d-none');
                } else {
                    customActivityInput.classList.add('d-none');
                }
            });
        }

        if (observerSelect && customObserverInput) {
            observerSelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    customObserverInput.classList.remove('d-none');
                } else {
                    customObserverInput.classList.add('d-none');
                }
            });
        }
    } catch (error) {
        console.warn('Error setting up custom inputs:', error);
    }
}

// Function to handle photo previews
function setupPhotoPreview() {
    try {
        const photoInput = document.getElementById('photo');
        if (photoInput) {
            photoInput.addEventListener('change', function(event) {
                const previewContainer = document.getElementById('photo-previews') || document.createElement('div');
                if (!document.getElementById('photo-previews')) {
                    previewContainer.id = 'photo-previews';
                    photoInput.parentNode.appendChild(previewContainer);
                }
                previewContainer.innerHTML = '';

                const files = event.target.files;
                if (files) {
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('img-fluid', 'rounded', 'm-2');
                            img.style.maxWidth = '150px';
                            previewContainer.appendChild(img);
                        };

                        reader.readAsDataURL(file);
                    }
                }
            });
        }
    } catch (error) {
        console.warn('Error setting up photo preview:', error);
    }
}

// Function to update total COTS count
function setupTotalCalculation() {
    try {
        const inputs = ['early_juvenile', 'juvenile', 'sub_adult', 'adult', 'late_adult'];
        const totalInput = document.getElementById('number_of_cots');

        if (totalInput) {
            inputs.forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', function() {
                        updateTotal();
                    });
                }
            });
        }

        function updateTotal() {
            let total = 0;
            inputs.forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    total += parseInt(input.value) || 0;
                }
            });
            if (totalInput) {
                totalInput.value = total;
            }
        }
    } catch (error) {
        console.warn('Error setting up total calculation:', error);
    }
}