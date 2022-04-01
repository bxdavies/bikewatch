<!DOCTYPE html>
<?php 

    // Set page title, heading and sub heading
    $pageTitle = "Police - All Crimes ";
    $pageHeading = "All Crimes"; 
    $pageSubHeading = "Displaying all reported crimes!";

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
    
    // Set Upload Folder
    $uploadFolder='../../uploads/';	
?>
<html>
<head>
    <!-- Head Content -->
    <?php include('../../templates/head.php');?>

    <link rel="stylesheet" href="dashboard.css">
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
            <select id="numberOfResultsToDisplay" class="count">
                <option> 10 </option>
                <option> 50 </option>
                <option> 100 </option>
            </select>
            <table> 
                <thead> 
                    <tr>
                        <th id="IDColumn" > ID <span> <span> </th>
                        <th id="reportDateColumn"> Report Date <span> <span> </th>
                        <th id="victimColumn"> Victim <span> <span> </th>
                        <th> Bike </th>
                        <th id="lastSeenColumn"> Last Seen <span> <span> </th>
                        <th id="statusColumn"> Status <span> <span> </th>
                        <th> Actions </th>
                    </tr>
                </thead>
                <tbody id="crimeTable">
                    
                </tbody>
            </table>
            <?php 
               

            ?>
        <div id="pageButtons">
            
        </div>
        </main>

    </div>
                        
    <!-- Page Footer -->
    <?php include('../../templates/footer.php');?>

    <script src="dashboard.js"></script>
</body>
</html>