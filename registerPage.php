<?php
/*
*	Author:  Dimitar Kermedchiev
*	FN:		 80943
*	Project: Express Conference Organiser
*	Page:	 Register 
*/
include 'basicFunctionality.php';

$email = $first_name = $last_name = $password = $re_password = "";
$emailErr = $firstNameErr = $lastNameErr = $passErr = $passReErr = "";
$specialErr = "Please enter valid email";
$checkValid = FALSE;
$checkFisrtName = $checkLastName = $checkPassword = $checkPasswords = FALSE;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = test_input($_POST["email"]);
  $first_name = test_input($_POST["first_name"]);
  $last_name = test_input($_POST["last_name"]);
  $password = test_input($_POST["password"]);
  $re_password = test_input($_POST["re_password"]);
}

if(!empty($_POST["email"])){	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$emailErr = "Invalid email format!";		
	}
	else{
		$checkValid = TRUE;
	}
}

if($checkValid){
	if(empty($_POST["first_name"]) || strlen($_POST["first_name"]) > 128) {
		$firstNameErr = "Invalid first name!";
	}
	else {
		$checkFisrtName = TRUE;
	}	
	if(empty($_POST["last_name"]) || strlen($_POST["last_name"]) > 128) {
		$lastNameErr = "Invalid last name!";
	}
	else {
		$checkLastName = TRUE;
	}
	if(empty($_POST["password"]) || strlen($_POST["password"]) > 50 || strlen($_POST["password"]) < 4) {
		$passErr = "Invalid password!";
	}
	else {
		$checkPassword = TRUE;
	}
	if (strcmp($password, $re_password) != 0) {
		$passReErr = "Passwords do not match!";
	}
	else {
		$checkPasswords = TRUE;
	}
	$sqlSelect = "SELECT * FROM users WHERE email = '$email' ";
	$query = $conn->query($sqlSelect) or die("Failed!");
		if ($query->rowCount() != 0) {
			$emailErr = "This email is alredy registered!";
			$checkValid = FALSE;
		}
}
// For now, default users are not masters.		
$master = 1;

if ($checkValid && $checkFisrtName && $checkLastName && $checkPassword && $checkPasswords) {
	$stmt = $conn->prepare("
      INSERT INTO users (first_name, last_name, email, password, master)
      VALUES (:first_name, :last_name, :email, :password, :master)" );
	$stmt->bindParam(':first_name', $first_name);
	$stmt->bindParam(':last_name', $last_name);
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT)); // Passrowd is hashed by default algorithm.
	$stmt->bindParam(':master', $master);
	$stmt->execute();
	$url='loginPage.php';
	echo "<script>window.location ='" . $url . "';</script>";
}
		
$conn = null;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Register in Express Conference Organiser</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/basicStyles.css">
	</head>
	<body>
		<div class="register-page">
			<header class="header">Registration</header>
			<div class="form">
				<form class="register-form" id="register" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method="post" accept-charset="UTF-8">
					<input type="text" name="email" id="email" placeholder="E-mail" value="<?php echo $email;?>" required />
					<span class="error" style="color: red;" > <?php echo $emailErr; ?></span></br>

					<input type="text" name="first_name" id="first_name" placeholder="First name" value="<?php echo $first_name; ?>" required />
					<span class="error" style="color: red;" > <?php echo $firstNameErr; ?></span></br>

					<input type="text" name="last_name" id="last_name" placeholder="Last name" value="<?php echo $last_name; ?>" required />
					<span class="error" style="color: red;" > <?php echo $lastNameErr; ?></span></br>

					<input type="password" name="password" id="password" placeholder="Password"/ required >
					<span class="error" style="color: red;" > <?php echo $passErr; ?></span></br>

					<input type="password" name="re_password" id="re_password" placeholder="Repeat password" required >
					<span class="error" style="color: red;" > <?php echo $passReErr; ?></span></br>
					
					<button type="submit" >Sign up</button>
					<p class="message">You have already registered an acccount? <a href="loginPage.php"></br>Sign in!</a></p>
				</form>
			</div>
		</div>
	</body>
</html>

