<?php
require_once 'ClassAutoLoad.php';
require_once 'conf.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userName  = trim($_POST['username']);
    $userEmail = trim($_POST['email']);
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, 'user')");
    $stmt->execute([
        ':name'     => $userName,
        ':email'    => $userEmail,
        ':password' => $password
    ]);

    // Send welcome email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = $conf['smtp_host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $conf['smtp_user'];
        $mail->Password   = $conf['smtp_pass'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = $conf['smtp_port'];

        $mail->setFrom($conf['smtp_user'], 'Dadaeb.co');
        $mail->addAddress($userEmail, $userName);

        $mail->isHTML(true);
        $mail->Subject = "Welcome to Dadaeb.co, $userName!";
        $mail->Body    = "Hello <b>$userName</b>,<br>Welcome to <b>Dadaeb.co</b>!";

        $mail->send();
        header("Location: signup.php?success=1");
        exit;
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}

$ObjLayouts->header($conf);
$ObjLayouts->navbar($conf);

echo "<main class='container mt-4'>";
if (isset($_GET['success'])) {
    echo "<p class='alert alert-success'>Signup successful. Please check your email.</p>";
}
$ObjForms->signup();
echo "</main>";

$ObjLayouts->footer($conf);
