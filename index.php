<!DOCTYPE html>
<?php 
    $pageTitle = "Home";
    $pageHeading = "Welcome to Gloucestershire Constabulary BikeWatch"; 
    $pageSubHeading = "Please Login or Register to add, view or report a new bike";

    include('functions/alerts.php');

    createAlert('error', 'This is a test alert from PHP', '');
?>
<html>
<head>
    <!-- Head Content -->
    <?php include("templates/head.php");?>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Alert container -->
    <?php include("templates/alerts.php"); ?>

    <!-- Page Container -->
    <div class="container">

        <!-- Page Navigation -->
        <?php include("templates/navigation.php"); ?>

        <!-- Page Header -->
        <?php include("templates/header.php");?>

        <!-- Page Content -->
        <main>
            <div class="small-container">
                <?php 
                    createAlert('error', 'This is a test alert from PHP', '');
                ?>
                <a class="button login" href="login/login.php"> Login </a> 
                <a class="button register" href="user/register/register.php"> Register </a>

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>

                <div class="center-container">
                    <a class="button police-login" href="login/login.php"> Police Login </a>
                </div>
            </div>
        </main>

    </div>
   
    <!-- Page Footer -->
    <?php include("templates/footer.php");?>

</body>
</html>