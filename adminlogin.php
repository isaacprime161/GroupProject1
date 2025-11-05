<?php
session_start();

// --- Database Connection ---
$host = "localhost";
$dbname = "geolink";
$user = "root";
$pass = "0000";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// --- Handle Login ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = htmlspecialchars($_POST['orgEmail']);
    $password = htmlspecialchars($_POST['password']);

    // Fetch organization details based on email
    $stmt = $pdo->prepare("SELECT * FROM organizations WHERE organization_email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $org = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($org && password_verify($password, $org['password'])) {
        // Store session details
        $_SESSION['organization_name'] = $org['organization_name'];
        $_SESSION['organization_email'] = $org['organization_email'];
        $_SESSION['phone_number'] = $org['phone_number'];

        header("Location: home.php");
        exit();
    } else {
        $errorMessage = "Invalid email or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Organization Login</title>
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
        max-width: 500px;
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

    .form-section {
        padding: 30px;
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

    .message {
        margin-top: 15px;
        text-align: center;
        font-size: 0.95rem;
    }

    .error {
        color: #a00;
        background: #ffe5e5;
        padding: 10px;
        border-radius: 5px;
    }

    .register-link {
        text-align: center;
        margin-top: 10px;
    }

    .register-link a {
        color: #2a6edb;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<div class="container">
    <div class="top">Organization Login</div>

    <div class="form-section">
        <form method="POST" action="">
            <label>Organization Email:</label>
            <input type="email" name="orgEmail" required>

            <label>Password:</label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" required>
               
            </div>

            <button type="submit">Login</button>
        </form>

        <?php if (isset($errorMessage)): ?>
            <div class="message error"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <div class="register-link">
            Don’t have an account? <a href="adminsignup.php">Register your organization</a>
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
