<?php
// Include database connection
include('db_connect.php');

// Function to display the table
if (isset($_GET['action']) && $_GET['action'] == 'view_foods') {
    displayFoodTable($conn);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for adding/editing food
    if (isset($_POST['fid'])) { // Update food
        $fid = $_POST['fid'];
        $food_name = $_POST['food-name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $cuisine_type = $_POST['cuisine-type'];
        $image = $_POST['food-image'];

        // SQL query to update food in the foods table
        $sql = "UPDATE Foods SET Food_Name='$food_name', Price='$price', Category='$category', cousin_types='$cuisine_type', Image='$image' WHERE FID='$fid'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Food updated successfully');
                    window.location.href = 'FoodSection.php';
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete_fid'])) { // Delete food
        $delete_fid = $_POST['delete_fid'];
        $sql = "DELETE FROM Foods WHERE FID='$delete_fid'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Food deleted successfully');
                    window.location.href = 'FoodSection.php';
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }  
         
    } else { // Add new food
        $food_name = $_POST['food-name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $cuisine_type = $_POST['cuisine-type'];
        $image = $_POST['food-image'];

        // SQL query to insert new food into the foods table
        $sql = "INSERT INTO Foods (Food_Name, Price, Category, cousin_types, Image) 
                VALUES ('$food_name', '$price', '$category', '$cuisine_type', '$image')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Food added successfully');
                    window.location.href = 'FoodSection.php';
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

function displayFoodTable($conn) {
    // SQL query to get all the foods
    $sql = "SELECT * FROM Foods";
    $result = mysqli_query($conn, $sql);

    // Generate table rows dynamically
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['FID']}</td>
                    <td>{$row['Food_Name']}</td>
                    <td>{$row['Price']}</td>
                    <td>{$row['Category']}</td>
                    <td>{$row['cousin_types']}</td>
                    <td><img src='{$row['Image']}' alt='{$row['Food_Name']}' style='width: 50px; height: 50px;'></td>
                    <td class='actions'>
                        <button onclick='editFood({$row['FID']}, \"{$row['Food_Name']}\", {$row['Price']}, \"{$row['Category']}\", \"{$row['cousin_types']}\", \"{$row['Image']}\")'>Edit</button>
                        <form action='FoodSection.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='delete_fid' value='{$row['FID']}'>
                            <button type='submit' onclick='return confirm(\"Are you sure you want to delete this food item?\");'>Delete</button>
                        </form>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No foods found</td></tr>";
    }
}
