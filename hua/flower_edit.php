<?php
	include 'dbconnection.php';
	$using_check ='selected';
	$not_using_check ='';
	$flower_type_id = $_GET['id'];
	if (is_numeric($flower_type_id)){
		$sql = 'select * from hua_flower_type where flower_type_id = '.$flower_type_id;
		$query = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($query);
		if( $row['using_this'] == 0 ) {
			$using_check ='';
			$not_using_check ='selected';
		}		
	}else{
		$row = array();
	}
?>
<form action="store_flower_edit_new.php" method="post">
	<input type="text" name="edit_type" value="flower" hidden />
	<input type="text" name="flower_type_id" value="<?php echo $flower_type_id; ?>" hidden />
	<br/><br/>Flower Type Name: <input name="flower_name" value="<?php if(isset($row['flower_name'])) echo $row['flower_name']; else echo ''; ?>" />
	<br/><br/>Using This Flower: <select name="using_this">
		<option value="1" <?php echo $using_check; ?> >Yes</option>
		<option value="0" <?php echo $not_using_check; ?>>No</option>
	</select>
	<br/><br/><a href="manage.php">Go Back</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" value="Submit" />
</form>

<?php mysqli_close($conn); ?>