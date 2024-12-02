<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
session_start(); // Start the session

require_once 'connection.php'; // Include the database connection file

// Ensure user is logged in
if (!isset($_SESSION['isloggedin']) || $_SESSION['isloggedin'] != 1) {
    header('Location: login.php');
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add-to-cart'])) {
    // Check if the session has a valid user ID
    if (isset($_SESSION['user_id'])) {
        $customerID = $_SESSION['user_id']; // Get the logged-in user's ID

        // Check if the required POST data exists
        if (isset($_POST['isbn'], $_POST['price'], $_POST['quantity'])) {
            // Sanitize inputs to prevent SQL injection
            $isbn = mysqli_real_escape_string($con, $_POST['isbn']);
            $price = (float)mysqli_real_escape_string($con, $_POST['price']);
            $quantity = (int)$_POST['quantity']; // Ensure quantity is an integer

            // Ensure price and quantity are valid numbers
            if ($price > 0 && $quantity > 0) {
                $totalPrice = $price * $quantity;

                // SQL query to insert the book into the cart table for the logged-in customer
                $sql = "INSERT INTO cart (customerid, bookid, price, quantity, totalprice)
                        VALUES ('$customerID', '$isbn', '$price', '$quantity', '$totalPrice')";

                // Execute query and check for success
                if ($con->query($sql) === TRUE) {
                    // Successful insertion
                    echo "Book added to cart successfully!";
                } else {
                    // Error during query execution
                    echo "Error: " . $con->error;
                }
            } else {
                echo "Invalid price or quantity. Both must be greater than zero.";
            }
        } else {
            echo "Missing required fields: isbn, price, or quantity.";
        }
    } else {
        // If the session doesn't have a valid user_id, redirect to login
        header('Location: login.php');
        exit();
    }
}
}

// Close the database connection
$con->close();
?>


<header>
    <div class="logo-container">
        <a href="home.php"><img src="image/logo.png" alt="Logo" class="logo"></a>
    </div>
    <nav class="navbar">
        <ul>
            <li><a href="home.php" class="nav-link">Home</a></li>
            <li><a href="book.php" class="nav-link">Bookstore</a></li>
            <li><a href="editprofile.php" class="nav-link">Edit Profile</a></li>
        </ul>
    </nav>
</header>

<div class="bookstore-container">
    <div class="book-list">
        <!-- Book 1 -->
        <div class="book">
            <form action="book.php" method="POST">
                <img src="image/9781838696719.jpg" alt="Book Image">
                <div class="details">
                    <p><strong>Title:</strong> Lonely Planet Australia (Travel Guide)</p>
                    <p><strong>ISBN:</strong> 123456</p>
                    <p><strong>Author:</strong> Lonely Planet</p>
                    <p><strong>Type:</strong> Travel</p>
                    <p><strong>Price:</strong> $27.99 USD</p>
                    <div class="quantity-section">
                        <label><strong>Quantity:</strong></label>
                        <input type="number" name="quantity" value="1" min="1">
                    </div>
                    <input type="hidden" name="isbn" value="123456">
                    <input type="hidden" name="price" value="27.99">
                    <input type="hidden" name="title" value="Lonely Planet Australia (Travel Guide)">
                </div>
                <button type="submit" class="add-to-cart" name="add-to-cart">Add to Cart</button>
            </form>
        </div>

        <!-- Book 2 -->
        <div class="book">
            <form action="book.php" method="POST">
                <img src="image/61DKIGMMftL.jpg" alt="Book Image">
                <div class="details">
                    <p><strong>Title:</strong> Crew Resource Management, Second Edition</p>
                    <p><strong>ISBN:</strong> 213456</p>
                    <p><strong>Author:</strong> Barbara Kanki</p>
                    <p><strong>Type:</strong> Technical</p>
                    <p><strong>Price:</strong> $59.00 USD</p>
                    <div class="quantity-section">
                        <label><strong>Quantity:</strong></label>
                        <input type="number" name="quantity" value="1" min="1">
                    </div>
                    <input type="hidden" name="isbn" value="213456">
                    <input type="hidden" name="price" value="59.00">
                    <input type="hidden" name="title" value="Crew Resource Management, Second Edition">
                </div>
                <button type="submit" class="add-to-cart" name="add-to-cart" style="align-self: self-end;">Add to Cart</button>
            </form>
        </div>
        <!-- Book 3 -->
        <div class="book">
            <form action="book.php" method="POST">
                <img src="image/technology.jpg" alt="Book Image">
                <div class="details">
                    <p><strong>Title:</strong> CCNA Routing and Switching 200-125 Official Cert Guide Library</p>
                    <p><strong>ISBN:</strong> 312456</p>
                    <p><strong>Author:</strong> Cisco Press</p>
                    <p><strong>Type:</strong> Technology</p>
                    <p><strong>Price:</strong> $32.00 USD</p>
                    <div class="quantity-section">
                        <label><strong>Quantity:</strong></label>
                        <input type="number" name="quantity" value="1" min="1">
                    </div>
                    <input type="hidden" name="isbn" value="312456">
                    <input type="hidden" name="price" value="32.00">
                    <input type="hidden" name="title" value="CCNA Routing and Switching 200-125 Official Cert Guide Library">
                </div>
                <button type="submit" class="add-to-cart" name="add-to-cart">Add to Cart</button>
            </form>
        </div>

        <!-- Book 4 -->
        <div class="book">
            <form action="book.php" method="POST">
                <img src="image/7152S71OsqL_1000x (1).webp" alt="Book Image">
                <div class="details">
                    <p><strong>Title:</strong> Easy Vegetarian Slow Cooker Cookbook</p>
                    <p><strong>ISBN:</strong> 412356</p>
                    <p><strong>Author:</strong> Rockridge Press</p>
                    <p><strong>Type:</strong> Food</p>
                    <p><strong>Price:</strong> $75.90 USD</p>
                    <div class="quantity-section">
                        <label><strong>Quantity:</strong></label>
                        <input type="number" name="quantity" value="1" min="1">
                    </div>
                    <input type="hidden" name="isbn" value="412356">
                    <input type="hidden" name="price" value="75.90">
                    <input type="hidden" name="title" value="Easy Vegetarian Slow Cooker Cookbook">
                </div>
                <button type="submit" class="add-to-cart" name="add-to-cart">Add to Cart</button>
            </form>
        </div>

        <!-- Book 5 -->
        <div class="book">
            <form action="book.php" method="POST">
                <img src="image/The-Transformative-Power-of-Laughter-Embrace-Joy-and-Positivity-3.webp" alt="Book Image">
                <div class="details">
                    <p><strong>Title:</strong> The Art of Mindful Living: Simple Practices for Everyday Peace</p>
                    <p><strong>ISBN:</strong> 512346</p>
                    <p><strong>Author:</strong> Sarah Lee</p>
                    <p><strong>Type:</strong> Self-help, Personal Development</p>
                    <p><strong>Price:</strong> $59.90 USD</p>
                    <div class="quantity-section">
                        <label><strong>Quantity:</strong></label>
                        <input type="number" name="quantity" value="1" min="1">
                    </div>
                    <input type="hidden" name="isbn" value="512346">
                    <input type="hidden" name="price" value="59.90">
                    <input type="hidden" name="title" value="The Art of Mindful Living: Simple Practices for Everyday Peace">
                </div>
                <button type="submit" class="add-to-cart" name="add-to-cart">Add to Cart</button>
            </form>
        </div>

        <!-- Book 6 -->
        <div class="book">
            <form action="book.php" method="POST">
                <img src="image/XL.jpg" alt="Book Image">
                <div class="details">
                    <p><strong>Title:</strong> Fashion Design</p>
                    <p><strong>ISBN:</strong> 612345</p>
                    <p><strong>Author:</strong> Sandra Burke</p>
                    <p><strong>Type:</strong> Model</p>
                    <p><strong>Price:</strong> $79.00 USD</p>
                    <div class="quantity-section">
                        <label><strong>Quantity:</strong></label>
                        <input type="number" name="quantity" value="1" min="1">
                    </div>
                    <input type="hidden" name="isbn" value="612345">
                    <input type="hidden" name="price" value="79.00">
                    <input type="hidden" name="title" value="Fashion Design">
                </div>
                <button type="submit" class="add-to-cart" name="add-to-cart">Add to Cart</button>
            </form>
        </div>
    </div>
</div>
            <div class="cart-section">
        <div class="cart-header">
            <i class="fa fa-shopping-cart" style="font-size:24px"></i>
            <img src="image/shopping-cart (2).png" alt="Cart Icon" height="20" width="20">
            <h2>Shopping Cart</h2>
        </div>
    
        <!-- Cart Item List -->
        <ul id="cart-list">
            <!-- Items will be dynamically added here -->
        </ul>
    
        <h2>Apply Discount to Your Cart</h2>
    <form method="POST" action="book.php">
        <label for="discount-code">Discount Code:</label>
        <input type="text" id="discount-code" name="discount-code" placeholder="e.g., discount10" required>
        <button type="submit" name="apply-discount">Apply Discount</button>
    </form>

    <p>Total: USD <span id="cart-total">
        <?php 
        // Display the total price after discount (if updated)
        echo isset($updated_total) ? number_format($updated_total, 2) : "0.00"; 
        ?>
    </span></p>
    </div>
    </div>
    <?php
// Database connection (adjust credentials as needed)
require "connection.php";

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to apply a discount.";
    exit();
}

$logged_in_customerid = $_SESSION['user_id']; // Get the logged-in user's ID

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply-discount'])) {
    $discountCode = trim($_POST['discount-code']); // Get the discount code from the form input

    // Validate the discount code format
    if (preg_match('/^discount(\d{1,3})$/', $discountCode, $matches)) {
        $discountValue = intval($matches[1]);

        // Ensure the discount is between 0% and 100%
        if ($discountValue >= 0 && $discountValue <= 100) {
            $discount = $discountValue / 100; // Convert to decimal (e.g., 10% -> 0.1)

            // Fetch the last cart entry for the logged-in user
            $sql = "SELECT cartid, totalprice 
                    FROM cart 
                    WHERE customerid = $logged_in_customerid 
                    ORDER BY cartid DESC 
                    LIMIT 1";

            $result = $con->query($sql);

            if ($result && $row = $result->fetch_assoc()) {
                $cartid = $row['cartid'];
                $current_total = $row['totalprice'];

                // Calculate the new total price after applying the discount
                $current_total *= (1- $discount);

                // Update the total price in the database
                $update_sql = "UPDATE cart 
                               SET totalprice = $current_total 
                               WHERE cartid = $cartid";

                if ($con->query($update_sql) === TRUE) {
                    echo "<p>Discount applied successfully! New total price: USD " . number_format($current_total, 2) . "</p>";
                } else {
                    echo "<p>Error applying discount: " . $con->error . "</p>";
                }
            } else {
                echo "<p>No cart items found for the user.</p>";
            }
        } else {
            echo "<p>Invalid discount value. Must be between 0% and 100%.</p>";
        }
    } else {
        echo "<p>Invalid discount code format. Use 'discount10' to 'discount100'.</p>";
    }
}

$con->close();
?>



<script src="app.js"></script>
</body>
</html>
