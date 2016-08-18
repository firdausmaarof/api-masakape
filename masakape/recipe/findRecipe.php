<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, x-xsrf-token");

include 'dbConnect.php';

$data = json_decode(file_get_contents("php://input"));
$dataCuisine = $data->cuisine;
$dataOccasion = $data->occasion;
$dataIngredient = $data->ingredient;
$dataSearch = $data->search;

$ingredient = $dataIngredient[0];
for($i=1; $i<sizeof($dataIngredient);$i++) {
    $ingredient .= "','".$dataIngredient[$i];
}
$ing_no = sizeof($dataIngredient);
$occasion = $dataOccasion[0];
$cuisine = $dataCuisine[0];
for($i=1; $i<sizeof($dataCuisine);$i++) {
    $cuisine .= "','".$dataCuisine[$i];
}

if($dataSearch == "exact"){
    $sql = "SELECT r.*, c.cuisine, o.occasion
    FROM   recipes r
    INNER JOIN (
        SELECT   ri.recipe_id
        FROM     recipe_ingredient ri
        WHERE    ri.recipe_id IN (
            SELECT   ri2.recipe_id
            FROM     recipe_ingredient ri2
            INNER JOIN recipes r2
            ON r2.id = ri2.recipe_id
            GROUP BY ri2.recipe_id
            HAVING   Count(ri2.recipe_id) <= '$ing_no'
        )
        AND ri.ingredient_id IN (
            SELECT id
            FROM   ingredients i
            WHERE  i.ingredient IN ('$ingredient')
        )
        GROUP BY ri.recipe_id
        HAVING   Count(ri.recipe_id) <= '$ing_no'
    ) aa
    ON r.id = aa.recipe_id
    INNER JOIN cuisines c
    ON r.cuisine_id = c.id
    INNER JOIN recipe_occasion ro
    ON r.id = ro.recipe_id
    INNER JOIN occasions o
    ON o.id = ro.occasion_id
    WHERE c.cuisine IN ('$cuisine')
    AND o.occasion = '$occasion'";
} else {
    $sql = "SELECT r.*
    FROM   recipes r
    INNER JOIN (SELECT   ri.recipe_id
                FROM     recipe_ingredient ri
                INNER JOIN recipes r
                ON r.id = ri.recipe_id
                INNER JOIN ingredients i
                ON i.id = ri.ingredient_id
                WHERE    i.ingredient IN ('$ingredient')
                GROUP BY ri.recipe_id
                HAVING   Count(ri.recipe_id) <= '$ing_no') aa
    ON r.id = aa.recipe_id
    INNER JOIN cuisines c
    ON r.cuisine_id = c.id
    INNER JOIN recipe_occasion ro
    ON r.id = ro.recipe_id
    INNER JOIN occasions o
    ON o.id = ro.occasion_id
    WHERE c.cuisine IN ('$cuisine')
    AND o.occasion = '$occasion'";
}

$result = mysqli_query($con,$sql) or exit('Wrong 2');
$r = array();
while($row = mysqli_fetch_array($result)){
    array_push($r,array(
        "id"=>$row['id'],
        "recipe"=>$row['recipe'],
        "instruction"=>utf8_encode($row['instruction']),
        "photo"=>$row['photo'],
        "rating"=>$row['rating'],
        "cuisine"=>$row['cuisine'],
        "occasion"=>$row['occasion']
    ));

}

//Displaying the array in json format 
echo json_encode($r);
mysqli_close($con);
?>