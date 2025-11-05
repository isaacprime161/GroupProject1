<?php
session_start();
require_once "db_connection.php";

class LoginScreen {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function handleLogin() {
        $message = "";

        if (isset($_POST['login'])) {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                header("Location: home.php");
                exit();
            } else {
                $message = "❌ Invalid email or password.";
            }
        }

        return $message;
    }

    public function show($message = "") {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Login</title>
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: #f9fafb;
                    margin: 0;
                }
                .container {
                    text-align: center;
                    background: white;
                    padding: 35px;
                    border-radius: 16px;
                    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.15);
                    width: 360px;
                }
                img {
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;
                    margin-bottom: 10px;
                    border: 3px solid #2563eb;
                }
                h1 {
                    color: #2563eb;
                    margin-bottom: 20px;
                }
                input {
                    width: 90%;
                    padding: 10px;
                    margin: 10px 0;
                    border: 1px solid #d1d5db;
                    border-radius: 6px;
                    font-size: 14px;
                    transition: border 0.3s ease;
                }
                input:focus {
                    border-color: #2563eb;
                    outline: none;
                    box-shadow: 0 0 5px rgba(37, 99, 235, 0.3);
                }
                button {
                    background: #2563eb;
                    color: white;
                    border: none;
                    padding: 10px 22px;
                    border-radius: 6px;
                    cursor: pointer;
                    font-weight: bold;
                    transition: background 0.3s ease;
                }
                button:hover {
                    background: #1d4ed8;
                }
                .link {
                    margin-top: 18px;
                    display: block;
                    font-weight: bold;
                    font-size: 14px;
                    color: #2563eb;
                    text-decoration: none;
                    transition: color 0.3s ease;
                }
                .link:hover {
                    color: #1d4ed8;
                    text-decoration: underline;
                }
                .message {
                    color: #dc2626;
                    margin-bottom: 10px;
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <img src="assets/login.png" alt="login image">
                <h1>Login Here</h1>

                <?php if (!empty($message)): ?>
                    <div class="message"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <input type="email" name="email" placeholder="Enter email" required><br>
                    <input type="password" name="password" placeholder="Enter password" required><br>
                    <button type="submit" name="login">Login</button>
                </form>

                <a href="signup.php" class="link">Don't have an account? Register</a>
            </div>
        </body>
        </html>
        <?php
    }
}

$loginScreen = new LoginScreen();
$message = $loginScreen->handleLogin();
$loginScreen->show($message);
?>
