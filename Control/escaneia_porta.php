<?php
session_start();
include "../Model/conexaobd.php";

// Obtém o MAC Address (opcional, caso necessário)
$MAC = exec('getmac');
$MAC = strtok($MAC, ' ');

// Função para escanear portas
function scan_portas($host, $portas, $tempo) {
    $portas_abertas = [];
    foreach ($portas as $porta) {
        $inicio = microtime(true);
        $conexao = @fsockopen($host, $porta, $errno, $errstr, $tempo);
        $fim = microtime(true);
        $tempo_resposta = $fim - $inicio;

        if (is_resource($conexao)) {
            $software_info = pega_nome_software($porta);
            $portas_abertas[$porta] = [
                'software' => $software_info['nome'],
                'versao' => $software_info['versao'],
                'tempo_resposta' => $tempo_resposta
            ];
            fclose($conexao);
        }
    }
    return $portas_abertas;
}

// Função para obter informações sobre o software
function pega_nome_software($porta) {
    $output = shell_exec("netstat -ano | findstr :$porta");
    if ($output) {
        $lines = explode("\n", $output);
        foreach ($lines as $line) {
            if (preg_match('/\s+(\d+)\s*$/', $line, $matches)) {
                $pid = $matches[1];
                $tasklist_output = shell_exec("tasklist /FI \"PID eq $pid\"");
                if ($tasklist_output) {
                    $tasklist_lines = explode("\n", $tasklist_output);
                    foreach ($tasklist_lines as $tasklist_line) {
                        if (strpos($tasklist_line, $pid) !== false) {
                            $columns = preg_split('/\s+/', $tasklist_line);
                            $nome_software = $columns[0] ?? 'Desconhecido';
                            $path_output = shell_exec("powershell -Command \"(Get-Process -Id $pid).Path\"");
                            $path = trim($path_output);
                            $versao = 'Desconhecido';
                            if ($path) {
                                $path = str_replace("\\", "\\\\", $path);
                                $versao_output = shell_exec("wmic datafile where name='$path' get Version /value");
                                if ($versao_output) {
                                    $versao_lines = explode("\n", $versao_output);
                                    foreach ($versao_lines as $versao_line) {
                                        if (strpos($versao_line, 'Version=') !== false) {
                                            $versao = trim(str_replace('Version=', '', $versao_line));
                                            break;
                                        }
                                    }
                                }
                            }
                            return ['nome' => $nome_software, 'versao' => $versao];
                        }
                    }
                }
            }
        }
    }
    return ['nome' => 'Desconhecido', 'versao' => 'Desconhecido'];
}

// Verifica se o e-mail do usuário está definido na sessão
if (!isset($_SESSION['email'])) {
    die("Usuário não autenticado.");
}

$email = $_SESSION['email'];

// Busca o ID do usuário no banco de dados com base no e-mail
$sqlUsuario = "SELECT idusuario FROM usuario WHERE email = ?";
$stmtUsuario = $conexao->prepare($sqlUsuario);
$stmtUsuario->bind_param("s", $email);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();

if ($resultUsuario->num_rows > 0) {
    $row = $resultUsuario->fetch_assoc();
    $fkidusuario = $row['idusuario'];
} else {
    die("Usuário não encontrado.");
}

$stmtUsuario->close();

// Configurações do scan
$host = '127.0.0.1';
$portas = [20, 21, 22, 23, 25, 53, 67, 68, 69, 80, 110, 119, 123, 143, 161, 162, 179, 194, 220, 443, 445, 465, 514, 515, 543, 546, 547, 587, 631, 636, 993, 995, 1025, 1026, 1027, 1433, 1434, 1521, 3000, 3306, 3389, 3690, 4333, 5432, 5900, 6379, 8080, 8443, 111, 135, 139, 2049, 3389, 5901];
$tempo = 0.001;

// Escaneia portas
$portas_abertas = scan_portas($host, $portas, $tempo);

// Construir o resultado
$resultado = "";

if (!empty($portas_abertas)) {
    foreach ($portas_abertas as $porta => $info) {
        $resultado .= "
       <strong> Porta $porta: </strong> {$info['software']} (Versão: {$info['versao']}) \n";
    }
} else {
    $resultado = "Nenhuma porta aberta encontrada.\n";
}

// Insere os dados no banco
$dataconsulta = date('Y-m-d H:i:s');
$idtipo = 6;

$sqlInserir = "INSERT INTO consSRetorno (fkidusuario, dataconsulta, fkidtipo) VALUES (?, ?, ?)";
$stmtInserir = $conexao->prepare($sqlInserir);

if ($stmtInserir) {
    $stmtInserir->bind_param("isi", $fkidusuario, $dataconsulta, $idtipo);
    if ($stmtInserir->execute()) {
        // Redireciona para a página de resultados com a mensagem
        header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
        exit();
    } else {
        echo "Erro ao inserir os dados: " . $stmtInserir->error;
    }
    $stmtInserir->close();
} else {
    echo "Erro ao preparar a consulta: " . $conexao->error;
}

$conexao->close();
?>
