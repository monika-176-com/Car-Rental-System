<?php
require_once 'config.php';
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?> - Premium Car Rental Service</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>
  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-0 pb-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body px-4 pt-0">
          <h3 class="text-center mb-4">Welcome Back</h3>
          <form id="loginForm" class="needs-validation" action="auth/login.php" method="post" novalidate>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
              <div class="invalid-feedback">Please enter a valid email.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
              <div class="invalid-feedback">Password is required.</div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Log In</button>
            <p class="text-center mb-0">
              Don't have an account? 
              <a href="#" data-bs-toggle="modal" data-bs-target="#signupModal" data-bs-dismiss="modal">Sign Up</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Signup Modal -->
  <div class="modal fade" id="signupModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-0 pb-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body px-4 pt-0">
          <h3 class="text-center mb-4">Create Account</h3>
          <form id="signupForm" class="needs-validation" action="auth/register.php" method="post" novalidate>
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" name="full_name" class="form-control" required>
              <div class="invalid-feedback">Please enter your name.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
              <div class="invalid-feedback">Please enter a valid email.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required minlength="6">
              <div class="invalid-feedback">Password must be at least 6 characters.</div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Sign Up</button>
            <p class="text-center mb-0">
              Already have an account? 
              <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Log In</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Booking Modal -->
  <div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Book Your Car</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="bookingForm" class="needs-validation" action="process/booking.php" method="post" novalidate>
            <input type="hidden" name="car_id" id="booking_car_id" value="">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Pick-up Date</label>
                <input type="date" name="pickup_date" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Return Date</label>
                <input type="date" name="return_date" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Pick-up Location</label>
                <select name="pickup_location" class="form-select" required>
                  <option value="">Select location</option>
                  <?php
                  $locations = getLocations();
                  foreach ($locations as $location) {
                    echo '<option value="' . $location['id'] . '">' . $location['name'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Return Location</label>
                <select name="return_location" class="form-select" required>
                  <option value="">Select location</option>
                  <?php
                  foreach ($locations as $location) {
                    echo '<option value="' . $location['id'] . '">' . $location['name'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label">Additional Requirements</label>
                <textarea name="additional_requirements" class="form-control" rows="3"></textarea>
              </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="mb-0">Total: <span id="totalPrice">$0.00</span></h5>
                <input type="hidden" name="total_price" id="total_price_input" value="0">
                <small class="text-muted">Includes taxes and fees</small>
              </div>
              <button type="submit" class="btn btn-primary">Confirm Booking</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <i class="bi bi-car-front text-primary me-2 fs-4"></i>
        DriveEase
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'home' ? 'active' : ''; ?>" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'cars' ? 'active' : ''; ?>" href="cars.php">Cars</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'about' ? 'active' : ''; ?>" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'contact' ? 'active' : ''; ?>" href="contact.php">Contact</a>
          </li>
          <?php if (isLoggedIn()): ?>
            <li class="nav-item dropdown ms-lg-3">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-1"></i> <?php echo $_SESSION['user_name']; ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                <li><a class="dropdown-item" href="bookings.php">My Bookings</a></li>
                <?php if (isAdmin()): ?>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="admin/index.php">Admin Dashboard</a></li>
                <?php endif; ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="auth/logout.php">Logout</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item ms-lg-3">
              <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Log In</button>
            </li>
            <li class="nav-item ms-lg-2">
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</button>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <?php displayAlert(); ?>