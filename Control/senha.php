<?php

// Função para buscar dados da API
function buscarDadosDaApi($caractereConsulta) {
    $url = 'https://api.pwnedpasswords.com/range/' . $caractereConsulta;
    $ch = curl_init($url);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resposta = curl_exec($ch);
    
    if (curl_errno($ch)) {
        throw new RuntimeException('Erro ao buscar: ' . curl_error($ch));
    }
    
    curl_close($ch);
    return $resposta;
}

// Função para contar as ocorrências da senha
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
        return "A senha não foi encontrada. Continue com segurança!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['fsenha'])) {
        $senha = $_POST['fsenha'];
        $resultado = processarDados($senha);
    } else {
        $resultado = "Nenhuma senha foi fornecida.";
    }
} else {
    $resultado = "Método de solicitação inválido.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Verificação</title>
</head>
<body>
    <h1>Resultado da Verificação de Senhas</h1>
    <p><?php echo htmlspecialchars($resultado, ENT_QUOTES, 'UTF-8'); ?></p>
    <a href="form.html">Voltar</a>
</body>
</html>
