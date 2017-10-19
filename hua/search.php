<?php
	$store_id = $_POST['store'];
	$flower_type_id = $_POST['flower_type_id'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	if($store_id) $sql_store="order_destination = $store_id"; else $sql_store='';
	
	if (!$start_time ){
		if (!$end_time) $sql_time=''; else $sql_time = "created_time <='$end_time' or ( delivered=1 and delivery_time <='$end_time' ) or ( order_retrieved=1 and retrieve_time<='$end_time')";
	}else{
		if (!$end_time)
			$sql_time = "created_time >='$start_time' or( delivered=1 and delivery_time >='$start_time' ) or ( order_retrieved=1 and retrieve_time>='$start_time')"; 
		else
			$sql_time = "created_time between  '$start_time' and '$end_time'  or ( delivered=1 and delivery_time between '$start_time' and '$end_time' ) or ( order_retrieved=1 and retrieve_time between'$start_time' and '$end_time' )";
	}
	
	if ($sql_store && $sql_time ) $sql_and = 'and' ; else $sql_and = '' ;
	if ($sql_store || $sql_time ) $sql_where = 'where'; else $sql_where = '';
	$sql = "select * from hua_order $sql_where $sql_store $sql_and $sql_time";
	echo $sql;
	
?>