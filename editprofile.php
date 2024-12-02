<?php
session_start(); // Start the session
require_once 'connection.php'; // Include the database connection

// Ensure the user is logged in
if (!isset($_SESSION['isloggedin']) || $_SESSION['isloggedin'] != 1) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in user's ID from the session
$id = $_SESSION['user_id'];

// Retrieve the current user data from the database
$query = "SELECT * FROM customer WHERE id = '$id'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    // If user not found, redirect to login
    header('Location: login.php');
    exit();
}

// Pre-fill form with current user data
$fullName = $user['full_name'];
$username = $user['username'];
$email = $user['email'];
$mobileNumber = $user['mobile_number'];
$icNumber = $user['ic_number'];
$gender = $user['gender'];
$address = $user['address'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $fullName = $_POST['fullName'] ?? '';
    $username = $_POST['userName'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobileNumber = $_POST['mobileNumber'] ?? '';
    $icNumber = $_POST['icNumber'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $address = $_POST['address'] ?? '';

    // Check for empty fields
    if (empty($fullName) || empty($username) || empty($password) || empty($email) || empty($mobileNumber) || empty($icNumber) || empty($gender) || empty($address)) {
        header('Location: editprofile.php?error=empty_fields');
        exit();
    }

    // Update the user's data in the database
    $updateQuery = "UPDATE customer SET 
                    full_name = '$fullName', 
                    username = '$username', 
                    email = '$email', 
                    mobile_number = '$mobileNumber', 
                    ic_number = '$icNumber', 
                    gender = '$gender', 
                    address = '$address', 
                    password = '$password' 
                    WHERE id = '$id'";

    if (mysqli_query($con, $updateQuery)) {
        header('Location: editprofile.php?success=updated');
        exit();
    } else {
        header('Location: editprofile.php?error=update_failed');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <script src="app.js"></script>

    <div class="logo-container">
        <a href="index.html"><img src="image/logo.png" alt="Logo" class="logo"></a>
    </div>
    <nav class="navbar">
        <ul>
            <li><a href="home.php" class="nav-link">Home</a></li>
        </ul>
    </nav>
</header>

<div class="editprofile">
    <div class="editprofile-header">
        <h2>Edit Your Profile</h2>
    </div>

    <form method="POST" action="editprofile.php">
        <label for="fullName">Full Name:</label>
        <input type="text" name="fullName" value="<?php echo htmlspecialchars($fullName); ?>" required><br>

        <label for="userName">User Name:</label>
        <input type="text" name="userName" value="<?php echo htmlspecialchars($username); ?>" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="email">E-mail:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>

        <label for="mobileNumber">Mobile Number:</label>
        <input type="text" name="mobileNumber" value="<?php echo htmlspecialchars($mobileNumber); ?>" required><br>

        <label for="icNumber">IC Number:</label>
        <input type="text" name="icNumber" value="<?php echo htmlspecialchars($icNumber); ?>" required><br>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select><br>

        <label for="address">Address:</label>
        <textarea name="address" required><?php echo htmlspecialchars($address); ?></textarea><br>

        <?php if (isset($_GET['error'])): ?>
            <p class="error-message"><?php echo $_GET['error']; ?></p>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <p class="success-message">Profile updated successfully!</p>
        <?php endif; ?>

        <button type="submit">Save Changes</button>
    </form>
</div>

<div class="profile-summary">
    <h2>Profile Summary</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($fullName); ?></p>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Mobile:</strong> <?php echo htmlspecialchars($mobileNumber); ?></p>
    <p><strong>IC Number:</strong> <?php echo htmlspecialchars($icNumber); ?></p>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></p>
    <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($address)); ?></p>
</div>

</body>
</html>
