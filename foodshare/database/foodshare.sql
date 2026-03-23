CREATE DATABASE foodshare;
USE foodshare;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role VARCHAR(20) DEFAULT 'user'
);

CREATE TABLE donations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  food VARCHAR(255),
  location VARCHAR(255),
  quantity VARCHAR(100),
  lat DOUBLE,
  lng DOUBLE,
  user_id INT,
  status VARCHAR(20) DEFAULT 'available'
);

CREATE TABLE claims (
  id INT AUTO_INCREMENT PRIMARY KEY,
  donation_id INT,
  user_id INT,
  status VARCHAR(20) DEFAULT 'pending'
);