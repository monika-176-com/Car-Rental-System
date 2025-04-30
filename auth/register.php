<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('../index.php');
}

// Process registration form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    // Validate inputs
    $errors = [];
    
    if (empty($full_name)) {
        $errors[] = 'Full name is required';
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required';
    }
    
    if (empty($password) || strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters';
    }
    
    if (empty($errors)) {
        // Register user
        $result = registerUser([
            'full_name' => $full_name,
            'email' => $email,
            'password' => $password
        ]);
        
        if ($result === 'exists') {
            setAlert('Email already exists. Please use a different email or login.', 'danger');
            redirect('../index.php');
        } elseif ($result) {
            // Auto login after registration
            loginUser($email, $password);
            setAlert('Registration successful! Welcome to DriveEase.');
            redirect('../index.php');
        } else {
            setAlert('Registration failed. Please try again later.', 'danger');
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