<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Load Composer's autoloader
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate form data
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Validate email format
        echo 'Please provide a valid email address.';
    } else {
        // Create an instance of PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'barryopeyemi@gmail.com';                     //SMTP username
            $mail->Password   = 'ftstqrakmzxarzxu';              // Your email password or app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                     // TCP port to connect to

          //Recipients
            $mail->setFrom($email , 'Mailer');
            $mail->addAddress('femi.john.akinwunmi@gmail.com', 'Joe User');           // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;                            // Email subject
            $mail->Body    = "
                <html>
                <head>
                  <title>{$subject}</title>
                </head>
                <body>
                  <p><strong>Name:</strong> {$name}</p>
                  <p><strong>Email:</strong> {$email}</p>
                  <p><strong>Message:</strong></p>
                  <p>{$message}</p>
                </body>
                </html>
            ";

            // Send the email
            $mail->send();
            echo 'Your message has been sent successfully!';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Method Not Allowed";
}
?>

