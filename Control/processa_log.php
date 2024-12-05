<?php
session_start();
include('../Model/conexaobd.php');

// Verificar se os campos estão vazios
if (empty($_POST['email']) || empty($_POST["senha"])) {
    $_SESSION['mensagem_erro'] = "Preencha todos os campos!";
    header("Location: ../View/login.php");
    exit();
}

// Limpar os dados do formulário
$email = mysqli_real_escape_string($conexao, $_POST['email']);
$senha = mysqli_real_escape_string($conexao, md5($_POST['senha'])); // Criptografar a senha com md5

// Consulta para verificar se o usuário existe e se a senha está correta
$query = "SELECT * FROM usuario WHERE email = '{$email}' AND senha = '{$senha}'";
$result = mysqli_query($conexao, $query);

// Verificar se a consulta foi bem-sucedida
if (!$result) {
    die('Erro na consulta: ' . mysqli_error($conexao)); // Exibe erro detalhado
}

$row = mysqli_num_rows($result);

if ($row == 1) {
    $usuario = mysqli_fetch_assoc($result); 
    $_SESSION['email'] = $usuario['email']; // Armazenando o nome na sessão
    header('Location: ../View/home.php'); // Redirecionando para uma página pós-login
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Usuário ou senha inválidos!";
    header('Location: ../View/login.php'); // Volta para a página de login com a mensagem de erro
    exit();
}
?>