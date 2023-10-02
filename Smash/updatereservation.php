<?php
session_start();
include 'header.php';

// Check if user is not logged in
if (!isset($_SESSION['admin_email'])) {
    $_SESSION['warning_message'] = "Please log in to access the reservation page.";
    header("Location: cust_login.php");
    exit();
}

include("connection.php"); // Include the database connection file

$reservation_id = $_GET['reservation_id'];

// Handle form submission
if (isset($_POST['update'])) {
    // Retrieve form data
    $court_number = $_POST['court_number'];
    $date = $_POST['date'];
    $duration = $_POST['duration'];

    // Perform form validation
    $isValid = true;

    if (empty($court_number)) {
        $court_error = 'Please select a court.';
        $isValid = false;
    }

    if (empty($date)) {
        $date_error = 'Please enter a date.';
        $isValid = false;
    }

    if (empty($duration)) {
        $duration_error = 'Please enter the duration.';
        $isValid = false;
    }

    // If all form fields are valid, proceed with reservation update
    if ($isValid) {
        // Get the court fee from the court table
        $query = "SELECT cfee FROM court WHERE court_number = $court_number";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $cfee = $row['cfee'];
            $price = $cfee * $duration;

            // Update reservation in the database
            $query = "UPDATE reservation SET court_number = '$court_number', date = '$date', duration = $duration, price = $price WHERE reservation_id = $reservation_id";

            if ($conn->query($query) === true) {
                // Reservation update successful, display success message
                echo '<div class="alert alert-success" role="alert">Reservation updated successfully!</div>';
                header("refresh:3;url=reservation.php");
            } else {
                // Reservation update failed, display error message
                echo "Error updating reservation: " . $conn->error;
            }
        }
    }

    // Close the database connection
    $conn->close();
} else {
    // Retrieve the reservation data for pre-filling the form
    $query = "SELECT * FROM reservation WHERE reservation_id = $reservation_id";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $court_number = $row['court_number'];
        $date = $row['date'];
        $duration = $row['duration'];
    } else {
        // Reservation not found, redirect to reservation.php
        header("Location: reservation.php");
        exit();
    }
}
?>

<div class="container">
    <h1>Update Reservation</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="court_number">Court Number:</label>
            <select class="form-control" id="court_number" name="court_number">
                <?php
                $query = "SELECT court_number FROM court";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($courtRow = $result->fetch_assoc()) {
                        $courtNumber = $courtRow['court_number'];
                        $selected = $court_number == $courtNumber ? 'selected' : '';
                        echo "<option value='$courtNumber' $selected>Court $courtNumber</option>";
                    }
                }
                ?>
            </select>
            <?php if (!empty($court_error)) { ?>
                <span class="text-danger"><?php echo $court_error; ?></span>
            <?php } ?>
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" id="date" name="date" value="<?php echo $date; ?>">
            <?php if (!empty($date_error)) { ?>
                <span class="text-danger"><?php echo $date_error; ?></span>
            <?php } ?>
        </div>
        <div class="form-group">
            <label for="duration">Duration (in hours):</label>
            <input type="number" class="form-control" id="duration" name="duration" value="<?php echo $duration; ?>">
            <?php if (!empty($duration_error)) { ?>
                <span class="text-danger"><?php echo $duration_error; ?></span>
            <?php } ?>
        </div>
        <button type="submit" class="btn btn-primary" name="update">Update</button>
        <a href="reservation.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include("footer.php"); ?>
