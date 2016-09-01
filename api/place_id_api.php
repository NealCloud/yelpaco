<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
$TEST_URL = "https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJHU1kl5s2w4ARwGSmC0EH61Y&key=AIzaSyC6o5e3BDFg9nAKsapCRvt69C6aRaT-htg";

$API_HOST = 'https://maps.googleapis.com/maps/api/';
$SEARCH_PATH = 'place/details/json';
$APIKEY = "AIzaSyC6o5e3BDFg9nAKsapCRvt69C6aRaT-htg";
$DEFAULT_ID = "ChIJHU1kl5s2w4ARwGSmC0EH61Y";
$DEFAULT_TERM = 'taco';
$DEFAULT_LOCATION = 'Costa Mesa, CA';
$SEARCH_LIMIT = 5;

$SORT_BY = "2"; //sort by rating
$RADIUS = "16000"; //meters = 10 miles*
$OFFSET = 0;

function query_api($builtUrl){
    $output = ['success' => false];
    //next example will recieve all messages for specific conversation
    $service_url = $builtUrl;
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

function urlBuild($id){
    $url_params = array();

    $url_params['key'] = $GLOBALS['APIKEY'];
    $url_params['placeid'] = $id ? : $GLOBALS['DEFAULT_ID'];

    $search_path = $GLOBALS['API_HOST'] . $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);
    //return $extra = ['yo' => $search_path];
    return query_api($search_path);
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
    if(isset($_POST['id'])){
        $id = $_POST['id'];
    }

    $output = urlBuild($id);
    print_r(json_encode($output));
}

else{
    $errorOut['error'] = 'no post data detected';
    $errorOut['dataParams'] = $_GET;
    print_r(json_encode($errorOut));
}

?>