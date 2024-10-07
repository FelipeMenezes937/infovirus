<?php
$api_key = "a01be194701967f1e8681056244a144ba6f1ecb8";
$email = $_GET['femail'];
$url = "https://leakcheck.io/api/public?key=$api_key&check=$email";

$response = file_get_contents($url);

$dados = json_decode($response, true);

if(!($dados['success'])){
    $resultado = "consultas excedidas :(";
}else{
$json_data = json_encode($dados);


file_put_contents('relatorio.json', $json_data);

echo "<pre>";
print_r($dados['found']);
echo "</pre>";
if(!($dados['found'] == 0)){
    $resultado = "email tem <strong>". $dados['found']." </strong> ocorrências, Confira os <a href='detalhes_email.php'>detalhes técnicos</a>" ;
}else{
    $resultado = "o email não tem ocorrências, tudo seguro por aqui..." ;

}}
header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
exit();
/* api_key1 = "25196145ef5ede904dbd8a5d0a098a9640377acc";
api_key2 = "a01be194701967f1e8681056244a144ba6f1ecb8"; */



 
