<!DOCTYPE html>
<?php

    // Include the alerts function, database connection and error handler
    include('../../functions/alerts.php');
    include('../../functions/database.php');
    include('../../functions/errors.php');

    // Start session
    session_start();

      // If session role is not set to police then redirect to login page
    if ($_SESSION['role'] != "police") {
        header("Location: ../../login/login.php");
    }

    // Check ID exists
    if (!isset($_GET['id'])) {
        createAlert('error', 'No crime ID provided!');
    }

    // Assign ID and type to vairables
    $ID = intval($_GET['id']);
    $type = $_GET['type'];

    // Set page title, heading and subheading
    $hummanType = ucfirst($type);
    $pageTitle = "Police - {$hummanType} View";
    $pageHeading = "{$hummanType} View ";
    $pageSubHeading = "You are viewing {$hummanType}: {$ID}";

    // Assign session id to userID variable
    $userID = $_SESSION['id'];

    // Set Upload Folder
    $uploadFolder = "../../uploads/";

    // If save is in post data then add comment to the database
    if (isset($_POST["save"])) {

        // Assign post data to variables
        $comment = $_POST["comment"];

        // If visibility is set then set public to true
        if (isset($_POST['visibility'])) {
            $DBAddComment = $DBConnection->prepare("INSERT INTO `comment` (`crime`, `author`, `public`, `comment`) VALUES (?, 1, ?, ?) ");
        } 
        // Else set public to false
        else {
            $DBAddComment = $DBConnection->prepare("INSERT INTO `comment` (`crime`, `author`, `comment`) VALUES (?, ?, ?) ");
        }

        $DBAddComment->bind_param('iis', $ID, $userID, $comment);
        
        // If record is inserted successfully then alert the user
        if ($DBAddComment->execute()) {
            createAlert('success', 'Comment Added!');
        } 
        // Else display error message and log
        else {
            createAlert('error', 'Failed to add comment to the database!');
            errorHandler(1, "Failed to add comment : {$DBAddComment->error}");
        }
    }
?>
<html>

<head>
    <!-- Head Content -->
    <?php include("../../templates/head.php"); ?>

    <!-- Page Specifc CSS goes here -->
    <link rel="stylesheet" href="view.css">
</head>

<body>

    <?php include("../../templates/alerts.php"); ?>

    <!-- Page Container -->
    <div class="container">

        <!-- Page Naviagtion -->
        <?php include("../../templates/navigation.php"); ?>

        <!-- Page Header -->
        <?php include("../../templates/header.php"); ?>

        <!-- Page Content -->
        <main>

            <!-- Image Modal -->
            <div class="modal">
                <input id="imageModal" type="checkbox" />
                <label for="imageModal" class="overlay"></label>
                <article>
                    <header>
                        <h3> Image </h3>
                        <label for="imageModal" class="close">&times;</label>
                    </header>
                    <section class="content">
                        <img id="modalImage">
                    </section>
                </article>
            </div>

            <div class="big-container">
                <?php
                if ($type == 'user') {
                    $DBGetUser = $DBConnection->prepare("SELECT `title`, `first_name`, `last_name`, `dob`, `gender`, `ethnicity`, `address_line_1`, `address_line_2`, `local_authority`, `town`, `postcode`, `mobile_number`, `email_address` FROM `user` WHERE `id` = ?");
                    $DBGetUser->bind_param('i', $ID);
                    $DBGetUser->execute();

                    $result = $DBGetUser->get_result();
                    $user = $result->fetch_assoc();

                    $DBGetBikes = $DBConnection->prepare("SELECT `bike`.`id`, `bike`.`nickname`, `bike`.`mpn`, `bike`.`brand`, `bike_image`.`image` FROM `bike` INNER JOIN `bike_image` ON `bike`.`id` = `bike_image`.`bike` WHERE `bike`.`user` = ? GROUP BY `bike`.`id`; ");
                    $DBGetBikes->bind_param('i', $ID);
                    $DBGetBikes->execute();

                    $bikes = $DBGetBikes->get_result();

                    include("user.php");
                } elseif ($type == 'bike') {
                    $DBGetUser = $DBConnection->prepare("SELECT `user`.`title`, `user`.`first_name`, `user`.`last_name`, `user`.`dob`, `user`.`gender`, `user`.`ethnicity`, `user`.`address_line_1`, `user`.`address_line_2`, `user`.`local_authority`, `user`.`town`, `user`.`postcode`, `user`.`mobile_number`, `user`.`email_address` FROM `bike` INNER JOIN `user` ON `user`.`id` = `bike`.`user` WHERE `bike`.`id` = ?");
                    $DBGetUser->bind_param('i', $ID);
                    $DBGetUser->execute();
                    $result = $DBGetUser->get_result();
                    $user = $result->fetch_assoc();

                    $DBGetBike = $DBConnection->prepare("SELECT `bike`.`nickname`, `bike`.`mpn`, `bike`.`brand`, `bike`.`model`, `bike`.`type`, `bike`.`wheel_size`, `bike`.`colour`, `bike`.`no_gears`, `bike`.`brake_type`, `bike`.`suspension`, `bike`.`gender`, `bike`.`age` FROM `bike` WHERE `bike`.`id` = ?;");
                    $DBGetBike->bind_param('i', $ID);
                    $DBGetBike->execute();

                    $result = $DBGetBike->get_result();
                    $bike = $result->fetch_assoc();

                    $DBGetNumberOfBikeImages = $DBConnection->prepare("SELECT COUNT(*) FROM `bike_image` INNER JOIN `bike` ON `bike_image`.`bike` = `bike`.`id` WHERE `bike`.`id` = ?");
                    $DBGetNumberOfBikeImages->bind_param('i', $ID);
                    $DBGetNumberOfBikeImages->execute();

                    $result = $DBGetNumberOfBikeImages->get_result();
                    $numberOfImages = $result->fetch_assoc()["COUNT(*)"];

                    $DBGetBikeImages = $DBConnection->prepare("SELECT `bike_image`.`image` FROM `bike_image` INNER JOIN `bike` ON `bike_image`.`bike` = `bike`.`id` WHERE `bike`.`id` = ?");
                    $DBGetBikeImages->bind_param('i', $ID);
                    $DBGetBikeImages->execute();

                    $bikeImages = $DBGetBikeImages->get_result();

                    include("bike.php");
                } elseif ($type == 'crime') {
                    $DBGetUser = $DBConnection->prepare("SELECT `user`.`title`, `user`.`first_name`, `user`.`last_name`, `user`.`dob`, `user`.`gender`, `user`.`ethnicity`, `user`.`address_line_1`, `user`.`address_line_2`, `user`.`local_authority`, `user`.`town`, `user`.`postcode`, `user`.`mobile_number`, `user`.`email_address` FROM `crime` INNER JOIN `bike`ON `bike`.`id` = `crime`.`bike` INNER JOIN `user` ON `user`.`id` = `bike`.`user` WHERE `crime`.`id` = ?;");
                    $DBGetUser->bind_param('i', $ID);
                    $DBGetUser->execute();

                    $result = $DBGetUser->get_result();
                    $victim = $result->fetch_assoc();

                    $DBGetBike = $DBConnection->prepare("SELECT `bike`.`nickname`, `bike`.`mpn`, `bike`.`brand`, `bike`.`model`, `bike`.`type`, `bike`.`wheel_size`, `bike`.`colour`, `bike`.`no_gears`, `bike`.`brake_type`, `bike`.`suspension`, `bike`.`gender`, `bike`.`age` FROM `crime` INNER JOIN `bike`ON `bike`.`id` = `crime`.`bike` WHERE `crime`.`id` = ?;");
                    $DBGetBike->bind_param('i', $ID);
                    $DBGetBike->execute();

                    $result = $DBGetBike->get_result();
                    $bike = $result->fetch_assoc();

                    $DBGetNumberOfBikeImages = $DBConnection->prepare("SELECT COUNT(*) FROM `bike_image` INNER JOIN `crime` ON `bike_image`.`bike` = `crime`.`bike` WHERE `crime`.`id` = ?");
                    $DBGetNumberOfBikeImages->bind_param('i', $ID);
                    $DBGetNumberOfBikeImages->execute();

                    $result = $DBGetNumberOfBikeImages->get_result();
                    $numberOfImages = $result->fetch_assoc()["COUNT(*)"];

                    $DBGetBikeImages = $DBConnection->prepare("SELECT `bike_image`.`image` FROM `bike_image` INNER JOIN `crime` ON `bike_image`.`bike` = `crime`.`bike` WHERE `crime`.`id` = ?");
                    $DBGetBikeImages->bind_param('i', $ID);
                    $DBGetBikeImages->execute();

                    $bikeImages = $DBGetBikeImages->get_result();

                    $DBGetCrime = $DBConnection->prepare("SELECT * FROM `crime` WHERE `crime`.`id` = ?");
                    $DBGetCrime->bind_param('i', $ID);
                    $DBGetCrime->execute();

                    $result = $DBGetCrime->get_result();
                    $crime = $result->fetch_assoc();

                    $DBGetComments = $DBConnection->prepare("SELECT `user`.`role`, `user`.`title`, `user`.`first_name`, `user`.`last_name`, `comment`.`comment` FROM `comment` INNER JOIN `user` ON `user`.`id` = `comment`.`author` WHERE `comment`.`crime` = ?");
                    $DBGetComments->bind_param('i', $ID);
                    $DBGetComments->execute();

                    $comments = $DBGetComments->get_result();

                    include("crime.php");
                }

                ?>
            </div>
        </main>

    </div>

    <!-- Page Footer -->
    <?php include("../../templates/footer.php"); ?>
    <script type="text/javascript" src="https://chir.ag/projects/ntc/ntc.js"></script>
    <script src="view.js"></script>
   
</body>

</html>