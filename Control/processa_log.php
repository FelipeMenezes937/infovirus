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
$query = "SELECT nome FROM usuario WHERE email = '{$email}' AND senha = '{$senha}'";
$result = mysqli_query($conexao, $query);
$row = mysqli_num_rows($result);

if ($row == 1) {
    $usuario = mysqli_fetch_assoc($result); 
    $_SESSION['nome'] = $usuario['nome']; // Armazenando o nome na sessão
    header('Location: ../View/home.php'); // Redirecionando para uma página pós-login
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Usuário ou senha inválidos!";
    header('Location: ../View/login.php'); // Volta para a página de login com a mensagem de erro
    exit();
}
?>
