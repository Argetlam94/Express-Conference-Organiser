<?php 
/*
*	Author:  Dimitar Kermedchiev
*	FN:		 80943
*	Project: Express Conference Organiser
*/
session_start();
session_destroy();
header('Location: loginPage.php');
exit;
?>