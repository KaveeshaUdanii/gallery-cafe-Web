// Function to fetch and display orders
function fetchOrders() {
    // Make a GET request to the orders.php file
    fetch('orders.php?action=view_orders')
    .then(response => response.text())
    .then(data => {
        // Populate the orders table with the fetched data
        document.getElementById('orders-table-body').innerHTML = data;
    })
    .catch(error => console.error('Error fetching orders:', error));
}

// Function to confirm an order
function confirmOrder(oid) {
    // Create a FormData object to send the OID via POST
    let formData = new FormData();
    formData.append('confirm_oid', oid);

    // Send a POST request to orders.php to confirm the order
    fetch('orders.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Display alert and refresh the order list
        alert('Order confirmed successfully');
        fetchOrders(); // Refresh orders
    })
    .catch(error => console.error('Error confirming order:', error));
}

// Function to delete an order
function deleteOrder(oid) {
    // Confirm with the user before deletion
    if (confirm('Are you sure you want to delete this order?')) {
        // Create a FormData object to send the OID via POST
        let formData = new FormData();
        formData.append('delete_oid', oid);

        // Send a POST request to orders.php to delete the order
        fetch('orders.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Display alert and refresh the order list
            alert('Order deleted successfully');
            fetchOrders(); // Refresh orders
        })
        .catch(error => console.error('Error deleting order:', error));
    }
}

// Function to handle "View Orders" button click
document.getElementById('view-orders-btn').addEventListener('click', function() {
    fetchOrders();
});
