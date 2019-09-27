<?php

$curl = curl_init();

$clientId="AdUXfl1sBpAcilku_H0KZXPjLCas-FXlCl95n5ILs0rUs0lC_O-zom_TU-wcZC48ZFOgPCCQYjPQ_R5q";
$secret="EPav8MSHtb7NyxdQEQDLZcdAR0YMAZqGlIXg0OnEWYImTckgSKAywtrciUwCEfmi-92beQVowI4SlJc5";

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/oauth2/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "grant_type=client_credentials",
  CURLOPT_USERPWD => $clientId .":". $secret,
  CURLOPT_HEADER => false,
  CURLOPT_HTTPHEADER => array(
    "Accept: application/json",
    "Accept-Language: en_US",
   
   ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "<pre>cURL Error #:" . $err . "</pre>";
} else {
  
  $response = json_decode($response);
  
  $access_token = $response->access_token;
// echo $access_token;

  $_SESSION['access_token'] = $access_token;
  
}



// client token 


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/identity/generate-token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HEADER => false,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "prefer:return=representation",
    "Authorization: Bearer " . $_SESSION['access_token']
  ),
  )
);

$response = curl_exec($curl);
$err = curl_error($curl);
$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);

if ($err) {
  echo "<pre>cURL Error #:" . $err . "</pre>";
  echo $httpcode . $response;

}
else{
  $response= json_decode($response);
  $client_token= $response->client_token;
  $_SESSION['access_token'] = $access_token;
  // echo  $client_token;

}