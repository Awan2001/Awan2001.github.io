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

// Retrieve customer ID from session
$customerID = $_SESSION['cust_id'];

// Fetch reservations for the logged-in customer
$query = "SELECT * FROM reservation WHERE cust_id = $customerID";
$reservationResult = $conn->query($query);

?>

<div class="container">
    <h1>My Reservations</h1>
    <?php if ($reservationResult->num_rows > 0) { ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Price</th>
                    <th>Court Number</th>
                    <th>Date</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $reservationResult->fetch_assoc()) { ?>
                    <tr>
                        <td>RM <?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo 'Court ' . $row['court_number']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['duration']; ?> hours</td>
                        <td>
                            <a href="transaction.php?reservation_id=<?php echo $row['reservation_id']; ?>&price=<?php echo $row['price']; ?>" class="btn btn-primary">Pay</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No reservations found.</p>
    <?php } ?>
</div>

<?php include("footer.php"); ?>
