<?php
// login.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate email format for Gmail
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
        die("Invalid email format. Only Gmail addresses are allowed.");
    }

    // Placeholder check for an existing user
    $existingUser = ['email' => 'mehdi@gmail.com', 'password' => 'pass'];

    // Check user credentials
    if ($email === $existingUser['email'] && $password === $existingUser['password']) {
        echo "Login successful!";
    } else {
        die("Invalid email or password.");
    }
}
?>
