<?php
	$order_id = $_POST['order_id'];
	include 'dbconnection.php';
	$sql_flower = 'select * from hua_order_detail where order_id ='.$order_id;
	$query_flower = mysqli_query($conn, $sql_flower);
	$retrieve_array = array();
	while ($row = mysqli_fetch_array($query_flower)){
		$flower_type_id = $row['flower_type_id'];
		if ($_POST['flower_'.$flower_type_id]==''){
			$amount = 0;
		}else{
			$amount = $_POST['flower_'.$flower_type_id];
		}
		$retrieve_array[$flower_type_id] = $amount;
	}
		
	foreach ($retrieve_array as $type_id => $amount){
		$sql = "insert hua_retrieve_detail set order_id = $order_id, flower_type_id = $type_id, retrieve_amount = $amount ";
		echo $sql;
		$query = mysqli_query($conn, $sql);
	}
	
	$retrieve_time = $_POST['retrieve_time'];
	$remark = $_POST['remark'];
	$sql = "update hua_order set order_retrieved=1, retrieve_time= '$retrieve_time', remark = '$remark' where order_id = $order_id";
	$query = mysqli_query($conn, $sql);
	
	mysqli_close($conn);
	header("Location: index.php");
?>