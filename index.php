<?php
include("common.php");

top();
#form for log in
?>
<form action="login.php" method="post">
	<div><input name="business" type="text" size="12" autofocus="autofocus" /> <span>Business</span></div>
	<div><input name="password" type="password" size="12" /> <span>Password</span></div>
	<div><input type="submit" value="Log in" /></div>
</form>

<!-- link for the registration form -->
<form action="register.php" method="post">
	<div><input type="submit" value="Register" /></div>	
</form>

<?php
bottom();
?>