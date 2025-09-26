<?php

class LoginScreen {

    private $db;

    // Constructor to create a DB connection
    public function __construct() {
       
        $host = "127.0.0.1";   
        $dbname = "geolink"; 
        $user = "root"; 
        $pass = "0000"; 

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }