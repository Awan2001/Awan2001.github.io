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
    $query = "SELECT * FROM admin WHERE admin_email = '$email' AND admin_pass = '$password'";
    $result = $conn->query($query);

    // Check if the query returned any rows
    if ($result->num_rows == 1) {
        // Login successful, set session variables
        $_SESSION['admin_email'] = $email;

        // Fetch the user_id from the database based on the user's email
        $row = $result->fetch_assoc();
        $_SESSION['admin_id'] = $row['admin_id'];

        // Redirect to the admin page or any other desired page
        header("Location: reservation.php");
        exit();
    } else {
        // Invalid credentials, display an error message
        $errorMsg = "Wrong username or password!";
    }

}
?>

<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Admin Login</title>
	<style>
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
</head>
<body>
	
    <div class="container">
        <div class="center-box">
            <form action="" method="post">
                <fieldset>
                    <legend>Admin Login</legend>
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
    </div>

<?php
include 'footer.php';
?>