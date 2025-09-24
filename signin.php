<?php
require_once 'ClassAutoLoad.php';
require_once 'conf.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// If already logged in, redirect away immediately
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$error = '';

// Handle POST (login attempt)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim((string)($_POST['email'] ?? ''));
    $password = trim((string)($_POST['password'] ?? ''));

    if ($input === '' || $password === '') {
        $error = "Please enter both email and password.";
    } else {
        try {
            $stmt = $conn->prepare(
                "SELECT id, name, email, password, role 
                 FROM users 
                 WHERE email = :input OR name = :input
                 LIMIT 1"
            );
            $stmt->execute([':input' => $input]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user'] = $user['email'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                // ✅ Redirect immediately to home (navbar will update)
                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            $error = "Database error: " . htmlspecialchars($e->getMessage());
        }
    }
}

// Render login page
$ObjLayouts->header($conf);
$ObjLayouts->navbar($conf);

echo "<main class='container mt-4'>";
if ($error) {
    echo "<div class='alert alert-danger'>" . htmlspecialchars($error) . "</div>";
}
$ObjForms->login();
echo "</main>";

$ObjLayouts->footer($conf);
