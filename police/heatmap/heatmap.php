<!DOCTYPE html>
<?php 
    // Define page variables here. These will affect the page title, heading and sub heading
    $pageTitle = "Police - Heatmap";
    $pageHeading = "Heatmap"; 
    $pageSubHeading = "Displaying a heatmap of all reported crimes";

    include("../../functions/alerts.php"); // This loads a function for creating alerts 
    include("../../functions/database.php"); // This load the database the vairable you will neeed is $DBConnection
	
	session_start();

    if ($_SESSION['role'] != "police")
    {
        header("Location: ../../login/login.php");
    }

    // Set User ID
    $userID = $_SESSION['id'];

?>
<html>
<head>
    <!-- Head Content -->
    <?php include("../../templates/head.php");?>

    <!-- Page Specifc CSS goes here -->
    <link rel="stylesheet" href="heatmap.css">
</head>
<body>

    <?php include("../../templates/alerts.php");?>
    
    <!-- Page Container -->
    <div class="container">

        <!-- Page Naviagtion -->
        <?php include("../../templates/navigation.php"); ?>

        <!-- Page Header -->
        <?php include("../../templates/header.php");?>

        <!-- Page Content -->
        <main>
            <div class="small-conatiner">
                <div id="map"></div>
	        
            </div>

        </main>

    </div>
                        
    <!-- Page Footer -->
    <?php include("../../templates/footer.php");?>


    <script src="heatmap.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWxVTnG3cp4-3nuo5dfF8RTzqgX2pkbuA&libraries=visualization&callback=initMap" async></script>
</body>
</html>