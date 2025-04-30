#  DriveEase Car Rental System

##  Overview

**DriveEase** is a web-based car rental management system that allows customers to browse, book, and manage car rentals online. The platform features an intuitive interface for customers and a robust admin dashboard for seamless business management.

---

##  Features

###  Customer Features
- User registration and login
- Browse available cars with advanced filters
- View detailed car specifications
- Make car reservations with date selection
- Online payment integration
- Manage bookings (view, modify, cancel)
- Contact support via a message form
- Subscribe to the newsletter

###  Admin Features
- Admin dashboard with statistics and analytics
- Car inventory management (add/edit/delete cars)
- Booking management and status updates
- User and location management
- Generate reports (revenue, booking stats)
- Respond to customer messages via message center

---

##  Installation

###  Requirements
- PHP 7.4 or higher  
- MySQL 5.7 or higher  
- Apache or Nginx web server

###  Setup Instructions

1. **Download the Files**
   - Place all project files in your web server’s root directory.

2. **Database Setup**
   - Create a MySQL database named `driveease`.
   - Import the `database.sql` file into this database.

3. **Configure Settings**
   - Open `includes/config.php` and update your database credentials:
     ```php
     $db_host = 'localhost';
     $db_user = 'your_username';
     $db_pass = 'your_password';
     $db_name = 'driveease';
     ```
   - Set the site URL:
     ```php
     define('SITE_URL', 'http://your-domain.com/');
     ```

4. **Set Permissions**
   - Ensure the `uploads/` directory is writable:
     ```bash
     chmod 755 uploads/
     ```

5. **Test the Installation**
   - Open your site URL in a browser and confirm everything is running.

---

##  Usage

###  Customer Workflow

1. **Register/Login**
   - Create an account or log in with existing credentials.

2. **Browse Cars**
   - Navigate to the "Cars" page.
   - Apply filters (location, type, price) and click on a car for full details.

3. **Make a Reservation**
   - Click “Rent Now”, select pickup and return dates, and complete the booking.

4. **Manage Bookings**
   - Access “My Bookings” to view, modify, or cancel reservations.

---

###  Admin Workflow

1. **Login to Admin Panel**
   - Go to `/admin` and sign in with admin credentials.

2. **Manage Cars**
   - Add, update, or remove car entries with images.

3. **Manage Bookings**
   - View all bookings, update status, and issue refunds if necessary.

4. **Reports**
   - Generate revenue and performance reports.

---

##  File Structure

```plaintext
/
├── admin/                  # Admin panel
├── assets/                 # CSS, JS, images
│   ├── css/
│   ├── js/
│   └── images/
├── includes/               # Shared PHP components
│   ├── config.php
│   ├── functions.php
│   ├── header.php
│   └── footer.php
├── uploads/                # Car images
├── process/                # Processing scripts
├── auth/                   # Authentication scripts
├── index.php               # Homepage
├── cars.php                # Car listings
├── about.php               # About page
├── contact.php             # Contact form
├── profile.php             # User dashboard
├── bookings.php            # Booking management
└── database.sql            # DB schema
##  Technologies Used
#### PHP – Server-side scripting

#### MySQL – Database management

#### HTML/CSS/JavaScript – Frontend

#### Bootstrap – Responsive design

#### jQuery – Interactive features
