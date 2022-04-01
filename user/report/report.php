<!DOCTYPE html>
<?php 
    // Define page variables here. These will affect the page title, heading and sub heading
    $pageTitle = "Reporting";
    $pageHeading = "Your bike report summary"; 
    $pageSubHeading = "Please check all details are correct and give any further useful information, <br>in the comments box.";

    include("../../functions/alerts.php"); // This loads a function for creating alerts 
    include("../../functions/database.php"); // This load the database the variable you will neeed is $DBConnection
	
 	$sql = "SELECT id FROM bike";
	$sql .= "SELECT image FROM bike_image";
	
	session_start();
	$userid = $_SESSION['id'];

	if(isset($_GET['bikeID']))
	{
		$bikeid = $_GET['bikeID'];
		$sql = $DBConnection->prepare("SELECT `bike`.`nickname`, `bike`.`model`, `bike`.`brand`, `bike_image`.`image` FROM `bike` INNER JOIN `bike_image` ON `bike_image`.`bike` = `bike`.`id` WHERE `bike`.`id`=? GROUP BY `bike`.`id`;");
		$sql->bind_param('i', $bikeid);
		$sql->execute();
		$result = $sql->get_result();
		$row = $result->fetch_assoc();

	}  
		
?>
<html>
<head>
    <!-- Head Content -->
    <?php include("../../templates/head.php");?>

    <!-- Page Specifc CSS goes here -->
    <!--<link rel="stylesheet" href="styles.css">-->
</head>
<body>

    <!-- Page Container -->
    <div class="container">

        <!-- Page Naviagtion -->
        <?php include("../../templates/navigation.php"); ?>

        <!-- Page Header -->
        <?php include("../../templates/header.php");?>

        <!-- Page Content -->
        <main>
			<div class="small-container">
				<div class="summary">
					<table>
						<th colspan="2">Bike Summary</th>
						<tr>
							<td><img src=<?php echo "../../uploads/" . $row['image']; ?> height=100px></td>
							<td><?php echo $row['nickname'] . ' ' . $row['brand'] . ' ' . $row['model']; ?></td>
						</tr>
					</table>
				</div><br>
				<br>
				
				<form method="POST">
				
					
					<label for="seen">Date last seen:</label>
  					<input type="date" id="seen" name="seen">
					<label for="comment">Any additional information:</label>
					<input type="text" id="comment" name="comment">
					<input type="submit" value="Submit" name="submit">
			
			
  				
				</form>
  			
			</div>
        </main>

    </div>
   
    <!-- Page Footer -->
    <?php include("../../templates/footer.php");?>

</body>
</html>