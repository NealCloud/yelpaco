<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");

require_once('apicred.php');

$API_HOST = 'https://maps.googleapis.com/maps/api/';
$output = ['success'=> false, 'missing' => []];

if($_SERVER["REQUEST_METHOD"] == 'POST') {
    //TODO filter mode
    $output = ['success'=> false];
    if(isset($_POST['mode'])){
        switch($_POST['mode']){
            case 'placeIdSearch':
                require_once('place_id_api.php');
                break;
            case 'phoneSearch':
                require_once('place_text_api.php');
                break;
            case 'radiusSearch':
                require_once('place_radius_api.php');
                break;
            default :
                $output['error'] = 'wrong mode entered';
                print_r(json_encode($output));
                exit();
        }
        if(isset($output['searchPath'])){
            $output['success'] = true;
            $output['query'] = query_api($output['searchPath']);
        }
    }
    print_r(json_encode($output));
}
else{
    $output['error'] = 'no post data detected';
    print_r(json_encode($output));
}

function query_api($builtUrl){
    $queryOutput = ['success' => false];

    $service_url = $builtUrl;

    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
        $info = curl_getinfo($curl);
        curl_close($curl);
        $queryOutput['error'] = 'curl exec failed Additional info: ' . var_export($info);
        return $queryOutput;
    }
    curl_close($curl);
    $decoded = json_decode($curl_response);
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
        $queryOutput['error'] = 'error occurred: ' . $decoded->response->errormessage;
        return $queryOutput;
    }
    $queryOutput['success'] = true;
    $queryOutput['place'] = $decoded; //var_export($decoded->response);
    return $queryOutput;
}

?>