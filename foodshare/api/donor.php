<?php
header('Content-Type: application/json');
require_once '../config/database.php';
require_once '../includes/functions.php';

$db = new Database();
$conn = $db->getConnection();
$functions = new FoodShareFunctions();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create_donation' && $functions->isLoggedIn()) {
        $donor_id = $_SESSION['user_id'];
        $title = trim($_POST['title']);
        $quantity = trim($_POST['quantity']);
        $expiry_time = $_POST['expiry_time'];
        $description = trim($_POST['description']);
        
        // Handle location (demo: use donor's saved location or fixed)
        $lat = 17.3850; // Hyderabad demo
        $lng = 78.4867;
        $address = 'Demo Location - Hyderabad';

        // Upload image
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $functions->uploadImage($_FILES['image']);
        }

        $stmt = $conn->prepare("
            INSERT INTO food_donations (donor_id, title, description, quantity, image, location_lat, location_lng, address, expiry_time, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'available')
        ");
        
        if ($stmt->execute([$donor_id, $title, $description, $quantity, $image, $lat, $lng, $address, $expiry_time])) {
            $donation_id = $conn->lastInsertId();
            
            // Notify nearby NGOs (demo: notify sample NGO)
            $stmt_notify = $conn->prepare("SELECT id FROM users WHERE role = 'ngo' LIMIT 5");
            $stmt_notify->execute();
            foreach ($stmt_notify->fetchAll() as $ngo) {
                $functions->createNotification($ngo['id'], 'New Donation Nearby', "New '{$title}' donation posted near you!", 'donation', $donation_id);
            }
            
            echo json_encode(['success' => true, 'donation_id' => $donation_id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create donation']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Unauthorized or invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

