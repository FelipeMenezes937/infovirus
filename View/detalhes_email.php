<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/detemail.css">
    <title>Detalhes Técnicos</title>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php include 'header.php'; ?><br><br><br><br><br>
    <div class="title-container">
        <div class="title">DETALHES TÉCNICOS</div>
    </div>
    <div class="buttons-top">
        <button onclick="mostrarAlerta()" class="btn-oqfazer">O que fazer agora?</button>  
        <button onclick="window.history.back()" class="btn-voltar">Voltar</button> <!-- Botão Voltar -->
    </div>

<?php
// Lê o conteúdo do arquivo JSON
$file_path = '../Control/resultados.json';
$json_data = file_get_contents($file_path);

// Verifica se o arquivo JSON foi lido corretamente
if ($json_data === false) {
    echo "Erro ao ler o arquivo JSON.";
    exit();
}

// Decodifica o JSON
$array = json_decode($json_data, true);

// Exibe o conteúdo decodificado para depuração
/* echo '<pre>';
var_dump($array); // Aqui você verá toda a estrutura do JSON
echo '</pre>'; */

// Verifica se o JSON foi decodificado corretamente e se a chave 'result' existe
if ($array && isset($array[0]['result']) && is_array($array[0]['result'])) { 
    // Agora que a chave 'result' está no índice correto, vamos acessar o array de resultados
    $results = $array[0]['result']; // Obtém o array de resultados
  /*   echo $results; */
    // Exibe os resultados em uma tabela
    echo '<table class="source-table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Nome da Fonte</th>';
    echo '<th>Data do Vazamento</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Loop para exibir cada fonte e data de vazamento
    foreach ($results as $source) {
        // Acessando o nome da fonte e a data de vazamento
        $source_name = isset($source['source']['name']) ? $source['source']['name'] : 'Nome não disponível';
        $breach_date = isset($source['source']['breach_date']) ? ($source['source']['breach_date'] ?: 'Data não disponível') : 'Data não disponível';

        // Exibe cada linha na tabela
        echo '<tr>';
        echo '<td>' . htmlspecialchars($source_name) . '</td>';
        echo '<td>' . htmlspecialchars($breach_date) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    
} else {
    echo "Não foram encontrados dados válidos no arquivo JSON.";
}
?>

<script>
    function mostrarAlerta() {
        Swal.fire({
            title: 'Atenção!',
            text: 'Acesse a cartilha de segurança na aba "Vazamento de dados" ',
            icon: 'info',
            iconColor: '#03449e',
            confirmButtonText: 'Vamos!',
            confirmButtonColor: '#03449e', 
            showCancelButton: true, // Exibe o botão "Agora não"
            cancelButtonText: 'Agora não', // Texto do botão "Agora não"
            cancelButtonColor: '#999', // Cor do botão "Agora não"
        }).then((result) => {
            // Verifica se o usuário clicou no botão OK
            if (result.isConfirmed) {
                // Redireciona o usuário para a página da cartilha
                window.location.href = 'https://cartilha.cert.br/fasciculos/vazamento-de-dados/fasciculo-vazamento-de-dados.pdf';
            } else if (result.isDismissed) {
                // Aqui você pode adicionar a lógica para quando o usuário clicar em "Agora não"
                console.log("Usuário optou por 'Agora não'.");
            }
        });
    }
</script>

<?php include 'vlibras.php'; ?>
<?php include 'config.php'; ?>
<?php include 'footer.php'; ?> 

</body>
</html>
<?php
file_put_contents($file_path, "");
?>