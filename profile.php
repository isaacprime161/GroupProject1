<?php
session_start();

// --- Database Connection ---
$host = "127.0.0.1";
$user = "root";
$pass = "0000";
$dbname = "mysql";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("Database connection failed: " . $conn->connect_error);

// --- Example: Logged-in user ID stored in session ---
// (You’ll set this after login; e.g. $_SESSION['user_id'] = $user_id;)
if (!isset($_SESSION['user_id'])) {
  // Redirect to login if not logged in
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// --- Fetch User Details ---
$sql = "SELECT full_name, email, phone FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// --- Handle Profile Update ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  $update_sql = "UPDATE users SET full_name = ?, email = ?, phone = ? WHERE id = ?";
  $update_stmt = $conn->prepare($update_sql);
  $update_stmt->bind_param("sssi", $full_name, $email, $phone, $user_id);

  if ($update_stmt->execute()) {
    $message = "Profile updated successfully!";
    // Refresh user info
    $user = ['full_name' => $full_name, 'email' => $email, 'phone' => $phone];
  } else {
    $message = "Error updating profile.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile - Geolink</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

  <header class="bg-blue-600 text-white py-6 text-center shadow-md">
    <h1 class="text-3xl font-bold">My Profile</h1>
  </header>

  <main class="max-w-xl mx-auto mt-10 bg-white shadow-lg rounded-2xl p-8">
    <?php if (!empty($message)): ?>
      <div class="mb-4 p-3 rounded text-center text-white <?php echo (strpos($message, 'success') !== false) ? 'bg-green-500' : 'bg-red-500'; ?>">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-5">
      <div>
        <label class="block text-gray-700 mb-1 font-semibold">Full Name</label>
        <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>

      <div>
        <label class="block text-gray-700 mb-1 font-semibold">Email Address</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>

      <div>
        <label class="block text-gray-700 mb-1 font-semibold">Phone Number</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>

      <div class="flex justify-between items-center pt-4">
        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">Save Changes</button>
        <a href="dashboard.php" class="text-blue-600 hover:underline">Back to Dashboard</a>
      </div>
    </form>
  </main>

  <footer class="bg-gray-900 text-gray-200 text-center py-6 mt-16">
    <p>&copy; <?php echo date("Y"); ?> Geolink. All rights reserved.</p>
  </footer>

</body>
</html>

<?php $conn->close(); ?>
