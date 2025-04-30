  <!-- Footer -->
  <footer class="bg-dark text-light py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-4">
          <div class="d-flex align-items-center mb-3">
            <i class="bi bi-car-front text-primary me-2 fs-4"></i>
            <span class="h4 mb-0">DriveEase</span>
          </div>
          <p class="text-muted">Premium car rental service providing you with the best vehicles for your journey.</p>
          <div class="d-flex gap-3">
            <a href="#" class="text-muted"><i class="bi bi-facebook"></i></a>
            <a href="#" class="text-muted"><i class="bi bi-twitter"></i></a>
            <a href="#" class="text-muted"><i class="bi bi-instagram"></i></a>
          </div>
        </div>
        
        <div class="col-lg-2">
          <h5>Quick Links</h5>
          <ul class="list-unstyled">
            <li><a href="index.php" class="text-muted text-decoration-none">Home</a></li>
            <li><a href="cars.php" class="text-muted text-decoration-none">Cars</a></li>
            <li><a href="about.php" class="text-muted text-decoration-none">About</a></li>
            <li><a href="contact.php" class="text-muted text-decoration-none">Contact</a></li>
          </ul>
        </div>
        
        <div class="col-lg-3">
          <h5>Contact Info</h5>
          <ul class="list-unstyled text-muted">
            <li><i class="bi bi-geo-alt me-2"></i>123 Rental Street</li>
            <li><i class="bi bi-building me-2"></i>New York, NY 10001</li>
            <li><i class="bi bi-telephone me-2"></i>(555) 123-4567</li>
            <li><i class="bi bi-envelope me-2"></i>info@driveease.com</li>
          </ul>
        </div>
        
        <div class="col-lg-3">
          <h5>Newsletter</h5>
          <p class="text-muted">Subscribe to get updates on new cars and special offers.</p>
          <form class="mt-3" id="newsletterForm" action="process/newsletter.php" method="post">
            <div class="input-group">
              <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
              <button class="btn btn-primary" type="submit">Subscribe</button>
            </div>
          </form>
        </div>
      </div>
      
      <hr class="my-4">
      
      <div class="text-center text-muted">
        <small>&copy; <?php echo date('Y'); ?> DriveEase. All rights reserved.</small>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>
</html>