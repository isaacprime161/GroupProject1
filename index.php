index.php
<?php
//Create database connection
$servername = "localhost";
$username = "root";
$password = "alex";
$dbname = "pro";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}else {
   echo "Connected successfully to " . $dbname;
}