<?php

$url = $_POST["furl"];
$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://www.virustotal.com/api/v3/private/urls",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'url' => 'facebook.com'
  ]),
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "content-type: application/json",
    "x-apikey: 9c786184ee0b07f3f16436272314583f89cc76a011add8d9feeb75b0bc41600e"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}