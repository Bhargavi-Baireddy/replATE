<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// ✅ Global DB instance first
$db = new Database();

class FoodShareFunctions {
public $db;
    
    public function __construct() {
        global $db;
        $this->db = $db->getConnection();
    }
    
    public function getDb() {
        return $this->db;
    }
    
    // Get current user
    public function getCurrentUser() {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    }
    
    // Check if user is logged in
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    // Check user role
    public function hasRole($role) {
        $user = $this->getCurrentUser();
        return $user && $user['role'] === $role;
    }
    
    // ✅ FIXED: Password hash method (for register.php)
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    // ✅ FIXED: Password verify method (for login.php)
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    // Get nearby donations (Haversine formula)
    public function getNearbyDonations($lat, $lng, $radius = 10) {
        $userId = $_SESSION['user_id'] ?? 0;
        $stmt = $this->db->prepare("
            SELECT fd.*, u.name as donor_name, u.profile_image,
                   (6371 * acos(cos(radians(?)) * cos(radians(fd.location_lat)) * 
                   cos(radians(fd.location_lng) - radians(?)) + 
                   sin(radians(?)) * sin(radians(fd.location_lat)))) AS distance
            FROM food_donations fd
            JOIN users u ON fd.donor_id = u.id
            WHERE fd.status = 'available' AND fd.expiry_time > NOW() AND fd.donor_id != ?
            HAVING distance < ?
            ORDER BY distance ASC
            LIMIT 20
        ");
        $stmt->execute([$lat, $lng, $lat, $userId, $radius]);
        return $stmt->fetchAll();
    }
    
    // Format time remaining for frontend
    public static function timeRemaining($expiry_time) {
        $time_left = strtotime($expiry_time) - time();
        if ($time_left <= 0) return ['expired' => true, 'text' => 'Expired'];
        
        $hours = floor($time_left / 3600);
        $minutes = floor(($time_left % 3600) / 60);
        $seconds = $time_left % 60;
        
        return ['expired' => false, 'text' => sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds)];
    }
    
    // Upload image
    public function uploadImage($file) {
        $target_dir = __DIR__ . '/../assets/images/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . uniqid() . '.' . $file_extension;
        
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_extension, $allowed_types)) {
            return false;
        }
        
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return str_replace(__DIR__ . '/../', '', $target_file);
        }
        return false;
    }
    
    // Create notification
    public function createNotification($user_id, $title, $message, $type = 'system', $related_id = null) {
        $stmt = $this->db->prepare("INSERT INTO notifications (user_id, title, message, type, related_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$user_id, $title, $message, $type, $related_id]);
    }
}

// ✅ Global instance (available everywhere)
$functions = new FoodShareFunctions();

// ✅ Role-based redirect for dashboard pages
if ($functions->isLoggedIn()) {
    $user = $functions->getCurrentUser();
    if ($user) {
        $role_dash = [
            'donor' => 'dashboard/donor.php',
            'ngo' => 'dashboard/ngo.php',
            'volunteer' => 'dashboard/volunteer.php',
            'admin' => 'dashboard/admin.php'
        ];
        if (isset($role_dash[$user['role']])) {
            // Avoid redirect loop in includes
            if (basename($_SERVER['PHP_SELF']) !== $role_dash[$user['role']]) {
                header('Location: ' . $role_dash[$user['role']]);
                exit;
            }
        }
    }
}
?>

