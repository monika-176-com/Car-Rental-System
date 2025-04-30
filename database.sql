-- Create database
CREATE DATABASE IF NOT EXISTS driveease;
USE driveease;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_admin TINYINT(1) DEFAULT 0
);

-- Cars table
CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    seats INT NOT NULL,
    fuel_type VARCHAR(50) NOT NULL,
    transmission VARCHAR(50) NOT NULL,
    price_per_day DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    is_available TINYINT(1) DEFAULT 1,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    pickup_date DATE NOT NULL,
    return_date DATE NOT NULL,
    pickup_location VARCHAR(100) NOT NULL,
    return_location VARCHAR(100) NOT NULL,
    additional_requirements TEXT,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
);

-- Newsletter subscribers table
CREATE TABLE IF NOT EXISTS subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contact messages table
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read TINYINT(1) DEFAULT 0
);

-- Locations table
CREATE TABLE IF NOT EXISTS locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample locations
INSERT INTO locations (name, address) VALUES
('New York City', '123 Broadway, New York, NY 10001'),
('Los Angeles', '456 Hollywood Blvd, Los Angeles, CA 90028'),
('Chicago', '789 Michigan Ave, Chicago, IL 60611'),
('Miami', '101 Ocean Drive, Miami, FL 33139');

-- Insert sample cars
INSERT INTO cars (name, type, year, seats, fuel_type, transmission, price_per_day, image, description) VALUES
('Rolls-Royce Phantom', 'Luxury', 2023, 4, 'Petrol', 'Automatic', 1200.00, 'rolls-royce-phantom.jpg', 'Experience ultimate luxury with the Rolls-Royce Phantom.'),
('BMW M4', 'Sports', 2023, 4, 'Petrol', 'Automatic', 280.00, 'bmw-m4.jpg', 'Feel the power of the BMW M4 sports car.'),
('Tesla Model S', 'Electric', 2023, 5, 'Electric', 'Automatic', 265.00, 'tesla-model-s.jpg', 'Drive the future with Tesla Model S electric car.');