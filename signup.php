<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// If the request is GET, show the registration form
if ($_SERVER["REQUEST_METHOD"] === "GET") {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            background-color: #f0f8ff;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #2c3e50;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"] {
            width: 85%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #bdc3c7;
            border-radius: 6px;
            outline: none;
            font-size: 16px;
            font-family: 'Arial', sans-serif;
        }
        input:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
        .gender-group {
            margin: 10px 0;
            text-align: left;
            width: 85%;
            display: inline-block;
        }
        .gender-group label {
            font-size: 16px;
            margin-right: 20px;
            color: #2c3e50;
        }
        button {
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 14px 20px;
            width: 90%;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
            transition: background 0.3s ease;
            font-family: 'Arial', sans-serif;
        }
        button:hover {
            background-color: #2980b9;
        }
        .link {
            display: block;
            margin-top: 20px;
            font-size: 14px;
            color: #3498db;
            text-decoration: none;
            font-family: 'Arial', sans-serif;
            font-weight: bold;
        }
        .link:hover {
            text-decoration: underline;
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
        <h2>Register Here</h2>
        <form method="POST" action="">
            <input type="text" name="firstname" placeholder="Enter first name" required><br>
            <input type="text" name="lastname" placeholder="Enter last name" required><br>
            <input type="number" name="age" placeholder="Enter age" required><br>

            <!-- ✅ Gender now as radio buttons -->
            <div class="gender-group">
                <label><input type="radio" name="gender" value="Male" required> Male</label>
                <label><input type="radio" name="gender" value="Female" required> Female</label>
            </div><br>

            <input type="text" name="phonenumber" placeholder="Enter phone number" required><br>
            <input type="email" name="email" placeholder="Enter email" required><br>
            <input type="password" name="password" placeholder="Enter password" required><br>
            <button type="submit">Register</button>
        </form>
        <a href="login.php" class="link">Already have an account? Login</a>
    </div>
</body>
</html>
<?php
    exit;
}

// ------------------- PHP Backend Logic -------------------
header("Content-Type: application/json");

require_once 'db_connection.php';
$pdo = ConnToDB();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname  = $conn->real_escape_string($_POST['lastname']);
    $age       = $conn->real_escape_string($_POST['age']);
    $gender    = $conn->real_escape_string($_POST['gender']); // unchanged logic
    $phonenumber = $conn->real_escape_string($_POST['phonenumber']);
    $email     = $conn->real_escape_string($_POST['email']);
    $password  = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $code      = rand(100000, 999999); // 6-digit verification code

    // Check if email already exists
   
    $checkEmail = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->execute([$email]);
    if ($checkEmail->rowCount() > 0) {
        echo json_encode(["status" => "error", "message" => "Email already exists."]);
        exit;
    }

    // Insert user with verification code and verified = 0
  
        $sql = "INSERT INTO users (firstname, lastname, age, gender, phonenumber, email, password, verification_code, verified)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, FALSE)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$firstname, $lastname, $age, $gender, $phonenumber, $email, $password, $code])) {

        if ($conn->query($sql) === TRUE) {
        // Send verification email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tevin.mwangi@strathmore.edu'; // replace with your email
            $mail->Password = 'excs eilc hmms hjgf'; // use Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tevin.mwangi@strathmore.edu', 'GeoLink');
            $mail->addAddress($email);
            $mail->Subject = 'Your GeoLink Verification Code';
            $mail->Body = "Hello $firstname,\n\nYour verification code is: $code\n\nPlease enter this code on the verification page to activate your account.\n\nGeoLink Team";

            $mail->send();

            echo json_encode(["status" => "success", "message" => "Registration successful! Verification code sent to your email."]);
            header("Location: verify.php?email=" . urlencode($email));
            exit;
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Email sending failed: {$mail->ErrorInfo}"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "DB Error: " . $conn->error]);
    }
    } 
}

?>