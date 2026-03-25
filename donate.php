<?php
session_start();
require 'config.php';
$conn = getDBConnection();

$donor_name = $_POST['donor_name'] ?? '';
$donor_phone = $_POST['donor_phone'] ?? '';
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$expires = $_POST['expires'] ?? '';
$location = $_POST['location'] ?? '';
$category = $_POST['category'] ?? '';

if (!$title || !$quantity || !$donor_name || !$donor_phone) {
    echo "error";
    exit;
}

// Save to donations table
$stmt = $conn->prepare("INSERT INTO donations (donor_name, donor_phone, title, description, quantity, expires_by, location, category) VALUES (?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssisiss", $donor_name, $donor_phone, $title, $description, $quantity, $expires, $location, $category);

if ($stmt->execute()) {

    // Send SMS (Textlocal example)
    $message = "Hi $donor_name, thank you for donating '$title' ($quantity). Your contribution helps feed people in need! – replATE";
    $apiKey = urlencode('YOUR_TEXTLOCAL_API_KEY');
    $numbers = urlencode($donor_phone); 
    $sender = urlencode('REPLATE');
    $msg = urlencode($message);
    $data = "apikey=$apiKey&numbers=$numbers&sender=$sender&message=$msg";

    $ch = curl_init('https://api.textlocal.in/send/?');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    echo "success";
} else {
    echo "error";
}
?>