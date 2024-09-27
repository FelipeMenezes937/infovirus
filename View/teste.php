<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vírus Identificados</title>
    <link rel="stylesheet" href="css/teste.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="alert-icon">
            <ion-icon name="warning-outline"></ion-icon>
        </div>
        <div class="tittle">
            <h1>RELATÓRIO</h1>
        </div>
        <p class="subtitle">analise os dados a seguir:</p>
        
        <div class="result-box">
            <?php
            if (isset($_GET['resultado'])) {
                // Exibe o resultado passado na URL
                echo nl2br(htmlspecialchars($_GET['resultado'], ENT_QUOTES, 'UTF-8'));
            } else {
                echo "Nenhum resultado disponível.";
            }
            ?>
        </div>
        <?php include 'size.php'; ?>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
