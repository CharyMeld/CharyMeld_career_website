<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptchaSecret = "YOUR_RECAPTCHA_SECRET_KEY_HERE";
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // ✅ Verify reCAPTCHA
    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify";
    $response = file_get_contents($verifyUrl . "?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseData = json_decode($response);

    if (!$responseData->success) {
        header("Location: contact.php?error=recaptcha");
        exit();
    }

    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    $to = "teamodigitalsolutions1@gmail.com";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8";

    $body = "<h2>New Contact Message</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong><br>$message</p>";

    // ✅ Send mail and redirect
    if (mail($to, "Contact Form: $subject", $body, $headers)) {
        // Redirect using a success anchor instead of query params to avoid repeat popup after reload
        header("Location: contact.php#success");
        exit();
    } else {
        header("Location: contact.php?error=send");
        exit();
    }
} else {
    header("Location: contact.php");
    exit();
}
?>
