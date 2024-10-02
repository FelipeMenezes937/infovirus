<?php
$api_key = "25196145ef5ede904dbd8a5d0a098a9640377acc";
$email = $_GET['femail'];
$url = "https://leakcheck.io/api/public?key=$api_key&check=$email";

$response = file_get_contents($url);

if ($response === FALSE) {
    die('Ocorreu um erro ao realizar a solicitação');
}

$dados = json_decode($response, true);

// Exibe toda a resposta da API
echo "<pre>";
print_r($dados);
echo "</pre>";
$resultado = $dados;
header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
exit();
?>
