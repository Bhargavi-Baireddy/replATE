<?php
session_start();
require_once 'config.php';

$conn = getDBConnection();

// Only donors can add donations
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    echo "unauthorized";
    exit;
}

$donor_id = $_SESSION['user_id'];
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$quantity = intval($_POST['quantity'] ?? 0);

if (empty($title) || $quantity <= 0) {
    echo "invalid";
    exit;
}

$stmt = $conn->prepare("INSERT INTO donations (donor_id, title, description, quantity) VALUES (?, ?, ?, ?)");
$stmt->bind_param("issi", $donor_id, $title, $description, $quantity);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>