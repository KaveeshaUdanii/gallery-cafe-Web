<?php
// Include database connection
include('db_connect.php');

// Function to display the reservations table
function displayReservationsTable($conn) {
    // SQL query to fetch data from Reservations
    $sql = "SELECT RID, UID, TID, No_Of_Persons, R_date, R_time, Reservation_Status FROM Reservations";
    $result = mysqli_query($conn, $sql);

    // Check if there are any rows
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['RID'] . "</td>";
            echo "<td>" . $row['UID'] . "</td>";
            echo "<td>" . $row['TID'] . "</td>";
            echo "<td>" . $row['No_Of_Persons'] . "</td>";
            echo "<td>" . $row['R_date'] . "</td>";
            echo "<td>" . $row['R_time'] . "</td>";
            echo "<td>" . $row['Reservation_Status'] . "</td>";
            echo "<td>";

            // If the reservation status is pending, display a confirm button or similar actions
            if ($row['Reservation_Status'] == 'Pending') {
                echo "<form method='post' action='ReservationSection.php' style='display:inline-block;'>
                        <input type='hidden' name='confirm_rid' value='" . $row['RID'] . "' />
                        <button type='submit' class='btn btn-success'>Confirm</button>
                      </form>";
            } else {
                echo "<span class='confirmed-status'>Confirmed</span>";
            }

            // Delete button for all reservations
            echo "<form method='post' action='ReservationSection.php' style='display:inline-block;'>
                    <input type='hidden' name='delete_rid' value='" . $row['RID'] . "' />
                    <button type='submit' class='btn btn-danger'>Delete</button>
                  </form>";

            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No reservations found.</td></tr>";
    }
}

// Handle POST requests for confirming and deleting reservations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Confirm reservation handling
    if (isset($_POST['confirm_rid'])) {
        $confirm_rid = $_POST['confirm_rid'];
        $sql = "UPDATE Reservations SET Reservation_Status='Confirmed' WHERE RID='$confirm_rid'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Reservation confirmed successfully');
                    window.location.href = 'ReservationSection.html'; // Redirect to the desired page
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Delete reservation handling
    if (isset($_POST['delete_rid'])) {
        $delete_rid = $_POST['delete_rid'];
        $sql = "DELETE FROM Reservations WHERE RID='$delete_rid'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Reservation deleted successfully');
                    window.location.href = 'ReservationSection.html'; // Redirect to the desired page
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Handle GET requests to view reservations
if (isset($_GET['action']) && $_GET['action'] == 'view_reservations') {
    displayReservationsTable($conn);
}
?>
