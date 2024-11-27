document.addEventListener("DOMContentLoaded", () => {
    // Update Total Price Function
    function updateTotalPrice() {
        let total = 0;
        let totalQuantity = 0; // Initialize total quantity
        // Loop through each cart item to calculate the total
        document.querySelectorAll('.cart-item').forEach(item => {
            const priceText = item.querySelector('.item-price').textContent; // Get price text
            const price = parseFloat(priceText.replace('$', '').trim()); // Extract price value
            const quantity = parseInt(item.querySelector('.quantity-input').value); // Get quantity
            total += price * quantity; // Add to total
            totalQuantity += quantity; // Add to total quantity
        });

        // Update the total price display
        document.getElementById('total-price').textContent = `$${total.toFixed(2)}`;
        document.getElementById('total-quantity').value = totalQuantity; // Set total quantity in the hidden input
    }


    // Increase or Decrease Quantity
    document.querySelectorAll('.quantity-increase, .quantity-decrease').forEach(button => {
        button.addEventListener('click', function() {
            const fid = this.getAttribute('data-fid'); // Get food ID
            const input = document.querySelector(`.quantity-input[data-fid="${fid}"]`); // Get quantity input
            let quantity = parseInt(input.value); // Get current quantity

            // Update quantity based on button clicked
            if (this.classList.contains('quantity-increase')) {
                quantity++;
            } else if (this.classList.contains('quantity-decrease') && quantity > 1) {
                quantity--;
            }

            // Visually update the quantity field
            input.value = quantity; 
            input.setAttribute("value", quantity);  // Ensure the 'value' attribute in DOM gets updated
            
            updateTotalPrice(); // Recalculate total price
        });
    });

    // Remove Item
    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const item = this.closest('.cart-item'); // Get the parent cart item
            item.remove(); // Remove the item from the DOM
            updateTotalPrice(); // Recalculate total price
        });
    });

    

    // Confirm Order Logic
    document.getElementById('confirm-order').addEventListener('click', function(event) {
        const orderDate = document.getElementById('delivery-date').value; // Get order date
        const orderTime = document.getElementById('delivery-time').value; // Get order time

        // Check if date and time are selected
        if (!orderDate || !orderTime) {
            alert("Please select both date and time.");
            event.preventDefault(); // Prevent form submission if date or time is missing
            return;
        }

        // Form will automatically be submitted now, due to the button being type="submit"
    });

    updateTotalPrice(); // Initial total price calculation
});

