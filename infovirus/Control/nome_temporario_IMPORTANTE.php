<?php
    echo '<pre>';
   print_r($_FILES['arquivo']);
   echo '</pre>';
   echo '<br>Nome do Arquivo: '.$_FILES['arquivo']['name'];
   echo '<br>Caminho Temporário do Arquivo: '.$_FILES['arquivo']['tmp_name'];
   echo '<br>Tipo do Arquivo: '.$_FILES['arquivo']['type'];
   echo '<br>Tamanho do Arquivo: '.$_FILES['arquivo']['size'].' bytes';
?>