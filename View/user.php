<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="css/user.css">
    </head>
    <body>
        <?php require_once 'header.php'; ?>
        
</body>
<?php   $nomeUser = $_SESSION['nome']; echo 'nome do usuário: '.$nomeUser; ?>
<a href="home.php"><button type="submit" href="home.php">deslogar<?php 

?></button></a>
</html>
<?php include 'vlibras.php'; ?>
<?php include 'config.php'; ?>
<?php require_once 'footer.php'; ?>


<?php
function deslogar(){
    return $_SESSION['nome'] = "";
}
?>