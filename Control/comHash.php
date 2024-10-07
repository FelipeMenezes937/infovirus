<?php
$arq1 =  $_FILES['arquivo1']['tmp_name'];
$arq2 =  $_FILES['arquivo2']['tmp_name'];

$sha1 = hash('sha256', file_get_contents($arq1));
$sha2 = hash('sha256', file_get_contents($arq2));

$md51 = hash('md5', file_get_contents($arq1));
$md52 = hash('md5', file_get_contents($arq2));

echo $hash1;
echo "<br>";
echo $hash2;
echo "<br>";

if ($sha1 == $sha2 && $md51 == $md52){
    $resultado = "<strong>arquivos são iguais</strong><br/><br/> primeiro arquivo: <br/> <strong>md5:</strong> $md51 <br/> <strong>sha256:</strong>$hash1<br/><br/>segundo arquivo: <br/> <strong>md5:</strong> $md52 <br/> <strong>sha256:</strong>$sha2 ";
}else{ 
    $resultado = "<strong>arquivos são diferentes</strong><br/><br/> primeiro arquivo: <br/> <strong>md5:</strong> $md51 <br/> <strong>sha256:</strong>$hash1<br/><br/>segundo arquivo: <br/> <strong>md5:</strong> $md52 <br/> <strong>sha256:</strong>$sha2 ";
};

header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
exit();
?>