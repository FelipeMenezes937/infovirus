<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/detalhes.css">
        <title>Document</title>
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <?php include 'header.php'; ?><br><br><br><br><br>
    <div class="title">DETALHES TÉCNICOS</div>
    <button onclick="mostrarAlerta()" class="btn-oqfazer">O que fazer agora?</button>    
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
    if ($scanDetails['detected'] == 1) {
        $scanDetails['detected'] = '<div class="detec">detectado</div>';
    } else {
        $scanDetails['detected'] = "<div class='ndetec'>não encontrado</div>";
    }


    if($scanDetails['result'] == ""){
        $scanDetails['result'] = "<div class='nfound'>não encontrado</div>";
    }

    echo '<tr>';
echo '<td>' . $scanName . '</td>';  // Sem htmlspecialchars para exibir o conteúdo diretamente
echo '<td>' . $scanDetails['detected'] . '</td>';  // Sem htmlspecialchars para exibir HTML
echo '<td>' . $scanDetails['result'] . '</td>';  // Sem htmlspecialchars para exibir HTML
echo '<td>' . $scanDetails['update'] . '</td>';  // Sem htmlspecialchars para exibir o texto normalmente
echo '<td>' . $scanDetails['version'] . '</td>';  // Sem htmlspecialchars para exibir o texto normalmente
echo '</tr>';
}
echo '</tbody>';
echo '</table><br><br><br>';

?>

<script>
    
    function mostrarAlerta() {
        Swal.fire({
            title: 'Atenção!',
            text: 'Acesse a cartilha de segurança na aba "Malware" ',
            icon: 'info',
            confirmButtonText: 'Vamos!',
            showCancelButton: true, // Exibe o botão "Agora não"
            cancelButtonText: 'Agora não', // Texto do botão "Agora não"
            cancelButtonColor: '#d33', // Cor do botão "Agora não"
        }).then((result) => {
            // Verifica se o usuário clicou no botão OK
            if (result.isConfirmed) {
                // Redireciona o usuário para a página da cartilha
                window.location.href = 'https://cartilha.cert.br/fasciculos/codigos-maliciosos/fasciculo-codigos-maliciosos.pdf';
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
