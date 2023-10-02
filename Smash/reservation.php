<?php
session_start();
include 'adminheader.php';

// Check if user is not logged in
if (!isset($_SESSION['admin_email'])) {
    $_SESSION['warning_message'] = "Please log in to access the reservation page.";
    header("Location: cust_login.php");
    exit();
}

include("connection.php"); // Include the database connection file

// Retrieve all reservations for the logged-in user
$query = "SELECT r.reservation_id, r.cust_id, r.court_number, r.date, r.duration, r.price, c.court_number as court_name, cu.first_name, cu.last_name, cu.email, cu.contact_no, cu.gender FROM reservation r
          JOIN court c ON r.court_number = c.court_number
          JOIN customer cu ON r.cust_id = cu.cust_id";
$result = $conn->query($query);

// Handle search form submission
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];

    // Modify the query to include the search term
    $query .= " WHERE r.reservation_id LIKE '%$searchTerm%'
                OR r.cust_id LIKE '%$searchTerm%'
                OR r.court_number LIKE '%$searchTerm%'
                OR r.date LIKE '%$searchTerm%'
                OR r.duration LIKE '%$searchTerm%'
                OR r.price LIKE '%$searchTerm%'
                OR c.court_number LIKE '%$searchTerm%'
                OR cu.first_name LIKE '%$searchTerm%'
                OR cu.last_name LIKE '%$searchTerm%'
                OR cu.email LIKE '%$searchTerm%'
                OR cu.contact_no LIKE '%$searchTerm%'
                OR cu.gender LIKE '%$searchTerm%'";

    $result = $conn->query($query);
}

// Handle reset form submission
if (isset($_POST['reset'])) {
    // Reset the query to retrieve all reservations
    $query = "SELECT r.reservation_id, r.cust_id, r.court_number, r.date, r.duration, r.price, c.court_number as court_name, cu.first_name, cu.last_name, cu.email, cu.contact_no, cu.gender FROM reservation r
              JOIN court c ON r.court_number = c.court_number
              JOIN customer cu ON r.cust_id = cu.cust_id";

    $result = $conn->query($query);
}

?>

<div class="container">
    <h1>List of Reservation</h1>

    <!-- Search Form -->
    <form class="form-inline mb-3" method="POST">
        <div class="form-group mr-2">
            <input type="text" class="form-control" id="searchTerm" name="searchTerm" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-primary" name="search">Search</button>
        <button type="submit" class="btn btn-secondary" name="reset">Reset</button>
    </form>

    <?php
    // Check if the query execution was successful
    if ($result === false) {
        echo '<div class="alert alert-danger" role="alert">Error retrieving reservations: ' . $conn->error . '</div>';
    } else {
        // Check if there are any reservations
        if ($result->num_rows > 0) {
            echo '<table class="table">
                    <thead>
                        <tr>
                            <th>Court Number</th>
                            <th>Date</th>
                            <th>Duration (hours)</th>
                            <th>Price</th>
                            <th>Court Name</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Contact No</th>
                            <th>Gender</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            // Loop through each reservation and display the details
            while ($row = $result->fetch_assoc()) {
                $reservation_id = $row['reservation_id'];
                $cust_id = $row['cust_id'];
                $court_number = $row['court_number'];
                $court_name = $row['court_name'];
                $date = $row['date'];
                $duration = $row['duration'];
                $price = $row['price'];
                $customer_name = $row['first_name'] . ' ' . $row['last_name'];
                $email = $row['email'];
                $contact_no = $row['contact_no'];
                $gender = $row['gender'];

                echo "<tr>
                        <td>Court $court_number - $court_name</td>
                        <td>$date</td>
                        <td>$duration</td>
                        <td>RM " . number_format($price, 2) . "</td>
                        <td>$court_name</td>
                        <td>$customer_name</td>
                        <td>$email</td>
                        <td>$contact_no</td>
                        <td>$gender</td>
                        <td>
                            <a href='updatereservation.php?reservation_id=$reservation_id' class='btn btn-warning'>Update</a>
                            <a href='deletereservation.php?reservation_id=$reservation_id' class='btn btn-danger'>Delete</a>
                        </td>
                      </tr>";
            }
            echo '</tbody></table>';
        } else {
            // No reservations found
            echo '<div class="alert alert-info" role="alert">No reservations found.</div>';
        }
    }
    ?>
</div>

<?php include("footer.php"); ?>
