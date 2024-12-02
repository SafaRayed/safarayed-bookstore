<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
    <blockquote>
         <img src="image/logo.png"  alt="Logo">
        </blockquote>
      
    <!-- Navigation Links -->
    <nav class="navbar">
        <ul>
            <li><a href="home.php" class="nav-link">Home</a></li>
            <li><a href="book.php" class="nav-link">Bookstore</a></li>
            <li><a href="register.php" class="nav-link">Register</a></li>
            <li><a href="login.php" class="nav-link">Login</a></li>
            <li><a href="editprofile.php" class="nav-link">Edit Profile</a></li>

        </ul>
    </nav>
    </header>
    <div class="login">
        <div class="login-header">
            <h2>Login</h2>
        </div>

        <form action="login.php" method="POST">
            <label for="username"></label>
            <input type="text" name="username" class="input-username" required placeholder="Username"><br><br>
    
            <label for="pwd"></label>
            <input type="password" name="pwd" class="input-password" required placeholder="Password"><br><br>
    
            <input class="button" type="submit" value="Login">
            <input class="button" type="button" value="Cancel" onClick="window.location='index.php';">
            
            <div class="additional-links">
                <a href="#">Forgot password?</a> | 
                <a href="register.php">Don't have an account? Register</a>
            </div>
        </form>
    </div>
    <script scr="app.js"> </script>
    <?php
    session_start(); // Start session

    require_once 'connection.php'; // Include the database connection file

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve input from the form safely using POST
        $u = $_POST['username'] ?? null;
        $pwd = $_POST['pwd'] ?? null;

        if ($u && $pwd) {
            // Query to check user credentials
            $query = "SELECT * FROM customer WHERE username='$u' AND password='$pwd'";
            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                // Fetch the user data from the query result
                $user = mysqli_fetch_assoc($result);
                
                // If user exists, start a session and save user ID
                $_SESSION['isloggedin'] = 1;
                $_SESSION['user_id'] = $user['id']; // Save user ID in the session

                header('Location: book.php'); // Redirect to book page after successful login
                exit();
            } else {
                // If login fails, redirect with an error message
                header('Location: login.php?error=invalid_credentials');
                exit();
            }
        } else {
            // If fields are missing, redirect back with an error
            header('Location: login.php?error=missing_fields');
            exit();
        }
    }
    ?>
</body>
</html>
