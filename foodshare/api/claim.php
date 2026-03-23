<?php
header('Content-Type: application/json');
require_once '../config/database.php';
require_once '../includes/functions.php';

$db = new Database();
$conn = $db->getConnection();
$functions = new FoodShareFunctions();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $functions->isLoggedIn() && $functions->hasRole('ngo')) {
    $input = json_decode(file_get_contents('php://input'), true);
    $donation_id = $input['donation_id'] ?? 0;
    
    if ($donation_id > 0) {
        $ngo_id = $_SESSION['user_id'];
        
        // Check if donation available
        $stmt = $conn->prepare("SELECT donor_id, status FROM food_donations WHERE id = ? AND status = 'available'");
        $stmt->execute([$donation_id]);
        $donation = $stmt->fetch();
        
        if ($donation && $donation['donor_id'] != $ngo_id) {
            // Create claim
            $stmt = $conn->prepare("INSERT INTO claims (donation_id, ngo_id, status) VALUES (?, ?, 'pending')");
            if ($stmt->execute([$donation_id, $ngo_id])) {
                $claim_id = $conn->lastInsertId();
                
                // Notify donor
                $functions->createNotification($donation['donor_id'], 'Food Claimed!', 'Your donation has been claimed by an NGO!', 'claim', $donation_id);
                
                // Update donation status
                $stmt = $conn->prepare("UPDATE food_donations SET status = 'claimed', claims_count = claims_count + 1 WHERE id = ?");
                $stmt->execute([$donation_id]);
                
                echo json_encode(['success' => true, 'claim_id' => $claim_id]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create claim']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Donation not available']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid donation ID']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
}
?>

