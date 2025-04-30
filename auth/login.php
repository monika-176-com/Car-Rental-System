<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('../index.php');
}

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    // Validate inputs
    $errors = [];
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required';
    }
    
    if (empty($password)) {
        $errors[] = 'Password is required';
    }
    
    if (empty($errors)) {
        // Login user
        $result = loginUser($email, $password);
        
        if ($result) {
            setAlert('Login successful! Welcome back.');
            redirect('../index.php');
        } else {
            setAlert('Invalid email or password. Please try again.', 'danger');
            redirect('../index.php');
        }
    } else {
        setAlert('Please fix the following errors: ' . implode(', ', $errors), 'danger');
        redirect('../index.php');
    }
} else {
    // Redirect to home page if accessed directly
    redirect('../index.php');
}
?>