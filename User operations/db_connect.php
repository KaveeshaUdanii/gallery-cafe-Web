<?php
$servername = "localhost";
$username = "root";
$password = "";  // Leave blank for default
$dbname = "Gallery_Cafe_DB";  // The database you created in phpMyAdmin

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


/*
// Check connection
if ($conn->connect_error) {
    // Error message if connection fails
    die("Connection failed: " . $conn->connect_error);
} else {
    // Success message if connection is established
    echo "Connected successfully to the database: $dbname";
}*/
?>

