<?php
require_once 'ClassAutoLoad.php';
require_once 'conf.php';

// Ensure session is started before checking
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Restrict access to admin role
if (!isset($_SESSION['user']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    echo "<main class='container mt-4'><div class='alert alert-danger'>Access denied. Admins only.</div></main>";
    exit;
}

$ObjLayouts->header($conf);
$ObjLayouts->navbar($conf);

echo "<main class='container mt-4'>";
echo "<h2>Registered Users</h2>";

try {
    $stmt = $conn->query("SELECT name, email, role, created_at FROM users ORDER BY name ASC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        echo "<table class='table table-bordered'><thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr></thead><tbody>";
        foreach ($users as $u) {
            echo "<tr><td>".htmlspecialchars($u['name'])."</td><td>".htmlspecialchars($u['email'])."</td><td>".htmlspecialchars($u['role'])."</td><td>".htmlspecialchars($u['created_at'])."</td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No users found.</p>";
    }
} catch (Exception $e) {
    echo "<p class='text-danger'>Could not load users: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "</main>";

$ObjLayouts->footer($conf);
