<?php
// test_email.php

// 1. Turn on strict error reporting for PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Load PHPMailer (Ensure this path is correct)
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

echo "<h3>Starting Email Test...</h3>";

$mail = new PHPMailer(true);

try {
    // 3. Turn on MAXIMUM debugging output
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; 

    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'official.shesecure@gmail.com'; 
    $mail->Password   = 'xpol lxno kpmx yqjl'; // <-- Put your app password here (no spaces)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Recipients
    $mail->setFrom('official.shesecure@gmail.com', 'SheSecure Test');
    $mail->addAddress('official.shesecure@gmail.com'); // Sending an email to yourself as a test

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'SMTP Test - SheSecure';
    $mail->Body    = 'If you are reading this, PHPMailer is working perfectly!';

    $mail->send();
    echo "<h3 style='color:green;'>Message has been sent successfully!</h3>";
} catch (Exception $e) {
    echo "<h3 style='color:red;'>Message could not be sent.</h3>";
    echo "<strong>Mailer Error:</strong> {$mail->ErrorInfo}";
}
?>