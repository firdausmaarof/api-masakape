<?php 
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
	header("Access-Control-Allow-Headers: Content-Type, x-xsrf-token");
	//Importing Database Script 
	require_once('dbConnect.php');

	$data = json_decode(file_get_contents("php://input"));
	$dataTopRecipe = $data->topRecipe;
	$dataCuisine = $data->cuisine;
	$dataOccasion = $data->occasion;
	
	if(sizeof($dataCuisine)!=0 && sizeof($dataOccasion)==0){
		$cuisine = $dataCuisine[0];
		for($i=1; $i<sizeof($dataCuisine);$i++) {
		    $cuisine .= "','".$dataCuisine[$i];
		}
		$sql = "SELECT r.* FROM recipes r
		INNER JOIN cuisines c
		ON r.cuisine_id = c.id
		WHERE c.cuisine IN ('$cuisine') ORDER BY rating DESC LIMIT $dataTopRecipe";
	}else if(sizeof($dataCuisine)==0 && sizeof($dataOccasion)!=0) {
		$occasion = $dataOccasion[0];
		for($i=1; $i<sizeof($dataOccasion);$i++) {
		    $occasion .= "','".$dataOccasion[$i];
		}
		$sql = "SELECT r.* FROM recipes r
		INNER JOIN recipe_occasion ro
		ON r.id = ro.recipe_id
		INNER JOIN occasions o
		ON ro.occasion_id = o.id
		WHERE o.occasion IN ('$occasion') ORDER BY rating DESC LIMIT $dataTopRecipe";
	}else if(sizeof($dataCuisine)!=0 && sizeof($dataOccasion)!=0){
		$cuisine = $dataCuisine[0];
		for($i=1; $i<sizeof($dataCuisine);$i++) {
		    $cuisine .= "','".$dataCuisine[$i];
		}
		$occasion = $dataOccasion[0];
		for($i=1; $i<sizeof($dataOccasion);$i++) {
		    $occasion .= "','".$dataOccasion[$i];
		}
		$sql = "SELECT r.* FROM recipes r
		INNER JOIN recipe_occasion ro
		ON r.id = ro.recipe_id
		INNER JOIN occasions o
		ON ro.occasion_id = o.id
		INNER JOIN cuisines c
		ON r.cuisine_id = c.id
		WHERE o.occasion IN ('$occasion') 
		AND c.cuisine IN ('$cuisine')
		ORDER BY rating DESC LIMIT $dataTopRecipe";
	}
	else{
		$sql = "SELECT * FROM recipes ORDER BY rating DESC LIMIT $dataTopRecipe";
	}
	
	//getting result 
	$r = mysqli_query($con,$sql);
	
	//creating a blank array 
	$result = array();
	
	//looping through all the records fetched
	while($row = mysqli_fetch_array($r)){
		
		//Pushing name and id in the blank array created 
		array_push($result,array(
			"id"=>$row['id'],
			"recipe"=>$row['recipe'],
			"rating"=>$row['rating'],
			"photo"=>$row['photo'],
			"resipi"=>$row['resipi'],
			"instruction"=>utf8_encode($row['instruction'])
		));
	}
	
	//Displaying the array in json format 
	echo json_encode($result);
	
	mysqli_close($con);
?>