// Dynamic parking loading simulation
const parkingTableBody = document.querySelector("#parking-table-body");

// Open form modal for adding new parking
document.getElementById("add-parking-btn").addEventListener("click", () => {
    document.getElementById("parking-form-modal").style.display = "flex";
    clearParkingForm();
});

// Close form modal
document.getElementById("close-parking-form").addEventListener("click", () => {
    document.getElementById("parking-form-modal").style.display = "none";
});

// View table button event
document.getElementById("view-parking-btn").addEventListener("click", () => {
    fetch('VehicleSection.php?action=view_parking')
        .then(response => response.text())
        .then(data => {
            parkingTableBody.innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
});

// Edit parking function
function editParking(pid, vehicleSpaceType, availability) {
    document.getElementById("pid").value = pid;
    document.getElementById("vehicle-space-type").value = vehicleSpaceType;
    document.getElementById("availability").value = availability; // Set availability from fetched data
    document.getElementById("parking-form-modal").style.display = "flex";
}

// Clear parking form fields
function clearParkingForm() {
    document.getElementById("pid").value = '';
    document.getElementById("vehicle-space-type").value = '';
    document.getElementById("availability").value = '1';
}

// -----------------------------------------show less the table button---------------------------------------
let currentRowCount = 5; // Number of rows to initially show
let totalRows = 0; // This will be set based on the total number of rows in the table

function viewParkingTable() {
    const rows = document.querySelectorAll('#parking-table-body tr');
    totalRows = rows.length; // Get total rows in parking table
    rows.forEach((row, index) => {
        if (index < currentRowCount) {
            row.style.display = 'table-row'; // Show row
        }
    });
    document.getElementById('showLessParkingButton').style.display = 'block';
}

function showLessParking() {
    const rows = document.querySelectorAll('#parking-table-body tr');
    rows.forEach((row, index) => {
        if (index >= currentRowCount) {
            row.style.display = 'none'; // Hide row
        }
    });
    currentRowCount = 5; // Set number of rows to keep visible
}

// Call this function on document ready or after your table is generated to initialize row count
function initializeParkingRowCount() {
    const rows = document.querySelectorAll('#parking-table-body tr');
    totalRows = rows.length; // Set total rows based on table content
    // Initially hide all rows except the first 'currentRowCount'
    showLessParking();
}

// Run this function when the document is ready
document.addEventListener('DOMContentLoaded', initializeParkingRowCount);
