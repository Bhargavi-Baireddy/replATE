<?php
include '../config/database.php';
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "GET") {
    $res = $conn->query("SELECT * FROM donations ORDER BY id DESC");
    $data = [];

    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}

if ($method == "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $conn->prepare(
        "INSERT INTO donations (food, location, quantity, lat, lng, user_id)
         VALUES (?,?,?,?,?,?)"
    );

    $stmt->bind_param(
        "sssddi",
        $data['food'],
        $data['location'],
        $data['quantity'],
        $data['lat'],
        $data['lng'],
        $data['user_id']
    );

    echo json_encode(["success" => $stmt->execute()]);
}
?>