<?php
session_start(); // Start the session
require 'db_connect.php'; // Your database connection file

$filter = 'all'; // Default cuisine filter
$category = '';  // Default category filter

// Handle cuisine filter if POST request is made
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filter'])) {
    $filter = $_POST['filter'];
}

// Handle category filter if POST request is made
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category'])) {
    $category = $_POST['category'];
}

// Handle "Add to cart" action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $food_id = $_POST['food_id'];

    // Check if user is logged in
    if (!isset($_SESSION['uid'])) {
        // User is not logged in, store the action and redirect to login page
        $_SESSION['pending_cart_item'] = $food_id; // Save the food_id in session
        header("Location: user.html"); // Redirect to the login page
        exit;
    }

    // If logged in, fetch food details from the database and add to cart
    $stmt = $conn->prepare("SELECT * FROM Foods WHERE FID = ?");
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $food = $result->fetch_assoc();
        // Create an item array
        $item = [
            'id' => $food['FID'],
            'name' => $food['Food_Name'],
            'price' => $food['Price'],
            'image' => $food['Image'],
            'quantity' => 1 // Default quantity
        ];

        // Add item to session cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][] = $item; // Add item to cart
    }

    $stmt->close();
}

// Handle "Confirm Order" action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_order'])) {
    // Check if cart exists and not empty
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $order_date = $_POST['order_date'];
        $order_time = $_POST['order_time'];
        $uid = $_SESSION['uid']; // Get user ID from session

        // Loop through cart items and insert into food_orders table
        foreach ($_SESSION['cart'] as $cart_item) {
            $fid = $cart_item['id'];
            $quantity = $cart_item['quantity'];

            // Insert order details into the food_orders table
            $stmt = $conn->prepare("INSERT INTO Food_Orders (UID, FID, Quantity, O_date, O_time, Order_Status) VALUES (?, ?, ?, ?, ?, 'Pending')");
            $stmt->bind_param("iiiss", $uid, $fid, $quantity, $order_date, $order_time);
            $stmt->execute();
        }

        // Clear the cart after order is confirmed
        unset($_SESSION['cart']);

        // Redirect to shop.php after successful order placement
        header("Location: shop.php"); // Redirect to shop page
        exit;
    } else {
        echo "<p>Your cart is empty.</p>";
    }
}


// Prepare the SQL query based on the filters
$sql = "SELECT * FROM Foods WHERE 1=1"; // Default query

if ($filter != 'all') {
    $sql .= " AND cousin_types = ?";
}
if (!empty($category)) {
    $sql .= " AND Category = ?";
}

// Prepare the statement
$stmt = $conn->prepare($sql);

if ($filter != 'all' && !empty($category)) {
    $stmt->bind_param("ss", $filter, $category);
} elseif ($filter != 'all') {
    $stmt->bind_param("s", $filter);
} elseif (!empty($category)) {
    $stmt->bind_param("s", $category);
}

$stmt->execute();
$result = $stmt->get_result(); // Get the result set

// Display food items
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card">';
        echo '<img src="images/' . htmlspecialchars($row["Image"]) . '" class="card-img" alt="' . htmlspecialchars($row["Food_Name"]) . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($row["Food_Name"]) . '</h5>';
        echo '<p class="card-text">Price: ' . htmlspecialchars($row["Price"]) . '</p>';
        // Add a form around the "Add to cart" button
        echo '<form method="POST" action="shop.php">';
        echo '<input type="hidden" name="food_id" value="' . $row["FID"] . '">';
        echo '<button type="submit" name="add_to_cart" class="card-btn">Add to cart</button>';
        echo '</form>';
        echo '</div></div>';
    }
} else {
    echo "No food items found."; // Display a message if no items found
}

$stmt->close();
$conn->close(); // Close the database connection
?>
