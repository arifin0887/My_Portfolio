<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

header('Content-Type: application/json; charset=utf-8');
$response = ['success' => false, 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$name || !$email || !$subject || !$message) {
        $response['message'] = 'Please fill in all fields with valid information.';
        echo json_encode($response);
        exit;
    }

    $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $safeSubject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
    $safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

    $mail = new PHPMailer(true);

    try {
        $senderEmail   = 'ngaripin6@gmail.com';
        $receiverEmail = 'ngaripin6@gmail.com';

    $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $senderEmail;
        $mail->Password   = 'kwuhclqyjupsrdjh';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->SMTPAutoTLS = true;
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 0;

        $mail->setFrom($senderEmail, 'Portfolio Website');
        $mail->addAddress($receiverEmail);
        $mail->addReplyTo($email, $safeName);

        $mail->isHTML(true);
        $mail->Subject = "Message from {$safeName}: {$safeSubject}";
        $mail->Body    = "
            <h3>New Message from Portfolio</h3>
            <p><strong>Name:</strong> {$safeName}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Subject:</strong> {$safeSubject}</p>
            <p><strong>Message:</strong><br>{$safeMessage}</p>
        ";
        $mail->AltBody = "New Message from Portfolio\nName: {$safeName}\nEmail: {$email}\nSubject: {$safeSubject}\nMessage: {$message}";

        $mail->send();
        $response['success'] = true;
        $response['message'] = 'Message sent successfully.';
    } catch (Exception $e) {
        $response['message'] = 'Mailer Error: ' . $mail->ErrorInfo;
    }
}

echo json_encode($response);
?>
