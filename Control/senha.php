<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

// Função para buscar dados da API usando Guzzle
function buscarDadosDaApi($caractereConsulta) {
    $client = new Client();
    $url = 'https://api.pwnedpasswords.com/range/' . $caractereConsulta;
    $response = $client->request('GET', $url);
    
    if ($response->getStatusCode() !== 200) {
        throw new RuntimeException('Erro ao buscar: ' . $response->getReasonPhrase());
    }
    
    return $response->getBody()->getContents();
}

function contarOcorrenciasDeSenha($hashes, $hashParaVerificar) {
    $linhas = explode("\n", trim($hashes));
    foreach ($linhas as $linha) {
        list($hash, $contagem) = explode(':', $linha);
        if ($hash === $hashParaVerificar) {
            return (int)$contagem;
        }
    }
    return 0;
}

function verificarSenhaNaApi($senha) {
    $sha1Senha = strtoupper(sha1($senha, false));
    $primeiros5Caracteres = substr($sha1Senha, 0, 5);
    $restante = substr($sha1Senha, 5);
    
    $resposta = buscarDadosDaApi($primeiros5Caracteres);
    return contarOcorrenciasDeSenha($resposta, $restante);
}

function processarDados($senha) {
    $contagem = verificarSenhaNaApi(trim($senha));
    
    if ($contagem) {
        return "A senha foi encontrada $contagem vez(es)... você provavelmente deve trocá-la.";
    } else {
        return "<strong>A senha não foi encontrada</strong>. Continue com segurança!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['fsenha'])) {
        $senha = $_POST['fsenha'];
        $resultado = processarDados($senha);
        // Redirecionar para a página de resultados com o resultado na URL
        header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
        exit();
    } else {
        $resultado = "Nenhuma senha foi fornecida.";
    }
} else {
    $resultado = "Método de solicitação inválido.";
}
?>

</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['fsenha'])) {
        $senha = $_POST['fsenha'];
        $resultado = processarDados($senha);
        // Redirecionar para a página de resultados com o resultado na URL
        header("Location: ../view/teste.php?resultado=" . urlencode($resultado));
        exit();
    } else {
        $resultado = "Nenhuma senha foi fornecida.";
    }
} else {
    $resultado = "Método de solicitação inválido.";
}
?>
