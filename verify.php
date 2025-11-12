<?php
$host = "127.0.0.1";
$user = "root";
$pass = "0000";
$dbname = "geolink";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $conn->real_escape_string($_POST["email"]);
    $code = $conn->real_escape_string($_POST["code"]);

    $result = $conn->query("SELECT * FROM users WHERE email='$email' AND verification_code='$code'");

    if ($result->num_rows > 0) {
        $conn->query("UPDATE users SET verified=TRUE, verification_code=NULL WHERE email='$email'");
        echo "<script>alert('Email verified successfully! You can now log in.');window.location='login.php';</script>";
    } else {
        echo "<script>alert('Invalid verification code! Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
    <style>
        body {
            background-color: #e9f0f8;
            font-family: cursive, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            width: 400px;
            text-align: center;
        }
        h2 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #2b4c7e;
        }
        input {
            width: 85%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #a3bffa;
            border-radius: 8px;
            outline: none;
            font-size: 16px;
        }
        input:focus {
            border-color: #2b4c7e;
            box-shadow: 0 0 5px rgba(43, 76, 126, 0.4);
        }
        button {
            background-color: #2b4c7e;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            width: 90%;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #1e3457;
        }
        img {
            width: 60px;
            height: auto;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="reo.png" alt="reo">
        <h2>Email Verification</h2>
        <form method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
            <input type="text" name="code" placeholder="Enter verification code" required><br>
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html>
