<!--
Student Name: Kupid Aun
File Name: delete_account.php
Date: 07/12/2024
--> 
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure session is started and check user authentication
    if (!isset($_SESSION['username'])) {
        header("Location: ../login.php");
        exit;
    }

    // Retrieve username from session
    $username = $_SESSION['username'];

    // Path to user data JSON file
    $file_path = 'users.json';

    // Check if the JSON file exists
    if (file_exists($file_path)) {
        // Read current JSON data
        $json_data = file_get_contents($file_path);
        if ($json_data === false) {
            die("Error reading users data.");
        }

        // Decode JSON data into associative array
        $users = json_decode($json_data, true);

        // Check if username exists in the users array
        if (isset($users[$username])) {
            // Remove user from the array
            unset($users[$username]);

            // Save updated users array back to JSON file
            file_put_contents($file_path, json_encode($users, JSON_PRETTY_PRINT));

            // Additional cleanup (if any), e.g., delete associated reservations

            // Destroy session and redirect to login page with success message
            session_unset();
            session_destroy();
            header("Location: ../login.php?message=" . urlencode("Your account has been successfully deleted."));
            exit;
        } 
    }
}
?>

