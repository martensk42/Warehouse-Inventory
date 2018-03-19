<?php
session_start();
include("common.php");
top();
sidebar();

if(isset($_GET["query"])){
	$query = $_GET["query"];
}
$db = getDatabase();
#the switch statment handles the cases for all the different queries available for this page
#the variable $columns records the column names
#the variable $sql records the query
switch ($query) {
	case 'order':
		#gets the inventory items for use to order more
		$sql = "SELECT i.item_id, i.description, i.manufacturer, i.unit_price, w.quantity_on_hand
				FROM  `Item` i
				JOIN  `Warehouse_has_Item` wi ON wi.Item_item_id = i.item_id
				JOIN  `Warehouse` w ON w.item_id = wi.Warehouse_item_id
				GROUP BY i.item_id;";
		$caption = "Place Order";
		$columns = array("item_id", "description", "manufacturer", "unit_price", "quantity_on_hand", "");
		break;

	case 'inventory':
		#gets all the items in the inventory
		$sql = "SELECT i.item_id, i.description, i.manufacturer, i.unit_price, w.quantity_on_hand
				FROM  `Item` i
				JOIN  `Warehouse_has_Item` wi ON wi.Item_item_id = i.item_id
				JOIN  `Warehouse` w ON w.item_id = wi.Warehouse_item_id
				GROUP BY i.item_id;";
		$caption = "Inventory";
		$columns = array("item_id", "description", "manufacturer", "unit_price", "quantity_on_hand");
		break;
	case 'clients':
		$id = $_SESSION["business_id"];
		#gets all the clients that are in the database
		$sql = "SELECT business_id, name
				FROM  `Client`;";
		$caption = "Clients";
		$columns = array("business_id", "business_name");

		break;
	default:
		if($business === "admin") {
			#gets all the orders for the admin user
			$sql = "SELECT o.order_id, i.item_id, i.description, i.manufacturer, i.unit_price, w.quantity_on_hand
					FROM  `Client` c
					JOIN  `Order` o ON o.business_id = c.business_id
					JOIN  `Order_has_Item` oi ON oi.order_id = o.order_id
					JOIN  `Item` i ON i.item_id = oi.item_id
					JOIN  `Warehouse_has_Item` wi ON wi.Item_item_id = i.item_id
					JOIN  `Warehouse` w ON w.item_id = wi.Warehouse_item_id
					WHERE c.name = $business;";
			$caption = "Previous Orders";
			$columns = array("order_id", "item_id", "description", "manufacturer", "unit_price", "quantity_on_hand");
		} else {
			$business = "'" . $db->real_escape_string($_SESSION["business"]) . "'";
			#gets all the orders for the user
			$sql = "SELECT o.order_id, i.item_id, i.description, i.manufacturer, i.unit_price, oi.quantity
					FROM  `Client` c
					JOIN  `Order` o ON o.business_id = c.business_id
					JOIN  `Order_has_Item` oi ON oi.order_id = o.order_id
					JOIN  `Item` i ON i.item_id = oi.item_id
					WHERE c.name = $business
					ORDER BY o.order_id ASC;";
			$caption = "Previous Orders";
			$columns = array("order_id", "item_id", "description", "manufacturer", "unit_price", "quantity");
		}
		break;
}
?>
<div id="outputarea">
	<?php
	# if the query is an order, we want to be able to submit an order for some items
	if($query === "order") {
		echo "<form action=\"order.php\" method=\"post\">";
	}
	?>
	<table>
		<caption><?=$caption?></caption>
		<tr>
		<?php
		#prints out column headers in the table
		$numCols = count($columns);
		for($i = 0; $i < $numCols; $i++){
			?>
			<th><?=$columns[$i]?></th>
			<?php
		}
		#if we are ordering, we want to have a column for the order of all items
		if($query === "order") {
			echo "<th>quantity to order</th>";
		}
		$rows = $db->query($sql);
		if($rows === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
			die();
		}
		$rows->data_seek(0);
		for($i = 0; $i < $rows->num_rows; $i++){
			$row = $rows->fetch_row();
			?>
			<tr>
				<?php
				#for every row and col we want to output the value
				for($j = 0; $j < $numCols; $j++){
					?>
					<td><?=$row[$j]?></td>
					<?php
				}
				#if we are ordering, we want a box to fill in the values of our order
				if($query === "order") {
					$itemID = $row[0];
					echo "<td><input name=\"$itemID\" type=\"text\" size=\"8\" /></td>";
				}
				?>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
	#if we are ordering, we want to be able to submit the order
	if($query === "order") {
		$itemID = $row[0];
		echo "<div>Will Call?<input name=\"$willCall\" type=\"checkbox\" /></div>";
		echo "<div><input type=\"submit\" value=\"Submit Order\" /></div>";
		echo "</form>";
	}
	?>
</div>

<?php
bottom();
?>