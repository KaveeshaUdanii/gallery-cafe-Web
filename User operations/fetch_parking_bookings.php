<?php
// Check if a session is not already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('db_connect.php');

if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];

    // Retrieve parking bookings
    $parkingSql = "SELECT P_date, P_time, No_Of_Vehicles, Vehicle_Number, Parking_Bookings_Status
                   FROM parking_bookings
                   WHERE UID = ?";
    $stmt = $conn->prepare($parkingSql);
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $parkingResult = $stmt->get_result();

    if ($parkingResult->num_rows > 0) {
        while ($row = $parkingResult->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['P_date']}</td>
                    <td>{$row['P_time']}</td>
                    <td>{$row['No_Of_Vehicles']}</td>
                    <td>{$row['Vehicle_Number']}</td>
                    <td>{$row['Parking_Bookings_Status']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No parking bookings found.</td></tr>";
    }

    $stmt->close();
} else {
    echo "<tr><td colspan='5'>You need to log in to view parking bookings.</td></tr>";
}
?>
