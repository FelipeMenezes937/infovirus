<?php
session_start();
include "../Model/conexaobd.php"; // Incluindo a conexão com o banco

$api_key = "515be629924a3ba0c1644febb76cca62c3044fd8";
$email = $_GET['femail'] ?? null;

// Verifica se o email foi fornecido
if (!$email) {
    echo "Erro: Email não fornecido.";
    exit();
}

// URL da API
$url = "https://leakcheck.io/api/v2/query/$email";

// Configuração do cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-API-Key: $api_key" // Cabeçalho correto para autenticação
]);

// Executa a requisição
$response = curl_exec($ch);
$error = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Verifica se houve erro na requisição
if ($response === false) {
    echo "Erro ao acessar a API: $error";
    exit();
}

// Verifica o código de resposta HTTP
if ($httpCode !== 200) {
    echo "Erro na API. Código de resposta HTTP: $httpCode";
    exit();
}

// Decodifica o JSON da API
$dados = json_decode($response, true);

// Verifica se a API retornou sucesso
if (!isset($dados['success']) || !$dados['success']) {
    echo "Problemas ao processar os dados da API.";
    exit();
}

// Caminho para o arquivo onde os resultados serão gravados
$file_path = './resultados.json'; 

// Verifica se o arquivo JSON já existe, e caso exista, atualiza os dados. Se não, cria o arquivo.
if (file_exists($file_path)) {
    // Lê o conteúdo atual do arquivo
    $existing_data = json_decode(file_get_contents($file_path), true);
    if ($existing_data) {
        // Adiciona os novos resultados ao arquivo existente
        $existing_data[] = $dados;  // Adiciona o novo resultado ao array
    } else {
        // Se o conteúdo do arquivo não for válido, cria um novo array
        $existing_data = [$dados];
    }
} else {
    // Se o arquivo não existir, cria um novo array
    $existing_data = [$dados];
}

// Grava os dados no arquivo JSON
if (file_put_contents($file_path, json_encode($existing_data, JSON_PRETTY_PRINT))) {
    echo "Dados gravados com sucesso no arquivo 'resultados.json'.<br>";
} else {
    echo "Erro ao gravar no arquivo 'resultados.json'.<br>";
}

// Processa o resultado da API
if ($dados['found'] > 0) {
    $resultado = "Email tem <strong>{$dados['found']}</strong> ocorrência(s). Confira os <a href='detalhes_email.php'>detalhes técnicos</a>.";
    $valorS = 1; // Email encontrado
} else {
    $resultado = "O email não tem ocorrências, tudo seguro por aqui...";
    $valorS = 0; // Email não encontrado
}
if (isset($_SESSION['email'])) {
   


    $userEmail = $_SESSION['email'];
    
    // Busca o ID do usuário no banco de dados
    $sql = "SELECT idUsuario FROM usuario WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    
    if (!$stmt) {
        echo "Erro ao preparar a consulta: " . $conexao->error;
        exit();
    }
    
    $stmt->bind_param("s", $userEmail);
    
    if (!$stmt->execute()) {
        echo "Erro ao executar a consulta: " . $stmt->error;
        $stmt->close();
        exit();
    }
    
    $stmt->bind_result($userId);
    $stmt->fetch();
    $stmt->close();
    
    // Verifica se o ID foi encontrado
    if (!$userId) {
        echo "Erro: Usuário não encontrado no banco de dados.";
        exit();
    }
    
    // Insere os dados da consulta no banco de dados
    $data = date('Y-m-d H:i:s'); // Data e hora atuais
    $idTipo = 5; // Valor fixo para idTipo
    
    $sqlInsert = "INSERT INTO ConsSValor (dataConsulta, fkidTipo, fkidUsuario, ValorS) VALUES (?, ?, ?, ?)";
    $stmtInsert = $conexao->prepare($sqlInsert);
    
    if (!$stmtInsert) {
        echo "Erro ao preparar a consulta de inserção: " . $conexao->error;
        exit();
    }
    
    $stmtInsert->bind_param("siii", $data, $idTipo, $userId, $valorS);
    
    if (!$stmtInsert->execute()) {
        echo "Erro ao inserir no banco de dados: " . $stmtInsert->error;
        $stmtInsert->close();
        exit();
    }
    
    $stmtInsert->close();
    
    // Redireciona para a página de resultado
    header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
    exit();
    }
?>
