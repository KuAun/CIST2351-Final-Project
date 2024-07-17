<!--
Student Name: Kupid Aun
File Name: reserve.php
Date: 07/05/2024
--> 
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
        session_start();
        if (!isset($_SESSION['username'])) {
            echo '<p>Please <a href="login.php">log in</a> to reserve a campsite.</p>';
            exit;
        }

        if (isset($_GET['message'])) {
            echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
        }
        ?>
        <form action="scripts/reservefunction.php" method="POST">
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

            <!-- Move the submit button below -->
            <div class="button-container">
                <input type="submit" value="Reserve" class="button">
            </div>
        </form>
    </div>
</body>
<footer>
<p>This website does not represent any organizations and is purely educational.</p>
</footer>
</html>


