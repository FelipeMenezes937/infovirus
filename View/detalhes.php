<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/detalhes.css">
    <title>Document</title>
</head>
<body>
    
    <?php include 'header.php'; ?><br><br><br><br><br>
    <div class="title">DETALHES TÉCNICOS</div>
<?php
// Verifica se o arquivo foi criado com sucesso
$json_data = file_get_contents('../Control/relatorio.json');

// Decodifica o JSON em um array associativo
$array = json_decode($json_data, true);
$scans = $array['scans'];

// Exibe os resultados em uma tabela
echo '<table class="scan-table">';
echo '<thead>';
echo '<tr>';
echo '<th>Antivírus</th>';
echo '<th>Detecção</th>';
echo '<th>Resultado</th>';
echo '<th>Atualização</th>';
echo '<th>Versão</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
foreach ($scans as $scanName => $scanDetails) {
    if($scanDetails['detected'] == 1){
        $scanDetails['detected'] = 'detectado';
    }else{
        $scanDetails['detected'] = 'não detectado';
    }


    echo '<tr>';
    echo '<td>' . htmlspecialchars($scanName) . '</td>';
    echo '<td>' . htmlspecialchars($scanDetails['detected']) . '</td>';
    echo '<td>' . htmlspecialchars($scanDetails['result']) . '</td>';
    echo '<td>' . htmlspecialchars($scanDetails['update']) . '</td>';
    echo '<td>' . htmlspecialchars($scanDetails['version']) . '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table><br><br><br>';
?>
<?php include 'vlibras.php'; ?>
<?php include 'config.php'; ?>
<?php include 'footer.php'; ?> 
</body>
</html>
