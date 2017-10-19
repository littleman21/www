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

<br/>
<?php
	include 'dbconnection.php';
	$sql = 'select * from hua_store order by using_this desc';
	$query = mysqli_query($conn, $sql);
	echo '<h4>Store List</h4>';
	echo '<table width=600>';
	$i=0;
	while($row = mysqli_fetch_array($query)){
		if ($i%2==0) $bgcolor='#CBF7CA'; else $bgcolor='#E7FBEE';
		echo '<tr bgcolor="'.$bgcolor.'" ><td align=center>'.$row['store_name'].'</td><td align=center>'.$row['store_address'].'</td>';
		if($row['using_this']){
			echo '<td></td>';
		}else{
			echo '<td align=center>Not Using</td>';
		}
		echo '<td align=center><a href="store_edit.php?id='.$row['store_id'].'">Edit</a></td></tr>';
		$i++;
	}
	if ($i%2==0) $bgcolor='#CBF7CA'; else $bgcolor='#E7FBEE';
	echo '<tr bgcolor="'.$bgcolor.'" ><td></td><td></td><td></td><td align=center><a href="store_edit.php?id=new">New Store</a></td></tr>';
	echo '</table><br/>';

	echo '<h4>Flower List</h4>';
	$sql = 'select * from hua_flower_type order by using_this desc';
	$query = mysqli_query($conn, $sql);
	echo '<table width=600>';
	$j=0;
	while($row = mysqli_fetch_array($query)){
		if ($j%2==0) $bgcolor='#F3C2EC'; else $bgcolor='#FCDEF9';
		echo '<tr bgcolor="'.$bgcolor.'" ><td align=center>'.$row['flower_name'];
		if($row['using_this']){
			echo '<td></td>';
		}else{
			echo '<td align=center>Not Using</td>';
		}
		echo '<td align=center><a href="flower_edit.php?id='.$row['flower_type_id'].'">Edit</a></td></tr>';
		$j++;
	}
	if ($j%2==0) $bgcolor='#F3C2EC'; else $bgcolor='#FCDEF9';
	echo '<tr bgcolor="'.$bgcolor.'" ><td></td><td></td><td align=center><a href="flower_edit.php?id=new">New Flower</a></td></tr>';
	echo '</table>';
	
	mysqli_close($conn); 
?>