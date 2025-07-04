-- Create database
CREATE DATABASE IF NOT EXISTS travel_agency;
USE travel_agency;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    phone VARCHAR(20),
    address TEXT,
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tours table
CREATE TABLE IF NOT EXISTS tours (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    short_description TEXT,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    discount INT DEFAULT 0,
    duration INT NOT NULL, -- in days
    max_group_size INT,
    category VARCHAR(50),
    featured BOOLEAN DEFAULT FALSE,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Payment methods table
CREATE TABLE IF NOT EXISTS payment_methods (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    processing_fee DECIMAL(5,2) DEFAULT 0.00,
    processing_fee_type ENUM('percentage', 'fixed') DEFAULT 'fixed',
    icon VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Payments table
CREATE TABLE IF NOT EXISTS payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    booking_id INT,
    payment_method_id INT,
    amount DECIMAL(10,2) NOT NULL,
    processing_fee DECIMAL(5,2) DEFAULT 0.00,
    total_amount DECIMAL(10,2) NOT NULL,
    transaction_id VARCHAR(255),
    status ENUM('pending', 'processing', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    payment_data JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id),
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id)
);

-- Bookings table (updated with payment status)
CREATE TABLE IF NOT EXISTS bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    tour_id INT,
    booking_date DATE NOT NULL,
    number_of_people INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled', 'paid', 'refunded') DEFAULT 'pending',
    payment_status ENUM('pending', 'partial', 'completed', 'failed') DEFAULT 'pending',
    special_requests TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (tour_id) REFERENCES tours(id)
);

-- Contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data for tours
INSERT INTO tours (title, short_description, description, price, duration, category, featured, image) VALUES
('Desert Safari Adventure', 'Experience the thrill of dune bashing and traditional entertainment', 'Full description of desert safari...', 299.99, 1, 'adventure', 1, 'assets/images/desert-safari.jpg'),
('Beach Paradise Getaway', 'Relax on pristine beaches with crystal clear waters', 'Full description of beach holiday...', 599.99, 3, 'beach', 1, 'assets/images/beach-paradise.jpg'),
('City Explorer Tour', 'Discover the rich history and culture of the city', 'Full description of city tour...', 199.99, 1, 'city', 1, 'assets/images/city-tour.jpg');

-- Insert payment methods
INSERT INTO payment_methods (name, description, processing_fee, processing_fee_type, icon) VALUES
('Credit Card', 'Visa, MasterCard, American Express', 2.50, 'percentage', 'fas fa-credit-card'),
('PayPal', 'Pay with your PayPal account', 3.00, 'percentage', 'fab fa-paypal'),
('Bank Transfer', 'Direct bank transfer', 5.00, 'fixed', 'fas fa-university'),
('Digital Wallet', 'Apple Pay, Google Pay', 1.50, 'percentage', 'fas fa-mobile-alt'),
('Cash on Arrival', 'Pay when you arrive', 0.00, 'fixed', 'fas fa-money-bill-wave');