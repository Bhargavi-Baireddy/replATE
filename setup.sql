USE replate;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  phone VARCHAR(20),
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('donor', 'ngo', 'volunteer', 'admin') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Test users
INSERT IGNORE INTO users (name, phone, email, password, role) VALUES
('Test Donor', '+919876543210', 'donor@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'donor'),
('Test NGO', '+919876543211', 'ngo@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ngo'),
('Test Volunteer', '+919876543212', 'vol@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'volunteer'),
('Test Admin', '+919876543213', 'admin@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

CREATE TABLE IF NOT EXISTS donations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  food_name VARCHAR(100) NOT NULL,
  description TEXT,
  quantity VARCHAR(50),
  expires_at DATETIME,
  location VARCHAR(255),
  category VARCHAR(50),
  phone VARCHAR(20),
  donor_id INT,
  status ENUM('active', 'claimed', 'delivered', 'expired') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (donor_id) REFERENCES users(id)
);
