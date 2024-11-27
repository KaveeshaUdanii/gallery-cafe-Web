<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "gallery_cafe_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total reservations by location (Indoor/Outdoor)
$reservationsByLocationQuery = "SELECT Location, COUNT(*) AS total_reservations FROM Reservations JOIN tables ON Reservations.TID = tables.TID GROUP BY Location";
$reservationsByLocationResult = $conn->query($reservationsByLocationQuery);

// Fetch total parking bookings by status
$totalParkingBookingsQuery = "SELECT Parking_Bookings_Status, COUNT(*) AS total_parkings FROM Parking_Bookings GROUP BY Parking_Bookings_Status";
$totalParkingBookingsResult = $conn->query($totalParkingBookingsQuery);

// Fetch food sales by category (4 specific categories)
$foodSalesQuery = "SELECT cousin_types, COUNT(*) AS total_sales FROM Food_Orders JOIN Foods ON Food_Orders.FID = Foods.FID WHERE cousin_types IN ('Sri Lankan', 'Chinese', 'Italian', 'Thailand') GROUP BY cousin_types";
$foodSalesResult = $conn->query($foodSalesQuery);

// Fetch table availability (new chart)
$tablesAvailabilityQuery = "SELECT Location, COUNT(*) AS total_available FROM tables WHERE Availability = 1 GROUP BY Location";
$tablesAvailabilityResult = $conn->query($tablesAvailabilityQuery);

// Fetch recent food orders (new chart)
$recentOrdersQuery = "SELECT O_date, COUNT(*) AS total_orders FROM Food_Orders GROUP BY O_date ORDER BY O_date DESC LIMIT 7";
$recentOrdersResult = $conn->query($recentOrdersQuery);

// Fetch total revenue overview (new chart)
$totalRevenueQuery = "SELECT SUM(Price * Quantity) AS total_revenue FROM Food_Orders JOIN Foods ON Food_Orders.FID = Foods.FID";
$totalRevenueResult = $conn->query($totalRevenueQuery);
$totalRevenue = $totalRevenueResult->fetch_assoc()['total_revenue'];

// Fetch new user registrations for growth (new chart)
$userGrowthQuery = "SELECT DATE(created_at) AS reg_date, COUNT(*) AS total_users FROM Users GROUP BY reg_date ORDER BY reg_date DESC LIMIT 7";
$userGrowthResult = $conn->query($userGrowthQuery);

// Fetch top 5 selling foods (new chart)
$topFoodsQuery = "SELECT Food_Name, COUNT(*) AS total_sales FROM Food_Orders JOIN Foods ON Food_Orders.FID = Foods.FID GROUP BY Food_Name ORDER BY total_sales DESC LIMIT 5";
$topFoodsResult = $conn->query($topFoodsQuery);

// Total Orders Query
$totalOrdersQuery = "SELECT COUNT(*) as total_orders FROM Food_Orders";
$totalOrdersResult = $conn->query($totalOrdersQuery);
$totalOrders = $totalOrdersResult->fetch_assoc()['total_orders'];

// Fetch total reservations count
$totalReservationsQuery = "SELECT COUNT(*) AS total_reservations FROM Reservations";
$totalReservationsResult = $conn->query($totalReservationsQuery);
$totalReservations = $totalReservationsResult->fetch_assoc()['total_reservations'];

// Fetch total parking bookings count
$totalParkingBookingsQuery = "SELECT COUNT(*) AS total_parking_bookings FROM Parking_Bookings";
$totalParkingBookingsResult = $conn->query($totalParkingBookingsQuery);
$totalParkingBookings = $totalParkingBookingsResult->fetch_assoc()['total_parking_bookings'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <!-- Main Navigation Menu -->
        <nav id="main-nav">
            <div class="navbar-container">
                <a class="navbar-brand" href="#">Gallery Café</a>
                <!-- Menu Toggle Button (Hamburger Icon) -->
                <button class="menu-toggle" id="menu-toggle" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>
                <!-- Navigation Menu Links -->
                <ul class="nav-menu" id="nav-menu">
                    <li><a href="dashboard.php">DASHBOAD</a></li>
                    <li><a href="FoodSection.html">FOOD SECTION</a></li>
                    <li><a href="ReservationSection.html">RESERVATION SECTION</a></li>
                    <li><a href="VehicleSection.html">VEHICLE SECTION</a></li>
                    <!-- Logout Button -->
                    <li><a href="logout.php" id="logout-icon" aria-label="Logout">
                        <img src="logout.png" alt="Logout Icon" class="nav-icon">
                    </a></li> <!-- Unique ID for logout -->
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1>Dashboard</h1>

        <!-- Stat overview section -->
        <div class="stats-overview">
            <div class="stat-item">
                <h3>Total Revenue</h3>
                <p>$<?php echo number_format($totalRevenue, 2); ?></p>
            </div>
            <div class="stat-item">
                <h3>Total Reservations</h3>
                <p><?php echo $totalReservations; ?></p>
            </div>
            <div class="stat-item">
                <h3>Total Parking Bookings</h3>
                <p><?php echo $totalParkingBookings; ?></p>
            </div>
            <div class="stat-item">
                <h3>Total Orders</h3>
                <p><?php echo $totalOrders; ?></p>
            </div>
        </div>

        <!-- Main row for charts -->
        <div class="charts-row">
            <div class="chart-container">
                <h3>Reservations (Indoor/Outdoor)</h3>
                <canvas id="reservationsBarChart"></canvas>
            </div>
            <div class="chart-container">
                <h3>Total Parking Bookings</h3>
                <canvas id="parkingPieChart" width="400" height="400"></canvas>
            </div>
            <div class="chart-container">
                <h3>Food Sales by Category</h3>
                <canvas id="foodSalesBarChart"></canvas>
            </div>
            <div class="chart-container">
                <h3>Top 5 Selling Foods</h3>
                <canvas id="topFoodsPieChart"></canvas>
            </div>
            <div class="chart-container">
                <h3>Table Availability (Indoor/Outdoor)</h3>
                <canvas id="tablesAvailabilityChart"></canvas>
            </div>
            <div class="chart-container">
                <h3>Recent Food Orders (Last 7 Days)</h3>
                <canvas id="recentOrdersChart"></canvas>
            </div>
            <div class="chart-container">
                <h3>User Growth (Last 7 Days)</h3>
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>
    </div>


    <!-- Load JavaScript for Charts -->
    <script>
        // Reservations Data (Indoor/Outdoor)
        const reservationsData = {
            labels: [
                <?php while ($row = $reservationsByLocationResult->fetch_assoc()) {
                    echo "'" . $row['Location'] . "',";
                } ?>
            ],
            datasets: [{
                label: 'Total Reservations',
                data: [
                    <?php
                    $reservationsByLocationResult->data_seek(0); // Reset result pointer
                    while ($row = $reservationsByLocationResult->fetch_assoc()) {
                        echo $row['total_reservations'] . ",";
                    } ?>
                ],
                backgroundColor: ['#4caf50', '#ff6384'] // Green for Indoor, Red for Outdoor
            }]
        };

        // Parking Bookings Pie Chart
        const parkingData = {
            labels: ['Confirmed', 'Pending'],
            datasets: [{
                data: [
                    <?php while ($row = $totalParkingBookingsResult->fetch_assoc()) {
                        echo $row['total_parkings'] . ",";
                    } ?>
                ],
                backgroundColor: ['#4caf50', '#ff6384'] // Green for Confirmed, Red for Pending
            }]
        };

        // Food Sales by Category
        const foodSalesData = {
            labels: ['Sri Lankan', 'Chinese', 'Italian', 'Thailand'],
            datasets: [{
                label: 'Total Sales',
                data: [
                    <?php while ($row = $foodSalesResult->fetch_assoc()) {
                        echo $row['total_sales'] . ",";
                    } ?>
                ],
                backgroundColor: ['#ffce56', '#36a2eb', '#ff6384', '#4bc0c0'] // Different colors for categories
            }]
        };

        // Top Selling Foods Pie Chart
        const topFoodsData = {
            labels: [
                <?php while ($row = $topFoodsResult->fetch_assoc()) {
                    echo "'" . $row['Food_Name'] . "',";
                } ?>
            ],
            datasets: [{
                data: [
                    <?php
                    $topFoodsResult->data_seek(0); // Reset result pointer
                    while ($row = $topFoodsResult->fetch_assoc()) {
                        echo $row['total_sales'] . ",";
                    } ?>
                ],
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff'] // Colors for top 5 foods
            }]
        };

        // Tables Availability
        const tablesAvailabilityData = {
            labels: [
                <?php while ($row = $tablesAvailabilityResult->fetch_assoc()) {
                    echo "'" . $row['Location'] . "',";
                } ?>
            ],
            datasets: [{
                label: 'Available Tables',
                data: [
                    <?php
                    $tablesAvailabilityResult->data_seek(0); // Reset result pointer
                    while ($row = $tablesAvailabilityResult->fetch_assoc()) {
                        echo $row['total_available'] . ",";
                    } ?>
                ],
                backgroundColor: ['#4caf50', '#ff6384'] // Green for Indoor, Red for Outdoor
            }]
        };

        // Recent Orders
        const recentOrdersData = {
            labels: [
                <?php while ($row = $recentOrdersResult->fetch_assoc()) {
                    echo "'" . $row['O_date'] . "',";
                } ?>
            ],
            datasets: [{
                label: 'Total Orders',
                data: [
                    <?php
                    $recentOrdersResult->data_seek(0); // Reset result pointer
                    while ($row = $recentOrdersResult->fetch_assoc()) {
                        echo $row['total_orders'] . ",";
                    } ?>
                ],
                backgroundColor: '#36a2eb' // Blue for recent orders
            }]
        };

        // User Growth
        const userGrowthData = {
            labels: [
                <?php while ($row = $userGrowthResult->fetch_assoc()) {
                    echo "'" . $row['reg_date'] . "',";
                } ?>
            ],
            datasets: [{
                label: 'Total Users Registered',
                data: [
                    <?php
                    $userGrowthResult->data_seek(0); // Reset result pointer
                    while ($row = $userGrowthResult->fetch_assoc()) {
                        echo $row['total_users'] . ",";
                    } ?>
                ],
                backgroundColor: '#4bc0c0' // Green for user growth
            }]
        };

        // Render Charts
        const ctxReservations = document.getElementById('reservationsBarChart').getContext('2d');
        new Chart(ctxReservations, {
            type: 'bar',
            data: reservationsData,
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        const ctxParking = document.getElementById('parkingPieChart').getContext('2d');
        new Chart(ctxParking, {
            type: 'pie',
            data: parkingData
        });

        const ctxFoodSales = document.getElementById('foodSalesBarChart').getContext('2d');
        new Chart(ctxFoodSales, {
            type: 'bar',
            data: foodSalesData,
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        const ctxTopFoods = document.getElementById('topFoodsPieChart').getContext('2d');
        new Chart(ctxTopFoods, {
            type: 'pie',
            data: topFoodsData
        });

        const ctxTablesAvailability = document.getElementById('tablesAvailabilityChart').getContext('2d');
        new Chart(ctxTablesAvailability, {
            type: 'bar',
            data: tablesAvailabilityData,
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        const ctxRecentOrders = document.getElementById('recentOrdersChart').getContext('2d');
        new Chart(ctxRecentOrders, {
            type: 'line',
            data: recentOrdersData,
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        const ctxUserGrowth = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(ctxUserGrowth, {
            type: 'line',
            data: userGrowthData,
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

</body>
</html>
