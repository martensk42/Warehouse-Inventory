<?php
$db = new mysqli('vergil.u.washington.edu', 'root', 'UWish**7', 'mysql', 4450);

if($db->connect_errno > 0) {
	die('Unable to connect to database [' . $db->connect_error . ']');
}

$sql = 'SELECT host, user FROM user;';
$rows = $db->query($sql);
 
if($rows === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
	die();
}
$rows->data_seek(0);
while($row = $rows->fetch_row()){
    echo $row[0] . '<br>';
}

?>
<!--
========= INSERT ==========
$v1="'" . $conn->real_escape_string('col1_value') . "'";
 
$sql="INSERT INTO tbl (col1_varchar, col2_number) VALUES ($v1,10)";
 
if($conn->query($sql) === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $last_inserted_id = $conn->insert_id;
  $affected_rows = $conn->affected_rows;
}

========= SELECT ==========
$sql='SELECT col1, col2, col3 FROM table1 WHERE condition';
 
$rs=$conn->query($sql);
 
if($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $rows_returned = $rs->num_rows;
}

========== PUT INTO ARRAY ========
$rs=$conn->query($sql);
 
if($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $arr = $rs->fetch_all(MYSQLI_ASSOC);
}
foreach($arr as $row) {
  echo $row['co1'];
}
-->