<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    redirect('../index.php');
}

if (isset($_GET['id'])) {
    $booking_id = (int) $_GET['id'];
    $user_id = $_SESSION['user_id'];
    
    // Check if booking belongs to user
    $sql = "SELECT * FROM bookings WHERE id = $booking_id AND user_id = $user_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
        
        // Only allow cancellation of pending bookings
        if ($booking['status'] === 'pending') {
            $sql = "UPDATE bookings SET status = 'cancelled' WHERE id = $booking_id";
            
            if ($conn->query($sql) === TRUE) {
                setAlert('Booking cancelled successfully.');
            } else {
                setAlert('Failed to cancel booking. Please try again later.', 'danger');
            }
        } else {
            setAlert('Only pending bookings can be cancelled.', 'warning');
        }
    } else {
        setAlert('Booking not found or you do not have permission to cancel it.', 'danger');
    }
} else {
    setAlert('Invalid request.', 'danger');
}

redirect('../bookings.php');
?>