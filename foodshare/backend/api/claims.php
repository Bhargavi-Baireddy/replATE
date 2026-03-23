<?php
include '../config/database.php';
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$donation_id = $data['donation_id'];
$user_id = $data['user_id'];

$stmt = $conn->prepare("INSERT INTO claims (donation_id, user_id) VALUES (?,?)");
$stmt->bind_param("ii", $donation_id, $user_id);

echo json_encode(["success" => $stmt->execute()]);
?>