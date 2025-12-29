// User Modal Controls
function switchModal(hideId, showId) {
    let hideModal = bootstrap.Modal.getInstance(document.getElementById(hideId));
    if (hideModal) hideModal.hide();

    let showModal = new bootstrap.Modal(document.getElementById(showId));
    showModal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Modal navigation event listeners
    const nextBtn1 = document.getElementById("nextBtn1");
    const backBtn2 = document.getElementById("backBtn2");
    const nextBtn2 = document.getElementById("nextBtn2");
    const backBtn3 = document.getElementById("backBtn3");
    const nextBtn3 = document.getElementById("nextBtn3");
    const backBtn4 = document.getElementById("backBtn4");

    if (nextBtn1) {
        nextBtn1.addEventListener("click", function () {
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
    }

    if (backBtn2) backBtn2.addEventListener("click", () => switchModal('modal2', 'modal1'));
    if (nextBtn2) nextBtn2.addEventListener("click", () => switchModal('modal2', 'modal3'));
    if (backBtn3) backBtn3.addEventListener("click", () => switchModal('modal3', 'modal2'));
    if (nextBtn3) nextBtn3.addEventListener("click", () => switchModal('modal3', 'modal4'));
    if (backBtn4) backBtn4.addEventListener("click", () => switchModal('modal4', 'modal3'));
});