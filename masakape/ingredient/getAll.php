<?php 
	header('Access-Control-Allow-Origin: *');
	//Importing Database Script 
	require_once('dbConnect.php');
	
	//Creating sql query
	$sql = "SELECT * FROM ingredients ORDER BY ingredient ASC";
	
	//getting result 
	$r = mysqli_query($con,$sql);
	
	//creating a blank array 
	$result = array();
	
	//looping through all the records fetched
	while($row = mysqli_fetch_array($r)){
		array_push($result, $row['ingredient']);
	}
	
	//Displaying the array in json format 
	echo json_encode($result);
	
	mysqli_close($con);
?>