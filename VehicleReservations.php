<?php
session_start();
include('db_connect.php'); // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Store form data
    $uid = $_POST['UID']; // UID should come from session, not form
    $persons = $_POST['persons']; // No_Of_Vehicles corresponds to persons in your case
    $vehicleNumber = $_POST['phone']; // This can be used as Vehicle_Number
    $date = $_POST['date'];
    $time = $_POST['time'];
    
    // Check if user is logged in
    if (isset($_SESSION['uid'])) {
        // User is logged in, insert into parking_bookings table
        $logged_in_uid = $_SESSION['uid'];
        $pid = 1; // Example Parking ID, you may want to update this dynamically

        // Insert into Parking_Bookings table
        $sql = "INSERT INTO parking_bookings (UID, PID, No_Of_Vehicles, Vehicle_Number, P_date, P_time, Parking_Bookings_Status)
                VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiisss", $logged_in_uid, $pid, $persons, $vehicleNumber, $date, $time);
        
        if ($stmt->execute()) {
            // Success, show notification and redirect
            echo "<script>
                    alert('Parking booking placed successfully!');
                    window.location.href = 'Reservations.html';
                  </script>";
        } else {
            // Failed to insert
            echo "<script>
                    alert('Failed to place parking booking.');
                    window.history.back();
                  </script>";
        }
        $stmt->close();
    } else {
        // User not logged in, save form data to session and redirect to login page
        $_SESSION['reservation_data'] = $_POST;
        echo "<script>
                alert('Please log in to complete your parking booking.');
                window.location.href = 'Reservations.html';
              </script>";
        exit;
    }
}
?>
