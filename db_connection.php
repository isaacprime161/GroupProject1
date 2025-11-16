<?php
require_once __DIR__ . '/vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function ConnToDB() {
    $host     = $_ENV['DB_HOST'];
    $port     = $_ENV['DB_PORT'];
    $dbname   = $_ENV['DB_NAME'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];

    try {
        $conn = new PDO(
            "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4",
            $username,
            $password
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
        $port     = isset($_ENV['DB_PORT']) ? $_ENV['DB_PORT'] : 3306;
}

// Test the connection
try {
    $conn = ConnToDB();
    
} catch (Exception $e) {
   
}
