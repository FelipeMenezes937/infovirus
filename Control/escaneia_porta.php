<?php
$MAC = exec('getmac');
$MAC = strtok($MAC, ' ');
function scan_portas($host, $portas, $tempo) {
    $portas_abertas = [];
    foreach ($portas as $porta) {
        $inicio = microtime(true); // Marca o tempo de início para cada porta
        $conexao = @fsockopen($host, $porta, $errno, $errstr, $tempo);
        $fim = microtime(true); // Marca o tempo de fim para cada porta
        $tempo_resposta = $fim - $inicio; // Calcula o tempo de resposta para cada porta

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
                                $path = str_replace("\\", "\\\\", $path); // Escapa as barras invertidas
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

$host = '127.0.0.1'; // localhost
$portas = [
    20, 21, 22, 23, 25, 53, 67, 68, 69, 80, 110, 119, 123, 143, 161, 162, 179, 194, 220, 443, 445, 465, 514, 515, 543, 546, 547, 587, 631, 636, 993, 995, 1025, 1026, 1027, 1433, 1434, 1521, 3000, 3306, 3389, 3690, 4333, 5432, 5900, 6379, 8080, 8443, 111, 135, 139, 2049, 3389, 5901, 5902, 5903, 5904, 5905, 5906, 5907, 5908, 5909, 5910, 5911, 5912, 5913, 5914, 5915, 5916, 5917, 5918, 5919, 5920, 5921, 5922, 5923, 5924, 5925, 5926, 5927, 5928, 5929, 5930, 5931, 5932, 5933, 5934, 5935, 5936, 5937, 5938, 5939, 5940, 5941, 5942, 5943, 5944, 5945, 5946, 5947, 5948, 5949, 5950, 5951, 5952, 5953, 5954, 5955, 5956, 5957, 5958, 5959, 5960, 5961, 5962, 5963, 5964, 5965, 5966, 5967, 5968, 5969, 6000
];

$tempo = 0.001;

$portas_abertas = scan_portas($host, $portas, $tempo);

// Construir o resultado
$resultado = "";

if (!empty($portas_abertas)) {
    foreach ($portas_abertas as $porta => $info) {
        $resultado .= "
       <strong> Porta   $porta: </strong> {$info['software']} (Versão: {$info['versao']}) \n";
    }
} else {


    $resultado = "Nenhuma porta aberta encontrada.\n";
}

// Redireciona para a página de resultados
header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
exit();
//(Tempo de resposta: " . round($info['tempo_resposta'], 4) . " segundos)