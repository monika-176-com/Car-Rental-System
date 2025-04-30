<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    setAlert('Please log in to make a booking.', 'danger');
    redirect('../index.php');
}

// Process booking form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = (int) $_POST['car_id'];
    $pickup_date = sanitize($_POST['pickup_date']);
    $return_date = sanitize($_POST['return_date']);
    $pickup_location = sanitize($_POST['pickup_location']);
    $return_location = sanitize($_POST['return_location']);
    $additional_requirements = sanitize($_POST['additional_requirements'] ?? '');
    
    // Validate inputs
    $errors = [];
    
    if (empty($car_id)) {
        $errors[] = 'Car selection is required';
    }
    
    if (empty($pickup_date)) {
        $errors[] = 'Pick-up date is required';
    }
    
    if (empty($return_date)) {
        $errors[] = 'Return date is required';
    }
    
    if (strtotime($pickup_date) >= strtotime($return_date)) {
        $errors[] = 'Return date must be after pick-up date';
    }
    
    if (empty($pickup_location)) {
        $errors[] = 'Pick-up location is required';
    }
    
    if (empty($return_location)) {
        $errors[] = 'Return location is required';
    }
    
    if (empty($errors)) {
        // Calculate total price
        $total_price = calculateBookingPrice($car_id, $pickup_date, $return_date);
        
        // Create booking
        $result = createBooking([
            'user_id' => $_SESSION['user_id'],
            'car_id' => $car_id,
            'pickup_date' => $pickup_date,
            'return_date' => $return_date,
            'pickup_location' => $pickup_location,
            'return_location' => $return_location,
            'additional_requirements' => $additional_requirements,
            'total_price' => $total_price
        ]);
        
        if ($result) {
            setAlert('Booking confirmed! We will contact you shortly with more details.');
            redirect('../bookings.php');
        } else {
            setAlert('Booking failed. Please try again later.', 'danger');
            redirect('../cars.php');
        }
    } else {
        setAlert('Please fix the following errors: ' . implode(', ', $errors), 'danger');
        redirect('../cars.php');
    }
} else {
    // Redirect to cars page if accessed directly
    redirect('../cars.php');
}
?>