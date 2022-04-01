<!DOCTYPE html>
<?php 
    // Define page variables here. These will affect the page title, heading and sub heading
    $pageTitle = "Login";
    $pageHeading = "Login"; 
    $pageSubHeading = "Please login to view reigstered bikes, register a new bike or report a lost/stolen bike";

    include("../functions/alerts.php"); // This loads a function for creating alerts 
    include("../functions/database.php"); // This load the database the vairable you will neeed is $DBConnection

//PHP to execute Post data on click of Login button.
	 if(isset($_POST['login']))
	 {
		$email_add = $_POST["email_add"];
		$pass = $_POST["pass"];

		 
		$sql = $DBConnection->prepare("SELECT `password`,`role`,`id` FROM `user` WHERE `email_address` = ?"); //start up BikeWatch database and get password, role, id from user table
		$sql->bind_param("s", $email_add);
		$sql->execute(); //where email is an email address, get result and return the first match.
		 
		$result = $sql->get_result();
		$row = $result->fetch_assoc();
		 
		if (password_verify($pass, $row["password"])) //verifies password matches from what is stored on database (password is encrypted)
		{
	        session_start();			//if database role = user who exists on database, get id of that user and log user in for that session.
			if ($row["role"]=="user") { 
				$_SESSION["role"]="user";
				$_SESSION["id"]=$row["id"];
				createAlert('success', 'You have successfully been logged in!', 'https://s4101563-ct4009.uogs.co.uk/user/dashboard/dashboard.php'); 
				//lets user know they have successfully logged into their BikeWatch account.
			}	
			if ($row["role"]=="police") {
				$_SESSION["role"]="police";
				$_SESSION["id"]=$row["id"];
				createAlert('success', 'You have logged in - Welcome!', 'https://s4101563-ct4009.uogs.co.uk/police/dashboard/dashboard.php');
				//lets Police know they have sucesfully logged in and redirects to BikeWatch Police dashboard page.
			}
		}
		
		
	 }

?>
<html>
<head>
    <!-- Head Content -->
    <?php include("../templates/head.php");?>

    <!-- Page Specifc CSS goes here -->
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <?php include("../templates/alerts.php");?>

    <!-- Page Container -->
    <div class="container">

        <!-- Page Naviagtion -->
        <?php include("../templates/navigation.php"); ?>

        <!-- Page Header -->
        <?php include("../templates/header.php");?>

        <!-- Page Content -->
        <main>

            <div class="small-container">
            <!-- Fill me with page specifc content  -->
                <form method="POST">
                    <label for="email_add">E-mail address: </label><br>
                    <input type="email" id="email_add" name="email_add"><br>
                    <label for="pass">Password: </label><br>
                    <input type="password" id="pass" name="pass"><br><br>
                    <input type="submit" value="Login" name="login"><br>
                </form>
			
			    <p id="login_reg">If you have not logged in before, please register <a href="../user/register/register.php">here.</a></p>
            </div>
        </main>

    </div>
   
    <!-- Page Footer -->
    <?php include("../templates/footer.php");?>

</body>
</html>

<!-- 
    The include statements are loading html for the there specifc parts
    You will need to ajust the paths of the include stamennts
    Rember ../ for back one directory! And so back two directories is ../../ and so on.

    You can create alerts from javascript or php using the createAlert() function into that function you need to pass the type, the message and redirect url. Redirect url is optional

    The message type should either be error or success
    The message can be whatever you want
    The redirect url should be url which the alert will redirect to after 10s or when the user presses the close button

    Example usage
    createAlert('error', 'This is my error message!')

-->