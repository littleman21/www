<body>
<style>
a:hover,a:visited{color:blue;}  
</style> 
<?php
	echo '<table width="700">';
	echo '<th><a href="index.php">Home Page</a></th>';
	echo '<th><a href="order_new.php">Create new Order</a></th>';
	echo '<th><a href="order_completed.php">Orders Completed</a></th>';
	echo '<th><a href="manage.php">Manage</a></th>';
	echo '<th><a href="statistics.php">Statistics</a></th>';
	echo '</table>';
?>

<br/><h3>● Orders Need to Deliver:</h3>
<?php
	include 'dbconnection.php';
	
	$sql_store = 'select store_id, store_name from hua_store order by store_name';
	$query_store = mysqli_query($conn, $sql_store);
	$store_array = array();
	
	while ($row_store = mysqli_fetch_array($query_store) ){
		$store_array[$row_store['store_id']] = $row_store['store_name'];
	}
	//print_r($store_array);
	
	$sql = "select * from hua_order where is_cancelled=0 and delivered=0";
	$query = mysqli_query($conn, $sql);
	if (mysqli_num_rows($query)){
		$th_array = array('Order ID', 'Destination','Created Time');
		echo '<table border=1>';
		foreach ($th_array as $table_head){
			echo '<th>'.$table_head.'</th>';
		}
		$total_flower = array();
		while ($row = mysqli_fetch_array($query)) {
			$time = strtotime($row['created_time']);
			echo '<tr>';
			echo '<td align=center>CCH-'.$row['order_id'].'</td>';
			echo '<td align=center>'.$store_array[$row['order_destination']].'</td>';
			echo '<td align=center>&nbsp;'.date('m-d D H:i', $time).'&nbsp;</td>';
			echo '<td align=center>&nbsp;<a href="Delivery_handle.php?id='.$row['order_id'].'">Report</a>&nbsp;</td>';
			if (!$row['remark'] =='') echo '<td>'.$row['remark'].'</td>';
			echo '</tr>';
			
			$sql_flower = 'select * from hua_order_detail where order_id = '.$row['order_id'];
			//echo $sql_flower;
			$query_flower = mysqli_query($conn, $sql_flower);
			
			while ($row_flower = mysqli_fetch_array($query_flower)){
				if( !isset ($total_flower[$row_flower['flower_type_id']])){
					$total_flower[$row_flower['flower_type_id']] = 0;
				}
				$total_flower[$row_flower['flower_type_id']] += $row_flower['flower_amount'];
			}
		}
		echo '</table>';
	}
	//print_r($total_flower);
	
	//get flower_type array
	$sql_flower_type = 'select flower_type_id, flower_name from hua_flower_type where using_this =1';
	$query_flower_type = mysqli_query($conn, $sql_flower_type);
	$flower_type_array = array();
	while ($flower_type = mysqli_fetch_array($query_flower_type) ){
		$flower_type_array[$flower_type['flower_type_id']] = $flower_type['flower_name'];
	}
	
	//display total amount of flower in orders
	echo 'Total: <table width=300>';
	//$j=0;
	foreach ($total_flower as $type_id => $amount) {
		//if ($j%2 == 0) $bgcolor = 'bgcolor ="#EEEEEE"'; else $bgcolor='';
		echo '<tr bgcolor ="#EEEEEE"><td>'.$flower_type_array[$type_id].'</td><td>'.$amount.'</td></tr>';
		//$j++;
	}
	echo '</table>';
	
	
	
?>

<?php
	$sql = "select *, TIMESTAMPDIFF(hour, delivery_time, now()) as hours from hua_order where order_retrieved=0 and delivered=1 and is_cancelled=0 and TIMESTAMPDIFF(minute, delivery_time, now())>=2880 order by delivery_time";
	$query = mysqli_query($conn, $sql);
	if (mysqli_num_rows($query)){
		echo '<h3><font color="red">◆ Has Delivered exceed 48 Hours: (Need to Retrieve ASAP)</h3></font>';
		$th_array = array('Order ID', 'Destination','Delivery Time','Hours from');
		echo '<table border=1>';
		foreach ($th_array as $table_head){
			echo '<th>'.$table_head.'</th>';
		}
		while ($row = mysqli_fetch_array($query)) {
			$time = strtotime($row['delivery_time']);
			echo '<tr>';
			echo '<td align=center>CCH-'.$row['order_id'].'</td>';
			echo '<td align=center>'.$store_array[$row['order_destination']].'</td>';
			echo '<td align=center>&nbsp;'.date('m-d D H:i', $time).'&nbsp;</td>';
			echo '<td align=center>'.$row['hours'].'</td>';
			echo '<td align=center>&nbsp;<a href="Retrieve_handle.php?id='.$row['order_id'].'">Retrieve</a>&nbsp;</td>';
			if (!$row['remark'] =='') echo '<td>'.$row['remark'].'</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
?>
<h3>▲ Orders Delivered ( Below 48 Hours ):</h3>
<?php
	$sql = "select *,TIMESTAMPDIFF(hour, delivery_time, now()) as hours from hua_order where order_retrieved=0 and delivered=1 and TIMESTAMPDIFF(minute, delivery_time, now())<2879 and is_cancelled=0 order by delivery_time";
	//orginal is '
	$query = mysqli_query($conn, $sql);
	if (mysqli_num_rows($query)){
		$th_array = array('Order ID', 'Destination','Delivery Time','Hours from');
		echo '<table border=1>';
		foreach ($th_array as $table_head){
			echo '<th>'.$table_head.'</th>';
		}
		while ($row = mysqli_fetch_array($query)) {
			$time = strtotime($row['delivery_time']);
			echo '<tr>';
			echo '<td align=center>CCH-'.$row['order_id'].'</td>';
			echo '<td align=center>'.$store_array[$row['order_destination']].'</td>';
			echo '<td align=center>&nbsp;'.date('m-d D H:i', $time).'&nbsp;</td>';
			echo '<td align=center>'.$row['hours'].'</td>';
			echo '<td align=center>&nbsp;<a href="Retrieve_handle.php?id='.$row['order_id'].'">Retrieve</a>&nbsp;</td>';
			if (!$row['remark'] =='') echo '<td>'.$row['remark'].'</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
?>
<br/><br/><br/>
<?php mysqli_close($conn); ?>