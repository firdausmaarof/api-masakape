<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, x-xsrf-token");

include 'dbConnect.php';

$data = json_decode(file_get_contents("php://input"));
$dataFavRecipe = $data->recipeId;

$recipe = $dataFavRecipe[0];
for($i=1; $i<sizeof($dataFavRecipe);$i++) {
    $recipe .= ",".$dataFavRecipe[$i];
}

$sql = "SELECT * FROM recipes WHERE id IN ($recipe)";

$result = mysqli_query($con,$sql) or exit('Wrong 2');
$r = array();
while($row = mysqli_fetch_array($result)){
    array_push($r,array(
        "id"=>$row['id'],
        "recipe"=>$row['recipe'],
        "resipi"=>$row['resipi'],
        "instruction"=>utf8_encode($row['instruction']),
        "arahan"=>utf8_encode($row['arahan']),
        "photo"=>$row['photo'],
        "rating"=>$row['rating'],
        "cuisine"=>$row['cuisine'],
        "masakan"=>$row['masakan'],
        "occasion"=>$row['occasion'],
        "majlis"=>$row['majlis']
    ));

}

//Displaying the array in json format 
echo json_encode($r);
mysqli_close($con);
?>