<?php
$furl = $_POST['furl'];
$apiKey = 'coloca a api key aqui paizao'; // Substitua pela sua chave de API
$apiEndpoint = 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . $apiKey;
$resultado;

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

$ch = curl_init($apiEndpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);

$response = curl_exec($ch);
curl_close($ch);

$responseData = json_decode($response, true);
if (isset($responseData['matches'])) {
    $vrul = " url: <strong>perigosa!</strong>";
} else {
    $vrul = " url: <strong>segura</strong>";
}
$resultado = $vssl ."<br>". $vrul;
echo $resultado;

/* 
urls fornecidas pela google para testar:
http://testsafebrowsing.appspot.com/s/malware.html
*/
?>
