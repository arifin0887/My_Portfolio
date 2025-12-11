<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ngaripin6@gmail.com';
        $mail->Password   = 'kwuhclqyjupsrdjh'; // tanpa spasi
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->SMTPDebug  = 2; // Tambahkan untuk debug (sementara)


        // Pengirim dan penerima
        $mail->setFrom('ngaripin6@gmail.com', 'Portfolio Website');
        $mail->addAddress('ngaripin@gmail.com'); // Email penerima (kamu sendiri)
        $mail->addReplyTo($email, $name);

        // Konten email
        $mail->isHTML(true);
        $mail->Subject = "Message from $name: $subject";
        $mail->Body    = "
            <h3>New Message from Portfolio</h3>
            <p><b>Name:</b> $name</p>
            <p><b>Email:</b> $email</p>
            <p><b>Subject:</b> $subject</p>
            <p><b>Message:</b><br>$message</p>
        ";

        $mail->send();
        echo "success";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>
