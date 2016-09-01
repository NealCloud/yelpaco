<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");

require_once('apicred.php');

$API_HOST = 'https://maps.googleapis.com/maps/api/';
$SEARCH_PATH = 'place/details/json';
$DEFAULT_ID = "ChIJHU1kl5s2w4ARwGSmC0EH61Y";

function query_api($builtUrl){
    $output = ['success' => false];

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

    $url_params['key'] = $GLOBALS['GOOGLEAPIKEY'];
    $url_params['placeid'] = $id ? $id : $GLOBALS['DEFAULT_ID'];

    $search_path = $GLOBALS['API_HOST'] . $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);
    //return $extra = ['path' => $search_path];
    return query_api($search_path);
}

if($_SERVER["REQUEST_METHOD"] == 'POST') {
    $id = false;
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