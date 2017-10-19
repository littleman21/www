

<head>
	<link type="text/css" rel="stylesheet" href="css/parsley.css" />

	<script type="text/javascript" src="js/jquery.min.js" ></script>
	<script type="text/javascript" src="js/parsley.min.js" ></script>
	<script>
		$(document).ready(function($){
			$('#new_order_form').parsley();
		})
	</script>
</head>

<body>
<style>
a:hover,a:visited{color:blue;}  
</style> 
<br/><br/>
<form action="order_create.php" id="new_order_form" method="post" >
	送去的NTUC店铺地点：<select name = "send_to_store_id" >

<?php

	include "dbconnection.php";
	$sql =  'select * from hua_store where using_this =1 order by store_name';
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result) ){
		echo '<option value="'.$row['store_id'].'">'.$row['store_name'].' - '.$row['store_address'].'</option>';
	}

?>
</select>
	<br/><br/>送去的花：<br/><br/>
<?php
	$sql_flower =  'select * from hua_flower_type where using_this=1';
	$result_flower = mysqli_query($conn, $sql_flower);
	$i=0;
	while ($row_flower = mysqli_fetch_assoc($result_flower) ){		
		echo '<input type="checkbox" name="flower_'.$i.'" value="'.$row_flower['flower_type_id'].'" />'.$row_flower['flower_name'].'&nbsp;&nbsp;';
		echo '<input onkeyup="if(this.value<0){this.value=0}" type="number" name="flower_amount_'.$i.'"  /><br/></br>';
		$i++;
	}
	echo '<input type="text" name="total_flower_type" value="'.$i.'" hidden/>';
?>
<a href="index.php">Back to Homepage</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" value="Create an order">
	<p>Remark: <br/>
	<textarea name="remark" cols="30" rows="3"></textarea>
	<br/><br/>

</form>

<?php mysqli_close($conn); ?>