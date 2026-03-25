<?php
session_start();
require_once 'config.php';

$conn = getDBConnection();

// Only volunteers or NGOs can claim donations
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['volunteer','ngo'])) {
    echo "unauthorized";
    exit;
}

$user_id = $_SESSION['user_id'];
$donation_id = intval($_POST['donation_id'] ?? 0);

if ($donation_id <= 0) {
    echo "invalid";
    exit;
}

// Check if donation exists and is available
$stmt = $conn->prepare("SELECT status FROM donations WHERE id=?");
$stmt->bind_param("i", $donation_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if ($row['status'] !== 'available') {
        echo "unavailable";
        exit;
    }
} else {
    echo "notfound";
    exit;
}

// Insert into claimed_donations
$stmt = $conn->prepare("INSERT INTO claimed_donations (donation_id, volunteer_id) VALUES (?, ?)");
$stmt->bind_param("ii", $donation_id, $user_id);

if ($stmt->execute()) {
    // Update donation status
    $stmt2 = $conn->prepare("UPDATE donations SET status='claimed' WHERE id=?");
    $stmt2->bind_param("i", $donation_id);
    $stmt2->execute();
    $stmt2->close();

    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>