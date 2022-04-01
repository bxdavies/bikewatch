<!DOCTYPE html>
<?php 
    // Define page variables here. These will affect the page title, heading and sub heading
    $pageTitle = "Police - All Crimes ";
    $pageHeading = "All Crimes"; 
    $pageSubHeading = "Displaying all reported crimes!";

    include("../../functions/alerts.php"); // This loads a function for creating alerts 
    include("../../functions/database.php"); // This load the database the vairable you will neeed is $DBConnection
	
	session_start();

    if ($_SESSION['role'] != "police")
    {
        header("Location: ../../login/login.php");
    }

    // Set User ID
    $userID = $_SESSION['id'];
    
    // Set Upload Folder
    $uploadFolder="../../uploads/";	
?>
<html>
<head>
    <!-- Head Content -->
    <?php include("../../templates/head.php");?>

    <!-- Page Specifc CSS goes here -->
    <link rel="stylesheet" href="dashboard.css">
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
    <?php include("../../templates/footer.php");?>

    <script src="dashboard.js"></script>
</body>
</html>