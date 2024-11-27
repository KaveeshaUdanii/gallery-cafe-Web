<?php
include 'db_connect.php';  // Include your database connection file

if ($conn) {
    echo "Connection successful!";
} else {
    echo "Connection failed: " . mysqli_connect_error();
}

$conn->close();  // Close the connection
?>
