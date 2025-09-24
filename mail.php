<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';    
require_once 'conf.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = trim($_POST['email']);
    $userName  = trim($_POST['name']);

    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'david.otieno@strathmore.edu';   
        $mail->Password   = 'Daxfaxi6';    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('david.otieno@strathmore.edu', 'Dadaeb.co');
        $mail->addAddress($userEmail, $userName);

        $mail->isHTML(true);
        $mail->Subject = "Welcome to Dadaeb.co, $userName!";
        $mail->Body    = "Hello <b>$userName</b>,<br><br>
                          Welcome to <b>Dadaeb.co</b>! 
                          Your signup was successful.";

        $mail->send();

        // Save to DB
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute([
            ':name'  => $userName,
            ':email' => $userEmail
        ]);

        header("Location: index.php?success=1");
        exit;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
