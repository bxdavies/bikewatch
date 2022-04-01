<!DOCTYPE html>
<?php 

    // Set page title, heading and sub heading
    $pageTitle = 'Police - Heatmap';
    $pageHeading = 'Heatmap'; 
    $pageSubHeading = 'Displaying a heatmap of all reported crimes';

    // Include the alerts function, database connection and error handler
    include('../../functions/alerts.php');
    include('../../functions/database.php');
    include('../../functions/errors.php');
	
    // Start session
	session_start();

    // If session role is not set to police then redirect to login page
    if ($_SESSION['role'] != 'police')
    {
        header('Location: ../../login/login.php');
    }

    // Assign session id to userID variable
    $userID = $_SESSION['id'];

?>
<html>
<head>
    <!-- Head Content -->
    <?php include('../../templates/head.php');?>

    <link rel="stylesheet" href="heatmap.css">
</head>
<body>

    <?php include('../../templates/alerts.php');?>
    
    <!-- Page Container -->
    <div class="container">

        <!-- Page Navigation -->
        <?php include('../../templates/navigation.php'); ?>

        <!-- Page Header -->
        <?php include('../../templates/header.php');?>

        <!-- Page Content -->
        <main>
            <div class="small-container">
                <div id="map"></div>
	        
            </div>

        </main>

    </div>
                        
    <!-- Page Footer -->
    <?php include('../../templates/footer.php');?>


    <script src="heatmap.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWxVTnG3cp4-3nuo5dfF8RTzqgX2pkbuA&libraries=visualization&callback=initMap" async></script>
</body>
</html>