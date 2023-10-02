<?php
session_start();
include 'header.php';

// Check if user is not logged in
if (!isset($_SESSION['user_email'])) {
    $_SESSION['warning_message'] = "Please log in to access the payment page.";
    header("Location: cust_login.php");
    exit();
}

// Check if the reservation_id and price are provided in the query parameters
if (!isset($_GET['reservation_id']) || !isset($_GET['price'])) {
    $_SESSION['error_message'] = "Reservation ID or price not provided.";
    header("Location: cviewreservation.php");
    exit();
}

$reservationID = $_GET['reservation_id'];
$price = $_GET['price'];
?>

<div class="container">
    <h1>Payment Details</h1>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="confirm_payment.php" method="POST">
                <input type="hidden" name="reservation_id" value="<?php echo $reservationID; ?>">
                <input type="hidden" name="price" value="<?php echo $price; ?>">
                
                <div class="form-group">
                    <label for="payment_method">Payment Method</label>
                    <select class="form-control" id="payment_method" name="payment_method" required>
                        <option value="credit_card">Credit Card</option>
                        <option value="debit_card">Debit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Total Price (RM)</label>
                    <input type="text" class="form-control" id="price" name="price" value="RM <?php echo $price; ?>" readonly>
                </div>

                <button type="submit" class="btn btn-primary">Confirm Payment</button>
            </form>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
