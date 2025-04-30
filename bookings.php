<?php
$current_page = 'bookings';
$page_title = 'My Bookings';
require_once 'includes/header.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Get user bookings
$user_id = $_SESSION['user_id'];
$bookings = getUserBookings($user_id);
?>

<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">My Bookings</h1>
        <p class="lead">View and manage your car rental bookings</p>
    </div>
</section>

<!-- Bookings Section -->
<section class="py-5">
    <div class="container">
        <?php if (empty($bookings)): ?>
            <div class="alert alert-info">
                <h4 class="alert-heading">No Bookings Found</h4>
                <p>You haven't made any bookings yet. Browse our cars and make your first booking today!</p>
                <hr>
                <a href="cars.php" class="btn btn-primary">Browse Cars</a>
            </div>
        <?php else: ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Your Bookings</h2>
                        <a href="cars.php" class="btn btn-outline-primary">Book Another Car</a>
                    </div>
                </div>
            </div>
            
            <div class="row g-4">
                <?php foreach ($bookings as $booking): ?>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="uploads/<?php echo $booking['car_image']; ?>" class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="<?php echo $booking['car_name']; ?>">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $booking['car_name']; ?></h5>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-<?php 
                                                if ($booking['status'] === 'confirmed') echo 'success';
                                                elseif ($booking['status'] === 'pending') echo 'warning';
                                                elseif ($booking['status'] === 'cancelled') echo 'danger';
                                                else echo 'info';
                                            ?>">
                                                <?php echo ucfirst($booking['status']); ?>
                                            </span>
                                            <small class="text-muted">Booked on: <?php echo date('M d, Y', strtotime($booking['created_at'])); ?></small>
                                        </div>
                                        <ul class="list-unstyled mb-3">
                                            <li><i class="bi bi-calendar-check me-2"></i>Pick-up: <?php echo date('M d, Y', strtotime($booking['pickup_date'])); ?></li>
                                            <li><i class="bi bi-calendar-x me-2"></i>Return: <?php echo date('M d, Y', strtotime($booking['return_date'])); ?></li>
                                            <li><i class="bi bi-cash me-2"></i>Total: $<?php echo number_format($booking['total_price'], 2); ?></li>
                                        </ul>
                                        <?php if ($booking['status'] === 'pending'): ?>
                                            <div class="d-flex gap-2">
                                                <a href="process/cancel_booking.php?id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</a>
                                                <a href="#" class="btn btn-sm btn-outline-primary">Contact Support</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>