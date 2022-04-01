<!DOCTYPE html>
<?php 

    // Set page title, heading and subheading
    $pageTitle = 'Account Verifcation';
    $pageHeading = 'Account Verifcation'; 
    $pageSubHeading = 'Account Verifcation Page';
    
    // Include the alerts function, database connection and error handler
    include('../../functions/alerts.php');
    include('../../functions/database.php');
    include('../../functions/errors.php');

    // Get user id and verification code from get data
    $userID = $_GET['userID'];
    $verificationCode = $_GET['verificationCode'];

    // If user id and verification code are not null then check verification code
    if ($verificationCode && $userID ){

        // Get verification code from database
        $DBGetVerificationCode = $DBConnection->prepare("SELECT `verification_code` FROM `user` WHERE `id` = ?");
        $DBGetVerificationCode->bind_param('i', $userID);

        if($DBGetVerificationCode->execute())
        {
            $verificationCodeinDB=$DBGetVerificationCode->get_result();
            $verificationCodeinDB=$verificationCodeinDB->fetch_assoc()['verification_code'];
            $DBGetVerificationCode->close();
            
            // If verification code in URL matches the verification code in the database set user to verified
            if($verificationCodeinDB == $verificationCode){

                // Set user to verified
                $DBSetVerified = $DBConnection->prepare("UPDATE `user` SET `verified` = 1 WHERE `id` = ?");
                $DBSetVerified->bind_param('i', $userID);

                // If record is successfully updated alert user
                if($DBSetVerified->execute()){
                    createAlert('success', 'Your account has been verified!', 'https://s4101563-ct4009.uogs.co.uk/login/login.php');
                }
                // Else display error message and log
                else{
                    createAlert('error', 'Failed to update verified in the database!');
                    errorHandler(1, "Failed to update record to  verified in the database: {$DBSetVerified->error}");
                }
                
                // Close
                $DBSetVerified->close();

            }
            // Else display error message
            else{
                createAlert('error', 'The provided verification code does not match the verifaction code in the database!');
            }
        }
        // Else display error message and log
        else{
            createAlert('error', 'Failed to get verifcation code from the database!');
            errorHandler(1, "Failed to get verifcation code from the database!: {$DBSetVerified->error}");
        }
    }
    // Else display error message
    else{
        createAlert('error', 'Verifcation code or user id missing from URL pramaters!');
    }

?>
<html>
<head>
    <!-- Head Content -->
    <?php include("../../templates/head.php");?>
</head>
<body>

    <?php include("../../templates/alerts.php");?>

    <div class="container">

        <!-- Page Naviagtion -->
        <?php include("../../templates/navigation.php"); ?>

        <!-- Page Header -->
        <?php include("../../templates/header.php");?>

        <!-- Page Content -->
        <main>

        </main>
            
    </div>
    <!-- Page Footer -->
    <?php include("../../templates/footer.php");?>

</body>
</html>