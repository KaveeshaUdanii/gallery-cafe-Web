<?php
// Check if a session is not already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('db_connect.php');

if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];

    // Retrieve table reservations
    $reservationsSql = "SELECT R_date, R_time, No_Of_Persons, Reservation_Status
                        FROM reservations
                        WHERE UID = ?";
    $stmt = $conn->prepare($reservationsSql);
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $reservationsResult = $stmt->get_result();

    if ($reservationsResult->num_rows > 0) {
        while ($row = $reservationsResult->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['R_date']}</td>
                    <td>{$row['R_time']}</td>
                    <td>{$row['No_Of_Persons']}</td>
                    <td>{$row['Reservation_Status']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No table reservations found.</td></tr>";
    }

    $stmt->close();
} else {
    echo "<tr><td colspan='4'>You need to log in to view table reservations.</td></tr>";
}
?>
