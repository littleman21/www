<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
</head>
<body>
	
<style>
a:hover,a:visited{color:blue;}  
</style> 
<?php
	$order_id = $_GET['id'];
	//echo $order_id;
	include 'dbconnection.php';
	$sql = 'select * from hua_order where order_id = '.$order_id;
	$query = mysqli_query($conn, $sql);
	$order = mysqli_fetch_array($query);
	echo '<b>Order ID:</b> CCH-'.$order_id.'<br/>';
	echo '<b>Created Time:</b> '.date('m-d D H:i',strtotime($order['created_time'])).'<br/>';
	
	$sql_store = 'select store_name, store_address from hua_store where store_id='.$order['order_destination'];
	$query_store = mysqli_query($conn, $sql_store);
	$store = mysqli_fetch_array($query_store);
	//echo '<b>Destination Store: </b><br/>';
	echo '<br/><b>'.$store['store_name'].'</b><br/>';
	echo $store['store_address'].'<br/><br/>';
	//echo '<br/><b>Flower Detail in the Order</b>';
	
	$sql_flower_type = 'select flower_type_id, flower_name from hua_flower_type where using_this =1';
	$query_flower_type = mysqli_query($conn, $sql_flower_type);
	$flower_type_array = array();
	while ($flower_type = mysqli_fetch_array($query_flower_type) ){
		$flower_type_array[$flower_type['flower_type_id']] = $flower_type['flower_name'];
	}
	
	$sql_flower = 'select * from hua_order_detail where order_id ='.$order_id;
	$query_flower = mysqli_query($conn, $sql_flower);
	echo '<table border=1><th>Flower Type</th><th>Amount</th>';
	while ( $order_detail = mysqli_fetch_array($query_flower)){
		echo '<tr>';
		echo '<td align=center>'.$flower_type_array[$order_detail['flower_type_id']].'</td>';
		echo '<td align=center>'.$order_detail['flower_amount'].'</td>';
		echo '</tr>';
	}
	echo '</table><br/>';
	
?>
<form action="order_report.php" METHOD="POST">
	<input type="text" name="order_id" value="<?php echo $order_id; ?>" hidden />
	<br/><b>Delivery Completed </b><input type="checkbox" name="delivered" value="1"/><br/>
	
	<br/>Delivery Time: <input type="text" id="datetimepicker" name="delivery_time" value="<?php echo date('Y-m-d H:i'); ?>" /><br/>(48 Hours count start from this time)
		<script src="js/jquery.js"></script>
		<script src="js/jquery.datetimepicker.full.js"></script>
		<script>
			var today = new Date();
			$('#datetimepicker').datetimepicker({
				format:'Y-m-d H:i',
				minDate:'<?php echo date('Y-m-d',strtotime($order['created_time'])); ?>',
				maxDate:today,
				step:60
			});
		</script>
	<br/> 
	<br/>Cancel this Order: <br/>(<font color="red">Can NOT Undo</font>)
	<select name="is_cancelled">
		<option value="0" selected >No</option>
		<option value="1" >Yes</option>
	</select>

	<br/><br/>
	<a href="index.php">Go Back</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" value="OK, Report it" />
	<br/><br/>
	<p>Remark: (if something happened) <br/>
	<textarea name="remark" cols="40" rows="3"><?php echo $order['remark']; ?></textarea>
	<br/><br/>
	</p>
</form>

</body>
<?php mysqli_close($conn); ?>