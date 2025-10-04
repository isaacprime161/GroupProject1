<?php
// signup.php
header("Content-Type: application/json");

// Database config (MariaDB connection)
$host = "localhost:3305";   // or "localhost"
$user = "root";        // your MariaDB username
$pass = "Kvmurji7";            // your MariaDB password
$dbname = "geolink";

// Connect to MariaDB
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "DB Connection failed: " . $conn->connect_error]));
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname  = $conn->real_escape_string($_POST['lastname']);
    $email     = $conn->real_escape_string($_POST['email']);
    $password  = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email exists
    $checkEmail = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($checkEmail->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already registered"]);
        exit;
    }

    // Insert user
    $sql = "INSERT INTO users (firstname, lastname, email, password)
            VALUES ('$firstname', '$lastname', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Registration successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "DB Error: " . $conn->error]);
    }
}
$conn->close();