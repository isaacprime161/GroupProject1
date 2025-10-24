<?php
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
            font-size: 28px;
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
            font-family: cursive, sans-serif;
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
            font-family: cursive, sans-serif;
        }

        button:hover {
            background-color: #1e3457;
        }

        .link {
            display: block;
            margin-top: 15px;
            font-size: 14px;
            color: #304a7d;
            text-decoration: none;
            font-family: cursive, sans-serif;
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
            <input type="text" name="gender" placeholder="Enter gender" required><br>
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

$host = "127.0.0.1";
$user = "root";
$pass = "0000";
$dbname = "geolink";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "DB Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname  = $conn->real_escape_string($_POST['lastname']);
    $age       = $conn->real_escape_string($_POST['age']);
    $gender    = $conn->real_escape_string($_POST['gender']);
    $phonenumber  = $conn->real_escape_string($_POST['phonenumber']);
    $email     = $conn->real_escape_string($_POST['email']);
    $password  = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $checkEmail = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($checkEmail->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already registered"]);
        exit;
    }

    // Insert user
    $sql = "INSERT INTO users (firstname, lastname, age, gender, phonenumber, email, password)
            VALUES ('$firstname', '$lastname', '$age', '$gender', '$phonenumber', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Registration successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "DB Error: " . $conn->error]);
    }
}

$conn->close();
?>
