<?php

$curl=curl_init();
$params = array('grant_type'=>'password', 'username'=>'cbo1','password'=>'CBO2016@');
$url_params = http_build_query($params);
$url = 'http://bvr.zimrbf.org:8080/dhis/uaa/oauth/token';
$app_secret = 'QualityApp:59545823d-c0ff-dde5-7266-54e66e30dcd';

 curl_setopt($curl, CURLOPT_URL, $url);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($curl, CURLOPT_POST, 1);
 curl_setopt($curl, CURLOPT_POSTFIELDS, $url_params);
 curl_setopt($curl, CURLOPT_USERPWD, $app_secret);
 curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));


$result = curl_exec($curl);
curl_close($curl);
$json=  json_decode($result);
$token = $json->access_token;

$url = 'http://bvr.zimrbf.org:8080/dhis/api/organisationUnits.json';

$auth_code = "Authorization: Bearer $token";   

$curl=curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_code));

$result = curl_exec($curl);
curl_close($curl);
$json=  json_decode($result);

//echo $json->dataElements[0]->displayName;
echo $result;

//http://bvr.zimrbf.org:8080/dhis/api/organisationUnits.json?filter=level:eq:2&filter=parent.id:eq:uLFWBf4qXuv
?>

