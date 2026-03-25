<?php
// setup.php
$conn = new mysqli('localhost', 'root', '');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$db_sql = "CREATE DATABASE IF NOT EXISTS replate";
$conn->query($db_sql);
$conn->select_db('replate');

// ----------------- USERS TABLE -----------------
$conn->query("DROP TABLE IF EXISTS users");
$users_sql = "CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('donor','ngo','volunteer','admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($users_sql);

// Insert demo users
$demo_users = [
    ['Demo Donor','1234567890','demo','demo','donor'],
    ['Demo NGO','0987654321','demo@ngo.com','demo','ngo'],
    ['Demo Volunteer','1122334455','demo@volunteer.com','demo','volunteer'],
    ['Demo Admin','5566778899','demo@admin.com','demo','admin']
];

$stmt = $conn->prepare("INSERT INTO users (name, phone, email, password, role) VALUES (?, ?, ?, ?, ?)");
foreach ($demo_users as $u) {
    $hashed_pw = password_hash($u[3], PASSWORD_DEFAULT);
    $stmt->bind_param("sssss", $u[0], $u[1], $u[2], $hashed_pw, $u[4]);
    $stmt->execute();
}

// ----------------- DONATIONS TABLE -----------------
$conn->query("DROP TABLE IF EXISTS donations");
$donations_sql = "CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donor_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    quantity INT NOT NULL,
    status ENUM('available','claimed','distributed') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (donor_id) REFERENCES users(id) ON DELETE CASCADE
)";
$conn->query($donations_sql);

// ----------------- CLAIMED DONATIONS TABLE -----------------
$conn->query("DROP TABLE IF EXISTS claimed_donations");
$claimed_sql = "CREATE TABLE claimed_donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donation_id INT NOT NULL,
    volunteer_id INT NOT NULL,
    claimed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending','completed') DEFAULT 'pending',
    FOREIGN KEY (donation_id) REFERENCES donations(id) ON DELETE CASCADE,
    FOREIGN KEY (volunteer_id) REFERENCES users(id) ON DELETE CASCADE
)";
$conn->query($claimed_sql);

echo "✅ Database setup complete with users, donations, and claimed_donations tables.<br>";
echo "You can now use demo users or sign up new users.";
$conn->close();
?>