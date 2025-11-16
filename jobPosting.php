<?php
require_once 'db_connection.php';
session_start();

if (!isset($_SESSION['org_id'])) {
    die("Access denied. Please log in as organization.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $org_id = $_SESSION['org_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("INSERT INTO jobs (org_id, title, description, salary, location) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $org_id, $title, $description, $salary, $location);

    if ($stmt->execute()) {
        echo "Job posted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Post a Job</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f6f8;
                margin: 0;
                padding: 20px;
            }
            .form-container {
                background-color: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                max-width: 500px;
                margin: auto;
            }
            .form-container h2 {
                margin-top: 0;
            }
            .form-container input, .form-container textarea {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
            .form-container button {
                background-color: #1b263b;
                color: white;
                padding: 10px 15px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            .form-container button:hover {
                background-color: #162030;
            }
        </style>
    </head>
    <body>
        <div class="form-container">
            <h2>Post a Job</h2>
            <form method="POST" action="">
                <input type="text" name="title" placeholder="Job Title" required>
                <textarea name="description" placeholder="Job Description" required></textarea>
                <input type="text" name="salary" placeholder="Salary" required>
                <input type="text" name="location" placeholder="Location" required>
                <button type="submit">Post Job</button>
            </form>
        </div>
    </body>
</html>