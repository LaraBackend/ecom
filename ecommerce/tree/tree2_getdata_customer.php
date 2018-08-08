<?php


if(isset($_COOKIE['be3liTimeBr'])) {

$u = $_COOKIE['be3liTimeBr'];

} else {
	
	$u = 0;
}



if (!isset($_POST['id'])) {
	$sel = '';
} else {
	$sel = ' AND customer_id !=  '.$u;
}



$id = isset($_POST['id']) ? intval($_POST['id']) : $u;

include 'conn.php';

$result = array();
 $sql = "select * from oc_customer where parent_id= $id $sel ";
 $rs = $conn->query($sql);
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