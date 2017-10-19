<?php
	include 'dbconnection.php';
	$using_check ='selected';
	$not_using_check ='';
	$store_id = $_GET['id'];
	if (is_numeric($store_id)){
		$sql = 'select * from hua_store where store_id = '.$store_id;
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
	<input type="text" name="edit_type" value="store" hidden />
	<input type="text" name="store_id" value="<?php echo $store_id; ?>" hidden />
	<br/><br/>Store Name: <input name="store_name" value="<?php if(isset($row['store_name'])) echo $row['store_name']; else echo ''; ?>" />

	<br/><br/>Store Address: <input name="store_address" value="<?php if(isset($row['store_address'])) echo $row['store_address']; else echo ''?>" />
	<br/><br/>Using This Store: <select name="using_this">
		<option value="1" <?php echo $using_check; ?> >Yes</option>
		<option value="0" <?php echo $not_using_check; ?>>No</option>
	</select>
	<br/><br/><a href="manage.php">Go Back</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" value="Submit" />
</form>

<?php mysqli_close($conn); ?>