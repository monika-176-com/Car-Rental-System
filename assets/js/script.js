// Form validation
document.querySelectorAll('.needs-validation').forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      
      form.classList.add('was-validated');
    });
  });
  
  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      if (this.getAttribute('href') === '#') return;
      
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        window.scrollTo({
          top: target.offsetTop - 70,
          behavior: 'smooth'
        });
      }
    });
  });
  
  // Navbar background change on scroll
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
      navbar.classList.add('shadow-sm');
    } else {
      navbar.classList.remove('shadow-sm');
    }
  });
  
  // Calculate total price in booking modal
  const bookingForm = document.getElementById('bookingForm');
  if (bookingForm) {
    const calculateTotal = () => {
      const startDate = new Date(bookingForm.querySelector('input[name="pickup_date"]').value);
      const endDate = new Date(bookingForm.querySelector('input[name="return_date"]').value);
      const carId = document.getElementById('booking_car_id').value;
      
      if (startDate && endDate && startDate < endDate && carId) {
        const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
        
        // Fetch car price using AJAX
        fetch(`process/get_car_price.php?id=${carId}`)
          .then(response => response.json())
          .then(data => {
            const basePrice = data.price_per_day;
            const total = days * basePrice;
            document.getElementById('totalPrice').textContent = `$${total.toFixed(2)}`;
            document.getElementById('total_price_input').value = total.toFixed(2);
          })
          .catch(error => {
            console.error('Error fetching car price:', error);
          });
      }
    };
    
    bookingForm.querySelectorAll('input[name="pickup_date"], input[name="return_date"]').forEach(input => {
      input.addEventListener('change', calculateTotal);
    });
    
    // Set car ID when clicking "Rent Now" button
    document.querySelectorAll('.rent-now-btn').forEach(button => {
      button.addEventListener('click', function() {
        const carId = this.getAttribute('data-car-id');
        document.getElementById('booking_car_id').value = carId;
        calculateTotal();
      });
    });
  }
  
  // Newsletter form submission
  const newsletterForm = document.getElementById('newsletterForm');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', function(e) {
      // Form will be handled by PHP
    });
  }
  
  // Search form submission
  const searchForm = document.getElementById('searchForm');
  if (searchForm) {
    searchForm.addEventListener('submit', function(e) {
      // Form will be handled by PHP
    });
  }