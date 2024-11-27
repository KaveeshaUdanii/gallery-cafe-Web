<?php
session_start();
include('db_connect.php'); // Include database connection

if (!isset($_SESSION['uid'])) {
    // User not logged in, redirect to login page
    echo "<script>
            alert('Please log in to make a reservation.');
            window.location.href = 'user.html';
          </script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $uid = $_SESSION['uid']; // Get logged in user's UID from session
    $tid = 1; 
    $no_of_persons = $_POST['persons'];
    $r_date = $_POST['date'];
    $r_time = $_POST['time'];
    $reservation_status = 'Pending'; // Initial status

    // Prepare SQL statement to insert reservation
    $sql = "INSERT INTO reservations (UID, TID, No_Of_Persons, R_date, R_time, Reservation_Status) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiisss", $uid, $tid, $no_of_persons, $r_date, $r_time, $reservation_status);

    // Execute the query
    if ($stmt->execute()) {
        // Success, reservation added
        echo "<script>
                alert('Reservation placed successfully!');
                window.location.href = 'Reservations.html';
              </script>";
    } else {
        // Failure, reservation not added
        echo "<script>
                alert('Error: Could not place reservation.');
                window.history.back();
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
