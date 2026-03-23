<?php
/**
 * FoodShare DB Installer - Run once: http://localhost/foodshare/install.php
 */
if (file_exists(__DIR__ . '/installed.flag')) {
    die('Already installed. <a href="index.php">Home</a>');
}

require_once 'config/database.php';

try {
    // Test base connection
    $test_conn = new PDO("mysql:host={$db->host}:3305;charset=utf8mb4", 'root', '');
    $test_conn = null;
    
    // Create DB
    $create_db = $test_conn->exec("CREATE DATABASE IF NOT EXISTS foodshare_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    // Connect to app DB & import schema
    $schema = file_get_contents(__DIR__ . '/sql/schema.sql');
    $db->conn = null; // reset
    $app_conn = $db->getConnection();
    $app_conn->exec($schema);
    
    file_put_contents(__DIR__ . '/installed.flag', 'Installed at ' . date('Y-m-d H:i'));
    echo '<h1 style="color:green">✅ FoodShare DB installed! Schema imported to foodshare_db</h1>';
    echo '<p><a href="index.php">← Go to FoodShare</a> | <a href="pages/auth/login.php">Login</a></p>';
    echo '<p>Demo: restaurant@test.com / password</p>';
    
} catch (Exception $e) {
    echo '<h1 style="color:red">Install failed: ' . htmlspecialchars($e->getMessage()) . '</h1>';
    echo '<p>Check MySQL running on port 3305, root no pass.</p>';
}
?>

