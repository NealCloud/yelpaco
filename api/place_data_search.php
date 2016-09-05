<?php
//connect to database
require 'mysql_connect.php';
//create output
$output = ["success" => false];
//check is post request is made;

//check if name post is sent
if(isset($_POST['id']) || isset($_POST['phone']) || isset($_POST['latlon'])){
//set heroName to from post
    $placeid = $_POST['id'];
    $phone = $_POST['phone'];
    $ll = $_POST['latlon'];
    if(strlen($placeid) < 35){
        //make the query based on name
        $query = "SELECT * FROM tacoPlaces WHERE placeId = '$placeid' or phone = '$phone' or latlon = '$ll'";
        $result = mysqli_query($conn, $query);
        //for each result loop through
        if(mysqli_num_rows($result) > 0){
            //set to success and initialize counter;
            $output['success'] = true;
            while($row = mysqli_fetch_assoc($result)){
                //asssing row info to hero info;
                $output['placeQuery'] = $row;
            }
        }
        else{
            $output['error'] = 'no match found';
        }
    }
}
else{ //error out if no post request
    $output['error'] = 'expected an id phone or latlon property';
}
//close database and print output
mysqli_close($conn);

