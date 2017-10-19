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
	
	include 'dbconnection.php';
	
	$sql = 'select * from hua_order where order_id = '.$order_id;
	$query = mysqli_query($conn, $sql);
	$order = mysqli_fetch_array($query);
	echo '<b>Order ID:</b> CCH-'.$order_id.'<br/>';
	echo '<b>Delivery Time:</b> '.date('m-d D H:i',strtotime($order['delivery_time'])).'<br/>';
	
	$sql_store = 'select store_name, store_address from hua_store where store_id='.$order['order_destination'];
	$query_store = mysqli_query($conn, $sql_store);
	$store = mysqli_fetch_array($query_store);
	echo '<br/><b>'.$store['store_name'].'</b><br/>';
	echo $store['store_address'].'<br/><br/>';
	
	$sql_flower_type = 'select flower_type_id, flower_name from hua_flower_type where using_this =1';
	$query_flower_type = mysqli_query($conn, $sql_flower_type);
	$flower_type_array = array();
	while ($flower_type = mysqli_fetch_array($query_flower_type) ){
		$flower_type_array[$flower_type['flower_type_id']] = $flower_type['flower_name'];
	}
	
	$sql_flower = 'select * from hua_order_detail where order_id ='.$order_id;
	$query_flower = mysqli_query($conn, $sql_flower);
	echo '<form action="retrieve_report.php" METHOD="POST">';
	echo '<table border=1><th>Flower Type</th><th>Delivered Amount</th><th>Retrieved Amount</th>';
	while ( $order_detail = mysqli_fetch_array($query_flower)){
		echo '<tr>';
		echo '<td align=center>'.$flower_type_array[$order_detail['flower_type_id']].'</td>';
		$max_amount = $order_detail['flower_amount'];
		echo '<td align=center>'.$max_amount.'</td>';
		echo '<td>&nbsp;
		<input onkeyup="if(this.value<0){this.value=0}; if(this.value>'.$max_amount.'){this.value='.$max_amount.'}"  type="number" name="flower_'.$order_detail['flower_type_id'].'"/>&nbsp;</td>';
		echo '</tr>';
	}
	echo '</table><br/>';
?>
	<input type="text" name="order_id" value="<?php echo $order_id; ?>" hidden />
	<br/>
	<br/>Retrieve Time: <input type="text" name="retrieve_time" id="datetimepicker" value="<?php echo date('Y-m-d H:i'); ?>" /><br/>
		<script src="js/jquery.js"></script>
		<script src="js/jquery.datetimepicker.full.js"></script>
		<script>
			var today = new Date();
			$('#datetimepicker').datetimepicker({
				format:'Y-m-d H:i',
				minDate: '<?php echo date('Y-m-d',strtotime($order['delivery_time'])); ?>',
				maxDate: today,
				step:60
			});
		</script>
	<br/> 
	<a href="index.php">Go Back</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" value="Retrieve Complete" />
	<br/><br/>
	<p>Remark: <br/>
	<textarea name="remark" cols="30" rows="3"><?php echo $order['remark']; ?></textarea>
	<br/><br/>
	</p>
</form>

<?php mysqli_close($conn); ?>