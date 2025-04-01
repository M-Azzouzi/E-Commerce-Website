<?php
// signup.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate email with regex for @gmail.com
    if (!preg_match("/^[a-z
    A-Z0-9._%+-]+@gmail\.com$/", $email)) {
        die("Invalid email. Must be a Gmail address.");
    }

    // Validate password (at least 8 characters)
    if (!preg_match("/^.{8,}$/", $password)) {
        die("Password must be at least 8 characters long.");
    }

    // Confirm password match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // If validation passes, add user to database or file (for now just simulate)
    // Simulated successful sign-up
    echo "Sign-up successful! Please <a href='index.html'>login here</a>.";
}
?>
