<?php
session_start();
include('db_connect.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['User_Name'];
    $password = $_POST['Password'];

    // Check if username and password are correct
    $sql = "SELECT * FROM users WHERE User_Name = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful
        $user = $result->fetch_assoc();
        $_SESSION['uid'] = $user['UID']; // Store the UID in the session
        $userType = $user['User_Type']; // Get user type for later redirection

        // Handle pending cart actions
        if (isset($_SESSION['pending_cart_item'])) {
            $food_id = $_SESSION['pending_cart_item'];
            unset($_SESSION['pending_cart_item']); // Clear the pending cart item from session
            header("Location: shop.php?add_to_cart=" . $food_id);
            exit;
        }

        // Handle pending reservation data
        if (isset($_SESSION['reservation_data'])) {
            $reservationData = $_SESSION['reservation_data'];
            $uid = $_SESSION['uid'];
            $pid = 1; // Example parking space ID
            $persons = $reservationData['persons'];
            $vehicleNumber = $reservationData['phone'];
            $p_date = $reservationData['date'];
            $p_time = $reservationData['time'];

            // Insert into Parking_Bookings table
            $sql = "INSERT INTO parking_bookings (UID, PID, No_Of_Vehicles, Vehicle_Number, P_date, P_time, Parking_Bookings_Status)
                    VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiisss", $uid, $pid, $persons, $vehicleNumber, $p_date, $p_time);

            if ($stmt->execute()) {
                // Success, clear session and redirect
                unset($_SESSION['reservation_data']); // Clear the session
                echo "<script>
                        alert('New Parking Space added successfully');
                        window.location.href = 'Reservations.html';
                      </script>";
                exit;
            } else {
                echo "<script>
                        alert('Error: Could not save parking reservation.');
                        window.history.back();
                      </script>";
                exit;
            }
        }

        // Update the Logins column in the users table
        $updateSql = "UPDATE users SET Logins = 1 WHERE UID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $user['UID']);
        $updateStmt->execute();

        // Redirect based on user type
        if ($userType === 'Admin') {
            echo "<script>
                alert('Login successful! Redirecting to Admin Operations.');
                window.location.href = 'Admin/dashboard.php';
                </script>";
        } elseif ($userType === 'Operational Staff') {
            echo "<script>
                alert('Login successful! Redirecting to Operational Staff.');
                window.location.href = 'Operational staff/dashboard.php';
                </script>";
        } elseif ($userType === 'Customer') {
            echo "<script>
                alert('Login successful! Redirecting to User Order Tracker.');
                window.location.href = 'User operations/User_Order_Tracker.php';
                </script>";
        }

    } else {
        // Login failed
        echo "<script>
            alert('Invalid username or password!');
            window.history.back(); // Return to the login form
            </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
