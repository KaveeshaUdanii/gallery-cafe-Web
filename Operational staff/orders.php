<?php
// Include database connection
include('db_connect.php');

// Function to display the orders table
function displayOrdersTable($conn) {
    // SQL query to fetch data from Food_Orders
    $sql = "SELECT OID, UID, FID, Quantity, O_date, O_time, Order_Status FROM Food_Orders";
    $result = mysqli_query($conn, $sql);

    // Check if there are any rows
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['OID'] . "</td>";
            echo "<td>" . $row['UID'] . "</td>";
            echo "<td>" . $row['FID'] . "</td>";
            echo "<td>" . $row['Quantity'] . "</td>";
            echo "<td>" . $row['O_date'] . "</td>";
            echo "<td>" . $row['O_time'] . "</td>";
            echo "<td>" . $row['Order_Status'] . "</td>";
            echo "<td>";

            // If the order status is pending, display the confirm button
            if ($row['Order_Status'] == 'Pending') {
                echo "<form method='post' action='orders.php' style='display:inline-block;'>
                        <input type='hidden' name='confirm_oid' value='" . $row['OID'] . "' />
                        <button type='submit' class='btn btn-success'>Confirm</button><p>    </P>
                      </form>";
            } else {
                echo "<span class='confirmed-status'>Confirmed</span>";
            }

            // Delete button for all orders
            echo "<form method='post' action='orders.php' style='display:inline-block;'>
                    <input type='hidden' name='delete_oid' value='" . $row['OID'] . "' />
                    <button type='submit' class='btn btn-danger'>Delete</button>
                  </form>";

            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No orders found.</td></tr>";
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Confirm order handling
    if (isset($_POST['confirm_oid'])) {
        $confirm_oid = $_POST['confirm_oid'];
        $sql = "UPDATE Food_Orders SET Order_Status='Confirmed' WHERE OID='$confirm_oid'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Order confirmed successfully');
                    window.location.href = 'FoodSection.html';
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Delete order handling
    if (isset($_POST['delete_oid'])) {
        $delete_oid = $_POST['delete_oid'];
        $sql = "DELETE FROM Food_Orders WHERE OID='$delete_oid'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Order deleted successfully');
                    window.location.href = 'FoodSection.html';
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Handle GET requests to view orders
if (isset($_GET['action']) && $_GET['action'] == 'view_orders') {
    displayOrdersTable($conn);
}
?>
