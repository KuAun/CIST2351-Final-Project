<!--
Student Name: Kupid Aun
File Name: mypage.php
Date: 07/05/2024
--> 
<?php
// error check
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

session_start();

include 'scripts/loginfunction.php';

// Logout logic
if (isset($_POST['logout'])) {
    session_unset();    // Unset all session variables
    session_destroy();  // Destroy the session
    header("Location: login.php");  // Redirect to login page
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Function to get reservations for a user from JSON file
function getUserReservations() {
    $file_path = 'scripts/reservations.json';

    if (file_exists($file_path)) {
        $json_data = file_get_contents($file_path);
        $reservations = json_decode($json_data, true);

        if ($reservations === null) {
            return []; // Return empty array if JSON decoding fails
        }

        // Retrieve user ID from session
        $user_id = $_SESSION['user_id'];

        // Filter reservations for the current user
        $user_reservations = array_filter($reservations, function ($reservation) use ($user_id) {
            return $reservation['user_id'] == $user_id;
        });

        return array_values($user_reservations); // Ensure numerical array keys
    } else {
        return []; // Return empty array if file doesn't exist
    }
}

// Get reservations for the logged-in user
$user_reservations = getUserReservations();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Page</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

        <!-- Logout -->
        <form method="post">
            <input type="submit" name="logout" value="Logout" class="button"> <!-- Added class="button" -->
        </form>
		
		<!-- Delete Account -->
		<form action="scripts/delete_account.php" method="POST">
			<input type="submit" value="Delete Account" class="button"> <!-- Added class="button" -->
		</form>

        <!-- Display Message -->
        <?php
        if (isset($_GET['message'])) {
            echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
        }
        ?>

        <!-- Display User Reservations -->
        <?php foreach ($user_reservations as $reservation): ?>
            <div class="reservation">
                <p>Reservation ID: <?php echo $reservation['id']; ?></p>
                <p>Campsite ID: <?php echo $reservation['campsite_id']; ?></p>
                <p>Start Date: <?php echo $reservation['start_date']; ?></p>
                <p>End Date: <?php echo $reservation['end_date']; ?></p>
                <form action="scripts/delete_reservation.php" method="POST">
                    <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                    <input type="submit" value="Cancel Reservation" class="button">
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
<footer>
<p>This website does not represent any organizations and is purely educational.</p>
</footer>
</html>


