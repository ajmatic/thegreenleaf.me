<?php

//get variables
$email = $_POST["email"];
$password = $_POST["password"];
$confirm = $_POST["confirm"];

//bypass email validation for now

//make sure passwords match
if ($password !== $confirm) {
	die("Your passwords do not match. Go back and try again!");
}

include("./cms/db_connect.php");

$date = new DateTime;

//hash password
$options = [
    'cost' => 12,
];
$password = password_hash($password, PASSWORD_BCRYPT, $options);

$sql = "INSERT INTO `users` (email, password, timestamp) VALUES ('$email', '$password', " . $date->getTimestamp() . ")";

$results = mysql_query($sql);
if ($results) {
	header("Location: login.php");
}


