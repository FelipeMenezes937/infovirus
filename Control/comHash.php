<?php
$arq1 =  $_FILES['arquivo1']['tmp_name'];
$arq2 =  $_FILES['arquivo2']['tmp_name'];

$hash1 = hash('sha256', file_get_contents($arq1));
$hash2 = hash('sha256', file_get_contents($arq2));

echo $hash1;
echo "<br>";
echo $hash2;
echo "<br>";

if ($hash1 == $hash2){
    $resultado = "arquivos são iguais";
}else{ 
    $resultado = "arquivos diferentes";
};

header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
exit();
?>