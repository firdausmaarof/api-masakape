<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, x-xsrf-token");

$con=mysqli_connect("localhost","root","FMServerdb","teman");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$data = json_decode(file_get_contents("php://input"));
$nama = mysqli_real_escape_string($con, $data->nama);
$alamat = mysqli_real_escape_string($con, $data->alamat);
$spesialis = mysqli_real_escape_string($con, $data->spesialis);
$fb = mysqli_real_escape_string($con, $data->fb);
$icon = mysqli_real_escape_string($con, $data->icon);

$sql = "INSERT INTO datateman(nama,alamat,spesialis,fb,icon) values ('$nama','$alamat','$spesialis','$fb','$icon')";

if (!mysqli_query($con, $sql)) {
  die('Error: ' . mysqli_error($con));
}
echo "1 record added";

mysqli_close($conn);
?>