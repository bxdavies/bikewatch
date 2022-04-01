<!DOCTYPE html>
<?php 
    // Define page variables here. These will affect the page title, heading and sub heading
    $pageTitle = "Police - Search";
    $pageHeading = "Search"; 
    $pageSubHeading = "Search crimes, users or bikes";

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
    <link rel="stylesheet" href="search.css">
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
                <h3> Easy Search </h3>
                    <label for="etable"> What are you searching for?</label>
                    <select name="etable" id="etable">
                        <option value="user"> User </option>
                        <option value="bike"> Bike </option>
                        <option value="crime"> Crime </option>
                    </select>
                    <label for="id"> ID </label>
                    <input type="number" id="id" name="id">

                    <button id="esearch"> Search</button>
                <h3> Complex Search </h3>
            
                <label for="table"> What are you searching for?</label>
                <select name="table" id="table">
                    <option value=""> Please select </option>
                    <option value="user" > User </option>
                    <option value="bike" > Bike </option>
                </select>

                <label for="column"> What columns do you want to search?</label>
                <select name="column" id="column" multiple>
                    <option> Please select what you want to search </option>
                </select>

                <div id="inputs"> </div>

                <button id="search"> Search</button>
            </div>

        </main>

    </div>
                        
    <!-- Page Footer -->
    <?php include("../../templates/footer.php");?>
    <script src="search.js"></script>

</body>
</html>