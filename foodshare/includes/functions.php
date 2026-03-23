<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

if (!isset($db)) {
    $db = new Database();
}

class FoodShareFunctions {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db->getConnection();
    }

    public function getDB() {
        return $this->db;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser() {
        if (!$this->isLoggedIn()) return null;

        $stmt = $this->db->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    }

    public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    // ✅ Nearby donations
    public function getNearbyDonations($lat, $lng, $radius = 10) {
        $userId = $_SESSION['user_id'] ?? 0;

        $stmt = $this->db->prepare("
            SELECT fd.*, u.name as donor_name,
            (6371 * acos(
                cos(radians(?)) * cos(radians(fd.location_lat)) * 
                cos(radians(fd.location_lng) - radians(?)) + 
                sin(radians(?)) * sin(radians(fd.location_lat))
            )) AS distance
            FROM food_donations fd
            JOIN users u ON fd.donor_id = u.id
            WHERE fd.status='available'
            AND fd.expiry_time > NOW()
            AND fd.donor_id != ?
            HAVING distance < ?
            ORDER BY distance ASC
        ");

        $stmt->execute([$lat, $lng, $lat, $userId, $radius]);
        return $stmt->fetchAll();
    }
}

$functions = new FoodShareFunctions();
?>