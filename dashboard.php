<?php
$host = "127.0.0.1";
$user = "root";
$pass = "0000";
$dbname = "geolink";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("Database connection failed: " . $conn->connect_error);

$welcome_message = "Welcome to Geolink!";
$website_name = "Geolink";
$description = "This dashboard is designed to provide an intuitive and engaging experience for our users and clients.
Explore below to learn more about how you can interact with our platform.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $website_name; ?> Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <header class="bg-blue-600 text-white py-12 text-center shadow-md">
    <h1 class="text-4xl font-bold mb-3"><?php echo $welcome_message; ?></h1>
    <p class="text-lg max-w-2xl mx-auto mb-8"><?php echo $description; ?></p>
    <div class="space-x-4">
      <a href="login.php" class="bg-white text-blue-600 font-semibold px-5 py-2 rounded-lg hover:bg-blue-100 transition">Login</a>
      <a href="signup.php" class="bg-yellow-400 text-white font-semibold px-5 py-2 rounded-lg hover:bg-yellow-500 transition">Sign Up</a>
    </div>
  </header>

  <section class="py-16 px-8 bg-white">
    <h2 class="text-2xl font-semibold text-center mb-10">Explore the Dashboard</h2>
    <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
      <div class="bg-blue-100 p-6 rounded-2xl shadow hover:shadow-lg transition">
        <h3 class="text-xl font-bold mb-3 text-blue-800">Employee</h3>
        <p>Access personalized tools, manage your account, and explore our features made just for you. We offer diverse and widespread options to pick from tailored by the most competitive candididates. Be a part of us today!  </p>
      </div>
      <div class="bg-green-100 p-6 rounded-2xl shadow hover:shadow-lg transition">
        <h3 class="text-xl font-bold mb-3 text-green-800">Organisations</h3>
        <p>We welcome all organisations to join Geolink. Choose clients within our employee pool. Choose yourself by choosing us!!</p>
      </div>
      <div class="bg-yellow-100 p-6 rounded-2xl shadow hover:shadow-lg transition">
        <h3 class="text-xl font-bold mb-3 text-yellow-800">About Section</h3>
        <p>Learn more about our mission, vision, and the values that drive our innovative solutions.</p>
        <a href="#" class="inline-block mt-5 bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Learn More</a>
      </div>
    </div>
  </section>

  <footer class="bg-gray-900 text-gray-200 py-10">
    <div class="max-w-4xl mx-auto text-center">
      <h3 class="text-xl font-semibold mb-3">Contact Information</h3>
      <p>Email: <a href="mailto:info@geolink.com" class="text-blue-400 hover:underline">info@geolink.com</a></p>
      <p>Phone: +254 754996924</p>
      <p>Address: Upperhill, Nairobi, Kenya</p>
      <div class="mt-5">
        <p class="text-gray-400 text-sm">&copy; <?php echo date("Y"); ?> <?php echo $website_name; ?>. All rights reserved.</p>
      </div>
    </div>
  </footer>

</body>
</html>

<?php $conn->close(); ?>
