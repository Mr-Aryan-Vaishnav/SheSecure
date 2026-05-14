<?php
// users/trigger_sos.php
session_start();
header('Content-Type: application/json');

// Force strict error reporting to catch hidden bugs
error_reporting(E_ALL);
ini_set('display_errors', 0);
set_exception_handler(function($e) {
    echo json_encode(["status" => "error", "message" => "Server Error: " . $e->getMessage()]);
    exit;
});

require_once '../Include/db_connect.php';
require_once '../Include/security_functions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $lat = $_POST['lat'] ?? 'Unknown';
    $lng = $_POST['lng'] ?? 'Unknown';
    $address = $_POST['address'] ?? 'Coordinates Only';

    try {
        // Fetch User and Encrypted Guardians
        $stmt = $conn->prepare("SELECT full_name, guardians_enc FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || empty($user['guardians_enc'])) {
            echo json_encode(["status" => "error", "message" => "No guardians found in the database."]);
            exit;
        }

        $user_name = decrypt_data($user['full_name']);
        $guardians_json = decrypt_data($user['guardians_enc']);
        $guardians = json_decode($guardians_json, true);

        if (!is_array($guardians) || count($guardians) === 0) {
            echo json_encode(["status" => "error", "message" => "Guardian data is empty or corrupted."]);
            exit;
        }

        // Setup PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'official.shesecure@gmail.com';
        
        // FIXED: Spaces removed from the Google App Password!
        $mail->Password = 'xpollxnokpmxyqjl'; 
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->setFrom('official.shesecure@gmail.com', 'SheSecure EMERGENCY');
        $mail->isHTML(true);
        
        // FIXED: Universal Google Maps format
        $maps_link = "https://www.google.com/maps?q={$lat},{$lng}";
        $success_count = 0;

        // Loop and email every guardian
        foreach ($guardians as $g) {
            if (!empty($g['email'])) {
                $mail->clearAddresses();
                $mail->addAddress($g['email']);
                $mail->Subject = "URGENT: {$user_name} has triggered an SOS!";
                
                $mail->Body = "
                <div style='font-family:Arial, sans-serif; background:#1C1116; padding:40px; color:white;'>
                    <div style='max-width:600px; margin:auto; background:#2d1520; border-radius:20px; border:2px solid #E8697A; overflow:hidden;'>
                        <div style='background:#C0394B; color:white; padding:20px; text-align:center;'>
                            <h1 style='margin:0; font-size:24px;'>CRITICAL EMERGENCY</h1>
                        </div>
                        <div style='padding:30px; line-height:1.6;'>
                            <p style='font-size:18px;'>Hello {$g['name']},</p>
                            <p style='font-size:18px;'><strong>{$user_name}</strong> has just triggered their SheSecure SOS Alarm.</p>
                            <p><strong>Approximate Location:</strong> $address</p>
                            
                            <div style='text-align:center; margin:30px 0;'>
                                <a href='{$maps_link}' style='background:#E8697A; color:white; padding:15px 30px; text-decoration:none; border-radius:10px; font-weight:bold; font-size:18px; display:inline-block;'>View Live GPS Location</a>
                            </div>
                            
                            <p style='color:#E8697A;'>Please attempt to contact them immediately. If unreachable, dispatch local authorities.</p>
                        </div>
                    </div>
                </div>";
                
                $mail->send();
                $success_count++;
            }
        }

        echo json_encode(["status" => "success", "message" => "Alerts dispatched to {$success_count} guardians."]);

    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "SMTP Failed: " . $mail->ErrorInfo]);
    }
}
?>