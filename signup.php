<?php
// Include database connection
include 'db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['User_Name'];
    $email = $_POST['Email'];
    $password = $_POST['Password']; // Hashing the password
    $contact_no = $_POST['Contact_No'];
    $user_type = $_POST['User_Type'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (User_Name, Email, Password, Contact_No, User_Type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $password, $contact_no, $user_type);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
        // Optionally, redirect to login page or show success message
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
