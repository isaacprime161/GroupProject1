<?php
// --- Backend: Handle form submission ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $orgName = htmlspecialchars($_POST['orgName']);
    $orgEmail = htmlspecialchars($_POST['orgEmail']);
    $phone = htmlspecialchars($_POST['phone']);
    $password = htmlspecialchars($_POST['password']);

    // Simulate payment completion for demonstration
    $paymentDone = true;

    if ($paymentDone) {
        header("Refresh:3; url=adminlogin.php");
        $paymentMessage = "Payment Complete. Redirecting to Admin Login...";
    } else {
        $paymentMessage = "Payment Pending. Please complete your payment.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Organization Registration</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #2a6edb, #9ec9ff);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background: #fff;
        display: flex;
        flex-direction: column;
        width: 90%;
        max-width: 900px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .top {
        background: #f4f8ff;
        text-align: center;
        padding: 20px;
        font-size: 1.5rem;
        font-weight: bold;
        color: #1a3a8b;
    }

    .bottom {
        display: flex;
        flex-wrap: wrap;
    }

    .form-section, .status-section {
        flex: 1;
        min-width: 300px;
        padding: 30px;
    }

    .form-section {
        border-right: 1px solid #ddd;
    }

    h2 {
        margin-bottom: 15px;
        color: #333;
    }

    label {
        display: block;
        margin-top: 10px;
        color: #555;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .password-wrapper {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #4b6cb7;
        font-size: 14px;
        font-weight: bold;
    }

    button {
        width: 100%;
        padding: 10px;
        margin-top: 15px;
        border: none;
        background-color: #2a6edb;
        color: white;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }

    button:hover {
        background-color: #1b4ea5;
    }

    .login-link {
        text-align: center;
        margin-top: 10px;
    }

    .login-link a {
        color: #2a6edb;
        text-decoration: none;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    .status-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .status-box {
        padding: 15px;
        border-radius: 5px;
        background: #f8f9fa;
        text-align: center;
        width: 80%;
    }

    .status-box.complete {
        background: #e0ffe0;
        border: 1px solid #6cc96c;
        color: #2e7d32;
    }

    .status-box.pending {
        background: #fff3cd;
        border: 1px solid #ffecb5;
        color: #856404;
    }
</style>
</head>
<body>

<div class="container">
    <div class="top">Become an Organization Admin today!</div>

    <div class="bottom">
        <!-- Left Section: Registration Form -->
        <div class="form-section">
            <h2>Organization Registration</h2>
            <form method="POST" action="">
                <label>Organization Name:</label>
                <input type="text" name="orgName" required>

                <label>Organization Email:</label>
                <input type="email" name="orgEmail" required>

                <label>Phone Number (M-Pesa):</label>
                <input type="text" name="phone" placeholder="e.g. 07XXXXXXXX" required>

                <label>Password:</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" required>
                    
                    
                </div>

                <button type="submit">Register Organization</button>
            </form>

            <div class="login-link">
                Already an Organisation Admin? <a href="adminlogin.php">Login here</a>
            </div>
        </div>

        <!-- Right Section: Payment Status -->
        <div class="status-section">
            <?php if (isset($paymentMessage)): ?>
                <div class="status-box <?= $paymentDone ? 'complete' : 'pending' ?>">
                    <?= htmlspecialchars($paymentMessage) ?>
                </div>
            <?php else: ?>
                <div class="status-box pending">
                    M-Pesa Payment Pending. Please complete payment to continue.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordField = document.getElementById("password");
    const toggleBtn = document.querySelector(".toggle-password");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleBtn.textContent = "Hide";
    } else {
        passwordField.type = "password";
        toggleBtn.textContent = "Show";
    }
}
</script>

</body>
</html>
