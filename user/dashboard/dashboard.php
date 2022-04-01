<!DOCTYPE html>
<?php

    // Set page title, heading and subheading
    $pageTitle = 'Home';
    $pageHeading = 'Welcome to your BikeWatch account';
    $pageSubHeading = 'Register a new bike and/or report a stolen bike';

    // Include the alerts function, database connection and error handler
    include('../../functions/alerts.php');
    include('../../functions/database.php');
    include('../../functions/errors.php');

    // Start session
    session_start();

    // If session role is not set to user then redirect to login page
    if ($_SESSION['role'] != 'user') {

        header('Location: ../../login/login.php');
    }

    // Assign session id to userID variable
    $userID = $_SESSION['id'];

    // Define upload folder variable
    $uploadFolder = '../../uploads/';

    // Get bikes and image from the database
    $DBGetBikes = $DBConnection->prepare("SELECT `bike`.`id`, `bike`.`nickname`, `bike`.`mpn`, `bike`.`brand`, `bike_image`.`image` FROM `bike` INNER JOIN `bike_image` ON `bike`.`id` = `bike_image`.`bike` WHERE `bike`.`user` = ? GROUP BY `bike`.`id`; ");
    $DBGetBikes->bind_param('i', $userID);

    // If addBike is in post data then add bike to the database
    if (isset($_POST['addBike'])) {

        // Assign post data to variables
        $nickname = $_POST['nickname'];
        $mpn = $_POST['mpn'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $type = $_POST['type'];
        $wheelSize = $_POST['wheelSize'];
        $colour = $_POST['colour'];
        $gears = $_POST['gears'];
        $brakes = $_POST['brakes'];
        $suspension = $_POST['suspension'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];

        // Create record for bike in the database
        $DBAddBike = $DBConnection->prepare("INSERT INTO `bike` (`user`, `nickname`, `mpn`, `brand`, `model`, `type`, `wheel_size`, `colour`, `no_gears`, `brake_type`, `suspension`, `gender`, `age`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $DBAddBike->bind_param('issssssssssss', $userID, $nickname, $mpn, $brand, $model, $type, $wheelSize, $colour, $gears, $brakes, $suspension, $gender, $age);

        // If record is created successfully then create records in the bike_image table
        if ($DBAddBike->execute()) {

            // Get Bike ID from id of created record
            $bikeID = $DBAddBike->insert_id;

            // Loop through uploaded files
            foreach ($_FILES['images']['name'] as $key => $file_name) {

                // Create a record for the image in the DB
                $DBAddImage = $DBConnection->prepare("INSERT INTO `bike_image` (`bike`) VALUES (?)");
                $DBAddImage->bind_param('i', $bikeID);

                // If record is created successfully then upload file to the uploads folder and update image location in the database
                if ($DBAddImage->execute()) {

                    // Get Image ID from id of created record
                    $imageID = $DBAddImage->insert_id;

                    // Set temporary name
                    $tmpName = $_FILES['images']['tmp_name'][$key];

                    // Get image extension
                    $ext = end(explode(".", $file_name));

                    // Set the images new file name
                    $newImageName = $imageID . "." . $ext;

                    // Move file from temporary to upload folder
                    move_uploaded_file($tmpName, $uploadFolder . $newImageName);

                    // Update image file name in the database
                    $DBUpdateImage = $DBConnection->prepare("UPDATE `bike_image` SET `image` = ? WHERE `bike_image`.`id` = ?");
                    $DBUpdateImage->bind_param('si', $newImageName, $imageID);

                    // If record is created successfully then alert user
                    if ($DBUpdateImage->execute()) {
                        createAlert('success', 'Bike has been added to your account!');
                        
                    }
                    // Else display error message and log
                    else {
                        createAlert('error', 'Failed to update images in the database!');
                        errorHandler(1, "Failed to update record to bike_image : {$DBUpdateImage->error}");
                    }

                    // Close 
                    $DBUpdateImage->close();
                }
                // Else display error message and log
                else {
                    createAlert('error', 'Failed to add images to the database!');
                    errorHandler(1, "Failed to add record to bike_image : {$DBAddImage->error}");
                }

                // Close
                $DBAddImage->close();
            }
        }
        // Else display error message and log
        else {
            createAlert('error', 'Failed to add bike to the database!');
            errorHandler(1, "Failed to add record to bike : {$DBAddBike->error}");
        }

        // Close 
        $DBAddBike->close();
    }
?>
<html>

<head>
    <!-- Head Content -->
    <?php include("../../templates/head.php"); ?>
    <link rel="stylesheet" href="dashboard.css">

    <script src="../../assets/js/jscolor.js"></script>
</head>

<body>

    <!-- Alert conatiner -->
    <?php include("../../templates/alerts.php"); ?>

    <div class="container">

        <!-- Page naviagtion -->
        <?php include("../../templates/navigation.php"); ?>

        <!-- Page header -->
        <?php include("../../templates/header.php"); ?>

        <!-- Page content -->
        <main>
            <div class="big-container">
                <div class="flex one two-12        // Close 
        $DBAddBike->close();00">

                    <!-- Bikes table -->
                    <div class="full two-third-1200" style="overflow-x:auto;">
                        <h3> Your Bikes </h3>
                        <table>
                            <thead>
                                <tr>
                                    <th> Image </th>
                                    <th> Nickname </th>
                                    <th class="details"> Details </th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // If query is successfully then add a row to the table
                                if ($DBGetBikes->execute()) {
                                    $bikes = $DBGetBikes->get_result();

                                    // Loop through results
                                    while ($bike = $bikes->fetch_assoc()) {

                                ?>
                                        <tr>
                                            <td> <img src="<?php echo $uploadFolder . $bike['image']; ?>" class="bike-image"> </td>
                                            <td> <?php echo $bike['nickname']; ?> </td>
                                            <td class="details">
                                                <p> MPN: <?php echo $bike['mpn']; ?> </p>
                                                <p> Brand: <?php echo $bike['brand']; ?> </p>
                                            </td>
                                            <td>
                                                <a href="#" class="button"> Edit</a>
                                                <a href="../report/report.php?bikeID=<?php echo $bike['id']; ?>" class="button"> Report </a>
                                            </td>
                                        </tr>

                                <?php
                                    }
                                } 
                                // Else display error message and log
                                else {
                                    createAlert('error', 'Failed to fetch bikes from the database');
                                    errorHandler(1, "Failed to fetch bikes from the database : {$DBGetBikes->error}");
                                }

                                // Close
                                $DBGetBikes->close();

                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Add bike -->
                    <div class="full third-1200">
                        <h3> Add a Bike </h3>
                        <form method="post" enctype="multipart/form-data">

                            <label for="nickname">Nickname</label>
                            <input type="text" name="nickname" id="nickname" required>

                            <label for="mpn"> Manufacturer part number (MPN) </label>
                            <input type="text" name="mpn" id="mpn">

                            <label for="brand"> Brand </label>
                            <input type="text" name="brand" id="brand" required>

                            <label for="model"> Model </label>
                            <input type="text" name="model" id="model" required>

                            <label for="type"> Type </label>
                            <select name="type" id="type" required>
                                <option> Hybrid </option>
                                <option> Road </option>
                                <option> Mountain </option>
                                <option> BMX </option>
                            </select>

                            <label for="wheelSize"> Wheel Size </label>
                            <input type="number" name="wheelSize" id="wheelSize">

                            <label for="colour"> Colour </label>
                            <input name="colour" id="colour" data-jscolor="{closeButton:true, closeText:'Close', backgroundColor:'#333', buttonColor:'#FFF'}">

                            <label for="gears"> Gears </label>
                            <input type="number" name="gears" id="gears" required>

                            <label for="brakes"> Brake Type </label>
                            <select name="brakes" id="brakes">
                                <option> Clamp / Rim Brakes </option>
                                <option> Disk Brakes </option>
                                <option> V Brakes </option>
                            </select>

                            <label for="suspension"> Suspension </label>
                            <select name="suspension" id="suspension">
                                <option> Back </option>
                                <option> Front </option>
                                <option> Full </option>
                            </select>

                            <label for="gender"> Gender </label>
                            <select name="gender" id="gender">
                                <option selected> Unisex </option>
                                <option> Male </option>
                                <option> Female </option>
                            </select>

                            <label for="age"> Age </label>
                            <select name="age" id="age">
                                <option> 3-4 </option>
                                <option> 5-6 </option>
                                <option> 7-8 </option>
                                <option> 9-10 </option>
                                <option> 11-12 </option>
                                <option selected> Adult </option>
                            </select>

                            <label for="images"> Images </label>
                            <input type="file" multiple name="images[]" id="images" required>

                            <input type="submit" name="addBike" value="Add Bike">
                        </form>
                    </div>
                </div>
            </div>

        </main>

    </div>

    <!-- Page Footer -->
    <?php include("../../templates/footer.php"); ?>
    
    <!-- Javascript -->
    <script type="text/javascript" src="https://chir.ag/projects/ntc/ntc.js"></script>
    <script type="text/javascript" src="dashboard.js"></script>

</body>

</html>