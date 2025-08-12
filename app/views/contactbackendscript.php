<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/plain");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    $to = "teamodigitalsolutions1@gmail.com";
    $subject = "New Contact Form Submission";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    $mail = new PHPMailer(true);
    try {
        // SMTP Debugging
        //$mail->SMTPDebug = 3;
       // $mail->Debugoutput = 'html';

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'teamodigitalsolutions1@gmail.com';  
        $mail->Password = 'sxnjxzznrkwzfvrd';  // Use your App Password here (without spaces)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = 465;  



        // Sender & Recipient
        $mail->setFrom($email, $name);
        $mail->addAddress($to);

        // Email Content
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Send Email
        if ($mail->send()) {
            echo "success";
        } else {
            echo "error: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    echo "error: Invalid request method!";
}

?>
