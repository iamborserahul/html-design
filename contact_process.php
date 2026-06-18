<?php
/**
 * CONTACT_PROCESS.PHP — Manthan Clinic
 * Handles contact form submissions
 */

require_once __DIR__ . '/includes/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$name    = isset($_POST['name'])    ? sanitize($_POST['name'])    : '';
$email   = isset($_POST['email'])   ? sanitize($_POST['email'])   : '';
$phone   = isset($_POST['phone'])   ? sanitize($_POST['phone'])   : '';
$subject = isset($_POST['subject']) ? sanitize($_POST['subject']) : '';
$message = isset($_POST['message']) ? sanitize($_POST['message']) : '';

// Validation
$errors = [];

if (empty($name) || strlen($name) < 2) {
    $errors[] = 'Please enter your full name.';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}

if (empty($message) || strlen($message) < 10) {
    $errors[] = 'Please write a message (minimum 10 characters).';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// Save to database (if available)
$db = getDB();
if ($db) {
    try {
        $stmt = $db->prepare("
            INSERT INTO contact_messages (name, email, phone, subject, message, created_at)
            VALUES (:name, :email, :phone, :subject, :message, NOW())
        ");
        $stmt->execute([
            ':name'    => $name,
            ':email'   => $email,
            ':phone'   => $phone,
            ':subject' => $subject,
            ':message' => $message,
        ]);
    } catch (PDOException $e) {
        // Silently log error, don't expose to user
    }
}

// Send email notification
$to      = SITE_EMAIL;
$subject = 'New Contact Form Submission: ' . ($subject ?: 'No Subject');
$body    = "
Name:    $name
Email:   $email
Phone:   $phone
Subject: $subject

Message:
$message
";
$headers = "From: $email\r\nReply-To: $email\r\nX-Mailer: PHP/" . phpversion();

mail($to, $subject, $body, $headers);

echo json_encode([
    'success' => true,
    'message' => 'Thank you, ' . htmlspecialchars($name) . '! Your message has been sent successfully. We will get back to you shortly.'
]);
exit;
