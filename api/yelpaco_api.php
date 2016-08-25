<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
// Enter the path that the oauth library is in relation to the php file
require_once('../lib/OAuth.php');
require_once('apicred.php');
// Set your OAuth credentials here  
// These credentials can be obtained from the 'Manage API Access' page in the
// developers documentation (http://www.yelp.com/developers)
//$CONSUMER_KEY = $apikey1;
//$CONSUMER_SECRET = $apikey2;
//$TOKEN = $apikey3;
//$TOKEN_SECRET = $apikey4;

$API_HOST = 'api.yelp.com';
$DEFAULT_TERM = 'taco';
$DEFAULT_LOCATION = 'Costa Mesa, CA';
$SEARCH_LIMIT = 3;
$SEARCH_PATH = '/v2/search/';
$BUSINESS_PATH = '/v2/business/';
$SORT_BY = "1"; //sort by distance

/**
 * Makes a request to the Yelp API and returns the response
 *
 * @param    $host    The domain host of the API
 * @param    $path    The path of the APi after the domain
 * @return   The JSON response from the request
 */
function request($host, $path) {
    $unsigned_url = "https://" . $host . $path;

    // Token object built using the OAuth library
    $token = new OAuthToken($GLOBALS['TOKEN'], $GLOBALS['TOKEN_SECRET']);

    // Consumer object built using the OAuth library
    $consumer = new OAuthConsumer($GLOBALS['CONSUMER_KEY'], $GLOBALS['CONSUMER_SECRET']);

    // Yelp uses HMAC SHA1 encoding
    $signature_method = new OAuthSignatureMethod_HMAC_SHA1();

    $oauthrequest = OAuthRequest::from_consumer_and_token(
        $consumer,
        $token,
        'GET',
        $unsigned_url
    );

    // Sign the request
    $oauthrequest->sign_request($signature_method, $consumer, $token);

    // Get the signed URL
    $signed_url = $oauthrequest->to_url();

    // Send Yelp API Call
    try {
        $ch = curl_init($signed_url);
        if (FALSE === $ch)
            throw new Exception('Failed to initialize');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //inserted to avoid ssl error; sigh
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);

        if (FALSE === $data)
            throw new Exception(curl_error($ch), curl_errno($ch));
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (200 != $http_status)
            throw new Exception($data, $http_status);

        curl_close($ch);
    } catch(Exception $e) {
        trigger_error(sprintf(
            'Curl failed with error #%d: %s',
            $e->getCode(), $e->getMessage()),
            E_USER_ERROR);
    }
    return $data;
}

/**
 * Query the Search API by a search term and location
 *
 * @param    $term        The search term passed to the API
 * @param    $location    The search location passed to the API
 * @return   The JSON response from the request
 */
function search($term, $location, $lonlat) {

    $url_params = array();

    $url_params['term'] = $term ?: $GLOBALS['DEFAULT_TERM'];
    if($lonlat){
        $url_params['cll'] = $lonlat;
    }
    $url_params['location'] = $location?: $GLOBALS['DEFAULT_LOCATION'];
    $url_params['limit'] = $GLOBALS['SEARCH_LIMIT'];
    $url_params['sort'] = $GLOBALS['SORT_BY'];
    $search_path = $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);

    return request($GLOBALS['API_HOST'], $search_path);
}

/**
 * Query the Business API by business_id
 *
 * @param    $business_id    The ID of the business to query
 * @return   The JSON response from the request
 */
function get_business($business_id) {
   // print 'hey this id is '.$business_id;
    $business_path = $GLOBALS['BUSINESS_PATH'] . urlencode($business_id);

    return request($GLOBALS['API_HOST'], $business_path);
}

/**
 * Queries the API by the input values from the user
 *
 * @param    $term        The search term to query
 * @param    $location    The location of the business to query
 */
function query_api($term, $location, $coords) {
    //create output array
    $output = ['success' => false];
    $output['postData'] = $_POST;
    //ajax api request
    $response = isset($coords) ? json_decode(search($term, $location, $coords)): json_decode(search($term, $location, null)) ;
    //get the length business returned
    $output['bizcount'] = count($response->businesses);
    if($output['bizcount'] > 0){
        $output['success'] = true;
    }
    $output['userinfo']['coords'] = $coords;
    $output['userinfo']['loc'] = $location;
   // print_r($response->businesses[2]);
    $business_id = $response->businesses[0]->id; //get a business id from array
    //print_r(json_encode($response));
   // print sprintf(
//        "%d businesses found, querying business info for the top result \"%s\"\n\n",
//        count($response->businesses),
//        $business_id
//    );

    //
    for($i = 0; $i < $output['bizcount']; $i++){
            $output['tacostands'][$i] = json_decode(get_business($response->businesses[$i]->id));
        }
    //$response = get_business($business_id);
    //$output['options'] = $GLOBALS['options'];
    //print sprintf("Result for business \"%s\" found:\n", $business_id);
    print_r(json_encode($output));
}


$term = '';
$location = '';

$lat = '34.9178543';
$lon = '-117.1133961';
$zip = 'long beach';
$errorOut = ['success' => 'fail'];

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
    query_api($term,$zip, $ll);
}
else{
    $errorOut['error'] = 'no post data detected';
    $errorOut['data'] = $_POST;
    print_r(json_encode($errorOut));
}

?>