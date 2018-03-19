<?php
include("common.php");

$db = getDatabase();
$willCall = $_POST['willCall'] === 'Yes' ? 1: 0;

#format for date time for today
$orderDate = date("Y-m-d");

#format for date time for 5 days from now
$deliveryDate = date('Y-m-d', strtotime($orderDate. ' + 5 days'));
$businessString = "'" . $db->real_escape_string($_SESSION["businessID"]) . "'";
$orderDateString = "'" . $db->real_escape_string($orderDate) . "'";
$deliveryDateString = "'" . $db->real_escape_string($deliveryDate) . "'";
$sql = "INSERT INTO `Order` (`business_id`, `order_date`, `delivery_date`, `will_call`)
		VALUES ($businessString, $orderDateString, $deliveryDateString, $willCall);";
$db->query($sql);

#get the order id for the new order
$orderid = $db->query("SELECT order_id FROM `Order` WHERE order_date = $orderDateString;");
$orderid->data_seek(0);
$oid = $orderid->fetch_row()[0];

#for every item that we ordered in the form, we want to insert it into the Order_has_Item table
# and remove that number of items from the warehouse table
foreach ($_POST as $item => $quantity) {
	if($quantity && $quantity > 0) {
		$sql = "INSERT INTO `Order_has_Item` (`item_id`, `order_id`, `quantity`)
				VALUES ($item, $oid, $quantity);";
		$db->query($sql);
		$db->query("UPDATE `Warehouse`
					SET quantity_on_hand = quantity_on_hand - $quantity
					WHERE `Warehouse`.item_id = $item;");
	}
}
#go back to the main view after we finish submitting the order
redirect("manager.php");

?>