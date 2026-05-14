<?php
// Put this at the VERY TOP of process_login.php
error_reporting(E_ALL);
ini_set('display_errors', 0); 

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    echo json_encode(["status" => "error", "message" => "PHP Error: $errstr in $errfile on line $errline"]);
    exit;
});
set_exception_handler(function($exception) {
    echo json_encode(["status" => "error", "message" => "Fatal Exception: " . $exception->getMessage()]);
    exit;
});
// process_login.php
session_start();
header('Content-Type: application/json');

require_once 'Include/db_connect.php';
require_once 'Include/security_functions.php'; // Needs our hash and decrypt functions

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Please enter both email and password."]);
        exit;
    }

    try {
        // 1. Hash the inputted email to look it up in the database
        $email_hash = create_lookup_hash($email);

        // 2. Search the database using the hash
        $stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE email_hash = ? LIMIT 1");
        $stmt->execute([$email_hash]);

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // 3. Verify the password using PHP's built-in secure verifier
            if (password_verify($password, $user['password'])) {
                
                // 4. Password is correct! Set up the session.
                $_SESSION['user_id'] = $user['id'];
                
                // Decrypt their name so we can welcome them on the dashboard
                $_SESSION['user_name'] = decrypt_data($user['full_name']); 
                $_SESSION['logged_in'] = true;

                // 5. Tell the Javascript to redirect
                echo json_encode([
                    "status" => "success", 
                    "message" => "Access Granted. Redirecting...",
                    "redirect" => "users/dashboard.php"
                ]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid email or password."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid email or password."]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "System error. Please try again."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>