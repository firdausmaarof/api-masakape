<?php 
	header('Access-Control-Allow-Origin: *');
	//Getting the requested id
	$id = $_GET['recipeId'];
	
	//Importing database
	require_once('dbConnect.php');
	
	//Creating sql query with where clause to get an specific employee
	$sql = "SELECT * FROM recipes WHERE id=$id";
	
	//getting result 
	$r = mysqli_query($con,$sql);
	
	//pushing result to an array 
	$result = array();
	$row = mysqli_fetch_array($r);
	array_push($result,array(
		"id"=>$row['id'],
		"recipe"=>$row['recipe'],
		"resipi"=>$row['resipi'],
		"rating"=>$row['rating'],
		"photo"=>$row['photo'],
		"time"=>$row['time'],
		"instruction"=>utf8_encode($row['instruction']),
		"arahan"=>utf8_encode($row['arahan'])
	));

	//displaying in json format 
	echo json_encode($result);
	
	mysqli_close($con);
?>