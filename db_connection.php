<?php
// db_connection.php
class Database {
    private $host = "127.0.0.1";
    private $dbname = "geolink";
    private $username = "root";
    private $password = "0000";
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("❌ Database connection failed: " . $e->getMessage());
        }
        return $this->conn;
    }
}
?>
