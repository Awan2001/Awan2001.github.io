<?php
include("header.php"); // Include the header file
include("connection.php"); // Include the database connection file

// Define variables for error messages
$pass_error = '';
$confirm_error = '';

// Handle form submission
if (isset($_POST['signup'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['confirm_pass'];

    // Perform password validation
    if ($password !== $confirm_password) {
        $confirm_error = 'Passwords do not match.';
    }

    // If there are no password errors, proceed with registration
    if (empty($pass_error) && empty($confirm_error)) {
        // Retrieve the last inserted cust_id and increment it for the new customer
        $query = "SELECT MAX(cust_id) AS last_id FROM customer";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $last_id = $row['last_id'];
        $new_id = $last_id + 1;

        // Insert the user's information into the database
        $query = "INSERT INTO customer (cust_id, first_name, last_name, gender, email, contact_no, pass) 
                  VALUES ($new_id, '$first_name', '$last_name', '$gender', '$email', '$contact_no', '$password')";

        if ($conn->query($query) === true) {
            // Registration successful, display success message
            echo '<div class="alert alert-success" role="alert">Registration successful!</div>';
            // Redirect to login page after a short delay
            header("refresh:3; url=cust_login.php");
            exit();
        } else {
            // Registration failed, display an error message
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<div class="container">
    <h1>Signup Page</h1>
    <form action="signup.php" method="POST">
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="contact_no">Contact No:</label>
            <input type="text" class="form-control" id="contact_no" name="contact_no" required>
        </div>
        <div class="form-group">
            <label for="pass">Password:</label>
            <input type="password" class="form-control" id="pass" name="pass" required>
            <?php if (!empty($pass_error)) { ?>
                <span class="text-danger"><?php echo $pass_error; ?></span>
            <?php } ?>
        </div>
        <div class="form-group">
            <label for="confirm_pass">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" required>
            <?php if (!empty($confirm_error)) { ?>
                <span class="text-danger"><?php echo $confirm_error; ?></span>
            <?php } ?>
        </div>
        <button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
    </form>
</div>

<?php include("footer.php"); ?>
