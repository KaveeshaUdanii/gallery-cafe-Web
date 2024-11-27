<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>
    <link rel="stylesheet" href="Cart.css">
</head>
<body>
    

    <!-- Cart Section -->
    <section class="cart-container">
        <div class="cart-header">
            <h1>Your Shopping Cart</h1>
        </div>
        
        <div class="cart-items" id="cart-items">
            <!-- Dynamically populated cart items -->
            <?php
            session_start(); // Start the session

            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    echo '<div class="cart-item">';
                    echo '<div class="cart-item-info">';
                    echo '<img src="images/' . htmlspecialchars($item['image']) . '" alt="' . htmlspecialchars($item['name']) . '" class="item-image">';
                    echo '<div class="item-details">';
                    echo '<h3>' . htmlspecialchars($item['name']) . '</h3>';
                    echo '<p class="item-price">$' . htmlspecialchars($item['price']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="item-quantity">';
                    echo '<button class="quantity-decrease" data-fid="' . $item['id'] . '">-</button>';
                    echo '<input type="text" value="' . $item['quantity'] . '" class="quantity-input" data-fid="' . $item['id'] . '" readonly>';
                    echo '<button class="quantity-increase" data-fid="' . $item['id'] . '">+</button>';
                    echo '</div>';
                    echo '<div class="remove-item">';
                    echo '<button class="remove-item-btn" data-fid="' . $item['id'] . '">Remove</button>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Your cart is empty.</p>'; // Message when cart is empty
            }
            ?>
        </div>
        
        <!-- Form for Order Confirmation -->
        <form method="POST" action="eshop.php" id="order-form">
            <!-- Date and Time Selection Section -->
            <div class="date-time-selection">
                <h3>Select Date and Time for Delivery/Pickup</h3>
                <input type="date" id="delivery-date" name="order_date" required>
                <input type="time" id="delivery-time" name="order_time" required>
            </div>

            <div class="cart-summary">
                <div class="total-price">
                    <h3>Total Price: <span id="total-price">$0.00</span></h3>
                </div>
                <div class="cart-actions">
                    <input type="hidden" id="total-quantity" name="total_quantity" value="0"> <!-- Total quantity input -->
                    <button type="submit" name="confirm_order" id="confirm-order" class="confirm-btn">Confirm Order</button>
                </div>
            </div>
        </form>
    </section>



    <script src="Cart.js"></script>

</body>
</html>