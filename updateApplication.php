<?php
require_once 'db_connection.php';
session_start();

if (!isset($_SESSION['org_id'])) {
    die("Access denied.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $app_id = $_POST['app_id'];
    $action = $_POST['action'];
    $org_id = $_SESSION['org_id'];

    // Determine new status
    $new_status = $action == 'accept' ? 'accepted' : 'rejected';

    // Update application status
    $stmt = $conn->prepare("UPDATE applications SET status=? WHERE app_id=?");
    $stmt->bind_param("si", $new_status, $app_id);
    $stmt->execute();

    // Get applicant email
    $sql = "SELECT u.email FROM applications a JOIN users u ON a.user_id = u.id WHERE a.app_id=?";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("i", $app_id);
    $stmt2->execute();
    $res = $stmt2->get_result()->fetch_assoc();
    $email = $res['email'];

    // Email message setup
    if ($action == 'accept') {

        // STEP 1: Record payment
        $amount = 500.00; // sample interview processing fee
        $stmt3 = $conn->prepare("INSERT INTO payments (org_id, app_id, amount, payment_status) VALUES (?, ?, ?, 'pending')");
        $stmt3->bind_param("iid", $org_id, $app_id, $amount);
        $stmt3->execute();
        $payment_id = $stmt3->insert_id;

        // STEP 2: Simulate M-Pesa Payment (sandbox)
        $success = true; // simulate success
        $transaction_code = "MPESA" . rand(10000,99999);

        if ($success) {
            $status = 'successful';
            $stmt4 = $conn->prepare("UPDATE payments SET payment_status=?, transaction_code=? WHERE payment_id=?");
            $stmt4->bind_param("ssi", $status, $transaction_code, $payment_id);
            $stmt4->execute();

            // STEP 3: Email applicant
            $subject = "Interview Invitation";
            $message = "Dear applicant,\n\nCongratulations! You've been shortlisted for an interview. Please await further instructions.\n\nTransaction ID: $transaction_code\n\nRegards,\nGeoLink Team";
            mail($email, $subject, $message);

            echo "Applicant accepted, payment recorded, and email sent successfully!";
        } else {
            $status = 'failed';
            $stmt4 = $conn->prepare("UPDATE payments SET payment_status=? WHERE payment_id=?");
            $stmt4->bind_param("si", $status, $payment_id);
            $stmt4->execute();
            echo "Payment failed. Applicant not notified.";
        }

    } else {
        // If rejected
        $subject = "Application Update";
        $message = "Dear applicant,\n\nWe regret to inform you that your application was not successful this time.\n\nRegards,\nGeoLink Team";
        mail($email, $subject, $message);

        echo "Applicant rejected and notified.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Application Update</h1>
        <p><?php echo "Application $new_status and email sent."; ?></p>
    </div>
</body>
</html>