<?php
require_once __DIR__ . '/../../includes/functions.php';

if (!$functions->isLoggedIn()) {
    echo "Login required";
    exit();
}

$db = $functions->getDB();
$user = $functions->getCurrentUser();

$stmt = $db->prepare("
INSERT INTO food_donations (donor_id,food_type,quantity,location_lat,location_lng,expiry_time,status)
VALUES (?,?,?,?,?,?, 'available')
");

$stmt->execute([
    $user['id'],
    $_POST['food_type'],
    $_POST['quantity'],
    $_POST['lat'],
    $_POST['lng'],
    $_POST['expiry']
]);

echo "Donation added!";