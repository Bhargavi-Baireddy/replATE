
-- FoodShare Database Schema
-- Run this in phpMyAdmin or MySQL CLI

CREATE DATABASE IF NOT EXISTS foodshare_db;
USE foodshare_db;

-- Users table (Donors, NGOs, Volunteers, Admin)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('donor', 'ngo', 'volunteer', 'admin') NOT NULL,
    phone VARCHAR(20),
    location_lat DECIMAL(10, 8),
    location_lng DECIMAL(11, 8),
    address TEXT,
    profile_image VARCHAR(255) DEFAULT NULL,
    is_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Food Donations table
CREATE TABLE food_donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donor_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    quantity VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    location_lat DECIMAL(10, 8) NOT NULL,
    location_lng DECIMAL(11, 8) NOT NULL,
    address VARCHAR(500) NOT NULL,
    expiry_time DATETIME NOT NULL,
    status ENUM('available', 'claimed', 'picked_up', 'delivered', 'cancelled', 'expired') DEFAULT 'available',
    views INT DEFAULT 0,
    claims_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (donor_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Claims table (NGO claims donation)
CREATE TABLE claims (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donation_id INT NOT NULL,
    ngo_id INT NOT NULL,
    volunteer_id INT NULL,
    status ENUM('pending', 'accepted', 'picked_up', 'delivered', 'cancelled') DEFAULT 'pending',
    pickup_time DATETIME NULL,
    delivery_time DATETIME NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (donation_id) REFERENCES food_donations(id) ON DELETE CASCADE,
    FOREIGN KEY (ngo_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (volunteer_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Chat Messages
CREATE TABLE chat_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    donation_id INT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (donation_id) REFERENCES food_donations(id) ON DELETE SET NULL
);

-- Notifications
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('claim', 'message', 'pickup', 'delivery', 'system') DEFAULT 'system',
    is_read BOOLEAN DEFAULT FALSE,
    related_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Impact Statistics (for admin dashboard)
CREATE TABLE impact_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    meals_saved INT DEFAULT 0,
    donations INT DEFAULT 0,
    total_weight DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_date (date)
);

-- Indexes for performance
CREATE INDEX idx_donations_status ON food_donations(status);
CREATE INDEX idx_donations_expiry ON food_donations(expiry_time);
CREATE INDEX idx_donations_location ON food_donations(location_lat, location_lng);
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_notifications_user ON notifications(user_id, is_read);
CREATE INDEX idx_claims_status ON claims(status);

-- Sample data for testing
INSERT INTO users (name, email, password, role, phone) VALUES 
('Test Restaurant', 'restaurant@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'donor', '1234567890'),
('Green NGO', 'ngo@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ngo', '0987654321'),
('Fast Volunteer', 'volunteer@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'volunteer', '1112223334'),
('Super Admin', 'admin@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '9998887776');

-- Note: Password is 'password' (hashed)

