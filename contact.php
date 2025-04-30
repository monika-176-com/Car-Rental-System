<?php
$current_page = 'contact';
$page_title = 'Contact Us';
require_once 'includes/header.php';

// Process contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);
    
    // Validate inputs
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required';
    }
    
    if (empty($subject)) {
        $errors[] = 'Subject is required';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required';
    }
    
    if (empty($errors)) {
        // Send message
        $result = sendContactMessage([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        ]);
        
        if ($result) {
            setAlert('Your message has been sent successfully. We will get back to you soon!');
            redirect('contact.php');
        } else {
            setAlert('There was an error sending your message. Please try again later.', 'danger');
        }
    } else {
        setAlert('Please fix the following errors: ' . implode(', ', $errors), 'danger');
    }
}
?>

<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">Contact Us</h1>
        <p class="lead">Get in touch with our team</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="contact-section">
                    <h1>Get In Touch</h1>
                    <p>Have questions about our services or need assistance with your booking? Our team is here to help. Fill out the form or use our contact information below.</p>
                    <div class="contact-info">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-primary me-3" style="width: 40px; height: 40px; font-size: 18px;">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Address</h5>
                                <p class="mb-0 text-muted">123 Rental Street, New York, NY 10001</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-primary me-3" style="width: 40px; height: 40px; font-size: 18px;">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Phone</h5>
                                <p class="mb-0 text-muted">(555) 123-4567</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-primary me-3" style="width: 40px; height: 40px; font-size: 18px;">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Email</h5>
                                <p class="mb-0 text-muted">info@driveease.com</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-circle bg-primary me-3" style="width: 40px; height: 40px; font-size: 18px;">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Business Hours</h5>
                                <p class="mb-0 text-muted">Mon - Fri: 9:00 AM - 6:00 PM<br>Sat: 10:00 AM - 4:00 PM<br>Sun: Closed</p>
                            </div>
                        </div>
                    </div>
                    <div class="social-icons">
                        <div class="d-flex gap-3">
                            <a href="#" class="icon-circle bg-primary" style="width: 40px; height: 40px; font-size: 18px; text-decoration: none;">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="icon-circle bg-primary" style="width: 40px; height: 40px; font-size: 18px; text-decoration: none;">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="#" class="icon-circle bg-primary" style="width: 40px; height: 40px; font-size: 18px; text-decoration: none;">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="icon-circle bg-primary" style="width: 40px; height: 40px; font-size: 18px; text-decoration: none;">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-4">Send Us a Message</h3>
                        <form action="contact.php" method="post">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Your Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Your Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Subject</label>
                                    <input type="text" name="subject" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Your Message</label>
                                    <textarea name="message" class="form-control" rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215256349542!2d-73.98784492426385!3d40.75790657138058!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25855c6480299%3A0x55194ec5a1ae072e!2sTimes%20Square!5e0!3m2!1sen!2sus!4v1710320987654!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>