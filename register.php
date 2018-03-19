<?php
include("common.php");
top();
#sets up the form for registration
?>
<form action="registerBus.php" method="post">
	<div><input name="business" type="text" size="12" autofocus="autofocus" /> <span>Business</span></div>
	<div><input name="password" type="password" size="12" /> <span>Password</span></div></div>
	<div><input name="phone_num" type="text" size="15" /> <span>Phone Number</span></div></div>
	<div><input name="address" type="text" size="20" /> <span>Address</span></div></div>
	<div><input name="city" type="text" size="12" /> <span>City</span></div></div>
	<div><input name="state" type="text" size="2" /> <span>State/Province</span></div></div>
	<div><input name="country" type="text" size="12" /> <span>Country</span></div></div>
	<div><input name="postal_code" type="text" size="12" /> <span>Postal Code</span></div></div>
	<div><input type="submit" value="Register" /></div>
</form>
<?php
bottom();
?>