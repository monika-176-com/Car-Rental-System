<?php
// Get all cars with optional filters
function getCars($filters = []) {
    global $conn;
    
    $sql = "SELECT * FROM cars WHERE 1=1";
    
    // Apply filters
    if (!empty($filters['type'])) {
        $type = sanitize($filters['type']);
        $sql .= " AND type = '$type'";
    }
    
    if (!empty($filters['location'])) {
        $location = sanitize($filters['location']);
        // For simplicity, we're not filtering by location in this example
        // In a real application, you would need a relationship between cars and locations
    }
    
    if (!empty($filters['min_price']) && !empty($filters['max_price'])) {
        $min_price = (float) $filters['min_price'];
        $max_price = (float) $filters['max_price'];
        $sql .= " AND price_per_day BETWEEN $min_price AND $max_price";
    }
    
    if (isset($filters['available']) && $filters['available']) {
        $sql .= " AND is_available = 1";
    }
    
    $sql .= " ORDER BY price_per_day ASC";
    
    $result = $conn->query($sql);
    $cars = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cars[] = $row;
        }
    }
    
    return $cars;
}

// Get car by ID
function getCarById($id) {
    global $conn;
    $id = (int) $id;
    
    $sql = "SELECT * FROM cars WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

// Get all locations
function getLocations() {
    global $conn;
    
    $sql = "SELECT * FROM locations ORDER BY name ASC";
    $result = $conn->query($sql);
    $locations = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $locations[] = $row;
        }
    }
    
    return $locations;
}

// Create a new booking
function createBooking($data) {
    global $conn;
    
    $user_id = (int) $data['user_id'];
    $car_id = (int) $data['car_id'];
    $pickup_date = sanitize($data['pickup_date']);
    $return_date = sanitize($data['return_date']);
    $pickup_location = sanitize($data['pickup_location']);
    $return_location = sanitize($data['return_location']);
    $additional_requirements = sanitize($data['additional_requirements'] ?? '');
    $total_price = (float) $data['total_price'];
    
    $sql = "INSERT INTO bookings (user_id, car_id, pickup_date, return_date, pickup_location, return_location, additional_requirements, total_price)
            VALUES ($user_id, $car_id, '$pickup_date', '$return_date', '$pickup_location', '$return_location', '$additional_requirements', $total_price)";
    
    if ($conn->query($sql) === TRUE) {
        return $conn->insert_id;
    }
    
    return false;
}

// Get user bookings
function getUserBookings($user_id) {
    global $conn;
    $user_id = (int) $user_id;
    
    $sql = "SELECT b.*, c.name as car_name, c.image as car_image 
            FROM bookings b 
            JOIN cars c ON b.car_id = c.id 
            WHERE b.user_id = $user_id 
            ORDER BY b.created_at DESC";
    
    $result = $conn->query($sql);
    $bookings = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }
    
    return $bookings;
}

// Subscribe to newsletter
function subscribeNewsletter($email) {
    global $conn;
    $email = sanitize($email);
    
    // Check if email already exists
    $sql = "SELECT id FROM subscribers WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        return 'exists';
    }
    
    $sql = "INSERT INTO subscribers (email) VALUES ('$email')";
    
    if ($conn->query($sql) === TRUE) {
        return true;
    }
    
    return false;
}

// Send contact message
function sendContactMessage($data) {
    global $conn;
    
    $name = sanitize($data['name']);
    $email = sanitize($data['email']);
    $subject = sanitize($data['subject']);
    $message = sanitize($data['message']);
    
    $sql = "INSERT INTO messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        return true;
    }
    
    return false;
}

// Register new user
function registerUser($data) {
    global $conn;
    
    $full_name = sanitize($data['full_name']);
    $email = sanitize($data['email']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    
    // Check if email already exists
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        return 'exists';
    }
    
    $sql = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        return $conn->insert_id;
    }
    
    return false;
}

// Login user
function loginUser($email, $password) {
    global $conn;
    
    $email = sanitize($email);
    
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            return true;
        }
    }
    
    return false;
}

// Logout user
function logoutUser() {
    // Unset all session variables
    $_SESSION = [];
    
    // Destroy the session
    session_destroy();
    
    return true;
}

// Calculate booking price
function calculateBookingPrice($car_id, $pickup_date, $return_date) {
    global $conn;
    
    $car_id = (int) $car_id;
    $pickup_date = new DateTime($pickup_date);
    $return_date = new DateTime($return_date);
    
    // Calculate number of days
    $interval = $pickup_date->diff($return_date);
    $days = $interval->days;
    
    // Get car price per day
    $sql = "SELECT price_per_day FROM cars WHERE id = $car_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $car = $result->fetch_assoc();
        $price_per_day = $car['price_per_day'];
        
        // Calculate total price
        $total_price = $price_per_day * $days;
        
        return $total_price;
    }
    
    return 0;
}
?>