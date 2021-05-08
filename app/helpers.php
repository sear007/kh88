<?php
if(!function_exists('fetchData')){
    function fetchData($fields){
    ksort($fields);
    $rawData = urldecode(http_build_query($fields,'', '&'));
    $hash = base64_encode(hash_hmac("sha1", $rawData, 'aghm1h6m9pqxy', TRUE));
	$signature = urlencode($hash);
	$url = "http://api688.net?AppID=TG9H&Signature=".$signature;
    $postData = json_encode($fields); 
    $curl = curl_init($url);                                                                      
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);                                                                  
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json')     
    ); 
    $data = curl_exec($curl);
    curl_close($curl);
    $response = new stdClass();
    $result = json_decode($data, true);
    return $result;
    }
}