<?php
session_start();
require 'ConnToDB.php';
require 'users.php';

$user = new User();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $loginResult = $user->login($email, $password);

    if ($loginResult === "not_verified") {
        $message = "Your account is not verified. Check your email for OTP.";
        $_SESSION['user_id'] = $loginResult['id'];
        header("Location: verify_otp.php");
        exit();

    } elseif ($loginResult === false) {
        $message = "Invalid email or password.";

    } else {
        // Successful login
        $_SESSION['logged_in_user'] = $loginResult;
        header("Location: dashboard.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h2>Login</h2>

  <?php if ($message): ?>
    <div class="alert alert-warning"><?php echo $message; ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
  </form>

  <p class="mt-3">Don't have an account? <a href="signup.php">Sign up</a></p>

</div>

</body>
</html>