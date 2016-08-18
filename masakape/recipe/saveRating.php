<?php 
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
	header("Access-Control-Allow-Headers: Content-Type, x-xsrf-token");
	//Importing Database Script 
	require_once('dbConnect.php');

	$data = json_decode(file_get_contents("php://input"));
	$dataRating = $data->rating;
	$dataRecipeId = $data->recipeId;
	
	$sql = "UPDATE recipes SET rating=$dataRating WHERE id=$dataRecipeId";
	
	if (!mysqli_query($con, $sql)) {
		die('Error: ' . mysqli_error($con));
	}
	echo "1 record update";
	
	mysqli_close($con);
?>