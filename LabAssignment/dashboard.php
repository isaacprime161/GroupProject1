<?php
session_start();
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['logged_in_user'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Welcome, <?= htmlspecialchars($user['name']) ?> 👋</h2>
  <p>You are logged in successfully.</p>

  <a href="users.php" class="btn btn-info">View all users</a>
  <a href="logout.php" class="btn btn-danger">Logout</a>
</div>
</body>
</html>