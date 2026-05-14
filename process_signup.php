<?php
// Put this at the VERY TOP of process_signup.php
error_reporting(E_ALL);
ini_set('display_errors', 0); // Hide raw errors from breaking JSON

// Catch all errors and format them as JSON so your Javascript can read them
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    echo json_encode(["status" => "error", "message" => "PHP Error: $errstr in $errfile on line $errline"]);
    exit;
});
set_exception_handler(function($exception) {
    echo json_encode(["status" => "error", "message" => "Fatal Exception: " . $exception->getMessage()]);
    exit;
});
// process_signup.php
header('Content-Type: application/json');
require_once 'Include/db_connect.php';
require_once 'Include/security_functions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Core User Data
    $raw_name = htmlspecialchars(trim($_POST['full_name']));
    $raw_email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $raw_phone = htmlspecialchars(trim($_POST['phone']));
    $raw_dob = $_POST['dob'] ?? '';
    $raw_gender = $_POST['gender'] ?? '';
    $password_plain = $_POST['password'];
    
    // 2. Dynamic Guardians Data Collection
    $guardians = [];
    if (isset($_POST['g_names']) && is_array($_POST['g_names'])) {
        for ($i = 0; $i < count($_POST['g_names']); $i++) {
            if (!empty($_POST['g_names'][$i]) && !empty($_POST['g_emails'][$i])) {
                $guardians[] = [
                    'name' => htmlspecialchars(trim($_POST['g_names'][$i])),
                    'email' => filter_var(trim($_POST['g_emails'][$i]), FILTER_SANITIZE_EMAIL),
                    'phone' => htmlspecialchars(trim($_POST['g_phones'][$i])),
                    'relation' => htmlspecialchars(trim($_POST['g_relations'][$i]))
                ];
            }
        }
    }

    // Basic Validation
    if (empty($raw_name) || empty($raw_email) || empty($password_plain) || empty($guardians)) {
        echo json_encode(["status" => "error", "message" => "All required fields and at least one guardian must be provided."]);
        exit;
    }

    // 3. Security Preparation
    $email_hash = create_lookup_hash($raw_email); // Hash for DB checking
    
    // Check if user already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email_hash = ?");
    $check->execute([$email_hash]);
    if ($check->rowCount() > 0) {
        echo json_encode(["status" => "error", "message" => "This email is already secured in our system."]);
        exit;
    }

    // Encrypt Data
    $enc_name = encrypt_data($raw_name);
    $enc_email = encrypt_data($raw_email);
    $enc_phone = encrypt_data($raw_phone);
    $enc_dob = encrypt_data($raw_dob);
    $enc_gender = encrypt_data($raw_gender);
    $password_hashed = password_hash($password_plain, PASSWORD_BCRYPT);
    $enc_guardians = encrypt_data(json_encode($guardians));

    // 4. Handle Image Upload to Images/users/
    $photo_path = 'Images/users/default.png'; // Default if none uploaded
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
        $upload_dir = 'Images/users/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        
        $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png'];
        
        if (in_array($ext, $allowed_exts)) {
            // Generate unique, safe filename
            $new_filename = uniqid('user_') . '.' . $ext;
            $destination = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $destination)) {
                $photo_path = $destination;
            }
        }
    }

    try {
        // 5. Database Insertion
        $sql = "INSERT INTO users (full_name, email_enc, email_hash, phone_enc, dob_enc, gender_enc, password, guardians_enc, profile_photo) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $conn->prepare($sql)->execute([$enc_name, $enc_email, $email_hash, $enc_phone, $enc_dob, $enc_gender, $password_hashed, $enc_guardians, $photo_path]);

        // ==========================================
        // 6. SENDING EMAILS (USER & GUARDIANS)
        // ==========================================
        $mail = new PHPMailer(true);
        // Setup SMTP server (Replace with your actual credentials)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'official.shesecure@gmail.com';
        $mail->Password   = 'xpol lxno kpmx yqjl'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->setFrom('official.shesecure@gmail.com', 'SheSecure System');
        $mail->isHTML(true);

        // --- EMAIL 1: TO THE USER ---
        $mail->addAddress($raw_email, $raw_name);
        $mail->Subject = 'Identity Secured - Welcome to SheSecure';
        
        // Format Guardian List for User Email
        $guardian_list_html = "<ul>";
        foreach ($guardians as $g) {
            $guardian_list_html .= "<li><strong>{$g['name']}</strong> ({$g['relation']}) - {$g['phone']}</li>";
        }
        $guardian_list_html .= "</ul>";

        $mail->Body = "
        <div style='font-family:Arial, sans-serif; background:#FFF7F5; padding:40px;'>
            <div style='max-width:600px; margin:auto; background:white; border-radius:20px; border:1px solid #C0394B; overflow:hidden;'>
                <div style='background:#C0394B; color:white; padding:30px; text-align:center;'>
                    <h1>SheSecure</h1>
                </div>
                <div style='padding:30px; color:#1C1116; line-height:1.6;'>
                    <h2>Welcome, $raw_name</h2>
                    <p>Your identity has been verified and stored using 256-bit AES encryption. Your details are safe.</p>
                    <p>We have also securely linked the following Guardians to your SOS protocol. They will be notified immediately if you trigger an emergency alert.</p>
                    $guardian_list_html
                    <p style='background:#f9f9f9; padding:15px; border-radius:10px; font-size:0.9em;'><strong>Note:</strong> We are actively notifying your guardians that you have designated them as emergency contacts.</p>
                    <br><p>Stay safe,<br><strong>Team Coffee To Code</strong></p>
                </div>
            </div>
        </div>";
        $mail->send(); // Send User Email

        // --- EMAIL 2: TO EACH GUARDIAN ---
        foreach ($guardians as $g) {
            $mail->clearAddresses(); // Clear previous recipients
            $mail->addAddress($g['email'], $g['name']);
            $mail->Subject = "Action Required: $raw_name designated you as a SheSecure Guardian";
            
            $mail->Body = "
            <div style='font-family:Arial, sans-serif; background:#FFF7F5; padding:40px;'>
                <div style='max-width:600px; margin:auto; background:white; border-radius:20px; border:1px solid #C0394B; overflow:hidden;'>
                    <div style='background:#1C1116; color:#E8697A; padding:30px; text-align:center;'>
                        <h1 style='margin:0;'>SheSecure Guardian Alert</h1>
                    </div>
                    <div style='padding:30px; color:#1C1116; line-height:1.6;'>
                        <h2>Hello {$g['name']},</h2>
                        <p><strong>$raw_name</strong> has recently joined the SheSecure safety platform and has designated you as a trusted <strong>{$g['relation']}</strong> (Guardian).</p>
                        <p><strong>What this means:</strong></p>
                        <ul>
                            <li>If $raw_name triggers an SOS emergency from their device, you will instantly receive an email and SMS with their live GPS location.</li>
                            <li>You do not need to download the app to receive these alerts, but keeping this email address active is critical.</li>
                        </ul>
                        <p style='background:#f9f9f9; border-left:4px solid #2A9D5C; padding:15px; border-radius:0 10px 10px 0;'>Please save our email address <strong>official.shesecure@gmail.com</strong> to your contacts to ensure emergency alerts are never sent to your spam folder.</p>
                        <br><p>Thank you for helping keep your loved ones safe,<br><strong>Team Coffee To Code</strong></p>
                    </div>
                </div>
            </div>";
            $mail->send(); // Send to this specific guardian
        }

        echo json_encode(["status" => "success", "message" => "Account secured! Welcome email sent."]);

    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Protocol failure: " . $e->getMessage()]);
    }
}
?>