<?php

$DEFAULT_COORD = "33.665242,-117.7490656";
$DEFAULT_RADIUS = "10000";
$SEARCH_PATH = 'place/nearbysearch/json';
$DEFAULT_TYPE = 'restaurant';
$DEFAULT_KEYWORD = 'taco';

$ll = false;
$radius = false;
$missing = [];
$api = false;

if(isset($_POST['lat']) && isset($_POST['lon'])){
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    $ll = $lat . ',' . $lon;
}
elseif(isset($_POST['latlon'])){
    $ll = $_POST['latlon'];
}
else{
    array_push($missing, 'no lat or lon property given');
}
if(isset($_POST['radius'])){
    $radius = $_POST['radius'];
}
else{
    array_push($missing, 'no radius property given');
}
if(isset($_POST['apiKey'])){
    $api = $_POST['apiKey'];
}
else{
    array_push($missing, 'no api given');
}

$output['searchPath'] = urlBuild($ll, $radius, false, false, $api);
$output['missing'] = $missing;

function urlBuild($loc, $rad, $type, $keyword, $api){
    $url_params = array();

    $url_params['key'] = $api ? $api : $GLOBALS['GOOGLEAPIKEY'];

    $url_params['type'] = $type ? $type : $GLOBALS['DEFAULT_TYPE'];
    $url_params['location'] = $loc ? $loc : $GLOBALS['DEFAULT_COORD'];
    $url_params['radius'] = $rad ? $rad : $GLOBALS['DEFAULT_RADIUS'];
    $url_params['keyword'] = $keyword ? $keyword : $GLOBALS['DEFAULT_KEYWORD'];

    $search_path = $GLOBALS['API_HOST'] . $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);

    return $search_path;
}

?>