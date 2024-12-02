<?php
require_once 'connection.php'; // Include the database connection file

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $fullName = isset($_POST['fullName']) ? trim($_POST['fullName']) : '';
    $userName = isset($_POST['userName']) ? trim($_POST['userName']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $mobileNumber = isset($_POST['mobileNumber']) ? trim($_POST['mobileNumber']) : '';
    $icNumber = isset($_POST['icNumber']) ? trim($_POST['icNumber']) : '';
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';

    // Check if all fields are filled
    if (empty($fullName) || empty($userName) || empty($password) || empty($email) ||
        empty($mobileNumber) || empty($icNumber) || empty($gender) || empty($address)) {
        header('Location: register.php?error=empty_fields');
        exit();
    }

    // Sanitize data for database
    $fullName = mysqli_real_escape_string($con, $fullName);
    $userName = mysqli_real_escape_string($con, $userName);
    $password = mysqli_real_escape_string($con, $password);
    $email = mysqli_real_escape_string($con, $email);
    $mobileNumber = mysqli_real_escape_string($con, $mobileNumber);
    $icNumber = mysqli_real_escape_string($con, $icNumber);
    $gender = mysqli_real_escape_string($con, $gender);
    $address = mysqli_real_escape_string($con, $address);

    // Insert the data into the database
    $query = "INSERT INTO customer (full_name, email, mobile_number, ic_number, gender, address, username, password) 
              VALUES ('$fullName', '$email', '$mobileNumber', '$icNumber', '$gender', '$address', '$userName', '$password')";

    if (mysqli_query($con, $query)) {
        // Start a session and store a success message
        session_start();
        $_SESSION['isregistered'] = 1;
        $_SESSION['username'] = $fullName;

        // Redirect to login page with success flag
        header('Location: login.php?success=registered');
        exit();
    } else {
        // Redirect back to the registration page with an error flag
        header('Location: register.php?error=insert_failed');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="logo-container">
        <a href="index.html"><img src="image/logo.png" alt="Logo" class="logo"></a>
    </div>
    <!-- Navigation Links -->
    <nav class="navbar">
        <ul>
            <li><a href="home.php" class="nav-link">Home</a></li>
            <li><a href="register.php" class="nav-link">Register</a></li>
            <li><a href="login.php" class="nav-link">Login</a></li>
        </ul>
    </nav>
</header>

<div class="register">
    <!-- Register Header -->
    <div class="register-header">
        <h2>Register</h2>
    </div>

    <!-- Registration Form -->
    <form id="registerForm" method="POST" action="register.php">
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" placeholder="Full Name" required><br>

        <label for="userName">User Name:</label>
        <input type="text" id="userName" name="userName" placeholder="User Name" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password" required><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="example@email.com" required><br>

        <label for="mobileNumber">Mobile Number:</label>
        <input type="text" id="mobileNumber" name="mobileNumber" placeholder="+961" required><br>

        <label for="icNumber">IC Number:</label>
        <input type="text" id="icNumber" name="icNumber" placeholder="Enter your IC Number" required><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" placeholder="Enter your address" required></textarea><br>
<script src="app.js"></script>
        <!-- Error Message -->
        <?php if (isset($_GET['error']) && $_GET['error'] == 'empty_fields') { ?>
            <p class="error-message">Please fill in all fields.</p>
        <?php } ?>
        <?php if (isset($_GET['error']) && $_GET['error'] == 'insert_failed') { ?>
            <p class="error-message">Registration failed. Please try again.</p>
        <?php } ?>

        <!-- Register Button -->
        <button type="submit">Register</button>
    </form>
</div>

<script src="app.js"></script>
</body>
</html>
