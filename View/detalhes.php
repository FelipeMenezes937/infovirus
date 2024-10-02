<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
 // Adicione uma verificação para ver todos os cookies disponíveis
print_r($_COOKIE);

if (isset($_COOKIE['relatorio'])) {
    $relatorio = unserialize($_COOKIE['relatorio']);
    
    // Verifique o conteúdo do array $relatorio após desserializar
    print_r($relatorio);
    
    // Exibindo os dados do array $relatorio
    echo "<h2>Relatório dos Antivírus</h2>";
    foreach ($relatorio as $banco => $dados) {
        echo "<strong>Banco:</strong> " . htmlspecialchars($banco, ENT_QUOTES, 'UTF-8') . "<br>";
        echo "<strong>Resultado:</strong> " . htmlspecialchars($dados['result'], ENT_QUOTES, 'UTF-8') . "<br><br>";
    }
} else {
    echo "Nenhum resultado disponível.";
}

    ?>
</body>
</html>