<?php
session_start();
require 'db_connect.php'; // Include your database connection file

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['uid'])) {
        // Redirect to login if user is not logged in
        header('Location: user.html');
        exit;
    }

    // Get the logged-in user's ID
    $uid = $_SESSION['uid'];

    // Get the posted form data
    $food_ids = $_POST['food_id']; // Array of food IDs
    $quantities = $_POST['quantity']; // Array of quantities
    $order_date = $_POST['order_date'];
    $order_time = $_POST['order_time'];

    // Loop through the cart items and insert each into the database
    foreach ($food_ids as $index => $fid) {
        $quantity = (int) $quantities[$index]; // Get the corresponding quantity

        // Prepare the SQL query to insert the order into the food_orders table
        $stmt = $conn->prepare("INSERT INTO food_orders (UID, FID, Quantity, O_date, O_time, Order_Status) VALUES (?, ?, ?, ?, ?, 'Confirmed')");
        $stmt->bind_param("iiiss", $uid, $fid, $quantity, $order_date, $order_time);

        // Execute the statement
        if (!$stmt->execute()) {
            // Handle the error
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    // Clear the cart session after confirming the order
    unset($_SESSION['cart']);

    // Redirect to a confirmation page or display a success message
    echo "Order confirmed!";
    header('Location: order_confirmation.php');
    exit;
}
?>
