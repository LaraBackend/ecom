<?php
if (!isset($_POST['id'])) {
	$sel = ' AND customer_id = 1 ';
} else {
	$sel = ' AND customer_id != 1 ';
}

 

$id = isset($_POST['id']) ? intval($_POST['id']) : 1;

include 'conn.php';

$result = array();
$rs = $conn->query("select * from oc_customer where parent_id= $id $sel ");
while($row = $rs->fetch_assoc() ){
	
	$node = array();
	$node['num'] = $row['customer_id'];
	$node['id'] = $row['customer_id'];
	$node['text'] = "[".$row['customer_id']."] ".$row['firstname']." ".$row['lastname'];
	$node['state'] = 'closed' ;
	array_push($result,$node);
	
}

echo json_encode($result);

?>