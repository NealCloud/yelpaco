<?php

$SEARCH_PATH = 'place/details/json';
$DEFAULT_ID = "ChIJHU1kl5s2w4ARwGSmC0EH61Y";

//TODO sanitize id then call urlBuilder
$output['searchPath'] = urlBuild($_POST['id'], $_POST['apiKey']);

function urlBuild($id, $api){
    $url_params = array();

    $url_params['key'] = $api ? $api : $GLOBALS['GOOGLEAPIKEY'];
    $url_params['placeid'] = $id ? $id : $GLOBALS['DEFAULT_ID'];

    $search_path = $GLOBALS['API_HOST'] . $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);

    return $search_path;
}

?>