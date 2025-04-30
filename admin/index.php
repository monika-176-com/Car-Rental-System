<?php
$current_page = 'admin_dashboard';
$page_title = 'Admin Dashboard';
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Redirect if not admin
if (!isAdmin()) {
    redirect('../index.php');
}

// Get statistics
$stats = [
    'users' => $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'],
    'cars' => $conn->query("SELECT COUNT(*) as count FROM cars")->fetch_assoc()['count'],
    'bookings' => $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'],
    'pending_bookings' => $conn->query("SELECT COUNT(*) as count FROM bookings WHERE status = 'pending'")->fetch_assoc()['count'],
    'subscribers' => $conn->query("SELECT COUNT(*) as count FROM subscribers")->fetch_assoc()['count'],
    'messages' => $conn->query("SELECT COUNT(*) as count FROM messages")->fetch_assoc()['count'],
    'unread_messages' => $conn->query("SELECT COUNT(*) as count FROM messages WHERE is_read = 0")->fetch_assoc()['count'],
    'revenue' => $conn->query("SELECT SUM(total_price) as total FROM bookings WHERE status != 'cancelled'")->fetch_assoc()['total'] ?? 0
];

// Get recent bookings
$recent_bookings = [];
$result = $conn->query("SELECT b.*, u.full_name as user_name, c.name as car_name 
                        FROM bookings b 
                        JOIN users u ON b.user_id = u.id 
                        JOIN cars c ON b.car_id = c.id 
                        ORDER BY b.created_at DESC LIMIT 5");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recent_bookings[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 0.5rem 1rem;
            margin: 0.2rem 0;
            border-radius: 0.25rem;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #3563E9;
        }
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
        .stat-card {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .stat-card .card-body {
            padding: 1.5rem;
        }
        .stat-card .icon {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <i class="bi bi-car-front text-primary me-2 fs-4"></i>
                        <span class="fs-4">DriveEase</span>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cars.php">
                                <i class="bi bi-car-front"></i> Cars
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="bookings.php">
                                <i class="bi bi-calendar-check"></i> Bookings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php">
                                <i class="bi bi-people"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="messages.php">
                                <i class="bi bi-chat-left-text"></i> Messages
                                <?php if ($stats['unread_messages'] > 0): ?>
                                    <span class="badge bg-danger rounded-pill ms-2"><?php echo $stats['unread_messages']; ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="subscribers.php">
                                <i class="bi bi-envelope"></i> Subscribers
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link" href="../index.php">
                                <i class="bi bi-arrow-left"></i> Back to Website
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="../auth/logout.php">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
                        </div>
                    </div>
                </div>
                
                <?php displayAlert(); ?>
                
                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted">Total Users</h6>
                                        <h3 class="mb-0"><?php echo $stats['users']; ?></h3>
                                    </div>
                                    <div class="icon bg-primary-subtle text-primary">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted">Total Cars</h6>
                                        <h3 class="mb-0"><?php echo $stats['cars']; ?></h3>
                                    </div>
                                    <div class="icon bg-success-subtle text-success">
                                        <i class="bi bi-car-front"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted">Total Bookings</h6>
                                        <h3 class="mb-0"><?php echo $stats['bookings']; ?></h3>
                                    </div>
                                    <div class="icon bg-warning-subtle text-warning">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted">Total Revenue</h6>
                                        <h3 class="mb-0">$<?php echo number_format($stats['revenue'], 2); ?></h3>
                                    </div>
                                    <div class="icon bg-info-subtle text-info">
                                        <i class="bi bi-cash-stack"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Bookings -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Bookings</h5>
                            <a href="bookings.php" class="btn btn-sm btn-primary">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>Car</th>
                                        <th>Dates</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($recent_bookings)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No bookings found</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($recent_bookings as $booking): ?>
                                            <tr>
                                                <td>#<?php echo $booking['id']; ?></td>
                                                <td><?php echo $booking['user_name']; ?></td>
                                                <td><?php echo $booking['car_name']; ?></td>
                                                <td>
                                                    <?php echo date('M d', strtotime($booking['pickup_date'])); ?> - 
                                                    <?php echo date('M d, Y', strtotime($booking['return_date'])); ?>
                                                </td>
                                                <td>$<?php echo number_format($booking['total_price'], 2); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php 
                                                        if ($booking['status'] === 'confirmed') echo 'success';
                                                        elseif ($booking['status'] === 'pending') echo 'warning';
                                                        elseif ($booking['status'] === 'cancelled') echo 'danger';
                                                        else echo 'info';
                                                    ?>">
                                                        <?php echo ucfirst($booking['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="booking_details.php?id=<?php echo $booking['id']; ?>" class="btn btn-outline-primary">View</a>
                                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="update_booking.php?id=<?php echo $booking['id']; ?>&status=confirmed">Confirm</a></li>
                                                            <li><a class="dropdown-item" href="update_booking.php?id=<?php echo $booking['id']; ?>&status=cancelled">Cancel</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item text-danger" href="delete_booking.php?id=<?php echo $booking['id']; ?>" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Stats -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0">Quick Stats</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Pending Bookings
                                        <span class="badge bg-warning rounded-pill"><?php echo $stats['pending_bookings']; ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Unread Messages
                                        <span class="badge bg-danger rounded-pill"><?php echo $stats['unread_messages']; ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Newsletter Subscribers
                                        <span class="badge bg-primary rounded-pill"><?php echo $stats['subscribers']; ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="add_car.php" class="btn btn-primary">Add New Car</a>
                                    <a href="add_user.php" class="btn btn-outline-primary">Add New User</a>
                                    <a href="messages.php" class="btn btn-outline-primary">View Messages</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <footer class="pt-5 d-flex justify-content-between">
                    <span>Copyright © <?php echo date('Y'); ?> <a href="../index.php"><?php echo SITE_NAME; ?></a></span>
                    <ul class="nav m-0">
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="#">Privacy Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="#">Terms of Use</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="#">Contact</a>
                        </li>
                    </ul>
                </footer>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
