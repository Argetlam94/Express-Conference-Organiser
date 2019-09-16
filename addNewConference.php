<?php
/*
*	Author:  Dimitar Kermedchiev
*	FN:		 80943
*	Project: Express Conference Organiser
*	Page:	 New Conference Creator
*/
include 'basicFunctionality.php';
session_start();
?>
<!DOCTYPE HTML>  
<html>
	<head>
		<title>Create new conference event</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/basicStyles.css">
		<link rel="stylesheet" href="css/footerStyles.css">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Cookie" type="text/css">
	</head>
	<body>  
<?php
if(!$_SESSION['valid']) {
  header("location:loginPage.php"); 
  die(); 
}

$topic = $hall = $forDate = $startTime = $endTime = $maxParticipants = $timeTaken = $description = $programme = '';
$user = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $topic = test_input($_POST["topic"]);
  $hall = test_input($_POST["hall"]);
  $forDate = test_input($_POST["for_date"]);
  $startTime = test_input($_POST["start_time"]);
  $endTime = test_input($_POST["end_time"]);
  $maxParticipants = test_input($_POST["max_participants"]);
  $timeTaken = test_input($_POST["time_taken"]);
  $programme = test_input($_POST["programme"]);
  $description = test_input($_POST["description"]);
}

if ($topic != "") {
	$stmt = $conn->prepare("
      INSERT INTO conferences (topic, for_date, hall, created_by, start_time, end_time, max_participants, time_taken, description)
      VALUES (:topic, :for_date, :hall, :created_by, :start_time, :end_time, :max_participants, :time_taken, :description)" );
	$stmt->bindParam(':topic', $topic);
	$stmt->bindParam(':for_date', $forDate);
	$stmt->bindParam(':hall', $hall);
	$stmt->bindParam(':created_by', $user);
	$stmt->bindParam(':start_time', $startTime);
	$stmt->bindParam(':end_time', $endTime);
	$stmt->bindParam(':max_participants', $maxParticipants);
	$stmt->bindParam(':time_taken', $timeTaken);
	$stmt->bindParam(':description', $description);
	$stmt->execute();
	$url='mainPage.php';
	echo '<script>window.location = "'.$url.'";</script>';
}
$conn = null;
?>
<script>
function goBack() {
    window.history.back()
}
</script>

		<header class="main-header"><p>Express Conference Organiser</p><p><?php echo $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'] . ", here you can fill the needed information to create new conferance event."; ?></p>
			<form class="logout-button" action="logoutPage.php">
			<input type="submit" value="Logout" />
			</form>
		</header>

		<form id="addNewconference" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" accept-charset="UTF-8" >
			<fieldset style="width:98%" >
				<legend>Create new conference event:</legend>
				<h3>Please, provide as much information for your event as possible!</h3>

				<label for="topic" >Topic of the event: </label></br>
				<input type="text" name="topic" id="topic" value="<?php echo $topic; ?>" size="45" maxlength="255" required/></br>				
				
				<label for="for_date" >Date of event(YYYY-MM-DD): </label></br>
				<input type="text" name="for_date" id="for_date" value="<?php echo $forDate; ?>" size="45" maxlength="20" required/></br>
				
				<label for="hall" >Hall: </label></br>
				<input type="text" name="hall" id="hall" value="<?php echo $hall; ?>" size="45" maxlength="128" required /></br>
				
				<label for="start_time" >Starting hour:(HH:MM:SS) </label></br>
				<input type="text" name="start_time" id="start_time" value="<?php echo $startTime; ?>" size="45" maxlength="10" required/></br>
				
				<label for="end_time" >Closing hour:(optional) </label></br>
				<input type="text" name="end_time" id="end_time" value="<?php echo $endTime; ?>" size="45" maxlength="10" /></br>
				
				<label for="max_participants" >Maximum participants count: </label></br>
				<input type="number" name="max_participants" id="max_participants" value="<?php echo $maxParticipants; ?>" min="1" style="width: 10em;" required/></br>
				
				<label for="time_taken" >Time limit per performance:(in minutes)</label></br>
				<input type="number" name="time_taken" id="time_taken" value="<?php echo $timeTaken; ?>" min="1" style="width: 10em;"  required /></br>
				
				<label for="description" >Description of the event: </label></br>
				<input type="text" name="description" id="description" value="<?php echo $description; ?>" size="45" maxlength="2048" required/></br>
				
				<label for="programme" >Programme of the event:(optional) </label></br>
				<input type="text" name="programme" id="programme" value="<?php echo $programme; ?>" size="45" maxlength="150" /></br></br>			
				
				<input type="reset" name="Reset" value="Reset Data" />
				<input type="submit" name="Submit" value="Create Event" /></br>
				<button onclick="goBack()" style="margin:auto;display:block;">Go Back to Main Page</button>
			</fieldset>
		</form>

		<footer class="footer-distributed">
			<div class="footer-left">
				<h3>Express Conference<span>Organiser</span></h3>
				<p class="footer-links">
					<a href="mainPage.php">Home</a>
					<a href="#">About</a>
				</p>
				<p class="footer-company-name">Express Conference Organiser &copy; 2018</p>
			</div>
			<div class="footer-center">
				<div>
					<i class="fa fa-map-marker"></i>
					<p><span>5 James Bourchier blvd.</span> Sofia, Bulgaria</p>
				</div>
				<div>
					<i class="fa fa-phone"></i>
					<p>+359 8867 09214</p>
				</div>
				<div>
					<i class="fa fa-envelope"></i>
					<p><a href="mailto:support@exconforg.com">support@exconforg.com</a></p>
				</div>
			</div>
			<div class="footer-right">
				<p class="footer-company-about">
					<span>About the company</span>Express Conference Organiser &copy; represents a platform which makes organizing a conference pretty simple task. Created by Dimitar Kermedchiev, F.N. 80943 for the course Web technologies 2017/2018.
				</p>
				<div class="footer-icons">
					<a href="#"><i class="fa fa-facebook"></i></a>
					<a href="#"><i class="fa fa-twitter"></i></a>
					<a href="#"><i class="fa fa-linkedin"></i></a>
					<a href="#"><i class="fa fa-github"></i></a>
				</div>
			</div>
		</footer>
	</body>
</html>