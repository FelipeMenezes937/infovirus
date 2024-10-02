<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=s, initial-scale=1.0">
    <link rel="stylesheet" href="css/head_cons.css">
    <title>Conscientização</title>
</head>
<body>
<?php include 'header.php'; ?>

    <div class="container">
    <br> <br> <br> 
        <h2> <b> Fascículos </b> </h2>  
        <p> Designamos esta página com o objetivo de conscientizar sobre o uso correto de dispositivos, garantindo que as pessoas estejam protegidas contra qualquer tipo de ataque digital. </p>
    
        <p> Exibiremos abaixo alguns dos principais fascículos que mostram diversos tipos de segurança digital: </p>
</div>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo de Legenda</title>
    <style>
        .foto {
            
            margin: 10px;
            object-fit: cover;
            transition: transform 0.6s; /*delay pra foto aumentar*/
            
            position: relative;
        }
        .foto:hover {
            transform: scale(1.1); /*tamanho da foto*/ 
        }
        .legenda {
            opacity: 0;
            transition: opacity 0.3s; /*velocidade da legenda */    
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-weight: bold;
        }
        .foto-container {
            position: relative;
            display: inline-block;
        }
        .foto-container:hover .legenda {
            opacity: 1;
        }
    </style>
</head>
<body>
<center>   
<div class="right-sobre">
        <div class="fotos"> 
        <a href="codigosmaliciosos.php"><div class="foto-container">
                <img class="foto" src="imagens/hacker.png" height="150" width="150">
                <div class="legenda">Códigos maliciosos</div>
            </div> </a>

            <a href="computadores">  <div class="foto-container">
                <img class="foto" src="imagens/computador.png" height="150" width="150">
                <div class="legenda">Computadores</div>
            </div></a>

            <a href="privacidade"> <div class="foto-container">
                <img class="foto" src="imagens/priv.png" height="150" width="150">
                <div class="legenda">Privacidade</div>
            </div></a>
          
            <a href="redes"> <div class="foto-container">
                <img class="foto" src="imagens/rede.png" height="150" width="150">
                <div class="legenda">Redes</div>
            </div></a>

            <a href="vazamentos"> <div class="foto-container">
                <img class="foto" src="imagens/vazamento.png" height="150" width="150">
                <div class="legenda">Vazamentos</div></a>
            </center>
            </div>
        </div>
    </div>
</body>
</html>



<?php include 'vlibras.php'; ?>
<?php include 'config.php'; ?>
<?php include 'footer.php'; ?> 


    </body>
</html>