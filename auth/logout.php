<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Logout user
logoutUser();
setAlert('You have been logged out successfully.');
redirect('../index.php');
?>