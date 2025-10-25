<?php
session_start();
$userId = $_SESSION['user_id'] ?? null;
require_once _DIR_ . '/users.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id']; // 
    $otp = $_POST['otp'];

    $user = new User();
    $isVerified = $user->verifyOTP($userId, $otp);

    if ($isVerified) {
        $message = "Account verified successfully! You can now log in.";
    } else {
        $message = "Invalid or expired OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Verify Your Account</h2>

  <?php if ($message): ?>
    <div class="alert alert-info"><?= $message ?></div>
  <?php endif; ?>

  <form method="POST">
    <input type="hidden" name="user_id" value="<?= htmlspecialchars($userId) ?>">

    <div class="mb-3">
      <label class="form-label">Enter OTP Code</label>
      <input type="text" name="otp" class="form-control" placeholder="6-digit code" required>
    </div>

    <button type="submit" class="btn btn-success">Verify</button>
  </form>
</div>
</body>
</html>