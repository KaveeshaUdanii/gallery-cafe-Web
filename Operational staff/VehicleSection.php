<?php
// Include database connection
include('db_connect.php');

// Function to display the table
if (isset($_GET['action']) && $_GET['action'] == 'view_parking') {
    displayParkingTable($conn);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for adding/editing parking
    if (isset($_POST['pid'])) { // Update parking
        $pid = (int)$_POST['pid']; // Cast to int for safety
        $vehicle_space_type = mysqli_real_escape_string($conn, $_POST['vehicle-space-type']);
        $availability = (int)$_POST['availability']; // Ensure this is an integer (1 or 0)

        // Prepare an SQL statement for updating
        $stmt = $conn->prepare("UPDATE Parking SET Vehicle_space_type=?, Availability=? WHERE PID=?");
        $stmt->bind_param("sii", $vehicle_space_type, $availability, $pid);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Parking updated successfully');
                    window.location.href = 'VehicleSection.html';
                  </script>";
        } else {
            error_log("Update error: " . $stmt->error); // Log error instead of echo
            echo "Error updating parking.";
        }
        $stmt->close();

    } elseif (isset($_POST['delete_pid'])) { // Delete parking
        $delete_pid = (int)$_POST['delete_pid']; // Cast to int for safety
        $stmt = $conn->prepare("DELETE FROM Parking WHERE PID=?");
        $stmt->bind_param("i", $delete_pid);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Parking deleted successfully');
                    window.location.href = 'VehicleSection.html';
                  </script>";
        } else {
            error_log("Delete error: " . $stmt->error); // Log error instead of echo
            echo "Error deleting parking.";
        }
        $stmt->close();

    } else { // Add new parking
        $vehicle_space_type = mysqli_real_escape_string($conn, $_POST['vehicle-space-type']);
        $availability = (int)$_POST['availability']; // Ensure this is an integer (1 or 0)

        // Prepare an SQL statement for inserting
        $stmt = $conn->prepare("INSERT INTO Parking (Vehicle_space_type, Availability) VALUES (?, ?)");
        $stmt->bind_param("si", $vehicle_space_type, $availability);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Parking added successfully');
                    window.location.href = 'VehicleSection.html';
                  </script>";
        } else {
            error_log("Insert error: " . $stmt->error); // Log error instead of echo
            echo "Error adding parking.";
        }
        $stmt->close();
    }
}

function displayParkingTable($conn) {
    // SQL query to get all the parking
    $sql = "SELECT * FROM Parking";
    $result = mysqli_query($conn, $sql);

    // Generate table rows dynamically
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $availability = $row['Availability'] ? 'Available' : 'Unavailable';
            echo "<tr>
                    <td>{$row['PID']}</td>
                    <td>{$row['Vehicle_space_type']}</td>
                    <td>{$availability}</td>
                    <td class='actions'>
                        <button onclick='editParking({$row['PID']}, \"{$row['Vehicle_space_type']}\", \"{$row['Availability']}\")'>Edit</button>
                        <form action='VehicleSection.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='delete_pid' value='{$row['PID']}'>
                            <button type='submit' onclick='return confirm(\"Are you sure you want to delete this parking item?\");'>Delete</button>
                        </form>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No parking found</td></tr>";
    }
}
?>
