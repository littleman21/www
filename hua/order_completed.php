<body>
<style>
a:hover,a:visited{color:blue;}  
</style> 
<?php
	echo '<table width="800">';
	echo '<th><a href="index.php">Home Page</a></th>';
	echo '<th><a href="order_new.php">Create new Order</a></th>';
	echo '<th><a href="order_completed.php">Orders Completed</a></th>';
	echo '<th><a href="manage.php">Manage</a></th>';
	echo '<th><a href="statistics.php">Statistics</a></th>';
	echo '</table>';
	echo '</table><br/><br/>';
	include 'dbconnection.php';
	
	$sql_store = 'select store_id, store_name from hua_store order by store_name';
	$query_store = mysqli_query($conn, $sql_store);
	$store_array = array();	
	while ($row_store = mysqli_fetch_array($query_store) ){
		$store_array[$row_store['store_id']] = $row_store['store_name'];
	}
	//print_r($store_array);
	$sql_flower_type = 'select flower_type_id, flower_name from hua_flower_type where using_this =1';
	$query_flower_type = mysqli_query($conn, $sql_flower_type);
	$flower_type_array = array();
	while ($flower_type = mysqli_fetch_array($query_flower_type) ){
		$flower_type_array[$flower_type['flower_type_id']] = $flower_type['flower_name'];
	}
	
	$sql = "select *,TIMESTAMPDIFF(hour, delivery_time, retrieve_time) as hours from hua_order where order_retrieved = 1 order by retrieve_time desc";
	$query = mysqli_query($conn, $sql);
	if (mysqli_num_rows($query)){
		$th_array = array('Order ID', 'Store','Delivery Time','Retrieve Time','Hours','Flower');
		echo '<table border=1>';
		foreach ($th_array as $table_head){
			echo '<th>'.$table_head.'</th>';
		}
		while ($row = mysqli_fetch_array($query)) {
			$time = strtotime($row['delivery_time']);
			$time_re = strtotime($row['retrieve_time']);
			//$hours = floor($time_re-$time)%86400/3600;
			echo '<tr>';
			echo '<td align=center>CCH-'.$row['order_id'].'</td>';
			echo '<td align=center>'.$store_array[$row['order_destination']].'</td>';
			echo '<td align=center>&nbsp;'.date('m-d D H:i', $time).'&nbsp;</td>';
			echo '<td align=center>&nbsp;'.date('m-d D H:i', $time_re).'&nbsp;</td>';
			echo '<td align=center>&nbsp;'.$row['hours'].'&nbsp;</td>';
			
			//get flowers in the order detail, put in an array
			$sql_flower = 'select * from hua_order_detail where order_id = '.$row['order_id'];
			$query_flower = mysqli_query($conn, $sql_flower);
			$order_flower = array();
			while ($row_flower = mysqli_fetch_array($query_flower)){
				$order_flower[$row_flower['flower_type_id']] = $row_flower['flower_amount'];
			}
			
			// get flowers in the retrieve table, put in an array 
			$sql_flower_re = 'select * from hua_retrieve_detail where order_id = '.$row['order_id'];
			$query_flower_re = mysqli_query($conn, $sql_flower_re);
			$order_flower_re = array();
			while ($row_flower_re = mysqli_fetch_array($query_flower_re)){
				$order_flower_re[$row_flower_re['flower_type_id']] = $row_flower_re['retrieve_amount'];				
			}
			
			echo '<td>';
			echo '<table width ="400">';
			foreach ($order_flower as $flower_type_id => $flower_amount){
				$flower_name = $flower_type_array[$flower_type_id];
				$retrieve_amount = $order_flower_re[$flower_type_id];
				$used_amount = $flower_amount - $retrieve_amount;
				echo '<tr>';
				echo '<td>'.$flower_name.'</td>';
				echo '<td>Sent:'.$flower_amount.'</td>';
				echo '<td>Back:'.$retrieve_amount.'</td>';
				echo '<td>Used:'.$used_amount.'</td>';
				echo '</tr>';
			}
			echo '</table>';			
			echo '</td>';
			if (!$row['remark'] =='') echo '<td>'.$row['remark'].'</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	
	mysqli_close($conn);
?>