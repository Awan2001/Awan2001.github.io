<?php
session_start();
include 'header.php';

include("connection.php");

// Check if user is not logged in or is not an admin
if (!isset($_SESSION['email'])) {
    $_SESSION['warning_message'] = "Please log in as an admin to access this page.";
    header("Location: cust_login.php");
    exit();
}

// Retrieve customer ID from session
$customer_id = $_SESSION['cust_id'];

// Handle form submission
if (isset($_POST['create_reservation'])) {
    // Capture values from HTML form
    $court_number = $_POST['court_number'];
    $date = $_POST['date'];
    $duration = $_POST['duration'];

    // Check if the selected court is available for the chosen date
    $query = "SELECT * FROM reservation WHERE court_number = $court_number AND date = '$date'";
    $existingReservationsResult = $conn->query($query);
    $isAvailable = $existingReservationsResult->num_rows === 0;

    // Check if the selected date has already been booked by another user
    $query = "SELECT * FROM reservation WHERE cust_id = $customer_id AND date = '$date'";
    $existingBookingsResult = $conn->query($query);
    $isAlreadyBooked = $existingBookingsResult->num_rows > 0;

    if (!$isAvailable) {
        // Court is not available, display error message
        echo '<div class="alert alert-danger" role="alert">The selected court is not available for the chosen date.</div>';
    } elseif ($isAlreadyBooked) {
        // Date has already been booked by the user, display error message
        echo '<div class="alert alert-danger" role="alert">You have already booked a court for the selected date.</div>';
    } else {
        // Fetch court fee from the database
        $query = "SELECT cfee FROM court WHERE court_number = $court_number";
        $courtResult = $conn->query($query);
        $row = $courtResult->fetch_assoc();
        $cfee = $row['cfee'];

        // Calculate price based on court fee and duration
        $price = $cfee * $duration;

        // Insert reservation into the database
        $query = "INSERT INTO reservation (cust_id, court_number, price, date, duration) 
                  VALUES ($customer_id, $court_number, $price, '$date', $duration)";

        if ($conn->query($query) === true) {
            // Reservation successful, display success message
            echo '<div class="alert alert-success" role="alert">Reservation created successfully!</div>';
        } else {
            // Reservation failed, display error message
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }
}

?>

<div class="container">
    <h1>Create Reservation</h1>
    <form action="makereserve.php" method="POST">
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <p>Check Court Availability: <a href="custavailable.php">Click here</a></p>
        <div class="form-group">
            <label for="court_number">Court Number:</label>
            <select class="form-control" id="court_number" name="court_number" required>
                <?php
                $query = "SELECT court_number FROM court";
                $courtResult = $conn->query($query);
                while ($row = $courtResult->fetch_assoc()) {
                    echo '<option value="' . $row['court_number'] . '">Court ' . $row['court_number'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="duration">Duration (in hours):</label>
            <input type="number" class="form-control" id="duration" name="duration" required>
        </div>
        <button type="submit" class="btn btn-primary" name="create_reservation">Create Reservation</button>
    </form>
</div>

<?php include("footer.php"); ?>
