<?php
// process_contact.php
header('Content-Type: application/json');
require_once 'Include/db_connect.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitize Inputs
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(strip_tags(trim($_POST['phone'])));
    $subject = htmlspecialchars(strip_tags(trim($_POST['subject'])));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        echo json_encode(["status" => "error", "message" => "Please fill in all required fields."]);
        exit;
    }

    try {
        // 2. Insert into Database
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (:name, :email, :phone, :subject, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        // 3. Send Professional HTML Email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'official.shesecure@gmail.com';         // Your SheSecure Gmail address
            $mail->Password   = 'xpol lxno kpmx yqjl';     // The Google App Password you generated
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
            $mail->Port       = 465;                                    // TCP port to connect to

            // Recipients
            $mail->setFrom('official.shesecure@gmail.com', 'SheSecure');
            $mail->addAddress($email, $name);                           // Add a recipient (the user)

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = 'We received your message – SheSecure';
            
            // Your HTML Body
            $mail->Body = "
            <html>
            <head>
              <style>
                body { font-family: 'Arial', sans-serif; background-color: #FFF7F5; color: #1C1116; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(192,57,75,0.1); border: 1px solid rgba(192,57,75,0.1); }
                .header { background: linear-gradient(135deg, #C0394B, #8B1A2A); padding: 30px; text-align: center; }
                .header h1 { color: #ffffff; margin: 0; font-size: 24px; letter-spacing: 1px; }
                .content { padding: 40px 30px; line-height: 1.6; }
                .content h2 { color: #C0394B; font-size: 20px; margin-top: 0; }
                .footer { background: #1C1116; color: #ffffff; text-align: center; padding: 20px; font-size: 12px; }
                .footer a { color: #E8697A; text-decoration: none; }
              </style>
            </head>
            <body>
              <div class='container'>
                <div class='header'>
                  <h1>SheSecure</h1>
                </div>
                <div class='content'>
                  <h2>Hello $name,</h2>
                  <p>Thank you for reaching out to the SheSecure team. We have received your message regarding <strong>'$subject'</strong>.</p>
                  <p>Our support team is reviewing your inquiry and will get back to you at this email address or your provided phone number ($phone) within 24 hours.</p>
                  <p>If you have any urgent concerns, you can always reach us directly at <a href='mailto:official.shesecure@gmail.com' style='color:#C0394B; font-weight:bold;'>official.shesecure@gmail.com</a>.</p>
                  <p>Stay safe,<br><strong>Team Coffee To Code</strong></p>
                </div>
                <div class='footer'>
                  &copy; " . date('Y') . " SheSecure | Team Coffee To Code. All rights reserved.<br>
                  Navigating towards safer cities for everyone.
                </div>
              </div>
            </body>
            </html>";

            $mail->send();
            
        } catch (Exception $e) {
            // Log the error internally, but don't show technical details to the user
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            echo json_encode(["status" => "error", "message" => "Message saved, but email delivery failed. Our team will still contact you."]);
            exit;
        }

        echo json_encode(["status" => "success", "message" => "Message sent successfully! Check your email."]);

    } catch(PDOException $e) {
        echo json_encode(["status" => "error", "message" => "A system error occurred. Please try again later."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>