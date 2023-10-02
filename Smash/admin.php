<?php
session_start(); // Initialize session

// Check if admin is logged in
if (!isset($_SESSION['admin_email'])) {
    // Admin is not logged in, redirect to login page with warning message
    $_SESSION['warning_message'] = "Please log in to access the admin page.";
    header("Location: admin_login.php");
    exit();
}

// Admin is logged in, retrieve admin email from session
$email = $_SESSION['admin_email'];

// Store email in session for access in other pages
$_SESSION['email'] = $email;
?>
<?php include 'header.php'; ?>

<h1>Welcome, <?php echo $email; ?>!</h1>
<!-- Add your admin-specific content here -->
<p>This is the admin page. You can display admin-specific information and functionality here.</p>
<?php include 'footer.php'; ?>
