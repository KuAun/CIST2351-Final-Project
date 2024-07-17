<!--
Student Name: Kupid Aun
File Name: reservefunction.php
Date: 07/12/2024
--> 
<?php
session_start();

// Function to reserve a campsite
function reserveCampsite($campsite_id, $user_id, $start_date, $end_date) {
    $file_path = 'reservations.json';

    // Read existing reservations from the JSON file
    if (file_exists($file_path)) {
        $json_data = file_get_contents($file_path);
        $reservations = json_decode($json_data, true);
    } else {
        $reservations = [];
    }

    // Check if the campsite is already reserved for the given date range
    foreach ($reservations as $reservation) {
        if ($reservation['campsite_id'] == $campsite_id &&
            (($start_date >= $reservation['start_date'] && $start_date <= $reservation['end_date']) ||
             ($end_date >= $reservation['start_date'] && $end_date <= $reservation['end_date']) ||
             ($start_date <= $reservation['start_date'] && $end_date >= $reservation['end_date']))) {
            return "This campsite is already reserved for the selected date range.";
        }
    }

    // Create a new reservation
    $new_reservation = [
        'id' => count($reservations) + 1,
        'campsite_id' => $campsite_id,
        'user_id' => $user_id,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'created_at' => date('c')
    ];

    // Add the new reservation to the array
    $reservations[] = $new_reservation;

    // Save the updated reservations array back to the JSON file
    file_put_contents($file_path, json_encode($reservations, JSON_PRETTY_PRINT));

    return true; // Indicate successful reservation
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo "Please log in to reserve a campsite.";
    exit;
}

// Initialize message variable
$message = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $campsite_id = $_POST['campsite_id'];
    $user_id = $_SESSION['user_id']; // Retrieve user_id from session
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if ($campsite_id < 1 || $campsite_id > 10) {
        $message = "Invalid campsite ID.";
    } else {
        $result = reserveCampsite($campsite_id, $user_id, $start_date, $end_date);
        if ($result === true) {
            // Redirect with success message
            header("Location: ../reserve.php?message=" . urlencode("Campsite reserved successfully."));
            exit;
        } else {
            $message = htmlspecialchars($result);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Campsite</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container">
        <h1>Reserve a Campsite</h1>
        <?php
        if (!empty($message)) {
            echo '<p>' . $message . '</p>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="campsite_id">Campsite ID:</label>
            <select id="campsite_id" name="campsite_id" required>
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <input type="submit" value="Reserve" class="button">
        </form>
    </div>
</body>
</html>
