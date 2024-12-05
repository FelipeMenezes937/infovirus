<?php
session_start();
include "../Model/conexaobd.php";
require 'vendor/autoload.php';

use GuzzleHttp\Client;

// Verifica se o e-mail do usuário está definido na sessão
if (!isset($_SESSION['email'])) {
    die("Usuário não autenticado.");
}

$email = $_SESSION['email']; // Obtém o e-mail do usuário da sessão

// Busca o ID do usuário no banco de dados com base no e-mail
$sqlUsuario = "SELECT idusuario FROM usuario WHERE email = ?";
$stmtUsuario = $conexao->prepare($sqlUsuario);
$stmtUsuario->bind_param("s", $email);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();

if ($resultUsuario->num_rows > 0) {
    $row = $resultUsuario->fetch_assoc();
    $fkidusuario = $row['idusuario'];
} else {
    die("Usuário não encontrado.");
}

$stmtUsuario->close();

// Captura a data da consulta
$dataconsulta = date('Y-m-d H:i:s');
$fkidtipo = 1; // Valor fixo para o tipo

// Configuração do VirusTotal
$virustotal_api_key = "9c786184ee0b07f3f16436272314583f89cc76a011add8d9feeb75b0bc41600e";
$file_to_scan = $_FILES['arquivo']['tmp_name'];
$file_size_mb = filesize($file_to_scan) / 1024 / 1024;
$file_hash = hash('sha256', file_get_contents($file_to_scan));

// Verifica se o arquivo já está no banco do VirusTotal
$report_url = "https://www.virustotal.com/vtapi/v2/file/report?apikey=$virustotal_api_key&resource=$file_hash";

$client = new Client();
$response = $client->request('GET', $report_url);
$api_reply = $response->getBody()->getContents();
$api_reply_array = json_decode($api_reply, true);

// Determina o resultado com base na resposta do VirusTotal
if ($api_reply_array['response_code'] == 1) {
    // O arquivo foi encontrado no banco
    if ($api_reply_array['positives'] == 0) {
        $resultado = "O arquivo não consta em nenhum banco, <strong>é seguro</strong>.";
        $valors = 0;
    } else {
        $resultado = "Recebemos um relatório dos antivírus, houveram <strong>" . $api_reply_array['positives'] . "</strong> positivos encontrados. Confira os <a href='detalhes.php'>detalhes técnicos</a>. <br/> O arquivo é <strong>perigoso</strong>.";
        $valors = 1;
    }
} elseif ($api_reply_array['response_code'] == 0) {
    // O arquivo não foi encontrado no banco
    $resultado = "O arquivo não consta em nenhum banco, <strong>é seguro</strong>.";
    $valors = 0;

    // Realiza o upload do arquivo para o VirusTotal
    $post_url = 'https://www.virustotal.com/vtapi/v2/file/scan';

    if ($file_size_mb >= 32) {
        $response = $client->request('GET', "https://www.virustotal.com/vtapi/v2/file/scan/upload_url?apikey=$virustotal_api_key");
        $api_reply = $response->getBody()->getContents();
        $api_reply_array = json_decode($api_reply, true);
        if (isset($api_reply_array['upload_url']) && $api_reply_array['upload_url'] != '') {
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
}

// Insere os dados no banco de dados
$sqlInserir = "INSERT INTO consSValor (fkidusuario, dataconsulta, fkidtipo, valors) VALUES (?, ?, ?, ?)";
$stmtInserir = $conexao->prepare($sqlInserir);

if ($stmtInserir) {
    $stmtInserir->bind_param("isii", $fkidusuario, $dataconsulta, $fkidtipo, $valors);
    if ($stmtInserir->execute()) {
        // Redireciona para a página de resultados com a mensagem
        header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
        exit();
    } else {
        echo "Erro ao inserir os dados: " . $stmtInserir->error;
    }
    $stmtInserir->close();
} else {
    echo "Erro ao preparar a consulta: " . $conexao->error;
}

$conn->close();
?>
