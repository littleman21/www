
<?php
	$order_flower = array();
		
	for ($i=0 ; $i<$_POST['total_flower_type'] ; $i++){
		if (isset($_POST["flower_$i"])){
			//如果数值为0或空，忽略掉
			if (!$_POST["flower_amount_$i"] || !is_numeric($_POST["flower_amount_$i"]) ) continue;
			$order_flower[$i]['flower_type'] = $_POST["flower_$i"];
			$order_flower[$i]['flower_amount'] = $_POST["flower_amount_$i"];
		}
	}

/* 	foreach($_POST['flower'] as $select_order => $flower_type) {
		$order_flower[$i]['flower_type'] = $flower_type;
		$order_flower[$i]['flower_amount'] = $_POST['flower_amount'][$select_order];
		$i++;
	} */
/* 	foreach( $_POST['flower'] as $flower_type){
		$order_flower[$i]['flower_type'] = $flower_type;
		//echo $i.'<br>';
		$i++;
	}
	$i=0;
	foreach( $_POST['flower_amount'] as $flower_amount){
		$order_flower[$i]['flower_amount'] = $flower_amount;
		$i++;
	} */
	//print_r($order_flower);
	
/* 	include "dbconnection.php";
	$sql = 'select count(using_this) from hua_flower_type where using_this =1';
	$query = mysqli_query($conn, $sql);
	if ($rs = $mysqli_fetch_array($query)){
		$total_flower_type = $rs[0];
	}else  */
	//echo $_POST['send_to_store_id'];
	
	if (!count($order_flower)){
		echo 'No Valid Data<br/><br/>';
		echo '<a href="javascript:history.go(-1)">Go Back</a>';
		exit;
	}
	
	include "dbconnection.php";
	$remark = $_POST['remark'];
	$store_id = $_POST['send_to_store_id'];
	$sql_order_create = "insert hua_order set remark='$remark', order_destination = $store_id";
	$query_order_create = mysqli_query($conn, $sql_order_create);
	$order_id = mysqli_insert_id($conn);
	$result = 1;
	if (!$query_order_create) $result = 0;
	
	foreach ($order_flower as $flower_detail ){
		$flower_type = $flower_detail['flower_type'];
		$flower_amount = $flower_detail['flower_amount'];
		$sql_order_detail_create = "insert hua_order_detail set order_id = $order_id, flower_type_id = $flower_type, flower_amount = $flower_amount";
		$query_order_detail_create = mysqli_query($conn, $sql_order_detail_create);	
		if (!$query_order_detail_create) $result = 0;
	}
	
	if ( $result == 0 )  {
		echo '<br/><br/><font color="red">Create Fail, Please Contact IT</font>';
		$sql = "delete from hua_order where order_id = $order_id";
		$sql_2 = "delete from hua_order_detail where order_id = $order_id";
		$query = mysqli_query($conn, $sql);
		$query_2 = mysqli_query($conn, $sql_2);
	}else{
		echo '<br/><br/>Create Sucess';
	}
	echo '<br/><br/><a href="index.php">Back to Index</a>';
	
	mysqli_close($conn);

?>