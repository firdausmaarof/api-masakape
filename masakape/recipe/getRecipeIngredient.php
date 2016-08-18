<?php 
	header('Access-Control-Allow-Origin: *');
	//Getting the requested id
	$id = $_GET['recipeId'];
	
	//Importing database
	require_once('dbConnect.php');
	
	//Creating sql query with where clause to get an specific employee
	$sql = "SELECT i.* FROM ingredients i 
		INNER JOIN recipe_ingredient ri
		ON ri.ingredient_id = i.id
		WHERE ri.recipe_id = '$id'";
	
	//getting result 
	$r = mysqli_query($con,$sql);
	
	//pushing result to an array 
	$result = array();
	$i = 1;

	while($row = mysqli_fetch_array($r)){
		array_push($result,array(
			"number"=>$i,
			"ingredient"=>$row['ingredient'],
			"ramuan"=>$row['ramuan']
		));
		$i++;
	}

	//displaying in json format 
	echo json_encode($result);
	
	mysqli_close($con);
?>