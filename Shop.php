<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery cafe shop</title>
    <link rel="stylesheet" href="Shop.css">
</head>

<body>
    <header>
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="navbar-container">
                <a class="navbar-brand" href="#">Gallery Café</a>
                <div class="search-container">
                    <h4>Free Delievery</h4> 
                </div>
            </div>
        </div>

        
        <!-- Main Navigation Menu -->
        <nav id="main-nav">
            <div class="navbar-container">
                <!-- Menu Toggle Button (Hamburger Icon) -->
                <button class="menu-toggle" id="menu-toggle" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>
                <!-- Navigation Menu Links -->
                <ul class="nav-menu" id="nav-menu">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="About.html">About Us</a></li>
                    <li><a href="Menu.html">Menu</a></li>
                    <li><a href="Reservations.html">Reservations</a></li>
                    <li><a href="Promotions.html">Event & Promotions</a></li>
                    <li><a href="Shop.php">Shop</a></li>
                    <li><a href="Contact.html">Contact Us</a></li>
                    <li><a href="CartInterface.php" id="cart-icon" aria-label="Cart">
                        <img src="images/cart-shopping-solid.svg" alt="Cart Icon" class="nav-icon">
                    </a></li>
                    <li><a href="user.html" id="user-icon" aria-label="User Page">
                        <img src="images/user-large-solid.svg" alt="User Icon" class="nav-icon">
                    </a></li>
                </ul>
            </div>
        </nav>
    </header>
    
    <section class="intro-section">
        <div class="container">
            <h1>E-SHOP</h1>
        </div>
    </section>


    <section id="menu-section">
        <div class="container text-center">
            <h2 style="text-align: center;">Explore Our Menu</h2>

            <!-- Cuisine Type Buttons -->
            <div class="cuisine-buttons">
                <form method="POST" action="shop.php"> <!-- Ensure the action points to the same page -->
                    <button type="submit" name="filter" value="all" class="cuisine-btn">All</button>
                    <button type="submit" name="filter" value="sri lankan" class="cuisine-btn">Sri Lankan</button>
                    <button type="submit" name="filter" value="chinese" class="cuisine-btn">Chinese</button>
                    <button type="submit" name="filter" value="italian" class="cuisine-btn">Italian</button>
                    <button type="submit" name="filter" value="thailand" class="cuisine-btn">Thailand</button>
                </form>
            </div>

            <div class="menu-content">
                <div class="sidebar">
                    <form method="POST" action="shop.php"> <!-- Ensure the action points to the same page -->
                        <button type="submit" name="category" value="Hot Beverages" class="side-btn">Hot Beverages</button>
                        <button type="submit" name="category" value="Cool Beverages" class="side-btn">Cool Beverages</button>
                        <button type="submit" name="category" value="Sweets" class="side-btn">Sweets</button>
                        <button type="submit" name="category" value="Short Eats" class="side-btn">Short Eats</button>
                    </form>
                </div>

                <div class="food-items" id="food-items">
                    <?php include 'eshop.php'; ?> <!-- PHP file to fetch and display food items -->
                </div>
            </div>
        </div>
    </section>

        
    

    <script src="script.js"></script>
</body>
</html>
