<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['admin_email'])) {
    $_SESSION['warning_message'] = "Please log in to access the reservation page.";
    header("Location: cust_login.php");
    exit();
}

if (!isset($_GET['reservation_id'])) {
    header("Location: reservation.php");
    exit();
}

$reservation_id = $_GET['reservation_id'];

include("connection.php"); // Include the database connection file

// Delete the reservation from the database
$query = "DELETE FROM reservation WHERE reservation_id = $reservation_id";

if ($conn->query($query) === true) {
    // Deletion successful, display success message
    $_SESSION['success_message'] = "Reservation deleted successfully.";
} else {
    // Deletion failed, display error message
    $_SESSION['error_message'] = "Error deleting reservation: " . $conn->error;
}

// Close the database connection
$conn->close();

// Delay for 3 seconds
sleep(3);

header("Location: reservation.php");
exit();
?>
