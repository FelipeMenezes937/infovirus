<?php
session_start();
include "../Model/conexaobd.php";
require 'vendor/autoload.php';
use GuzzleHttp\Client;

$furl = $_POST['furl'];
$apiKey = "AIzaSyAtoJrq4rufxtaYtkGs6jZWuii7p10EOAg";
$apiEndpoint = 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . $apiKey;
$resultado;

if (isset($apiKey) && $apiKey[0] == "A" && isset($furl)) {

    // Função para obter o domínio principal
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
        $vssl = "Host desconhecido: $hostname";
    }

    // Verificação SSL do domínio
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
                $vssl = " certificado ssl: <strong>não é válido (expirado)</strong>\n";
            } else {
                $vssl = " certificado ssl: <strong>válido</strong>\n";
            }
        } else {
            $vssl = " certificado ssl: <strong>não encontrado</strong>\n";
        }
    } else {
        echo "Erro ao conectar: $errstr ($errno)";
        exit;
    }

    // Definição do corpo da requisição para a API do Safe Browsing
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

    // Realiza a requisição para a API do Google Safe Browsing
    $client = new Client();
    $response = $client->request('POST', $apiEndpoint, [
        'headers' => ['Content-Type' => 'application/json'],
        'body' => $requestBody
    ]);

    $responseData = json_decode($response->getBody(), true);
    if (isset($responseData['matches'])) {
        $vrul = " url: <strong>perigosa!</strong>";
        $valorS = 1; // URL considerada perigosa
    } else {
        $vrul = " url: <strong>segura</strong>";
        $valorS = 0; // URL considerada segura
    }

    // Recupera o ID do usuário da sessão
    if (isset($_SESSION['email'])) {
        $userEmail = $_SESSION['email']; // Pega o email do usuário da sessão

        // Recupera o ID do usuário com base no email
        $sql = "SELECT idUsuario FROM usuario WHERE email = ?";
        
        if ($stmt = $conexao->prepare($sql)) {
            $stmt->bind_param("s", $userEmail); // 's' para string (email)

            if ($stmt->execute()) {
                $stmt->bind_result($userId);
                $stmt->fetch(); // Recupera o ID do usuário

                // Liberando os resultados
                $stmt->free_result();
                $stmt->close();

                // Verifica se o ID do usuário foi encontrado
                if ($userId) {
                    // Data da consulta
                    $data = date('Y-m-d H:i:s'); // Usando o formato correto de data e hora

                    // Define o idTipo como 3
                    $idTipo = 3;

                    // Consulta SQL para inserir os dados no banco de dados
                    $sqlInsert = "INSERT INTO ConsSValor (dataConsulta, fkidTipo, fkidUsuario, ValorS) VALUES (?, ?, ?, ?)";

                    // Preparando a consulta para inserção
                    if ($stmtInsert = $conexao->prepare($sqlInsert)) {
                        // Vinculando os parâmetros
                        $stmtInsert->bind_param("siii", $data, $idTipo, $userId, $valorS);

                        // Executando a consulta de inserção
                        if ($stmtInsert->execute()) {
                            $resultado = $vssl . "<br>" . $vrul;
                            // Redireciona para a página de resultado com a mensagem de retorno
                            header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
                            exit();
                        } else {
                            echo "Erro ao inserir no banco de dados: " . $stmtInsert->error;
                        }
                    } else {
                        echo "Erro ao preparar a consulta de inserção: " . $conexao->error;
                    }
                } else {
                    echo "Usuário não encontrado.";
                }
            } else {
                echo "Erro ao consultar ID do usuário: " . $stmt->error;
            }
        } else {
            echo "Erro ao preparar a consulta de busca do ID: " . $conexao->error;
        }
    } else {
        echo "Erro: O email do usuário não está encontrado na sessão.";
    }

} else {
    $resultado = "API key faltando";
    header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
    exit();
}
?>
