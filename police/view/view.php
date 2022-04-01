<!DOCTYPE html>
<?php

    include("../../functions/alerts.php"); // This loads a function for creating alerts 
    include("../../functions/database.php"); // This load the database the vairable you will neeed is $DBConnection

    // Start Session
    session_start();

    // Check if Police is logged in
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

    // Set Page Title, Heading and Sub Heading
    $hummanType = ucfirst($type);
    $pageTitle = "Police - {$hummanType} View";
    $pageHeading = "{$hummanType} View ";
    $pageSubHeading = "You are viewing {$hummanType}: {$ID}";

    // Set User ID
    $userID = $_SESSION['id'];

    // Set Upload Folder
    $uploadFolder = "../../uploads/";

    if (isset($_POST["save"])) {

        $comment = $_POST["comment"];

        if (isset($_POST['visibility'])) {
            $insertCommentDB = $DBConnection->prepare("INSERT INTO `comment` (`crime`, `author`, `public`, `comment`) VALUES (?, 1, ?, ?) ");
        } else {
            $insertCommentDB = $DBConnection->prepare("INSERT INTO `comment` (`crime`, `author`, `comment`) VALUES (?, ?, ?) ");
        }
        $insertCommentDB->bind_param('iis', $crimeID, $userID, $comment);

        if ($insertCommentDB->execute()) {
            createAlert('success', 'Comment Added!');
        } else {
            echo "Failed to add record!" . $insertCommentDB->error;
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
                    $userDB = $DBConnection->prepare("SELECT `title`, `first_name`, `last_name`, `dob`, `gender`, `ethnicity`, `address_line_1`, `address_line_2`, `local_authority`, `town`, `postcode`, `mobile_number`, `email_address` FROM `user` WHERE `id` = ?");
                    $userDB->bind_param('i', $ID);
                    $userDB->execute();

                    $result = $userDB->get_result();
                    $user = $result->fetch_assoc();

                    $bikeDB = $DBConnection->prepare("SELECT `bike`.`id`, `bike`.`nickname`, `bike`.`mpn`, `bike`.`brand`, `bike_image`.`image` FROM `bike` INNER JOIN `bike_image` ON `bike`.`id` = `bike_image`.`bike` WHERE `bike`.`user` = ? GROUP BY `bike`.`id`; ");
                    $bikeDB->bind_param('i', $ID);
                    $bikeDB->execute();

                    $bikes = $bikeDB->get_result();

                    include("user.php");
                } elseif ($type == 'bike') {
                    $userDB = $DBConnection->prepare("SELECT `user`.`title`, `user`.`first_name`, `user`.`last_name`, `user`.`dob`, `user`.`gender`, `user`.`ethnicity`, `user`.`address_line_1`, `user`.`address_line_2`, `user`.`local_authority`, `user`.`town`, `user`.`postcode`, `user`.`mobile_number`, `user`.`email_address` FROM `bike` INNER JOIN `user` ON `user`.`id` = `bike`.`user` WHERE `bike`.`id` = ?");
                    $userDB->bind_param('i', $ID);
                    $userDB->execute();
                    $result = $userDB->get_result();
                    $user = $result->fetch_assoc();

                    $bikeDB = $DBConnection->prepare("SELECT `bike`.`nickname`, `bike`.`mpn`, `bike`.`brand`, `bike`.`model`, `bike`.`type`, `bike`.`wheel_size`, `bike`.`colour`, `bike`.`no_gears`, `bike`.`brake_type`, `bike`.`suspension`, `bike`.`gender`, `bike`.`age` FROM `bike` WHERE `bike`.`id` = ?;");
                    $bikeDB->bind_param('i', $ID);
                    $bikeDB->execute();

                    $result = $bikeDB->get_result();
                    $bike = $result->fetch_assoc();

                    $numberOfBikeImagesDB = $DBConnection->prepare("SELECT COUNT(*) FROM `bike_image` INNER JOIN `bike` ON `bike_image`.`bike` = `bike`.`id` WHERE `bike`.`id` = ?");
                    $numberOfBikeImagesDB->bind_param('i', $ID);
                    $numberOfBikeImagesDB->execute();

                    $result = $numberOfBikeImagesDB->get_result();
                    $numberOfImages = $result->fetch_assoc()["COUNT(*)"];

                    $bikeImagesDB = $DBConnection->prepare("SELECT `bike_image`.`image` FROM `bike_image` INNER JOIN `bike` ON `bike_image`.`bike` = `bike`.`id` WHERE `bike`.`id` = ?");
                    $bikeImagesDB->bind_param('i', $ID);
                    $bikeImagesDB->execute();

                    $bikeImages = $bikeImagesDB->get_result();

                    include("bike.php");
                } elseif ($type == 'crime') {
                    $userDB = $DBConnection->prepare("SELECT `user`.`title`, `user`.`first_name`, `user`.`last_name`, `user`.`dob`, `user`.`gender`, `user`.`ethnicity`, `user`.`address_line_1`, `user`.`address_line_2`, `user`.`local_authority`, `user`.`town`, `user`.`postcode`, `user`.`mobile_number`, `user`.`email_address` FROM `crime` INNER JOIN `bike`ON `bike`.`id` = `crime`.`bike` INNER JOIN `user` ON `user`.`id` = `bike`.`user` WHERE `crime`.`id` = ?;");
                    $userDB->bind_param('i', $ID);
                    $userDB->execute();

                    $result = $userDB->get_result();
                    $victim = $result->fetch_assoc();

                    $bikeDB = $DBConnection->prepare("SELECT `bike`.`nickname`, `bike`.`mpn`, `bike`.`brand`, `bike`.`model`, `bike`.`type`, `bike`.`wheel_size`, `bike`.`colour`, `bike`.`no_gears`, `bike`.`brake_type`, `bike`.`suspension`, `bike`.`gender`, `bike`.`age` FROM `crime` INNER JOIN `bike`ON `bike`.`id` = `crime`.`bike` WHERE `crime`.`id` = ?;");
                    $bikeDB->bind_param('i', $ID);
                    $bikeDB->execute();

                    $result = $bikeDB->get_result();
                    $bike = $result->fetch_assoc();

                    $numberOfBikeImagesDB = $DBConnection->prepare("SELECT COUNT(*) FROM `bike_image` INNER JOIN `crime` ON `bike_image`.`bike` = `crime`.`bike` WHERE `crime`.`id` = ?");
                    $numberOfBikeImagesDB->bind_param('i', $ID);
                    $numberOfBikeImagesDB->execute();

                    $result = $numberOfBikeImagesDB->get_result();
                    $numberOfImages = $result->fetch_assoc()["COUNT(*)"];

                    $bikeImagesDB = $DBConnection->prepare("SELECT `bike_image`.`image` FROM `bike_image` INNER JOIN `crime` ON `bike_image`.`bike` = `crime`.`bike` WHERE `crime`.`id` = ?");
                    $bikeImagesDB->bind_param('i', $ID);
                    $bikeImagesDB->execute();

                    $bikeImages = $bikeImagesDB->get_result();

                    $crimeDB = $DBConnection->prepare("SELECT * FROM `crime` WHERE `crime`.`id` = ?");
                    $crimeDB->bind_param('i', $ID);
                    $crimeDB->execute();

                    $result = $crimeDB->get_result();
                    $crime = $result->fetch_assoc();

                    $commentsDB = $DBConnection->prepare("SELECT `user`.`role`, `user`.`title`, `user`.`first_name`, `user`.`last_name`, `comment`.`comment` FROM `comment` INNER JOIN `user` ON `user`.`id` = `comment`.`author` WHERE `comment`.`crime` = ?");
                    $commentsDB->bind_param('i', $ID);
                    $commentsDB->execute();

                    $comments = $commentsDB->get_result();

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