<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Alamat email tujuan (email kamu)
    $to = "ngaripin@gmail.com";

    // Subjek email
    $email_subject = "New Message from $name: $subject";

    // Isi pesan email
    $email_body = "
    You have received a new message from your portfolio contact form.\n\n
    Name: $name\n
    Email: $email\n
    Subject: $subject\n
    Message:\n$message
    ";

    // Header email
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Kirim email
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "<script>
            alert('Message sent successfully!');
            window.location.href='index.html';
        </script>";
    } else {
        echo "<script>
            alert('Failed to send message. Please try again later.');
            window.history.back();
        </script>";
    }
}
?>
