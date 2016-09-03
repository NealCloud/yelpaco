<?php

$DEFAULT_COORD = "33.665242,-117.7490656";
$DEFAULT_QUERY = "9494724468";
$SEARCH_PATH = 'place/textsearch/json';

$ll = false;
$phone = false;
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
if(isset($_POST['phone'])){
    $phone = $_POST['phone'];
}
else{
    array_push($missing, 'no phone property given');
}
if(isset($_POST['apiKey'])){
    $api = $_POST['apiKey'];
}
else{
    array_push($missing, 'no api given');
}

$output['searchPath'] = urlBuild($ll, $phone, $api);
$output['missing'] = $missing;

function urlBuild($loc, $phone, $api){
    $url_params = array();

    $url_params['key'] = $api ? $api : $GLOBALS['GOOGLEAPIKEY'];
    $url_params['query'] = $phone ? $phone : $GLOBALS['DEFAULT_QUERY'];
    $url_params['location'] = $loc ? $loc : $GLOBALS['DEFAULT_COORD'];

    $search_path = $GLOBALS['API_HOST'] . $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);

    return $search_path;
}

?>