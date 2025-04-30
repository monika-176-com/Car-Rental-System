<?php
$current_page = 'profile';
$page_title = 'My Profile';
require_once 'includes/header.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Get user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Process profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate inputs
    $errors = [];
    
    if (empty($full_name)) {
        $errors[] = 'Full name is required';
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required';
    }
    
    // Check if email exists (if changed)
    if ($email !== $user['email']) {
        $check_sql = "SELECT id FROM users WHERE email = '$email' AND id != $user_id";
        $check_result = $conn->query($check_sql);
        if ($check_result->num_rows > 0) {
            $errors[] = 'Email already exists';
        }
    }
    
    // Password validation (only if changing password)
    if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
        if (empty($current_password)) {
            $errors[] = 'Current password is required to change password';
        } elseif (!password_verify($current_password, $user['password'])) {
            $errors[] = 'Current password is incorrect';
        }
        
        if (empty($new_password) || strlen($new_password) < 6) {
            $errors[] = 'New password must be at least 6 characters';
        }
        
        if ($new_password !== $confirm_password) {
            $errors[] = 'New passwords do not match';
        }
    }
    
    if (empty($errors)) {
        // Update user data
        $sql = "UPDATE users SET full_name = '$full_name', email = '$email', phone = '$phone', address = '$address'";
        
        // Update password if provided
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql .= ", password = '$hashed_password'";
        }
        
        $sql .= " WHERE id = $user_id";
        
        if ($conn->query($sql) === TRUE) {
            // Update session variables
            $_SESSION['user_name'] = $full_name;
            $_SESSION['user_email'] = $email;
            
            setAlert('Profile updated successfully.');
            redirect('profile.php');
        } else {
            setAlert('Profile update failed. Please try again later.', 'danger');
        }
    } else {
        setAlert('Please fix the following errors: ' . implode(', ', $errors), 'danger');
    }
}
?>

<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">My Profile</h1>
        <p class="lead">Manage your account information</p>
    </div>
</section>

<!-- Profile Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <img src="assets/images/avatar.jpg" alt="Profile" class="rounded-circle" width="100" height="100">
                        </div>
                        <h4><?php echo $user['full_name']; ?></h4>
                        <p class="text-muted"><?php echo $user['email']; ?></p>
                        <p class="text-muted">Member since: <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
                        <hr>
                        <div class="d-grid gap-2">
                            <a href="bookings.php" class="btn btn-outline-primary">My Bookings</a>
                            <?php if (isAdmin()): ?>
                                <a href="admin/index.php" class="btn btn-outline-dark">Admin Dashboard</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-4">Edit Profile</h3>
                        <form action="profile.php" method="post">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="full_name" class="form-control" value="<?php echo $user['full_name']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" name="phone" class="form-control" value="<?php echo $user['phone']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" value="<?php echo $user['address']; ?>">
                                </div>
                                
                                <div class="col-12">
                                    <hr>
                                    <h4>Change Password</h4>
                                    <p class="text-muted small">Leave blank if you don't want to change your password</p>
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" name="current_password" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="new_password" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="confirm_password" class="form-control">
                                </div>
                                
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>