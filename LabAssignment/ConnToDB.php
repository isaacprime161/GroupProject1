<?php
// Debug: print resolved autoload.php path
require_once _DIR_ . '/../vendor/autoload.php';
// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(_DIR_);
$dotenv->load();

// Read database settings
$host = $_ENV['DB_HOST'];
$db   = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

// Connect using PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo " Connected successfully to database: $db";
} catch (PDOException $e) {
    echo " Connection failed: " . $e->getMessage();
}
?>