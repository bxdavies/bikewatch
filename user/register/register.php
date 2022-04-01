<!DOCTYPE html>
<?php

    // Set page title, heading and subheading
    $pageTitle = 'Register';
    $pageHeading = 'Register';
    $pageSubHeading = 'Please create an account to use BikeWatch';

    // Include the alerts function, database connection and error handler
    include('../../functions/alerts.php');
    include('../../functions/database.php');
    include('../../functions/errors.php');

    // If register in post data then add user to the database
    if (isset($_POST['register'])) {

        // Assign post data to variables
        $title = $_POST['title'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $gender = $_POST['gender'];
        $ethnicity = $_POST['ethnicity'];
        $addressLine1 = $_POST['addressLine1'];
        $addressLine2 = $_POST['addressLine2'];
        $localAuthority = $_POST['localAuthority'];
        $town = $_POST['town'];
        $postcode = $_POST['postcode'];
        $emailAddress = $_POST['emailAddress'];
        $phoneNumber = $_POST['phoneNumber'];

        // Create a hyphenated date string from DOB post data, then create date object and format to Y-m-d for the database
        $DOBString = $_POST['DOBYear'] . "-" . $_POST['DOBDay'] . "-" . $_POST['DOBMonth'];
        $DOB = date_create($DOBString);
        $DOB = date_format($DOB, 'Y-m-d');
        
        // Hash password
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Generate a random verification code
        $verificationCode = substr(md5(uniqid(rand(), true)), 16, 16);

        // Create record for user in the database
        $DBAddUser = $DBConnection->prepare("INSERT INTO `user`(`role`, `title`, `first_name`, `last_name`, `dob`, `gender`, `ethnicity`, `address_line_1`, `address_line_2`, `local_authority`, `town`, `postcode`, `mobile_number`, `email_address`, `password`, `verification_code`) VALUES ('user', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $DBAddUser->bind_param('sssssssssssssss', $title, $firstName, $lastName, $DOB, $gender, $ethnicity, $addressLine1, $addressLine2, $localAuthority, $town, $postcode, $phoneNumber, $emailAddress,  $password, $verificationCode);

        // If record is created successfully then send an email and alert the user
        if ($DBAddUser->execute()) {

            // Get userID from id of created record
            $userID = $DBAddUser->insert_id;

            // Set email message content
            $message = "
                <html>
                <body>
                <h1> Welcome to Gloucestershire Constabulary BikeWatch </h1>
                <p> Please click <a href='https://s4101563-ct4009.uogs.co.uk/user/verify/verify.php?userID=$userID&verificationCode=$verificationCode'> this </a> link to verify you account! </p>
                </body>
                </html>
                ";
            // Alert user
            createAlert('success', 'Account successfully created! A link to verify your account has been emailed to you.');
            
            // Load send email function and send email
            include("../../functions/email.php");
            sendEmail($emailAddress, "Verify your Account!", $message);

        } 
        // Else display error message and log
        else {
            createAlert('error', 'Failed to add user to the database!');
            errorHandler(1, "Failed to add record to user : {$DBAddUser->error}");
        }

        // Close
        $DBAddUser->close();
    }
?>
<html>

<head>
    <!-- Head Content -->
    <?php include("../../templates/head.php"); ?>
    <link rel="stylesheet" href="register.css">
</head>

<body>

    <!-- Alert conatiner -->
    <?php include("../../templates/alerts.php"); ?>

    <div class="container">

        <!-- Page Naviagtion -->
        <?php include("../../templates/navigation.php"); ?>

        <!-- Page Header -->
        <?php include("../../templates/header.php"); ?>

        <!-- Page Content -->
        <main>

            <div class="small-container">
                <form method="POST">

                    <h3> About You </h3>

                    <!-- Title, First Name, Last Name -->
                    <h4> Title and Name </h4>
                    <label for="title">Title</label>
                    <select id="title" name="title" required>
                        <option value="">Please select ...</option>
                        <option>Mr</option>
                        <option>Mrs</option>
                        <option>Miss</option>
                        <option>Ms</option>
                        <option>Dr</option>
                        <option>Rev</option>
                        <option>Other</option>
                    </select>

                    <label for="firstName"> First name </label>
                    <input id="firstName" name="firstName" type="text" placeholder="John" required>

                    <label for="lastName"> Last name </label>
                    <input id="lastName" name="lastName" type="text" placeholder="Doe" required>

                    <hr>

                    <!-- DOB -->
                    <h4> Date of birth </h4>
                    <div class="hint"> Day Month Year </div>
                    <div class="dob">
                        <div>
                            <label for="DOBDay"> Day </label>
                            <input id="DOBDay" name="DOBDay" type="number" placeholder="24" min="1" max="31" size="2" style="width: 2.5em;" required>
                        </div>

                        <div>
                            <label for="DOBMonth"> Month </label>
                            <input id="DOBMonth" name="DOBMonth" type="number" placeholder="12" min="1" max="12" size="2" style="width: 2.5em;" required>
                        </div>


                        <div>
                            <label for="DOBYear"> Year </label>
                            <input id="DOBYear" name="DOBYear" type="number" placeholder="2018" size="4" style="width: 4em;" required>
                        </div>
                    </div>

                    <hr>

                    <!-- Gender -->
                    <h4> What is your gender? </h4>

                    <label>
                        <input type="radio" name="gender" value="Female">
                        <span class="checkable"> Female </span>
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="gender" value="Male">
                        <span class="checkable"> Male </span>
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="gender" value="Non-binary">
                        <span class="checkable"> Non-binary </span>
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="gender" value="Prefer not to say">
                        <span class="checkable"> Prefer not to say </span>
                    </label>

                    <!-- Ethnicity -->
                    <h4> Ethnicity </h4>
                    <select name="ethnicity" required>

                        <option value="">Please select ...</option>

                        <optgroup label="Asian or Asian British">
                            <option>Bangladeshi</option>
                            <option>Indian</option>
                            <option>Pakistani</option>
                            <optio>Any other Asian background</option>
                        </optgroup>

                        <optgroup label="Black or Black British">
                            <option>African</option>
                            <option>Caribbean</option>
                            <option>Any other Black background</option>
                        </optgroup>

                        <optgroup label="Chinese or any other ethnic group">
                            <option>Chinese</option>
                            <option>Any other ethnic group</option>
                        </optgroup>

                        <optgroup label="Mixed">
                            <option>White and Asian</option>
                            <option>White and Black African</option>
                            <option>White and Black Caribbean</option>
                            <option>Any other mixed background</option>
                        </optgroup>

                        <optgroup label="White">
                            <option>White - British</option>
                            <option>White - Irish</option>
                            <option>Any other White background</option>
                        </optgroup>

                        <optgroup label="Other">
                            <option>I prefer not to say</option>
                        </optgroup>

                    </select>

                    <!-- Address -->
                    <h3> Your Address </h3>

                    <label for="searchAddress"> Search For your Address </label>
                    <input id="searchAddress" name="searchAddress" type="text">

                    <label for="addressLine1"> Address Line 1 </label>
                    <input id="addressLine1" name="addressLine1" type="text" required>

                    <label for="addressLine2"> Address Line 2 </label>
                    <input id="addressLine2" name="addressLine2" type="text">

                    <label for="localAuthority"> Local Authority </label>
                    <select id="localAuthority" name="localAuthority" required>
                        <option value=""> Please select ...</option>
                        <option> Tewkesbury </option>
                        <option> Forest of Dean </option>
                        <option> City of Gloucester </option>
                        <option> Cheltenham </option>
                        <option> Stroud </option>
                        <option> Cotswold </option>
                        <option> South Gloucestershire </option>
                    </select>

                    <label for="town"> Town </label>
                    <input id="town" name="town" type="text" required>

                    <label for="postcode"> Postcode </label>
                    <input id="postcode" name="postcode" type="text" required>

                    <!-- Conact Infomation -->
                    <h3> Conact Information </h3>

                    <label for="emailAddress"> Email </label>
                    <input id="emailAddress" name="emailAddress" type="email" placeholder="john.doe@example.com" required>

                    <label for="phoneNumber"> Phone Number </label>
                    <input id="phoneNumber" name="phoneNumber" placeholder="07700 900000" type="tel" required>

                    <!-- Password -->
                    <h3> Password </h3>

                    <label for="password"> Password </label>
                    <input id="password" name="password" type="password" required>

                    <label for="password-verify"> Password Verify </label>
                    <input id="password-verify" type="password" required>

                    <!-- Submit -->
                    <input type="submit" value="Register" name="register" />

                </form>
            </div>
        </main>



    </div>
    <!-- Page Footer -->
    <?php include("../../templates/footer.php"); ?>

    <!-- Javascript -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWxVTnG3cp4-3nuo5dfF8RTzqgX2pkbuA&libraries=places&callback=initAutocomplete" async></script>
    <script type="text/javascript" src="register.js"> </script>

</body>

</html>