// Function to fetch and display bookings
function fetchBookings() {
    // Make a GET request to the VehicleSection.php file
    fetch('VBooking.php?action=view_bookings')
        .then(response => response.text())
        .then(data => {
            // Populate the bookings table with the fetched data
            document.getElementById('bookings-table-body').innerHTML = data;
        })
        .catch(error => console.error('Error fetching bookings:', error));
}

// Function to handle "View Bookings" button click
document.getElementById('view-bookings-btn').addEventListener('click', function() {
    fetchBookings();
});
