<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

header("Content-Type: text/plain"); 

$virustotal_api_key = "9c786184ee0b07f3f16436272314583f89cc76a011add8d9feeb75b0bc41600e";

$file_to_scan =  $_FILES['arquivo']['tmp_name'];

$file_size_mb = filesize($file_to_scan)/1024/1024;

$file_hash = hash('sha256', file_get_contents($file_to_scan));

$report_url = 'https://www.virustotal.com/vtapi/v2/file/report?apikey='.$virustotal_api_key."&resource=".$file_hash;

$client = new Client();
$response = $client->request('GET', $report_url);
$api_reply = $response->getBody()->getContents();

$api_reply_array = json_decode($api_reply, true);

if($api_reply_array['response_code'] == -2){
    echo $api_reply_array['verbose_msg'];
}

if ($api_reply_array['response_code'] == 1) {
    $resultado = "Recebemos um relatório dos antivírus, houveram <strong>" . $api_reply_array['positives'] . "</strong> positivos encontrados. Confira os <a href='detalhes.php'>detalhes técnicos</a>.";
    
    setcookie('relatorio', serialize($api_reply_array['scans']), time() + 3600, "/"); 
    header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
    exit();
}

// [PART 2] se o arquivo n for encontrado a gnt manda o arquivo para relatório
if($api_reply_array['response_code'] == 0){

    $post_url = 'https://www.virustotal.com/vtapi/v2/file/scan';

    if($file_size_mb >= 32){
        $response = $client->request('GET', 'https://www.virustotal.com/vtapi/v2/file/scan/upload_url?apikey='.$virustotal_api_key);
        $api_reply = $response->getBody()->getContents();
        $api_reply_array = json_decode($api_reply, true);
        if(isset($api_reply_array['upload_url']) && $api_reply_array['upload_url'] != ''){
            $post_url = $api_reply_array['upload_url'];
        }
    }
    
    $response = $client->request('POST', $post_url, [
        'multipart' => [
            [
                'name'     => 'apikey',
                'contents' => $virustotal_api_key
            ],
            [
                'name'     => 'file',
                'contents' => fopen($file_to_scan, 'r')
            ]
        ]
    ]);

    $api_reply = $response->getBody()->getContents();
    $api_reply_array = json_decode($api_reply, true);

    header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
    exit();
}
?>
