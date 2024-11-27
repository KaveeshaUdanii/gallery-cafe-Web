<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Gallery cafe User_Order_Tracter</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="User_Order_Tracker.css">
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
                    <li><a href="../index.html">Home</a></li>
                    <li><a href="../About.html">About Us</a></li>
                    <li><a href="../Menu.html">Menu</a></li>
                    <li><a href="../Reservations.html">Reservations</a></li>
                    <li><a href="../Promotions.html">Event & Promotions</a></li>
                    <li><a href="../Shop.php">Shop</a></li> <!-- New Shop link -->
                    <li><a href="../Contact.html">Contact Us</a></li>
                    <li><a href="../User.html" id="user-icon" aria-label="User Page">
                        <img src="user.png" alt="User Icon" class="nav-icon">
                    </a></li>
                </ul>
            </div>
        </nav>
    </header>

    <?php
        session_start();
        include('db_connect.php'); // Include your database connection

        // Check if the user is logged in
        if (!isset($_SESSION['uid'])) {
            header("Location: user.html"); // Redirect to login if not logged in
            exit();
        }

        // Get the user's UID from the session
        $uid = $_SESSION['uid'];

        // Fetch the user's username from the database
        $userSql = "SELECT User_Name FROM users WHERE UID = ?";
        $stmt = $conn->prepare($userSql);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $userResult = $stmt->get_result();

        // Check if the user exists
        if ($userResult->num_rows > 0) {
            $user = $userResult->fetch_assoc();
            $username = $user['User_Name']; // Store the username
        } else {
            header("Location: user.html"); // Redirect to login if user not found
            exit();
        }

        $stmt->close();
    ?>

    <section class="track-order-section">
        <div class="container">
            <h1>User Order Tracker</h1>
            <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2> <!-- Display the username -->

            <!-- Food Orders Section -->
            <h2>Food Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Food Name</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                        <th>Order Time</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include('fetch_food_orders.php'); ?> <!-- Include PHP to fetch food orders -->
                </tbody>
            </table>

            <!-- Table Reservations Section -->
            <h2>Table Reservations</h2>
            <table>
                <thead>
                    <tr>
                        <th>Reservation Date</th>
                        <th>Reservation Time</th>
                        <th>No. of Persons</th>
                        <th>Reservation Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include('fetch_reservations.php'); ?> <!-- Include PHP to fetch reservations -->
                </tbody>
            </table>

            <!-- Parking Bookings Section -->
            <h2>Parking Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>Parking Date</th>
                        <th>Parking Time</th>
                        <th>No. of Vehicles</th>
                        <th>Vehicle Number</th>
                        <th>Booking Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include('fetch_parking_bookings.php'); ?> <!-- Include PHP to fetch parking bookings -->
                </tbody>
            </table>
        </div>
    </section>




    <script src="script.js"></script>
</body>
</html>