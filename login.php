<?php
session_start();
require_once 'config.php';

$conn = getDBConnection();

$action = $_POST['action'] ?? '';
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if (empty($email) || empty($password) || empty($role) || empty($action)) {
    echo "invalid";
    exit;
}

// ---------------- LOGIN ----------------
if ($action === 'login') {
    $stmt = $conn->prepare("SELECT id,name,password FROM users WHERE email=? AND role=?");
    $stmt->bind_param("ss",$email,$role);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($row = $result->fetch_assoc()){
        if(password_verify($password,$row['password'])){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
            $_SESSION['name'] = $row['name'];
            echo "success";
        } else { echo "invalid"; }
    } else { echo "invalid"; }
    $stmt->close();
}

// ---------------- SIGNUP ----------------
elseif ($action === 'signup') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    if(empty($name) || empty($phone)){
        echo "invalid"; exit;
    }
    
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->store_result();
    
    if($stmt->num_rows>0){
        echo "exists";
    } else {
        $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, phone, email, password, role) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss",$name,$phone,$email,$hashed_pw,$role);
        if($stmt->execute()){
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
            $_SESSION['name'] = $name;
            echo "success";
        } else { echo "invalid"; }
    }
    $stmt->close();
}

else { echo "invalid"; }

$conn->close();
?>