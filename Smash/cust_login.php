<?php
session_start();
include 'header.php';

include("connection.php");

$errorMsg = '';

// Handle form submission
if (isset($_POST['login'])) {

    // Capture values from HTML form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the user exists in the database
    $query = "SELECT * FROM customer WHERE email = '$email' AND pass = '$password'";
    $result = $conn->query($query);

    // Check if the query returned any rows
    if ($result->num_rows == 1) {
        // Login successful, set session variables
        $_SESSION['user_email'] = $email;

        // Fetch the user_id from the database based on the user's email
        $row = $result->fetch_assoc();
        $_SESSION['cust_id'] = $row['cust_id'];

        // Redirect to the customer page or any other desired page
        header("Location: customer.php");
        exit();
    } else {
        // Invalid credentials, display an error message
        $errorMsg = "Wrong username or password!";
    }

}
?>

<style>
    .center-box {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    /*General Styles*/
		body{
			font-family:Arial,sans-serif;
			margin:0;
			padding:0;
			background: linear-gradient(135deg,#FF6600,#FFFFFF);
		}
	/*Container Styles*/
		.container{
			max-width: 1000px;
			margin:0 auto;
			padding: 20px
		}
	/* Header Styles */
        header {
            text-align: center;
            padding: 20px 0;
        }

        h1 {
            margin: 0;
            font-size: 32px;
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .icon {
            font-size: 24px;
            margin: 10px;
        }
		
	</style>
</style>
<div class="center-box">
    <form action="" method="post">
        <fieldset>
            <legend>Customer Login</legend>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <?php if (!empty($errorMsg)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorMsg; ?>
                </div>
            <?php } ?>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
            <a href="index.html" class="btn btn-secondary">Back</a>
        </fieldset>
    </form>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-V7/RnAB1u8qE4p+Hxr8fN8p6BbmW+iWrQ8H9W8+WUvIUKIUnBp08UnWdYGzJ4eV+" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-HvQOcvzj+q+1u9BSixQWvxvKc6TJfGJ1l9+u5+i6f0vI1cPh9F80ql+Yf2+5u3/w" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
