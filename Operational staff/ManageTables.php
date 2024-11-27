<?php
// Database connection
include 'db_connect.php'; // Make sure this file contains your database connection details

$action = $_GET['action'] ?? '';

if ($action == 'view') {
    // Fetch all tables
    $result = $conn->query("SELECT * FROM tables");
    $tables = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($tables);
    exit;
}

if ($action == 'edit') {
    // Edit specific table
    $tid = $_GET['tid'];
    $stmt = $conn->prepare("SELECT * FROM tables WHERE TID = ?");
    $stmt->bind_param("i", $tid);
    $stmt->execute();
    $result = $stmt->get_result();
    $table = $result->fetch_assoc();
    echo json_encode($table);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Save or update table
    $tid = $_POST['tid'] ?? null;
    $capacity = $_POST['capacity'];
    $location = $_POST['location'];
    $availability = $_POST['availability'];

    if ($tid) {
        // Update existing table
        $stmt = $conn->prepare("UPDATE tables SET Capacity = ?, Location = ?, Availability = ? WHERE TID = ?");
        $stmt->bind_param("isii", $capacity, $location, $availability, $tid);
        $stmt->execute();
        echo "<script>alert('Table updated successfully'); window.location.href = 'ReservationSection.html';</script>";
    } else {
        // Add new table
        $stmt = $conn->prepare("INSERT INTO tables (Capacity, Location, Availability) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $capacity, $location, $availability);
        $stmt->execute();
        echo "<script>alert('Table added successfully'); window.location.href = 'ReservationSection.html';</script>";
    }
    exit;
}

if ($action == 'delete') {
    // Delete specific table
    $tid = $_GET['tid'];
    $stmt = $conn->prepare("DELETE FROM tables WHERE TID = ?");
    $stmt->bind_param("i", $tid);
    $stmt->execute();
    echo "<script>alert('Table deleted successfully'); window.location.href = 'ReservationSection.html';</script>";
    exit;
}
?>
