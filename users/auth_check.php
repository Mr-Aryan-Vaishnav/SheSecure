<?php
// users/auth_check.php
session_start();

// If the user is not logged in, kick them back to the login page securely
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}

// Grab the decrypted name we set during process_login.php
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Secure User';

// Get the first letter of their name for the Avatar circle
$user_initial = strtoupper(substr($user_name, 0, 1));
?>