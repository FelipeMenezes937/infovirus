<?php 
require_once 'session_start.php'; 
// Inicia a sessão para capturar o ID do usuário logado
include "../Model/conexaobd.php";

// Verifica se o usuário está logado, ou seja, se a sessão contém o ID do usuário
if (isset($_SESSION['email'])) {
    $ssemail = $_SESSION['email']; // Pega o email do usuário da sessão

    // Consulta ao banco de dados para pegar o nome do usuário baseado no email
    $query = "SELECT idUsuario, nome, email FROM Usuario WHERE email = ?";
    $stmt = $conexao->prepare($query); // Prepara a consulta
    $stmt->bind_param("s", $ssemail); // Substitui o ? pela variável $ssemail
    $stmt->execute(); // Executa a consulta
    $stmt->bind_result($idUsuario, $nome, $email); // Vincula os resultados
    $stmt->fetch(); // Obtém o resultado da consulta
    $stmt->close(); // Fecha a consulta
} 

// Consulta para contar as ocorrências de cada tipo de pesquisa nas tabelas conssvalor e conssretorno, filtrando pelo idUsuario
$query_counts = "
    SELECT
        t.idTipo,
        COUNT(DISTINCT cv.idConsSValor) AS count_cons,
        COUNT(DISTINCT cr.idConsSRetorno) AS count_ret
    FROM Tipo t
    LEFT JOIN conssvalor cv ON t.idTipo = cv.FKidTipo AND cv.FKidUsuario = ?
    LEFT JOIN conssretorno cr ON t.idTipo = cr.FKidTipo AND cr.FKidUsuario = ?
    GROUP BY t.idTipo
";

$stmt_counts = $conexao->prepare($query_counts);
$stmt_counts->bind_param("ii", $idUsuario, $idUsuario); // Substitui os ? pelo idUsuario
$stmt_counts->execute();
$stmt_counts->bind_result($idTipo, $count_cons, $count_ret);
$counts = [
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0
];

while ($stmt_counts->fetch()) {
    // Atualiza as contagens conforme o idTipo
    $counts[$idTipo] = $count_cons + $count_ret; // Soma o count de cons e retorno
}

$stmt_counts->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="css/user.css">
</head>
<body>
<?php require_once 'header.php'; // Inclui o cabeçalho ?>

<div class="main-user">
    <!-- Div Esquerda -->
    <div class="left-user"> 
        <div class="card-user"> 
            <div class="user-info">
                <ion-icon name="person-circle-outline"></ion-icon>
                <div>   
                    <!-- Exibe o nome do usuário recuperado do banco de dados -->
                    <h1><?php echo htmlspecialchars($nome); ?></h1> <!-- Exibe o nome do usuário -->
                    <p><?php echo htmlspecialchars($email); ?></p> <!-- Exibe o e-mail do usuário -->
                </div>
            </div>
            <div class="buttons">
                <!-- Botões para deslogar e alterar senha -->
                <a href="fecha_sessao.php"> <button class="btn">Deslogar</button> </a>
                <button class="btn">Alterar Senha</button>
            </div>
        </div>

        <div class="card-pesq"> 
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"> </script>
            <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Pesquisas', 'Já feitas'],
                    ['Arquivo', <?php echo $counts[1]; ?>],
                    ['URL', <?php echo $counts[3]; ?>],
                    ['Senha', <?php echo $counts[2]; ?>],
                    ['Porta', <?php echo $counts[6]; ?>],
                    ['Comparador', <?php echo $counts[4]; ?>],
                    ['Email', <?php echo $counts[5]; ?>]
                ]);

                var options = {
                    is3D: true, // Deixe como 3D ou altere para false, se preferir 2D
                    slices: {
                        0: { offset: 0.1, color: '#02569b' }, // Cor principal
                        1: { offset: 0.1, color: '#0372c7' }, // Azul mais claro
                        2: { offset: 0.1, color: '#023d73' }, // Azul mais escuro
                        3: { offset: 0.1, color: '#0379e0' }, // Tom intermediário
                        4: { offset: 0.1, color: '#81c4f7' }, // Azul claro pastel
                        5: { offset: 0.1, color: '#b8d9f9' }  // Azul suave
                    },
                    title: 'Pesquisas Feitas',
                    titleTextStyle: {
                        fontSize: 34, // Tamanho do título
                        fontName: 'sans-serif', // Fonte personalizada
                        bold: true,
                        color: '#000' // Cor do título
                    },
                    backgroundColor: '#f9f9f9',
                    pieSliceText: 'valor', // Exibe as porcentagens nas fatias
                    pieSliceTextStyle: {
                        color: '#fff', // Cor do texto dentro das fatias
                        fontSize: 16 // Tamanho da fonte do texto
                    },
                    legend: {
                        position: 'bottom', // Opção de legenda
                        maxLines: '4', // Opção de legenda
                        textStyle: {
                            color: '#000', // Cor do texto da legenda
                            fontSize: 10 // Tamanho da fonte da legenda
                        }
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                chart.draw(data, options);
            }
            </script>
            <div id="piechart_3d" style="width: 100%; height: 500px;"></div>
        </div>
    </div>
</div>

</body>
</html>







              <!--      <h2>Pesquisas Feitas</h2>
                    <div class="stats">
                        <p>Arquivo: 5</p>
                        <p>URL: 8</p>
                        <p>Senha: 3</p>
                        <p>Porta: 4</p>
                        <p>Comparador: 6</p>
                        <p>Email: 10</p> 
                    </div> -->
                </div>
            </div>
            <!-- Div Direita -->
            <div class="right-user" > 
                <h1>HISTÓRICO</h1>
                <!-- O histórico pode ser adicionado aqui, dependendo dos dados a serem exibidos -->
                <?php 
if (!isset($_SESSION['email'])) {
    die("Usuário não autenticado.");
}

// Obtém o email da sessão
$email = $_SESSION['email']; 

// Busca o idUsuario baseado no email
$sql_usuario = "SELECT idUsuario FROM Usuario WHERE email = ?";
$stmt_usuario = $conexao->prepare($sql_usuario);
$stmt_usuario->bind_param("s", $email); // Liga o parâmetro ao email
$stmt_usuario->execute();
$stmt_usuario->bind_result($idUsuario); // Armazena o id do usuário
$stmt_usuario->fetch();
$stmt_usuario->close();

if (!$idUsuario) {
    die("Usuário não encontrado no banco de dados.");
}

// Consulta para buscar os dados das consultas filtrando pelo idUsuario
$sql = "SELECT idConsSValor, dataConsulta, FKidTipo, FKidUsuario, valorS 
        FROM consSvalor 
        WHERE FKidUsuario = ? 
        ORDER BY idConsSValor ASC";

$stmt = $conexao->prepare($sql); // Prepara a consulta
$stmt->bind_param("i", $idUsuario); // Liga o parâmetro ao idUsuario
$stmt->execute(); // Executa a consulta

$result = $stmt->get_result(); // Obtém os resultados

if ($result->num_rows > 0) {
    echo "<ol>"; // Inicia uma lista ordenada
    while ($row = $result->fetch_assoc()) {
        echo "<li>
            <strong>Data da Consulta:</strong> {$row['dataConsulta']}<br/>
            <strong>ID Tipo:</strong> {$row['FKidTipo']}<br/>
            <strong>ID Usuário:</strong> {$row['FKidUsuario']}<br/>
            <strong>ValorS:</strong> {$row['valorS']}
        </li>";
    }
    echo "</ol>"; // Finaliza a lista ordenada
} else {
    echo "Nenhuma consulta encontrada.";
}

$stmt->close(); // Fecha a declaração
$conexao->close(); // Fecha a conexão
?>
            </div>
        </div>

        <?php include 'vlibras.php'; ?>
        <?php include 'config.php'; ?>
        <?php require_once 'footer.php'; ?>
    </body>
</html>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>