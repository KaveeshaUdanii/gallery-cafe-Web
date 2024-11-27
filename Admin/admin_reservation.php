<?php
// Database connection
require 'db_connect.php'; // Ensure this file contains your database connection logic

// Handle adding a new table
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['capacity']) && isset($_POST['location'])) {
    $capacity = $_POST['capacity'];
    $location = $_POST['location'];

    // Insert the new table into the database
    $sql = "INSERT INTO Tables (Capacity, Location, Availability) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $availability = 1; // Assuming 1 means available
    $stmt->bind_param("isi", $capacity, $location, $availability);
    $stmt->execute();
    $stmt->close();
}

// Handle confirming a reservation
if (isset($_POST['confirm_reservation_id'])) {
    $reservationId = $_POST['confirm_reservation_id'];

    // Update the reservation status in the database
    $sql = "UPDATE Reservations SET Reservation_Status='Confirmed' WHERE RID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reservationId);
    $stmt->execute();
    $stmt->close();
}

// Handle deleting a table
if (isset($_POST['delete_table_id'])) {
    $tableId = $_POST['delete_table_id'];

    // Delete the table from the database
    $sql = "DELETE FROM Tables WHERE TID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tableId);
    $stmt->execute();
    $stmt->close();
}

// Handle deleting a reservation
if (isset($_POST['delete_reservation_id'])) {
    $reservationId = $_POST['delete_reservation_id'];

    // Delete the reservation from the database
    $sql = "DELETE FROM Reservations WHERE RID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reservationId);
    $stmt->execute();
    $stmt->close();
}





//============================================================================================================================
// Function to display the tables
if (isset($_GET['action']) && $_GET['action'] == 'view_tables') {
    displayTableData($conn);
}

// Function to fetch and display table data
function displayTableData($conn) {
    // SQL query to get all the tables
    $sql = "SELECT * FROM Tables";
    $result = mysqli_query($conn, $sql);

    // Generate table rows dynamically
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $availability = $row['Availability'] ? 'Available' : 'Not Available';
            echo "<tr>
                    <td>{$row['TID']}</td>
                    <td>{$row['Capacity']}</td>
                    <td>{$row['Location']}</td>
                    <td>{$availability}</td>
                    <td class='actions'>
                        <button onclick='editTable({$row['TID']}, {$row['Capacity']}, \"{$row['Location']}\", \"{$row['Availability']}\")'>Edit</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No tables found</td></tr>";
    }
}
