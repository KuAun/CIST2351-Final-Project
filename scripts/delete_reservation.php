<!--
Student Name: Kupid Aun
File Name: delete_reservation.php
Date: 07/12/2024
--> 
<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Check if reservation ID is provided via POST
if (!isset($_POST['reservation_id'])) {
    header("Location: mypage.php?message=" . urlencode("Reservation ID not provided."));
    exit;
}

$reservation_id = $_POST['reservation_id'];

// Function to delete reservation from JSON file
function deleteReservation($reservation_id) {
    $file_path = 'reservations.json';

    if (file_exists($file_path)) {
        $json_data = file_get_contents($file_path);
        $reservations = json_decode($json_data, true);

        if ($reservations === null) {
            return "Failed to decode JSON data.";
        }

        // Find reservation index by ID
        $index = -1;
        foreach ($reservations as $key => $reservation) {
            if ($reservation['id'] == $reservation_id) {
                $index = $key;
                break;
            }
        }

        // Remove reservation if found
        if ($index !== -1) {
            unset($reservations[$index]);
            // Save updated reservations array back to JSON file
            file_put_contents($file_path, json_encode(array_values($reservations), JSON_PRETTY_PRINT));
            return true; // Deletion successful
        } else {
            return "Reservation not found.";
        }
    } else {
        return "File not found.";
    }
}

// Attempt to delete reservation
$result = deleteReservation($reservation_id);

// Redirect back to mypage.php with appropriate message
if ($result === true) {
    header("Location: ../mypage.php?message=" . urlencode("Reservation canceled successfully."));
    exit;
} else {
    header("Location: ../mypage.php?message=" . urlencode("Failed to cancel reservation: " . $result));
    exit;
}
?>