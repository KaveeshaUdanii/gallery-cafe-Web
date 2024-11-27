<?php
// Check if a session is not already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('db_connect.php'); // Include your database connection

if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];

    // SQL query to fetch food orders for the logged-in user
    $sql = "SELECT f.Food_Name, fo.Quantity, fo.O_date, fo.O_time, fo.Order_Status
            FROM Food_Orders fo
            JOIN Foods f ON fo.FID = f.FID
            WHERE fo.UID = ?"; // Filter by UID

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $uid); // Bind the user ID parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any food orders
    if ($result->num_rows > 0) {
        // Output data for each order
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['Food_Name']) . "</td>
                    <td>" . htmlspecialchars($row['Quantity']) . "</td>
                    <td>" . htmlspecialchars($row['O_date']) . "</td>
                    <td>" . htmlspecialchars($row['O_time']) . "</td>
                    <td>" . htmlspecialchars($row['Order_Status']) . "</td>
                  </tr>";
        }
    } else {
        // No orders found message
        echo "<tr><td colspan='5'>No food orders found.</td></tr>";
    }

    $stmt->close(); // Close the statement
} else {
    echo "<tr><td colspan='5'>You need to log in to view food orders.</td></tr>";
}
?>
