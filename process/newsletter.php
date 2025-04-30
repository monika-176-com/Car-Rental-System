<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Process newsletter subscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    
    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setAlert('Please enter a valid email address.', 'danger');
        redirect($_SERVER['HTTP_REFERER'] ?? '../index.php');
    }
    
    // Subscribe to newsletter
    $result = subscribeNewsletter($email);
    
    if ($result === 'exists') {
        setAlert('You are already subscribed to our newsletter.');
    } elseif ($result) {
        setAlert('Thank you for subscribing to our newsletter!');
    } else {
        setAlert('Subscription failed. Please try again later.', 'danger');
    }
    
    redirect($_SERVER['HTTP_REFERER'] ?? '../index.php');
} else {
    // Redirect to home page if accessed directly
    redirect('../index.php');
}
?>