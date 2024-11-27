// JavaScript to toggle between login and sign-up forms
document.getElementById('signup-link').addEventListener('click', function() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('signup-form').style.display = 'block';
    // Clear the notification when switching to signup
    document.getElementById('notification').textContent = '';
});

document.getElementById('login-link').addEventListener('click', function() {
    document.getElementById('login-form').style.display = 'block';
    document.getElementById('signup-form').style.display = 'none';
    // Clear the notification when switching to login
    document.getElementById('notification').textContent = '';
});

// JavaScript for handling form submission and displaying notification
document.getElementById('signupForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    // Form data collection
    const formData = new FormData(this);

    // AJAX request to submit the form
    fetch('signup.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Clear the form fields after successful submission
        document.getElementById('signupForm').reset();

        // Show notification
        document.getElementById('notification').textContent = data;
        document.getElementById('notification').style.color = "green"; // Success message color

        // Request notification permission if not already granted
        if (Notification.permission !== "granted") {
            Notification.requestPermission();
        }

        // Show desktop notification if permission granted
        if (Notification.permission === "granted") {
            window.notification = new Notification("Registration Successful", {
                body: "You have successfully registered! Redirecting to login...",
                icon: "images/success_icon.png" // Optional, add your icon here
            });
        }

        // Redirect back to login form after 3 seconds
        setTimeout(function() {
            document.getElementById('signup-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
            // Clear notification when switching to login form
            document.getElementById('notification').textContent = '';
            if (window.notification) {
                window.notification.close();
            }
        }, 3000); // 3 seconds delay
    })
    .catch(error => {
        document.getElementById('notification').textContent = 'Sign-up failed, please try again.';
        document.getElementById('notification').style.color = "red"; // Error message color
    });
});

// Password validation logic
document.getElementById('password').addEventListener('input', function () {
    const passwordMessage = document.getElementById('password-message');
    const passwordValue = this.value;

    // Check if the password length is less than 8
    if (passwordValue.length < 8) {
        passwordMessage.textContent = "Password must be at least 8 characters long.";
        passwordMessage.classList.add('active');
    } else {
        passwordMessage.textContent = ""; // Clear message if password is valid
        passwordMessage.classList.remove('active');
    }
});



