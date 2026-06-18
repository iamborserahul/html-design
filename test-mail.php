<?php
// Quick SMTP test - DELETE THIS FILE after testing!
require_once __DIR__ . '/phpmailer/Exception.php';
require_once __DIR__ . '/phpmailer/PHPMailer.php';
require_once __DIR__ . '/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 2; // Show detailed debug output
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'akashvishwakarma1212@gmail.com';
    $mail->Password   = 'wiqjmvooxxngbwap';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('akashvishwakarma1212@gmail.com', 'Test Mail');
    $mail->addAddress('shubhamg44391@gmail.com');

    $mail->isHTML(false);
    $mail->Subject = 'Test Email from Khodiyar Steel Website';
    $mail->Body    = "This is a test email. If you receive this, the SMTP setup is working correctly!";

    $mail->send();
    echo "<h2 style='color:green;'>✅ SUCCESS! Email sent to shubhamg44391@gmail.com</h2>";
} catch (Exception $e) {
    echo "<h2 style='color:red;'>❌ FAILED: " . $mail->ErrorInfo . "</h2>";
}
?>
