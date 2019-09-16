<?php
$user = "root";
$pass = "";
$host = "localhost";
$dbname = "ECOfinalProject";
$sql = "";
try {
	$conn = new PDO("mysql:host=$host;dbname=phpmyadmin", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE " . $dbname;
    $conn->exec($sql);	
    echo "Database created successfully<br>";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `first_name` varchar(128) COLLATE utf8mb4_bin DEFAULT NULL,
 `last_name` varchar(128) COLLATE utf8mb4_bin DEFAULT NULL,
 `email` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
 `password` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
 `date_registered` datetime DEFAULT CURRENT_TIMESTAMP,
 `master` tinyint(1) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin";
   $conn->exec($sql);	
   echo "Table created successfully<br>";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE `conferences` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `topic` varchar(256) COLLATE utf8mb4_bin DEFAULT NULL,
 `for_date` datetime DEFAULT NULL,
 `hall` varchar(128) COLLATE utf8mb4_bin NOT NULL,
 `created_by` int(11) DEFAULT NULL,
 `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
 `start_time` time NOT NULL DEFAULT '09:00:00',
 `end_time` time DEFAULT NULL,
 `max_participants` int(11) DEFAULT NULL,
 `time_taken` int(11) DEFAULT NULL,
 `description` varchar(2048) COLLATE utf8mb4_bin DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `Foreign` (`created_by`),
 CONSTRAINT `conferences_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin";
   $conn->exec($sql);	
   echo "Table created successfully<br>";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE `schedule` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `conference` int(11) NOT NULL,
 `starting_at` time NOT NULL,
 `topic` varchar(256) COLLATE utf8mb4_bin DEFAULT NULL,
 `created_by` int(11) DEFAULT NULL,
 `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
 `team` varchar(1024) COLLATE utf8mb4_bin DEFAULT NULL,
 `description` varchar(2048) COLLATE utf8mb4_bin DEFAULT NULL,
 `links` varchar(2048) COLLATE utf8mb4_bin DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `Foreign` (`conference`,`created_by`),
 KEY `created_by` (`created_by`),
 CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`conference`) REFERENCES `conferences` (`id`),
 CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin";
   $conn->exec($sql);	
   echo "Table created successfully<br>";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`, `master`) VALUES ('Dimitar', 'Kermedchiev', 'dimitarkermedchiev@gmail.com', '$2y$10$7uthF1CFDNQ7Hqrm/bBmhOdwATL9BC2RQHn8z82CtjAlB3ZW6iP3y', '1')";
	$conn->exec($sql);	
	echo "New record created successfully<br>";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`, `master`) VALUES ('Milen', 'Petrov', 'milenp@fmi.uni-sofia.bg', '$2y$10$7uthF1CFDNQ7Hqrm/bBmhOdwATL9BC2RQHn8z82CtjAlB3ZW6iP3y', '1')";
	$conn->exec($sql);	
	echo "New record created successfully<br>";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`, `master`) VALUES ('Admin', 'Admin', 'support@exconforg.com', '$2y$10$7uthF1CFDNQ7Hqrm/bBmhOdwATL9BC2RQHn8z82CtjAlB3ZW6iP3y', '1')";
	$conn->exec($sql);	
	echo "New record created successfully<br>";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO `conferences`(`topic`, `for_date`, `hall`, `created_by`, `start_time`, `end_time`, `max_participants`, `time_taken`, `description`) VALUES ('Interactive Project Review - Group 1', '2018-02-14 09:00:00', 'Musala 325', '1', '09:00:00', '18:00:00', '25', '15', 'Interactive Project Review - Group 1')";
	$conn->exec($sql);	
	echo "New record created successfully<br>";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO `conferences`(`topic`, `for_date`, `hall`, `created_by`, `start_time`, `end_time`, `max_participants`, `time_taken`, `description`) VALUES ('Interactive Project Review - Group 2', '2018-02-15 10:00:00', '326', '1', '10:00:00', '18:00:00', '30', '20', 'Interactive Project Review - Group 2')";
	$conn->exec($sql);	
	echo "New record created successfully<br>";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO `schedule`(`conference`, `starting_at`, `topic`, `created_by`, `team`, `description`, `links`) VALUES ('1', '10:00:00', 'Presentation on something 1', '1', 'Dimitar Kermedchiev', 'Presentation', 'link to sth 1')";
	$conn->exec($sql);	
	echo "New record created successfully<br>";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO `schedule`(`conference`, `starting_at`, `topic`, `created_by`, `team`, `description`, `links`) VALUES ('1', '11:00:00', 'Presentation on something 2', '2', 'Someone', 'Presentation', 'link to sth 2')";
	$conn->exec($sql);	
	echo "New record created successfully<br>";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO `schedule`(`conference`, `starting_at`, `topic`, `created_by`, `team`, `description`, `links`) VALUES ('2', '10:00:00', 'Presentation on something 3', '1', 'Random 1', 'Presentation', 'link to sth 3')";
	$conn->exec($sql);	
	echo "New record created successfully<br>";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO `schedule`(`conference`, `starting_at`, `topic`, `created_by`, `team`, `description`, `links`) VALUES ('2', '11:00:00', 'Presentation on something 4', '2', 'Random 2', 'Presentation', 'link to sth 4')";
	$conn->exec($sql);	
	echo "New record created successfully<br>";
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
?> 