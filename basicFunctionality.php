<?php
/*
*	Author:  Dimitar Kermedchiev
*	FN:		 80943
*	Project: Express Conference Organiser
*/

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// DB init
$user = "root";
$pass = "";
$host = "localhost";
$dbname = "ECOfinalProject";
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
?>