<!--
Student Name: Kupid Aun
File Name: login.php
Date: 07/05/2024
-->
<?php
// error check
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

session_start();
include 'scripts/loginfunction.php';

// Redirect to mypage.php if already logged in
if (isset($_SESSION['username'])) {
    header("Location: mypage.php");
    exit;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Attempt login
    if (loginUser($username, $password)) {
        header("Location: mypage.php"); // Redirect on successful login
        exit;
    } else {
        $error = "Invalid login credentials."; // Error message for invalid login
    }
}
// Registration Success Message
$registration_message = isset($_GET['registration_message']) ? $_GET['registration_message'] : '';

// Account Deletion Success Message
$delete_message = isset($_GET['delete_message']) ? $_GET['delete_message'] : '';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        
        <!-- Display error message if $error is set -->
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
		
        <!-- Display registration success message -->
        <?php if (!empty($registration_message)) : ?>
            <p style="color: green;"><?php echo htmlspecialchars($registration_message); ?></p>
        <?php endif; ?>
        
        <!-- Display account deletion success message -->
        <?php if (!empty($delete_message)) : ?>
            <p style="color: green;"><?php echo htmlspecialchars($delete_message); ?></p>
        <?php endif; ?>
        
        <!-- Login -->
        <form method="POST" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <div class="button-container">
                <input type="submit" value="Login" class="button">
                <a href="register.php" class="button">Sign Up</a>
            </div>
        </form>
    </div>
</body>
<footer>
<p>This website does not represent any organizations and is purely educational.</p>
</footer>
</html>