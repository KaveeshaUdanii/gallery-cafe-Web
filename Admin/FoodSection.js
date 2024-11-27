// Dynamic food and orders loading simulation
const foodsTableBody = document.querySelector("#foods-table tbody");
const ordersTableBody = document.querySelector("#orders-table tbody");

// Open form modal for adding new food
document.getElementById("add-food-btn").addEventListener("click", () => {
    document.getElementById("food-form-modal").style.display = "flex";
    clearForm();
});

// Close form modal
document.getElementById("close-food-form").addEventListener("click", () => {
    document.getElementById("food-form-modal").style.display = "none";
});


// View table button event
document.getElementById("view-table-btn").addEventListener("click", () => {
    fetch('FoodSection.php?action=view_foods')
        .then(response => response.text())
        .then(data => {
            foodsTableBody.innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
});

// Edit food function
function editFood(fid, foodName, price, category, cuisineType, image) {
    document.getElementById("fid").value = fid;
    document.getElementById("food-name").value = foodName;
    document.getElementById("price").value = price;
    document.getElementById("category").value = category;
    document.getElementById("cuisine-type").value = cuisineType;
    document.getElementById("food-image").value = image;
    document.getElementById("food-form-modal").style.display = "flex";
}

// Clear form fields
function clearForm() {
    document.getElementById("fid").value = '';
    document.getElementById("food-name").value = '';
    document.getElementById("price").value = '';
    document.getElementById("category").value = '';
    document.getElementById("cuisine-type").value = '';
    document.getElementById("food-image").value = '';
}



// -----------------------------------------show less the table button---------------------------------------
let currentRowCount = 5; // Number of rows to initially show
let totalRows = 0; // This will be set based on the total number of rows in the table

function viewTable() {
    const rows = document.querySelectorAll('table tr');
    totalRows = rows.length - 1; // Exclude the header row
    rows.forEach((row, index) => {
        if (index < totalRows) {
            row.style.display = 'table-row'; // Show row
        }
    });
    document.getElementById('showLessButton').style.display = 'block';
    currentRowCount = totalRows; // Update current row count
}

function showLess() {
    const rows = document.querySelectorAll('table tr');
    rows.forEach((row, index) => {
        if (index >= currentRowCount) {
            row.style.display = 'none'; // Hide row
        }
    });
    currentRowCount = 5; // Change this to the number of rows you want to keep visible
}

// Call this function on document ready or after your table is generated to initialize row count
function initializeRowCount() {
    const rows = document.querySelectorAll('table tr');
    totalRows = rows.length - 1; // Set total rows based on table content
    // Initially hide all rows except the first 'currentRowCount'
    showLess();
}

// Run this function when the document is ready
document.addEventListener('DOMContentLoaded', initializeRowCount);


