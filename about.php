<?php
$current_page = 'about';
$page_title = 'About Us';
require_once 'includes/header.php';
?>

<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">About DriveEase</h1>
        <p class="lead">Learn more about our premium car rental service</p>
    </div>
</section>

<!-- About Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="assets/images/about-us.jpg" alt="About DriveEase" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6">
                <h2 class="display-6 fw-bold mb-4">Our Story</h2>
                <p class="lead">Providing premium car rental services since 2010</p>
                <p>DriveEase was founded with a simple mission: to provide customers with the best car rental experience possible. What started as a small fleet of just five vehicles has grown into one of the most trusted car rental services in the country.</p>
                <p>We take pride in our well-maintained vehicles, competitive prices, and exceptional customer service. Whether you're traveling for business or pleasure, we have the perfect car for your needs.</p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="display-6 fw-bold text-center mb-5">Why Choose DriveEase</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 h-100 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-primary mb-3 mx-auto">
                            <i class="bi bi-car-front"></i>
                        </div>
                        <h4>Premium Vehicles</h4>
                        <p class="text-muted">Our fleet consists of the latest models from top manufacturers, ensuring you get a reliable and comfortable ride.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 h-100 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-primary mb-3 mx-auto">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                        <h4>Competitive Pricing</h4>
                        <p class="text-muted">We offer transparent pricing with no hidden fees, ensuring you get the best value for your money.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 h-100 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-primary mb-3 mx-auto">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h4>24/7 Support</h4>
                        <p class="text-muted">Our customer support team is available around the clock to assist you with any questions or concerns.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Team -->
<section class="py-5">
    <div class="container">
        <h2 class="display-6 fw-bold text-center mb-5">Meet Our Team</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <img src="assets/images/team-1.jpg" class="card-img-top" alt="Team Member">
                    <div class="card-body text-center p-4">
                        <h4>John Doe</h4>
                        <p class="text-primary mb-3">Founder & CEO</p>
                        <p class="text-muted">John founded DriveEase with a vision to revolutionize the car rental industry with customer-centric services.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-muted"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-muted"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="text-muted"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <img src="assets/images/team-2.jpg" class="card-img-top" alt="Team Member">
                    <div class="card-body text-center p-4">
                        <h4>Jane Smith</h4>
                        <p class="text-primary mb-3">Operations Manager</p>
                        <p class="text-muted">Jane ensures that all our operations run smoothly, from vehicle maintenance to customer service.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-muted"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-muted"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="text-muted"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <img src="assets/images/team-3.jpg" class="card-img-top" alt="Team Member">
                    <div class="card-body text-center p-4">
                        <h4>Michael Johnson</h4>
                        <p class="text-primary mb-3">Customer Relations</p>
                        <p class="text-muted">Michael leads our customer relations team, ensuring that every client receives exceptional service.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-muted"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-muted"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="text-muted"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="display-6 fw-bold text-center mb-5">What Our Customers Say</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="mb-3">"I've rented cars from many companies, but DriveEase stands out for their exceptional service and well-maintained vehicles. Will definitely use them again!"</p>
                        <div class="d-flex align-items-center">
                            <img src="assets/images/testimonial-1.jpg" alt="Customer" class="rounded-circle me-3" width="50" height="50">
                            <div>
                                <h6 class="mb-0">Robert Williams</h6>
                                <small class="text-muted">Business Traveler</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="mb-3">"The booking process was seamless, and the car was in perfect condition. The staff was friendly and helpful. Highly recommend DriveEase!"</p>
                        <div class="d-flex align-items-center">
                            <img src="assets/images/testimonial-2.jpg" alt="Customer" class="rounded-circle me-3" width="50" height="50">
                            <div>
                                <h6 class="mb-0">Sarah Thompson</h6>
                                <small class="text-muted">Vacation Traveler</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="mb-3">"I rented a luxury car for my wedding day, and DriveEase made the experience special. The car was immaculate and exactly what I wanted!"</p>
                        <div class="d-flex align-items-center">
                            <img src="assets/images/testimonial-3.jpg" alt="Customer" class="rounded-circle me-3" width="50" height="50">
                            <div>
                                <h6 class="mb-0">David Chen</h6>
                                <small class="text-muted">Special Occasion</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>