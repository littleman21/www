

<?php
	$order_id = $_POST['order_id'];
	include 'dbconnection.php';
	//echo $order_id;
	if ( $_POST['is_cancelled']){
		$sql_cancel = "update hua_order set is_cancelled = 1 where order_id= $order_id";
		$query_cancel = mysqli_query($conn, $sql_cancel);
		//echo $sql_cancel;
		header("Location: index.php");
		exit;
	}	
	if (isset( $_POST['delivered'])){
		$delivery_time = $_POST['delivery_time'];
		$sql = "update hua_order set delivery_time = '$delivery_time', delivered=1 where order_id= $order_id";
		$query = mysqli_query($conn, $sql);
		//echo $sql;
	}
	//无论任何情况都可以更新remark
	$remark = $_POST['remark'];
	$sql = "update hua_order set remark='$remark' where order_id= $order_id";
	$query = mysqli_query($conn, $sql);
	
	mysqli_close($conn);
	header("Location: index.php");
	
?>