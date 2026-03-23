<?php
/**
 * Database configuration class for FoodShare app
 * XAMPP MySQL port 3305
 */

class Database {
    private $host = 'localhost';
    private $port = 3305;
    private $db_name = 'foodshare_db';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DB Connection failed: " . $e->getMessage());
            http_response_code(500);
            die("Database connection failed: " . $e->getMessage());
        }
        
        return $this->conn;
    }
}

// Global instance
$db = new Database();
?>

