<?php
session_start();
include "../Model/conexaobd.php";

// Verificando se todos os campos obrigatórios foram preenchidos
if (empty($_POST['fname']) || empty($_POST['femail']) || empty($_POST['fsenha']) || empty($_POST['fconfirma_senha'])) {
    $_SESSION['mensagem_erro'] = "Por favor, preencha todos os campos.";
    header("Location: ../View/register.php");
    exit();
}

// Verificando se as senhas coincidem
if ($_POST['fsenha'] != $_POST['fconfirma_senha']) {
    $_SESSION['mensagem_erro'] = "As senhas não coincidem.";
    header("Location: ../View/register.php");
    exit();
}

// Verificando se a checkbox de termos foi marcada
if (!isset($_POST['termos'])) {
    $_SESSION['mensagem_erro'] = "Você deve aceitar os termos e condições.";
    header("Location: ../View/register.php");
    exit();
}

$nome = mysqli_real_escape_string($conexao, trim(str_replace ("'", "", ($_POST['fname']))));
$email = mysqli_real_escape_string($conexao, trim(str_replace("'","", ($_POST['femail']))));
$senha = mysqli_real_escape_string($conexao, md5(trim(str_replace("'","", $_POST['fsenha']))));

// Verificando se o usuário já está registrado
$sql = "SELECT COUNT(*) AS total FROM usuario WHERE email = '$email'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] == 1) {
    $_SESSION['usuario_existe'] = true;
    $_SESSION['mensagem_erro'] = "Usuário já registrado.";
    header("Location: ../View/register.php");
    exit();
}

// Inserindo o novo usuário no banco de dados
$sql = "INSERT INTO usuario (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

if ($conexao->query($sql) === TRUE) {
    $_SESSION['status_cadastro'] = true;
    header('Location: ../View/login.php');
    $conexao->close();
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Erro ao cadastrar usuário.";
    header("Location: ../View/register.php");
    $conexao->close();
    exit();
}


?>
