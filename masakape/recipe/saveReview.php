<?php 
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
	header("Access-Control-Allow-Headers: Content-Type, x-xsrf-token");
	//Importing Database Script 
	require_once('dbConnect.php');

	$data = json_decode(file_get_contents("php://input"));
	$dataUsername = $data->username;
	$dataComment = $data->comment;
	$dataRecipeId = $data->recipeId;
	
	$sql = "INSERT INTO comments(username, comment, recipe_id) VALUES ('$dataUsername', '$dataComment', '$dataRecipeId')";
	
	if (!mysqli_query($con, $sql)) {
		die('Error: ' . mysqli_error($con));
	}
	echo "1 record inserted";
	
	mysqli_close($con);
?>