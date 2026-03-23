<?php
include '../config/database.php';
header("Content-Type: application/json");

$action = $_POST['action'] ?? $_GET['action'] ?? '';

$data = [];
if ($_POST) {
    $data = $_POST;
} else {
    $data = json_decode(file_get_contents("php://input"), true);
}

if ($action == "register") {
    // Validate required fields
    if (!isset($data['name'], $data['email'], $data['password'], $data['role'])) {
        echo json_encode(["status" => "error", "message" => "Missing required fields"]);
        exit;
    }

    $name = trim($data['name']);
    $email = trim($data['email']);
    $password = password_hash($data['password'], PASSWORD_BCRYPT);
    $role = $data['role'];
    $phone = trim($data['phone'] ?? '');
    $address = trim($data['address'] ?? '');

    // Check if email exists
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    if ($checkStmt->get_result()->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already registered"]);
        exit;
    }

    // Insert user with all fields
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $password, $role, $phone, $address);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Account created successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Registration failed: " . $stmt->error]);
    }
}

if ($action == "login") {
    $email = trim($data['email']);
    $password = $data['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc();

    if ($result && password_verify($password, $result['password'])) {
        session_start();
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['user_role'] = $result['role'];
        echo json_encode(["status" => "success", "user" => $result, "redirect" => "../dashboard/" . $result['role'] . ".php"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
    }
}
?>

