<?php
$current_page = 'home';
$page_title = 'Home';
require_once 'includes/header.php';

// Get popular cars
$popular_cars = getCars(['available' => true]);
$popular_cars = array_slice($popular_cars, 0, 3); // Get only 3 cars for display
?>

  <!-- Hero Section -->
  <section id="home" class="hero">
    <div class="container">
      <div class="row align-items-center min-vh-100">
        <div class="col-lg-6">
          <h1 class="display-4 fw-bold mb-4">Find Your Perfect <span class="text-primary">Drive</span> Today</h1>
          <p class="lead mb-5">Experience the freedom of the open road with our premium car rental service. Choose from our extensive fleet of vehicles for your next adventure.</p>
          <div class="d-flex gap-3">
            <a href="cars.php" class="btn btn-primary btn-lg">Browse Cars</a>
            <a href="about.php" class="btn btn-outline-light btn-lg">Learn More</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Search Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <form id="searchForm" class="row g-3" action="cars.php" method="get">
            <div class="col-md-3">
              <label class="form-label">Pick-up Location</label>
              <select class="form-select" name="location">
                <option value="">Any Location</option>
                <?php
                $locations = getLocations();
                foreach ($locations as $location) {
                  echo '<option value="' . $location['id'] . '">' . $location['name'] . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Car Type</label>
              <select class="form-select" name="type">
                <option value="">Any Type</option>
                <option value="Luxury">Luxury</option>
                <option value="Sports">Sports</option>
                <option value="SUV">SUV</option>
                <option value="Electric">Electric</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Price Range</label>
              <select class="form-select" name="price_range">
                <option value="">Any Price</option>
                <option value="0-100">$0 - $100</option>
                <option value="100-200">$100 - $200</option>
                <option value="200-500">$200 - $500</option>
                <option value="500+">$500+</option>
              </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
              <button type="submit" class="btn btn-primary w-100">Search Cars</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Popular Cars Section -->
  <section id="cars" class="py-5">
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-6">
          <h2 class="display-6 fw-bold">Popular Car Rentals</h2>
          <p class="text-muted">Choose from our selection of premium vehicles</p>
        </div>
        <div class="col-lg-6 text-lg-end">
          <a href="cars.php" class="btn btn-outline-primary">View All Cars</a>
        </div>
      </div>
      
      <div class="row g-4">
        <?php foreach ($popular_cars as $car): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card car-card h-100">
            <img src="uploads/<?php echo $car['image']; ?>" class="card-img-top" alt="<?php echo $car['name']; ?>">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="card-title mb-0"><?php echo $car['name']; ?></h5>
                <span class="badge bg-<?php echo $car['is_available'] ? 'success' : 'danger'; ?>">
                  <?php echo $car['is_available'] ? 'Available' : 'Unavailable'; ?>
                </span>
              </div>
              <p class="card-text text-muted"><?php echo $car['type']; ?> • <?php echo $car['year']; ?></p>
              <ul class="list-unstyled mb-3">
                <li class="mb-2"><i class="bi bi-people me-2"></i><?php echo $car['seats']; ?> Seats</li>
                <li class="mb-2"><i class="bi bi-fuel-pump me-2"></i><?php echo $car['fuel_type']; ?></li>
                <li><i class="bi bi-gear me-2"></i><?php echo $car['transmission']; ?></li>
              </ul>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="h5 mb-0">$<?php echo $car['price_per_day']; ?><span class="text-muted">/day</span></div>
                <button class="btn btn-primary rent-now-btn" data-car-id="<?php echo $car['id']; ?>" data-bs-toggle="modal" data-bs-target="#bookingModal">Rent Now</button>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section class="bg-light py-5">
    <div class="container">
      <h2 class="display-6 fw-bold text-center mb-5">How It Works</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card border-0 bg-transparent text-center">
            <div class="card-body">
              <div class="icon-circle bg-primary mb-3 mx-auto">
                <i class="bi bi-search"></i>
              </div>
              <h4>Find Your Car</h4>
              <p class="text-muted">Browse our extensive fleet of vehicles. Filter by type, price, and more.</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="card border-0 bg-transparent text-center">
            <div class="card-body">
              <div class="icon-circle bg-primary mb-3 mx-auto">
                <i class="bi bi-calendar-check"></i>
              </div>
              <h4>Make a Reservation</h4>
              <p class="text-muted">Select your dates and complete your booking securely online.</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="card border-0 bg-transparent text-center">
            <div class="card-body">
              <div class="icon-circle bg-primary mb-3 mx-auto">
                <i class="bi bi-car-front"></i>
              </div>
              <h4>Enjoy Your Ride</h4>
              <p class="text-muted">Pick up your car and enjoy your journey with our well-maintained vehicles.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php require_once 'includes/footer.php'; ?>