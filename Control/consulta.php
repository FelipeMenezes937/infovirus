<?php

// Defina o e-mail que você deseja consultar
$email = $_GET["femail"];

// Codifique o e-mail para incluir na URL
$emailCodificado = urlencode($email);

// Construa a URL da API
$apiUrl = "https://email-forensics-investigation-api.p.rapidapi.com/url/?url=" . $emailCodificado;

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: email-forensics-investigation-api.p.rapidapi.com",
        "x-rapidapi-key: 9c00ef27a8msh58a8545856f98b9p12b9d9jsn221e89fcb072"
    ],
]);

$resposta = curl_exec($curl);
$erro = curl_error($curl);

curl_close($curl);

if ($erro) {
    echo "Erro cURL #:" . $erro;
}
$dados = json_decode($resposta, true);

    // Verifique se a decodificação foi bem-sucedida
    if (json_last_error() === JSON_ERROR_NONE) {
        // Formate e exiba a resposta
        echo "<h1>Resultado da Investigação</h1>";
        echo "<pre>";
        print_r($dados); 
        echo "</pre>";

        // echo "<p><strong>Status:</strong> " . htmlspecialchars($dados['status']) . "</p>";
        // echo "<p><strong>Detalhes:</strong> " . htmlspecialchars($dados['details']) . "</p>";
    } else {
        echo "Erro ao decodificar JSON: " . json_last_error_msg();
    }

?>
