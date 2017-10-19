<?php
	$type = $_POST['edit_type'];
	include 'dbconnection.php';
	//echo $type;
	
	if ($type == 'store') {
		$store_id = $_POST['store_id'];
		$store_name = $_POST['store_name'];
		$store_address = $_POST['store_address'];
		$using_this = $_POST['using_this'];
		
		if(is_numeric($store_id)){
			$sql = "update hua_store set store_name = '$store_name', store_address = '$store_address', using_this = $using_this where store_id = $store_id";
			//echo $sql;
		}else{
			$sql = "insert hua_store set store_name = '$store_name', store_address = '$store_address', using_this = $using_this";
		}
		//echo $sql;
		$query = mysqli_query($conn, $sql);
	}	
	if ($type == 'flower') {
		$flower_type_id = $_POST['flower_type_id'];
		$flower_name = $_POST['flower_name'];
		$using_this = $_POST['using_this'];
		
		if(is_numeric($flower_type_id)){
			$sql = "update hua_flower_type set flower_name = '$flower_name', using_this = $using_this where flower_type_id = $flower_type_id";
			//echo $sql;
		}else{
			$sql = "insert hua_flower_type set flower_name = '$flower_name', using_this = $using_this";
		}
		//echo $sql;
		$query = mysqli_query($conn, $sql);
	}
	
	mysqli_close($conn);
	header("Location: manage.php");
?>