<?php
/*
*	Author:  Dimitar Kermedchiev
*	FN:		 80943
*	Project: Express Conference Organiser
*	Page:	 Login 
*/
include 'basicFunctionality.php';
ob_start();
session_start();
$email = $password = $msg = "";

if (isset($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password'])) {
	$email = test_input($_POST['email']);
	$password = test_input($_POST['password']);
	$sqlSelect = "SELECT id, first_name, last_name, password FROM users WHERE email = '$email'";
	$query = $conn->query($sqlSelect) or die("Failed!");
	if($query->rowCount() == 0) {
		$msg = 'Wrong email or password!';
	}
	else {
		while($row = $query->fetch(PDO::FETCH_ASSOC)){
			if (password_verify($password, $row["password"])) {
				$_SESSION['valid'] = true;
				$_SESSION['timeout'] = time();
				$_SESSION['user_email'] = $email;
				$_SESSION['user_id'] = $row["id"];
				$_SESSION['user_first_name'] = $row["first_name"];
				$_SESSION['user_last_name'] = $row["last_name"];					
				$url='mainPage.php';
				echo '<script>window.location = "'.$url.'";</script>';
			}
			else {
				$msg = 'Password for this email is wrong!';  
			}
		}
	}
}
$conn = null;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Log in to Express Conference Organiser</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/basicStyles.css">
	</head>
	<body>
		<div class="register-page">
			<header class="header">Log in to ECO system</header>
			<div class="form">
				<form class="register-form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
					<input type="text" name="email" id="email" placeholder="E-mail" value="<?php echo $email;?>" required/>
					<span class="err-message"><?php echo $msg; ?></span></br>
					<input type="password" name="password" id="password" placeholder="Password" required/>
					<button type="submit"  name = "login">Login</button>
					<p class="message">Don't have registration? <a href="registerPage.php">Create new account!</a></p>
				</form>
			</div>
		</div>
	</body>
</html>
