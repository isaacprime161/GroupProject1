<?php
include 'config.php';
session_start();

if (!isset($_SESSION['org_id'])) {
    die("Access denied. Please log in as organization.");
}

$org_id = $_SESSION['org_id'];

$sql = "SELECT a.app_id, u.firstname, u.lastname, u.email, a.cover_letter, a.status 
        FROM applications a
        JOIN jobs j ON a.job_id = j.job_id
        JOIN users u ON a.user_id = u.id
        WHERE j.org_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $org_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<div>";
    echo "<h4>{$row['firstname']} {$row['lastname']}</h4>";
    echo "<p>Email: {$row['email']}</p>";
    echo "<p>Status: {$row['status']}</p>";
    echo "<form action='update_application.php' method='POST'>
            <input type='hidden' name='app_id' value='{$row['app_id']}'>
            <button name='action' value='accept'>Accept</button>
            <button name='action' value='reject'>Reject</button>
          </form>";
    echo "</div><hr>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applicants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
        }
        div {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }
        h4 {
            margin: 0 0 10px 0;
        }
        form button {
            margin-right: 10px;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        form button[name="action"][value="accept"] {
            background-color: #4CAF50;
            color: white;
        }
        form button[name="action"][value="reject"] {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <h1>View Applicants</h1>
    <?php
    include 'config.php';
    session_start();

    if (!isset($_SESSION['org_id'])) {
        die("Access denied. Please log in as organization.");
    }

    $org_id = $_SESSION['org_id'];

    $sql = "SELECT a.app_id, u.firstname, u.lastname, u.email, a.cover_letter, a.status 
            FROM applications a
            JOIN jobs j ON a.job_id = j.job_id
            JOIN users u ON a.user_id = u.id
            WHERE j.org_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $org_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h4>{$row['firstname']} {$row['lastname']}</h4>";
        echo "<p>Email: {$row['email']}</p>";
        echo "<p>Status: {$row['status']}</p>";
        echo "<form action='update_application.php' method='POST'>
                <input type='hidden' name='app_id' value='{$row['app_id']}'>
                <button name='action' value='accept'>Accept</button>
                <button name='action' value='reject'>Reject</button>
              </form>";
        echo "</div><hr>";
    }
    ?>
</body>
</html>
