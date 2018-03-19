<?php
include("common.php");

#get the post variables
if(isset($_POST["business"]) && isset($_POST["password"])){
	$business = $_POST["business"];
	$password = $_POST["password"];
} else {
	redirect("index.php");
}

#this code sets up php to run a query on the database
$db = getDatabase();
$business = "'" . $db->real_escape_string($business) . "'";
$password = "'" . $db->real_escape_string($password) . "'";
$sql = "SELECT * FROM `Client` WHERE name = $business AND password = $password;";

#actually run the query
$rows = $db->query($sql);

#if something goes wrong, report and error
if($rows === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	die();
}
$rows->data_seek(0);

#gets each row of the outputted query
if($row = $rows->fetch_row()){
	session_start();
	$_SESSION["business"] = $row[1];
	$_SESSION["businessID"] = $row[0];
	redirect("manager.php");
} else {
	redirect("index.php");
}
?>