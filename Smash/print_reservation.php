<?php
session_start();
include 'header.php';

include("connection.php");

// Check if user is not logged in
if (!isset($_SESSION['user_email'])) {
    $_SESSION['warning_message'] = "Please log in to access the reservation page.";
    header("Location: cust_login.php");
    exit();
}

// Check if the reservation ID is provided in the query parameter
if (!isset($_GET['reservation_id'])) {
    $_SESSION['error_message'] = "Reservation ID not provided.";
    header("Location: cviewreservation.php");
    exit();
}

$reservationID = $_GET['reservation_id'];

// Fetch the reservation details
$query = "SELECT * FROM reservation WHERE reservation_id = $reservationID";
$reservationResult = $conn->query($query);

// Check if the reservation exists
if ($reservationResult->num_rows !== 1) {
    $_SESSION['error_message'] = "Invalid reservation ID.";
    header("Location: cviewreservation.php");
    exit();
}

// Retrieve the reservation details
$reservation = $reservationResult->fetch_assoc();

// Fetch additional customer details
$customerID = $_SESSION['cust_id'];
$query = "SELECT * FROM customer WHERE cust_id = $customerID";
$customerResult = $conn->query($query);
$customer = $customerResult->fetch_assoc();

?>

<div class="container">
    <div class="receipt">
        <h2 class="text-center">Reservation Receipt</h2>

        <div class="row">
            <div class="col-md-6">
                <h4>Customer Details</h4>
                <p><strong>Name:</strong> <?php echo $customer['first_name'] . ' ' . $customer['last_name']; ?></p>
                <p><strong>Email:</strong> <?php echo $customer['email']; ?></p>
                <p><strong>Contact No:</strong> <?php echo $customer['contact_no']; ?></p>
            </div>
            <div class="col-md-6">
                <h4>Reservation Details</h4>
                <p><strong>Reservation ID:</strong> <?php echo $reservation['reservation_id']; ?></p>
                <p><strong>Court Number:</strong> <?php echo 'Court ' . $reservation['court_number']; ?></p>
                <p><strong>Date:</strong> <?php echo $reservation['date']; ?></p>
                <p><strong>Duration:</strong> <?php echo $reservation['duration']; ?> hours</p>
                <p><strong>Price:</strong> RM <?php echo number_format($reservation['price'], 2); ?></p>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-primary" onclick="printReceipt()">Print</button>
    </div>
</div>

<script>
    function printReceipt() {
        window.print();
    }
</script>

<?php include("footer.php"); ?>
