<!--
Student Name: Kupid Aun
File Name: loginfunction.php
Date: 07/12/2024
--> 
<?php
session_start();

// Registration Logic
function registerUser($username, $password) {
    $users = getUsers();

    // Check if username is already taken
    if (isset($users[$username])) {
        return "Username already taken.";
    }

    // Calculate the next available user_id
    $next_user_id = count($users) + 1;

    // Add the new user with hashed password and automatically assigned user_id
    $users[$username] = [
        'id' => $next_user_id,
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ];

    // Save updated user data
    setUsers($users);

    return true; // Registration successful
}

//Login Logic
function loginUser($username, $password) {
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            setcookie("username", $username, time() + (86400 * 30), "/"); // 30 days
            return true; // Login successful
        }
    }
    return false; // Login failed
}

// Json Logic
function getUsers() {
    $users = [];
    $file_path = 'scripts/users.json';

    if (file_exists($file_path)) {
        $json_data = file_get_contents($file_path);
        $users = json_decode($json_data, true);
    }

    return $users;
}

function setUsers($users) {
    $file_path = 'scripts/users.json';
    file_put_contents($file_path, json_encode($users, JSON_PRETTY_PRINT));
}
?>