<head>
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
<script src="js/jquery.js"></script>
<script>

	function show(){
		//alert('dsfsdf');
		var store = $("#store_choose_id").val();
		var flower_type_id = $("#flower_type_id").val();
		var start_time = $("#start_time_id").val();
		var end_time = $("#end_time_id").val();
		var result_pane = $("#result");
		$.ajax({
			type:"POST",
			url:"search.php",
			data:{
				store: store,
				flower_type_id: flower_type_id,
				start_time: start_time,
				end_time: end_time
			},
			success:function(json){
				//alert (json);
				result_pane.empty();
				result_pane.append(json);
			}
		})
	}
</script>
</head>
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
?>

<form action="search.php" id="statisics_form" method="post" >
	NTUC Store：
	<select name = "store" id="store_choose_id">
	<option value="0">All Store</option>

<?php

	$sql =  'select * from hua_store order by using_this desc, store_name ';
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result) ){
		echo '<option value="'.$row['store_id'].'">'.$row['store_name'].' - '.$row['store_address'].'</option>';
	}

?>
</select>
	&nbsp;&nbsp;&nbsp;Flower Type：
<select name="flower_type_id" id="flower_type_id">
	<option value="0">All Flower</option>
<?php
	$sql_flower =  'select * from hua_flower_type order by using_this=1 desc, flower_name';
	$result_flower = mysqli_query($conn, $sql_flower);
	$i=0;
	while ($row_flower = mysqli_fetch_assoc($result_flower) ){		
		echo '<option value="'.$row_flower['flower_type_id'].'">'.$row_flower['flower_name'].'</option>';
	}
?>
</select>
</br></br>
Start Time
<input type="text" name="start_time" id="start_time_id" />
&nbsp;&nbsp;&nbsp;End Time
<input type="text" name="end_time" id="end_time_id" />

		<script src="js/jquery.js"></script>
		<script src="js/jquery.datetimepicker.full.js"></script>
		<script>
			var today = new Date();
			$('#start_time_id').datetimepicker({
				format:'Y-m-d H:i',
				step:60
			});
			$('#end_time_id').datetimepicker({
				format:'Y-m-d H:i',
				step:60
			});
		</script>

&nbsp;&nbsp;&nbsp;<input type="submit" value="Submit" />
<div id="result">
</div>














