<?php
#redirects the user to the given destination and makes the page die
function redirect($destination){
	header("Location: " . $destination);
	die();
}

#returns the database connection
function getDatabase(){
	$db = new mysqli('vergil.u.washington.edu', 'root', 'UWish**7', 'martens_kyle_db', 4450);
	
	if($db->connect_errno > 0) {
		die('Unable to connect to database [' . $db->connect_error . ']');
	}
	return $db;
}

#outputs the begining of all the websites for the Inventory Manager
function top(){
	if(isset($_SESSION["business"])){
		$business = ", " . $_SESSION["business"] . ",";
	} else {
		$business = "";
	}
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<title>Inventory Manager</title>
			<link href="manager.css" type="text/css" rel="stylesheet" />
		</head>
		<body>
			<div id="content">
				<div id="banner">
					<h1>Welcome<?=$business?> to the Inventory Manager</h1>
					<?php
					# if the business exists, they are logged in, and may want to log out
					if($business !== ""){
						echo "<form id=\"logout\" action=\"logout.php\" method=\"post\"><input type=\"submit\" value=\"Logout\"></input></form>";
					}
					?>
				</div>
	<?php
}

#the sidebar contains the controls for the various queries.
function sidebar(){
	if(isset($_SESSION["business"])){
		$business = ", " . $_SESSION["business"] . ",";
	} else {
		$business = "";
	}
	?>
	<div id="controls">
		<form id="loginform" action="manager.php" method="get">
			<select name="query">
				<option value="inventory">Check What's In Stock</option>
				<?php
				if($business === ", admin,"){
					echo "<option value=\"clients\">View All Clients</option>";
				} else {
					echo "<option value=\"order\">Place An Order</option>";
					echo "<option value=\"history\">Purchase History</option>";
				}
				?>
			</select>
			<div><input type="submit" value="Go" /></div>
		</form>
	</div>
	<?php
}

#outputs the end of all the websites for the Inventory Manager
function bottom() {
	?>
			</div> <!-- ends the content div -->
		</body>
	</html>
	<?php
}
?>