<?php
// process_forgot.php
header('Content-Type: application/json');
require_once 'Include/db_connect.php';
require_once 'Include/security_functions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// Ensure script doesn't crash silently
error_reporting(E_ALL);
ini_set('display_errors', 0);
set_exception_handler(function($e) {
    echo json_encode(["status" => "error", "message" => "System Error: " . $e->getMessage()]);
    exit;
});

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    $raw_email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $email_hash = create_lookup_hash($raw_email);

    // =================================================================
    // ACTION 1: REQUEST TOKEN
    // =================================================================
    if ($action === 'request') {
        // 1. Check if user exists
        $stmt = $conn->prepare("SELECT full_name FROM users WHERE email_hash = ? LIMIT 1");
        $stmt->execute([$email_hash]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // For security, do not reveal if the email exists or not. Give generic success.
            echo json_encode(["status" => "success", "message" => "If the email exists, a token has been sent."]);
            exit;
        }

        // 2. Generate 12-char secure mixed token
        $token = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 12);
        
        // 3. Save token and set expiration (15 minutes from now)
        $expires = date("Y-m-d H:i:s", strtotime('+15 minutes'));
        $update = $conn->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email_hash = ?");
        $update->execute([$token, $expires, $email_hash]);

        // 4. Send Email via PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'official.shesecure@gmail.com';
        // FIXED: Added your password WITHOUT spaces
        $mail->Password = 'xpollxnokpmxyqjl'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('official.shesecure@gmail.com', 'SheSecure Security');
        $mail->addAddress($raw_email);
        $mail->isHTML(true);
        $mail->Subject = 'SheSecure - Password Reset Token';
        
        $user_name = decrypt_data($user['full_name']);
        
        $mail->Body = "
        <div style='font-family:Arial, sans-serif; background:#FFF7F5; padding:40px;'>
            <div style='max-width:600px; margin:auto; background:white; border-radius:20px; border:1px solid #C0394B; overflow:hidden;'>
                <div style='background:#C0394B; color:white; padding:20px; text-align:center;'>
                    <h2>Security Alert</h2>
                </div>
                <div style='padding:30px; line-height:1.6; color:#1C1116;'>
                    <p>Hello $user_name,</p>
                    <p>We received a request to reset your Master Password. Here is your 12-character secure verification token:</p>
                    <div style='text-align:center; margin:30px 0;'>
                        <span style='background:#f0f0f0; padding:15px 30px; font-size:24px; font-weight:bold; letter-spacing:3px; border-radius:10px; border:2px dashed #E8697A;'>$token</span>
                    </div>
                    <p style='color:#8B1A2A; font-weight:bold;'>This token will expire in exactly 15 minutes.</p>
                    <p>If you did not request this reset, please ignore this email. Your account remains encrypted and secure.</p>
                </div>
            </div>
        </div>";

        $mail->send();
        echo json_encode(["status" => "success", "message" => "Token sent! Check your inbox and spam folder."]);
        exit;
    }

    // =================================================================
    // ACTION 2: VERIFY TOKEN & RESET PASSWORD
    // =================================================================
    if ($action === 'reset') {
        $token = trim($_POST['token']);
        $new_password = $_POST['new_password'];

        // 1. Verify token exists and is not expired
        $stmt = $conn->prepare("SELECT full_name FROM users WHERE email_hash = ? AND reset_token = ? AND reset_expires > NOW() LIMIT 1");
        $stmt->execute([$email_hash, $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo json_encode(["status" => "error", "message" => "Invalid or expired token. Please request a new one."]);
            exit;
        }

        // 2. Hash new password and clear the token
        $password_hashed = password_hash($new_password, PASSWORD_BCRYPT);
        $update = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE email_hash = ?");
        $update->execute([$password_hashed, $email_hash]);

        // 3. Send "Password Successfully Changed" Notification Email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'official.shesecure@gmail.com';
        // FIXED: Removed the spaces from the password
        $mail->Password = 'xpollxnokpmxyqjl'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('official.shesecure@gmail.com', 'SheSecure Security');
        $mail->addAddress($raw_email);
        $mail->isHTML(true);
        $mail->Subject = 'Security Notice: Password Updated Successfully';
        
        $user_name = decrypt_data($user['full_name']);
        
        $mail->Body = "
        <div style='font-family:Arial, sans-serif; background:#FFF7F5; padding:40px;'>
            <div style='max-width:600px; margin:auto; background:white; border-radius:20px; border:1px solid #2A9D5C; overflow:hidden;'>
                <div style='background:#2A9D5C; color:white; padding:20px; text-align:center;'>
                    <h2>Password Updated</h2>
                </div>
                <div style='padding:30px; line-height:1.6; color:#1C1116;'>
                    <p>Hello $user_name,</p>
                    <p>Your Master Password has been successfully updated.</p>
                    <p>You can now use your new password to access your encrypted dashboard.</p>
                    <p style='margin-top:20px; font-size:12px; color:#6B4A52;'>If you did not perform this action, please contact our support team immediately.</p>
                </div>
            </div>
        </div>";

        $mail->send();

        echo json_encode(["status" => "success", "message" => "Master Password successfully updated!"]);
        exit;
    }
}
?>