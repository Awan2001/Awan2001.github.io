<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Smash Reservation System</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Smash!!!</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if (!isset($_SESSION['user_email'])) { ?>
                <li class="nav-item d-flex">
                    
                    <a class="nav-link" href="cust_login.php">Login</a>
                    <a class="nav-link" href="adminlogin.php">Admin Login</a>
                    <a class="nav-link" href="signup.php">Sign Up</a>
                </li>
            <?php } else { ?>
                <li class="nav-item d-flex">
                    <a class="nav-link" href="makereserve.php">Make Reservation</a>
                    <a class="nav-link" href="cviewreservation.php">View Reservation</a>
                    <form class="form-inline my-2 my-lg-0" action="" method="post">
                        <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit" name="logout">Logout</button>
                    </form>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>

<?php
// Handle logout
if (isset($_POST['logout'])) {
    // Remove session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to login page
    header("Location: cust_login.php");
    exit();
}
?>
