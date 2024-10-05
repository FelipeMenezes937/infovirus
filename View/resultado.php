<?php
if(isset($_COOKIE['relatorio'])){
    echo 'cookie setado';
}else{
    echo 'cookie não setado';
}?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vírus Identificados</title>
    <link rel="stylesheet" href="css/resultado.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="alert-icon">
            <ion-icon name="warning-outline"></ion-icon>
        </div>
        <div class="title">
            <h1>RELATÓRIO</h1>
        </div>
        <p class="subtitle"> Analise os dados a seguir:</p>
        
        <div class="result-box">
            <?php
            if (isset($_GET['resultado'])) {
                // Exibe o resultado passado na URL
                echo nl2br($_GET['resultado'], ENT_QUOTES, );

            }
            ?>
        </div>
    </div>


    <?php include 'vlibras.php'; ?>
    <?php include 'config.php'; ?>
    <?php include 'footer.php'; ?> 

</body>
</html>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
