<?php
// Include/db_connect.php

// 1. Load the database credentials from your config file
require_once __DIR__ . '/config.php';

try {
    // 2. Create the $conn variable that process_signup.php is looking for
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    
    // 3. Set PDO to throw exceptions on errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    // If the connection fails, stop the script and tell the Javascript
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $e->getMessage()]));
}
?>