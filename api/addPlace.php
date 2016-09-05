<?php
//connect to database
require 'mysql_connect.php';
//create output array
$output = ["success" => false];
//check if post ajax made

$output['data'] = $_POST;
//check if name role and universe are set
if(isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['id']) && isset($_POST['latlon'])){
    //TODO: sanitize inputs

    $placeName = $_POST['name'];
    $placeId = $_POST['id'];
    $placeCoord = $_POST['latlon'];
    $placePhone = $_POST['phone'];

    //$output['extra'] = ($heroName . $heroUni . $heroRole);
    //set query for insert
    $query = "INSERT INTO `tacoPlaces` ( `name`, `placeId`, `latlon`, `phone`) VALUES ('$placeName', '$placeId', '$placeCoord', '$placePhone');";
    $result = mysqli_query($conn, $query);
    //check if query success
    if($result){
        //output id of newly inserted row
        $output['placeAdded']= $last_id = mysqli_insert_id($conn);
        $output['success'] = true;
    }
    else{
        $output['error'] = 'failed to create place';
    }
}
else{
    $output['error'] = 'missing properties needs name phone id and latlon';
}
//close and print output array
mysqli_close($conn);