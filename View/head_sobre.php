<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/head_sobre.css">

    <title>Sobre Nós</title>
    <style>
    </style>
</head >
<body>
    <?php include 'header.php'; ?>
<div class="main-sobre">
 <div class="left-sobre">   
    <div class="container">
        <h2>    <b> SOBRE NÓS  </b> </h2>   
        <p>Somos um grupo de alunos da ETEC de Francisco Morato, apaixonados por tecnologia e inovação. No âmbito de nossos estudos, desenvolvemos um projeto que reflete nossa dedicação e habilidades: um site especializado na realização de verificações de vírus. Utilizando APIs avançadas, nosso site proporciona uma forma eficaz e confiável de identificar ameaças e garantir a segurança digital.</p>
        <br>
        <p>Combinamos conhecimentos em programação e segurança da informação para criar uma ferramenta que não só atende às necessidades atuais, mas também contribui para um ambiente online mais seguro. Nosso projeto é o resultado de muito trabalho em equipe, pesquisa e aprendizado, e tem como objetivo oferecer uma solução prática e acessível para a detecção de vírus em sites.</p>
        <br>
        <p>Estamos entusiasmados com a oportunidade de aplicar nossos conhecimentos em um projeto tão relevante e esperamos que nossa ferramenta possa ser útil para a comunidade. <br>
       </p>
    </div>
</div>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo de Legenda</title>
    <style>
        .foto {
            border-radius: 50%;
            object-fit: cover;
            transition: transform 0.6s; /*delay pra foto aumentar*/
            margin: 10px;
            position: relative;
        }
        .foto:hover {
            transform: scale(1.2); /*tamanho da foto*/ 
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
    <div class="right-sobre">
        <div class="fotos"> 
            <div class="foto-container">
                <img class="foto" src="imagens/felipe.jpeg" alt="Foto 1" height="220" width="220">
                <div class="legenda">Felipe Menezes</div>
            </div>

            <div class="foto-container">
                <img class="foto" src="imagens/kelvin.jpeg" alt="Foto 2" height="220" width="220">
                <div class="legenda">Kelvin Ruiz </div>
            </div>

            <div class="foto-container">
                <img class="foto" src="imagens/pinto.jpeg" alt="Foto 3" height="220" width="220">
                <div class="legenda">Davi Pinho</div>
            </div>
            <center>
            <div class="foto-container">
                <img class="foto" src="imagens/jeiso.jpeg" alt="Foto 4" height="220" width="220">
                <div class="legenda">Jeyson Alves</div>
            </div>

            <div class="foto-container">
                <img class="foto" src="imagens/mendes.jpeg" alt="Foto 5" height="220" width="220">
                <div class="legenda">Kauan Mendes</div>
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
