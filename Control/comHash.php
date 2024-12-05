<?php
session_start();
include "../Model/conexaobd.php";

// Verifica se o e-mail do usuário está armazenado na sessão
if (!isset($_SESSION['email'])) {
    die("Usuário não autenticado.");
}

$email = $_SESSION['email']; // Captura o e-mail do usuário da sessão

// Busca o ID do usuário no banco de dados com base no e-mail
$sqlUsuario = "SELECT idusuario FROM usuario WHERE email = ?";
$stmtUsuario = $conexao->prepare($sqlUsuario);
$stmtUsuario->bind_param("s", $email);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();

if ($resultUsuario->num_rows > 0) {
    $row = $resultUsuario->fetch_assoc();
    $idusuario = $row['idusuario'];
} else {
    die("Usuário não encontrado.");
}

$stmtUsuario->close();

// Captura a data da consulta
$dataConsulta = date('Y-m-d H:i:s'); // Formato compatível com SQL
$fkidtipo = 4; // Valor fixo para o tipo

// Captura os arquivos enviados pelo formulário
$arq1 = $_FILES['arquivo1']['tmp_name'];
$arq2 = $_FILES['arquivo2']['tmp_name'];

// Calcula os hashes dos arquivos
$sha1 = hash('sha256', file_get_contents($arq1));
$sha2 = hash('sha256', file_get_contents($arq2));
$md51 = hash('md5', file_get_contents($arq1));
$md52 = hash('md5', file_get_contents($arq2));

// Determina o valor de 'valors' com base na comparação dos hashes
$valors = ($sha1 == $sha2 && $md51 == $md52) ? 0 : 1;

// Prepara o resultado para exibição
if ($valors == 0) {
    $resultado = "<strong>Arquivos são iguais</strong><br/><br/>Primeiro arquivo:<br/><strong>MD5:</strong> $md51 <br/><strong>SHA256:</strong> $sha1<br/><br/>Segundo arquivo:<br/><strong>MD5:</strong> $md52 <br/><strong>SHA256:</strong> $sha2";
} else {
    $resultado = "<strong>Arquivos são diferentes</strong><br/><br/>Primeiro arquivo:<br/><strong>MD5:</strong> $md51 <br/><strong>SHA256:</strong> $sha1<br/><br/>Segundo arquivo:<br/><strong>MD5:</strong> $md52 <br/><strong>SHA256:</strong> $sha2";
}

// Insere os dados no banco de dados
$sqlInserir = "INSERT INTO consSValor (fkidusuario, dataconsulta, fkidtipo, valors) VALUES (?, ?, ?, ?)";
$stmtInserir = $conexao->prepare($sqlInserir);

if ($stmtInserir) {
    $stmtInserir->bind_param("isii", $idusuario, $dataConsulta, $fkidtipo, $valors);
    if ($stmtInserir->execute()) {
        // Redireciona para a página de resultados com a mensagem
        header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
        exit();
    } else {
        echo "Erro ao inserir os dados: " . $stmtInserir->error;
    }
    $stmtInserir->close();
} else {
    echo "Erro ao preparar a consulta: " . $conn->error;
}

$conn->close();
?>
