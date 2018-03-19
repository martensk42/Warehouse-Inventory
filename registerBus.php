<?php
include("common.php");

#get all the posted values for registration to put into the database
if(isset($_POST["business"])
	&& isset($_POST["password"])
	&& isset($_POST["phone_num"])
	&& isset($_POST["address"])
	&& isset($_POST["city"])
	&& isset($_POST["state"])
	&& isset($_POST["country"])
	&& isset($_POST["postal_code"])){
	$business = $_POST["business"];
	$password = $_POST["password"];
	$phone_num = $_POST["phone_num"];
	$address = $_POST["address"];
	$city = $_POST["city"];
	$state = $_POST["state"];
	$country = $_POST["country"];
	$postal_code = $_POST["postal_code"];
} else {
	#there was an error with the input
	redirect("register.php");
}

$db = getDatabase();

#real_escape_string is a method that prevents sql insersion by surounding escape characters
$businessString = "'" . $db->real_escape_string($business) . "'";
$password = "'" . $db->real_escape_string($password) . "'";
$phone_num = "'" . $db->real_escape_string($phone_num) . "'";
$address = "'" . $db->real_escape_string($address) . "'";
$city = "'" . $db->real_escape_string($city) . "'";
$state = "'" . $db->real_escape_string($state) . "'";
$country = "'" . $db->real_escape_string($country) . "'";
$postal_code = "'" . $db->real_escape_string($postal_code) . "'";
$sql = "INSERT INTO `Client` (`name`, `password`, `phone_num`, `address`, `city`, `state`, `country`, `postal_code`)
		VALUES ($businessString, $password, $phone_num, $address, $city, $state, $country, $postal_code);";
$rows = $db->query($sql);
if($rows === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	die();
}

#a query to get the business id
$row = $db->query("SELECT businessID FROM `Client` WHERE name = $businessString");
$row->data_seek(0);
#starts a session to store the business's name and id
session_start();
$_SESSION["business"] = $business;
$_SESSION["businessID"] = $row[0];
redirect("manager.php");

?>