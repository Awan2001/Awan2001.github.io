<?php
include("connection.php");

// Fetch available courts for the selected date
if (isset($_GET['date'])) {
    $selectedDate = $_GET['date'];

    $query = "SELECT court_number FROM court WHERE court_number NOT IN (
        SELECT court_number FROM reservation WHERE date = '$selectedDate'
    )";
    $result = $conn->query($query);

    $availableCourts = array();
    while ($row = $result->fetch_assoc()) {
        $availableCourts[] = $row['court_number'];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Check Court Availability</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }

        .status-available {
            color: green;
        }

        .status-unavailable {
            color: red;
        }

        .form-inline .btn {
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Check Court Availability</h1>
        <form action="" method="GET" class="form-inline">
            <div class="form-group">
                <label for="date">Select Date:</label>
                <input type="date" class="form-control mx-2" id="date" name="date" required>
            </div>
            <button type="submit" class="btn btn-primary">Check Availability</button>
            <?php if (isset($_GET['date']) && isset($availableCourts)) { ?>
                <a href="admin_reservation.php" class="btn btn-primary">Back</a> <!-- Replace "admin_reservation.php" with the appropriate URL or page name -->
            <?php } ?>
        </form>

        <?php if (isset($_GET['date']) && isset($availableCourts)) { ?>
            <h3 class="mt-4">Available Courts on <?php echo $selectedDate; ?>:</h3>
            <ul>
                <?php foreach ($availableCourts as $courtNumber) { ?>
                    <li class="status-available">Court <?php echo $courtNumber; ?></li>
                <?php } ?>
            </ul>
            <?php if (empty($availableCourts)) { ?>
                <p class="status-unavailable">No courts available on <?php echo $selectedDate; ?></p>
            <?php } ?>
        <?php } ?>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
