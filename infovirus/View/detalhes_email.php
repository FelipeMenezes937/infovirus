<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/detemail.css">
    <title>Document</title>
</head>
<body>
    
    <?php include 'header.php'; ?><br><br><br><br><br>
    <div class="title">DETALHES TÉCNICOS</div>
<?php
// Verifica se o arquivo foi criado com sucesso
/* $json_data = file_get_contents('../Control/relatorio.json'); */

// Decodifica o JSON em um array associativo
$json_data = file_get_contents('../Control/relatorio.json');
  $array = json_decode($json_data, true);
  $sources = $array['sources'];
  
  // Exibe os resultados em uma tabela
  echo '<table class="source-table">';
  echo '<thead>';
  echo '<tr>';
  echo '<th>Nome da Fonte</th>';
  echo '<th>Data</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  
  foreach ($sources as $source) {
      echo '<tr>';
      echo '<td>' . htmlspecialchars($source['name']) . '</td>';
      echo '<td>' . htmlspecialchars($source['date'] ? $source['date'] : 'Data não disponível') . '</td>';
      echo '</tr>';
  }
  
  echo '</tbody>';
  echo '</table>';
  
echo '</tbody>';
echo '</table><br><br><br>';
?>
<?php include 'vlibras.php'; ?>
<?php include 'config.php'; ?>
<?php include 'footer.php'; ?> 
</body>
</html>
