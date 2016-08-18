<?php 
	header('Access-Control-Allow-Origin: *');
	//Getting the requested id
	$id = $_GET['recipeId'];
	
	//Importing database
	require_once('dbConnect.php');
	
	//Creating sql query with where clause to get an specific employee
	$sql = "SELECT * FROM comments WHERE recipe_id=$id";
	
	//getting result 
	$r = mysqli_query($con,$sql);
	
	//pushing result to an array 
	$result = array();
	while($row = mysqli_fetch_array($r)){
		array_push($result,array(
			"id"=>$row['id'],
			"username"=>$row['username'],
			"comment"=>$row['comment']
		));
	}

	//displaying in json format 
	echo json_encode($result);
	
	mysqli_close($con);
?>