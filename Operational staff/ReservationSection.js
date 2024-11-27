// Function to fetch and display reservations
function fetchReservations() {
    // Make a GET request to the reservations.php file
    fetch('ReservationSection.php?action=view_reservations')
        .then(response => response.text())
        .then(data => {
            // Populate the reservations table with the fetched data
            document.getElementById('reservations-table-body').innerHTML = data;
        })
        .catch(error => console.error('Error fetching reservations:', error));
}

// Function to handle "View Reservations" button click
document.getElementById('view-reservations-btn').addEventListener('click', function() {
    fetchReservations();
});
