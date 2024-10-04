<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

$furl = $_POST['furl'];
$apiKey = '';
$apiEndpoint = 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . $apiKey;
$resultado;

if(isset($api_key) && $api_key[1] === "A"){
function getMainDomain($url) {
    $url = preg_replace('/^https?:\/\//', '', $url);
    $url = explode('/', $url)[0];
    $parts = explode('.', $url);
    if (count($parts) > 2) {
        $url = implode('.', array_slice($parts, -2));
    }
    return $url;
}

$hostname = getMainDomain($furl);
$port = 443;

// Verificar se o hostname pode ser resolvido
if (gethostbyname($hostname) == $hostname) {
    echo "Host desconhecido: $hostname";
    exit;
}

$context = stream_context_create([
    "ssl" => [
        "capture_peer_cert" => true,
        "verify_peer" => false,
        "verify_peer_name" => false,
    ],
]);

$client = @stream_socket_client("ssl://{$hostname}:{$port}", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context);

if ($client) {
    $cont = stream_context_get_params($client);
    if (isset($cont["options"]["ssl"]["peer_certificate"])) {
        $cert = openssl_x509_parse($cont["options"]["ssl"]["peer_certificate"]);
        
        $currentDate = time();
        if ($currentDate > $cert['validTo_time_t']) {
            $vssl = " certificado ssl: <strong> não é válido (expirado)</strong>\n";
        } else {
            $vssl = " certificado ssl: <strong> válido </strong>\n";    
        }
    } else {
        $vssl = " certificado ssl: <strong>não encontrado</strong>\n";
    }
} else {
    echo "Erro ao conectar: $errstr ($errno)";
    exit;
}

$requestBody = json_encode([
    'client' => [
        'clientId' => 'yourcompanyname',
        'clientVersion' => '1.5.2'
    ],
    'threatInfo' => [
        'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING'],
        'platformTypes' => ['ANY_PLATFORM'],
        'threatEntryTypes' => ['URL'],
        'threatEntries' => [
            ['url' => $furl]
        ]
    ]
]);

$client = new Client();
$response = $client->request('POST', $apiEndpoint, [
    'headers' => ['Content-Type' => 'application/json'],
    'body' => $requestBody
]);

$responseData = json_decode($response->getBody(), true);
if (isset($responseData['matches'])) {
    $vrul = " url: <strong>perigosa!</strong>";
} else {
    $vrul = " url: <strong>segura</strong>";
}
$resultado = $vssl ."<br>". $vrul;
echo $resultado;

header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
exit();

/* 
urls fornecidas pela google para testar:
http://testsafebrowsing.appspot.com/s/malware.html
*/
}else{
    $resultado = "coloca a api key paizao"; 
    header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
exit();
}
?>
