<?php
session_start();
include('db_connect.php'); // Include your database connection file

if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];

    // Update the Logins column in the users table to 0
    $sql = "UPDATE users SET Logins = 0 WHERE UID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    
    // Destroy the session to log the user out
    session_destroy();

    // Redirect to index.html with a JavaScript alert
    echo "<script>
            alert('localhost says: You have successfully logged out!');
            window.location.href = '../index.html';
          </script>";
} else {
    // If no user is logged in, simply redirect to the homepage
    echo "<script>
            window.location.href = '../index.html';
          </script>";
}

$stmt->close();
$conn->close();
?>
