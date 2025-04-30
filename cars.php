<?php
$current_page = 'cars';
$page_title = 'Our Cars';
require_once 'includes/header.php';

// Process filters
$filters = [];

// Sanitize and validate all inputs
if (isset($_GET['location']) && !empty($_GET['location'])) {
    $filters['location'] = intval($_GET['location']); // Ensure it's an integer
}

if (isset($_GET['type']) && !empty($_GET['type'])) {
    // Validate against allowed types
    $allowed_types = ['Luxury', 'Sports', 'SUV', 'Electric'];
    if (in_array($_GET['type'], $allowed_types)) {
        $filters['type'] = $_GET['type'];
    }
}

if (isset($_GET['price_range']) && !empty($_GET['price_range'])) {
    if (strpos($_GET['price_range'], '-') !== false) {
        $price_range = explode('-', $_GET['price_range']);
        if (count($price_range) == 2 && is_numeric($price_range[0]) && is_numeric($price_range[1])) {
            $filters['min_price'] = floatval($price_range[0]);
            $filters['max_price'] = floatval($price_range[1]);
        }
    } elseif (strpos($_GET['price_range'], '+') !== false) {
        $min_price = str_replace('+', '', $_GET['price_range']);
        if (is_numeric($min_price)) {
            $filters['min_price'] = floatval($min_price);
            $filters['max_price'] = 10000; // High value to represent "and above"
        }
    }
}

// Always show available cars by default unless explicitly requested otherwise
$filters['available'] = true;

// Debug the filters (remove in production)
// echo "<pre>Filters: "; print_r($filters); echo "</pre>";

// Get cars based on filters
$cars = getCars($filters);

// If getCars() function isn't working properly, here's a fixed implementation:
/*
function getCars($filters = []) {
    global $conn;
    
    $sql = "SELECT c.*, l.name as location_name 
            FROM cars c 
            LEFT JOIN locations l ON c.location_id = l.id 
            WHERE 1=1";
    
    $params = [];
    
    // Apply location filter
    if (isset($filters['location']) && !empty($filters['location'])) {
        $sql .= " AND c.location_id = ?";
        $params[] = $filters['location'];
    }
    
    // Apply type filter
    if (isset($filters['type']) && !empty($filters['type'])) {
        $sql .= " AND c.type = ?";
        $params[] = $filters['type'];
    }
    
    // Apply price range filter
    if (isset($filters['min_price']) && isset($filters['max_price'])) {
        $sql .= " AND c.price_per_day BETWEEN ? AND ?";
        $params[] = $filters['min_price'];
        $params[] = $filters['max_price'];
    }
    
    // Apply availability filter
    if (isset($filters['available']) && $filters['available']) {
        $sql .= " AND c.is_available = 1";
    }
    
    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $cars = [];
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
    
    return $cars;
}
*/
?>

<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">Our Car Fleet</h1>
        <p class="lead">Choose from our wide selection of premium vehicles</p>
    </div>
</section>

<!-- Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h5 class="mb-3">Filter Cars</h5>
                <form id="filterForm" class="row g-3" action="cars.php" method="get">
                    <div class="col-md-3">
                        <label class="form-label">Location</label>
                        <select class="form-select" name="location" id="locationFilter">
                            <option value="">Any Location</option>
                            <?php
                            $locations = getLocations();
                            foreach ($locations as $location) {
                                $selected = (isset($_GET['location']) && $_GET['location'] == $location['id']) ? 'selected' : '';
                                echo '<option value="' . $location['id'] . '" ' . $selected . '>' . $location['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Car Type</label>
                        <select class="form-select" name="type" id="typeFilter">
                            <option value="">Any Type</option>
                            <?php
                            $types = ['Luxury', 'Sports', 'SUV', 'Electric'];
                            foreach ($types as $type) {
                                $selected = (isset($_GET['type']) && $_GET['type'] == $type) ? 'selected' : '';
                                echo '<option value="' . $type . '" ' . $selected . '>' . $type . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Price Range</label>
                        <select class="form-select" name="price_range" id="priceRangeFilter">
                            <option value="">Any Price</option>
                            <?php
                            $price_ranges = ['0-100' => '$0 - $100', '100-200' => '$100 - $200', '200-500' => '$200 - $500', '500+' => '$500+'];
                            foreach ($price_ranges as $value => $label) {
                                $selected = (isset($_GET['price_range']) && $_GET['price_range'] == $value) ? 'selected' : '';
                                echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Cars Listing -->
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-0"><?php echo count($cars); ?> Cars Available</h2>
                <p class="text-muted">Find your perfect ride</p>
                
                <?php if (!empty($_GET)): ?>
                <div class="mt-3">
                    <p>
                        <strong>Active Filters:</strong> 
                        <?php
                        $active_filters = [];
                        
                        if (isset($_GET['location']) && !empty($_GET['location'])) {
                            foreach ($locations as $loc) {
                                if ($loc['id'] == $_GET['location']) {
                                    $active_filters[] = "Location: " . $loc['name'];
                                    break;
                                }
                            }
                        }
                        
                        if (isset($_GET['type']) && !empty($_GET['type'])) {
                            $active_filters[] = "Type: " . $_GET['type'];
                        }
                        
                        if (isset($_GET['price_range']) && !empty($_GET['price_range'])) {
                            $active_filters[] = "Price: " . $price_ranges[$_GET['price_range']];
                        }
                        
                        echo !empty($active_filters) ? implode(", ", $active_filters) : "None";
                        ?>
                        <a href="cars.php" class="btn btn-sm btn-outline-secondary ms-2">Clear All Filters</a>
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (empty($cars)): ?>
            <div class="alert alert-info">
                No cars found matching your criteria. Please try different filters.
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($cars as $car): ?>
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
                            <?php if (!empty($car['description'])): ?>
                                <p class="card-text"><?php echo $car['description']; ?></p>
                            <?php endif; ?>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="h5 mb-0">$<?php echo $car['price_per_day']; ?><span class="text-muted">/day</span></div>
                                <button class="btn btn-primary rent-now-btn" data-car-id="<?php echo $car['id']; ?>" data-bs-toggle="modal" data-bs-target="#bookingModal">Rent Now</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Add JavaScript for enhanced filtering -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when any filter changes (optional enhancement)
    /*
    const filterSelects = document.querySelectorAll('#locationFilter, #typeFilter, #priceRangeFilter');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
    */
    
    // Ensure filter values are preserved after page reload
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.has('location')) {
        document.getElementById('locationFilter').value = urlParams.get('location');
    }
    
    if (urlParams.has('type')) {
        document.getElementById('typeFilter').value = urlParams.get('type');
    }
    
    if (urlParams.has('price_range')) {
        document.getElementById('priceRangeFilter').value = urlParams.get('price_range');
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>