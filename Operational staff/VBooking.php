<?php
// Include database connection
include('db_connect.php');

// Function to display the bookings table
function displayBookingsTable($conn) {
    // SQL query to fetch data from Parking_Bookings
    $sql = "SELECT PBID, UID, PID, No_Of_Vehicles, Vehicle_Number, P_date, P_time, Parking_Bookings_Status FROM Parking_Bookings";
    $result = mysqli_query($conn, $sql);

    // Check if there are any rows
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['PBID'] . "</td>";
            echo "<td>" . $row['UID'] . "</td>";
            echo "<td>" . $row['PID'] . "</td>";
            echo "<td>" . $row['No_Of_Vehicles'] . "</td>";
            echo "<td>" . $row['Vehicle_Number'] . "</td>";
            echo "<td>" . $row['P_date'] . "</td>";
            echo "<td>" . $row['P_time'] . "</td>";
            echo "<td>" . $row['Parking_Bookings_Status'] . "</td>";
            echo "<td>";

            // If the booking status is pending, display a confirm button or similar actions
            if ($row['Parking_Bookings_Status'] == 'Pending') {
                echo "<form method='post' action='VBooking.php' style='display:inline-block;'>
                        <input type='hidden' name='confirm_booking_id' value='" . $row['PBID'] . "' />
                        <button type='submit' class='btn btn-success'>Confirm</button>
                      </form>";
            } else {
                echo "<span class='confirmed-status'>Confirmed</span>";
            }

            // Delete button for all bookings
            echo "<form method='post' action='VBooking.php' style='display:inline-block;'>
                    <input type='hidden' name='delete_booking_id' value='" . $row['PBID'] . "' />
                    <button type='submit' class='btn btn-danger'>Delete</button>
                  </form>";

            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No bookings found.</td></tr>";
    }
}

// Handle POST requests for confirming and deleting bookings
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Confirm booking handling
    if (isset($_POST['confirm_booking_id'])) {
        $confirm_id = $_POST['confirm_booking_id'];
        $sql = "UPDATE Parking_Bookings SET Parking_Bookings_Status='Confirmed' WHERE PBID='$confirm_id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Booking confirmed successfully');
                    window.location.href = 'VehicleSection.html'; // Redirect to the desired page
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Delete booking handling
    if (isset($_POST['delete_booking_id'])) {
        $delete_id = $_POST['delete_booking_id'];
        $sql = "DELETE FROM Parking_Bookings WHERE PBID='$delete_id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Booking deleted successfully');
                    window.location.href = 'VehicleSection.html'; // Redirect to the desired page
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Handle GET requests to view bookings
if (isset($_GET['action']) && $_GET['action'] == 'view_bookings') {
    displayBookingsTable($conn);
}
?>
