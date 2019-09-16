<?php
/*
*	Author:  Dimitar Kermedchiev
*	FN:		 80943
*	Project: Express Conference Organiser
*	Page:	 Main
*/
include 'basicFunctionality.php';
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Express Conference Organiser</title>
		<link rel="stylesheet" href="css/basicStyles.css">
		<link rel="stylesheet" href="css/footerStyles.css">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Cookie" type="text/css">
	</head>
	<body>
		<header class="main-header">
			<p>Express Conference Organiser</p>
			<p><?php echo "Wellcome, " . $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'] . "! "; ?>Just select the event you want and fill the needed information.</p>
			<form class="logout-button" action="logoutPage.php">
				<input type="submit" value="Logout" />
			</form>
		</header>
<?php
if(!$_SESSION['valid']) {
	header("location:loginPage.php"); 
	die(); 
}
$start_time = $time_taken = $hall = $for_date = $main_description = $end_time = "";
$arrayID = array();
$arrayID_allAttributes = array();
$sql_conferences = "SELECT id, topic, hall, for_date, start_time, time_taken, end_time, max_participants, description FROM conferences";
$query = $conn->query($sql_conferences) or die("Failed!");
echo "<ul class='tab'>"; 
echo "<li><a href='addNewConference.php'</a>+ NEW</li>";
if($query->rowCount() != 0) {
	while($row = $query->fetch(PDO::FETCH_ASSOC)){
		if(!empty($row["id"])){
			$id = $row["id"];
			$arrayID[] = $id;
			$hall = $row["hall"];
			$for_date = $row["for_date"];
			$main_description = $row["description"];
			$start_time = $row["start_time"];
			$time_taken = $row["time_taken"];
			$end_time = $row["end_time"];
			$max_participants = $row["max_participants"];
			$arrayID_allAttributes[$id] = array($start_time, $time_taken, $max_participants, $hall, $for_date, $main_description);
			echo "<li><a href='javascript:void(0)' class='tablinks' onclick='loadTab(event, $id)' >" . $row["topic"] . "</a></li>";						
		}
	}	
}	
echo "</ul>";	

$topic = $team = $description = $links = $conference = $starting_at = "";
foreach($arrayID as $var){
	echo "<div id='$var' class='tabcontent'>";
	echo "<div class='sub-header'>&nbsp;Where: " . $arrayID_allAttributes[$var][3] . "; When: " . $arrayID_allAttributes[$var][4] . "; Description: ". $arrayID_allAttributes[$var][5] . "</div><div class='table'>";
	$count = 1;
	$start_time = $arrayID_allAttributes[$var][0];
	$date = new DateTime($start_time);	
	$time_gap = $arrayID_allAttributes[$var][1];
	echo "<div><div>№</div><div>Start:</div><div>Topic:</div> <div>Team:</div><div>Description:</div><div>Resources:</div><div>Invitation:</div><div></div><div></div><div>Click to save</div></div>";
	while($count <= $arrayID_allAttributes[$var][2]){
		$conference = $var;
		$starting_at = $date->format('h:i:s');
		$sql_shedule = "SELECT id, topic, team, description, links, starting_at FROM schedule WHERE conference = '$var'";
		$query2 = $conn->query($sql_shedule) or die("Failed!");
		if($query2->rowCount() == 0 ) {
			$topic = $team = $description = $links = "";
		}
		else{
			while($row = $query2->fetch(PDO::FETCH_ASSOC)){
				$st_time = strtotime($row["starting_at"]);
				$end_time = strtotime($date->format('h:i:s'));				
				if(strcmp($st_time, $end_time) == 0){
					if($row["topic"] != ""){
						$topic = $row["topic"];
					}
					if($row["team"] != ""){
						$team = $row["team"];
					}
					if($row["description"] != ""){
						$description = $row["description"];
					}
					if($row["links"] != ""){
						$links = $row["links"];
					}
					$starting_at = $row["starting_at"];
				}
			}
		}
		echo "<form class='table-row-form' method='get'><div>" . $count . ".</div><div>" . $date->format('h:i:s') . "</div><div><input name='topic' value='$topic' size='35' style='border: none;' required /></div><div><input name='team' value='$team' size='35' size='35' style='border: none;' required /></div><div><input name='description' value='$description' size='35' style='border: none;' size='35' required /></div><div><input name='links' value='$links' size='35' style='border: none;'/></div><div><input type='file' accept='image/*' name='upload' value='Upload invitation' /></div><div><input type='hidden' name='conference' value='$conference'></div><div><input type='hidden' name='starting_at' value='$starting_at'></div><div><input type='submit' name='submit' value='Save Changes' /></div></form>";
		$date->add(new DateInterval('PT' . $time_gap . 'M'));					
		$count++;
		$topic = $team = $description = $links = "";
	}
	echo "</div></div>";
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$topic = test_input((isset($_GET['topic']) ? $_GET['topic'] : null));
	$team = test_input((isset($_GET['team']) ? $_GET['team'] : null));
	$description = test_input((isset($_GET['description']) ? $_GET['description'] : null));
	$links = test_input((isset($_GET['links']) ? $_GET['links'] : null));
	$conference = test_input((isset($_GET['conference']) ? $_GET['conference'] : null));
	$starting_at = test_input((isset($_GET['starting_at']) ? $_GET['starting_at'] : null));
}

if (!empty($topic) && !empty($team) && !empty($description)) {
	$stmt = $conn->prepare("
		INSERT INTO schedule (topic, team, description, links, conference, starting_at, created_by)
		VALUES (:topic, :team, :description, :links, :conference, :starting_at, :created_by)" );
	$stmt->bindParam(':topic', $topic);
	$stmt->bindParam(':team', $team);
	$stmt->bindParam(':description', $description);
	$stmt->bindParam(':links', $links);
	$stmt->bindParam(':conference', $conference);
	$stmt->bindParam(':starting_at', $starting_at);
	$stmt->bindParam(':created_by', $_SESSION['user_id']);
	$stmt->execute();
	echo "<meta http-equiv=refresh content=\"0; URL=mainPage.php\">";
}
$conn = null;	
?>

<script>
	function loadTab(evt, conference_id) {
	    var i, tabcontent, tablinks;
	    tabcontent = document.getElementsByClassName("tabcontent");
	    for (i = 0; i < tabcontent.length; i++) {
	        tabcontent[i].style.display = "none";
	    }
	    tablinks = document.getElementsByClassName("tablinks");
	    for (i = 0; i < tablinks.length; i++) {
	        tablinks[i].className = tablinks[i].className.replace(" active", "");
	    }
	    document.getElementById(conference_id).style.display = "block";
	    evt.currentTarget.className += " active";
		// Hide picture when tab is opened.
		document.getElementById('magic').style.display = 'none';
	}
</script>	

		<div id="magic">
			<img id="image" alt="Conference Clipart" title="Conference Clipart" src="img/conference-clipart.jpg" />
		</div>
		<footer class="footer-distributed">
			<div class="footer-left">
				<h3>Express Conference<span>Organiser</span></h3>
				<p class="footer-links">
					<a href="#">Home</a>
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