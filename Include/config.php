<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// AES-256 Keys - Keep these 100% private! 
// If you ever change these, you will lose access to all previously encrypted data.
define('ENCRYPTION_KEY', '756a6272376b5a4b415a7732476b504d'); // Must be 32 characters
define('ENCRYPTION_IV', '9876543210123456'); // Must be exactly 16 characters

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'shesecure');
define('DB_USER', 'root');
define('DB_PASS', '');
?>