<?php
session_start();
include 'header.php';

// Check if user is not logged in
if (!isset($_SESSION['user_email'])) {
    $_SESSION['warning_message'] = "Please log in to access the confirmation page.";
    header("Location: cust_login.php");
    exit();
}

// Check if the payment is successful
if (isset($_POST['payment_method']) && isset($_POST['reservation_id']) && isset($_POST['price'])) {
    // Retrieve payment details from the form
    $paymentMethod = $_POST['payment_method'];
    $reservationID = $_POST['reservation_id'];
    $price = $_POST['price'];

    // Process the payment and mark it as successful (you can implement the actual payment processing logic here)

    // Retrieve reservation details and user information from the database
    include("connection.php"); // Include the database connection file

    $query = "SELECT r.*, c.court_number, u.first_name, u.last_name, u.gender, u.email, u.contact_no
              FROM reservation r
              INNER JOIN court c ON r.court_number = c.court_number
              INNER JOIN customer u ON r.cust_id = u.cust_id
              WHERE r.reservation_id = $reservationID";

    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $courtNumber = 'Court ' . $row['court_number'];
        $reservationDate = $row['date'];
        $duration = $row['duration'];
        $firstName = $row['first_name'];
        $lastName = $row['last_name'];
        $gender = $row['gender'];
        $email = $row['email'];
        $contactNo = $row['contact_no'];

        // Display the payment successful message with reservation and user details
        echo '<div class="container">
                <div class="alert alert-success" role="alert">
                    Payment Successful!
                </div>
                <div>
                    <h3>Reservation Details</h3>
                    <p><strong>Court Number:</strong> ' . $courtNumber . '</p>
                    <p><strong>Date:</strong> ' . $reservationDate . '</p>
                    <p><strong>Duration:</strong> ' . $duration . ' hours</p>
                    <h3>User Information</h3>
                    <p><strong>Name:</strong> ' . $firstName . ' ' . $lastName . '</p>
                    <p><strong>Gender:</strong> ' . $gender . '</p>
                    <p><strong>Email:</strong> ' . $email . '</p>
                    <p><strong>Contact:</strong> ' . $contactNo . '</p>
                    <p><strong>Payment Method:</strong> ' . $paymentMethod . '</p>
                    <p><strong>Total Price:</strong> RM ' . number_format((float)$price, 2) . '</p>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary" onclick="printReceipt()">Print Receipt</button>
                </div>
              </div>';
    } else {
        $_SESSION['error_message'] = "Invalid reservation.";
        header("Location: cviewreservation.php");
        exit();
    }

    // Close the database connection
    $conn->close();
} else {
    $_SESSION['error_message'] = "Invalid payment request.";
    header("Location: cviewreservation.php");
    exit();
}
?>

<script>
    // JavaScript function to print the receipt
    function printReceipt() {
        window.print();
    }
</script>

<?php include("footer.php"); ?>
