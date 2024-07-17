<!--
Student Name: Kupid Aun
File Name: register.php
Date: 07/05/2024
--> 
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'scripts/loginfunction.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Attempt registration
    $registration_result = registerUser($username, $password);

    // Check result
    if ($registration_result === true) {
        // Registration successful, redirect to login page or any other page
        header("Location: login.php?registration_message=" . urlencode("Registration successful. Please log in."));
		exit;
    } else {
        // Failed, set error message
        $error = $registration_result; // This will contain the error message from registerUser function
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <?php include 'header.php'; ?>
    <style>
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        
        <!-- Display error message if $error is set -->
        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <!-- Registration form -->
        <form method="POST" action="register.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <div class="button-container">
                <input type="submit" value="Sign Up" class="button">
                <a href="login.php" class="button">Login</a>
            </div>
        </form>
    </div>
</body>
<footer>
<p>This website does not represent any organizations and is purely educational.</p>
</footer>
</html>