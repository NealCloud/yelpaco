<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");


$API_HOST = 'https://maps.googleapis.com/maps/api/place/';
$APIKEY = "AIzaSyC6o5e3BDFg9nAKsapCRvt69C6aRaT-htg";
$LL = "33.665242,-117.7490656";
$QUERY = "9494724468";
$DEFAULT_TERM = 'taco';
$DEFAULT_LOCATION = 'Costa Mesa, CA';
$SEARCH_LIMIT = 5;
$SEARCH_PATH = 'textsearch/json?';
$SORT_BY = "2"; //sort by rating
$RADIUS = "16000"; //meters = 10 miles*
$OFFSET = 0;

function query_api($urlparam){
    $output = ['success' => false];
    //next example will recieve all messages for specific conversation
    //$service_url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?query=9494724468&location=33.665242,-117.7490656&key=AIzaSyC6o5e3BDFg9nAKsapCRvt69C6aRaT-htg';
    $service_url = $urlparam;
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
        $info = curl_getinfo($curl);
        curl_close($curl);
        $output['error'] = 'error occured during curl exec. Additional info: ' . var_export($info);
        return $output;
    }
    curl_close($curl);
    $decoded = json_decode($curl_response);
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
        $output['error'] = 'error occured: ' . $decoded->response->errormessage;
        return $output;
    }
    $output['success'] = true;
    $output['place'] = $decoded; //var_export($decoded->response);
    return $output;
}

function urlBuild(){
    $url_params = array($phone, $loc);

    $url_params['key'] = $GLOBALS['APIKEY'];
    if($lonlat){
        $url_params['cll'] = $lonlat;
    }
    $url_params['query'] = $location?: $GLOBALS['QUERY'];
    $url_params['loc'] = $GLOBALS['SEARCH_LIMIT'];
    $url_params['sort'] = $GLOBALS['SORT_BY'];
    $url_params['radius_filter'] = $GLOBALS['RADIUS'];
    $url_params['offset'] = $offset;

    $search_path = $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);

    return request($GLOBALS['API_HOST'], $search_path);
}

if($_SERVER["REQUEST_METHOD"] == 'POST') {
    $ll = null;
    if(isset($_POST['lat'])) {
        $GLOBALS['lat'] = $_POST['lat'];
    }
    if(isset($_POST['lon'])) {
        $GLOBALS['lon'] = $_POST['lon'];
    }
    if(isset($_POST['zip'])) {
        $GLOBALS['zip'] = $_POST['zip'];
    }
    if(isset($_POST['lat'])){
        $ll = $lat . ',' . $lon;
    }
    if(isset($_POST['offset'])){
        $offset = $_POST['offset'];
    }

    $outputfile = query_api();
    print_r(json_encode($outputfile));
}

else{
    $errorOut['error'] = 'no post data detected';
    $errorOut['dataParams'] = $_GET;
    print_r(json_encode($errorOut));
}

?>