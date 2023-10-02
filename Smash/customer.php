<?php
session_start(); // Initialize session

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    // User is not logged in, redirect to login page with warning message
    $_SESSION['warning_message'] = "Please log in to access the customer page.";
    header("Location: cust_login.php");
    exit();
}

// User is logged in, retrieve user email from session
$email = $_SESSION['user_email'];

// Store email in session for access in other pages
$_SESSION['email'] = $email;
?>
<?php include 'header.php'; ?>

<h1>Welcome, <?php echo $email; ?>!</h1>
<!-- Add your customer-specific content here -->
<p>This is the customer page. You can display customer-specific information and functionality here.</p>
<?php include 'footer.php'; ?>
