<?php
             require_once 'session_start.php'; 
        ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="darkmode/dark-mode.css">
        <title>Cabeçalho</title>
        
    </head>
    <body>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <header>
            <div class="logo">
                <a href="home.php"> 
                    <img class="hlogo-image" src="imagens/logo-clean.png">
                    <div class="logo-text"> 
                        <h1><i>INFO VIRUS</i></h1> 
                    </div>
            </a>
        </div>

        <nav class="nav-bar">
            <ul>
                <li>
                    <a href="head_cons.php">Conscientização</a>
                </li>
                <li>
                    <a href="head_sobre.php">Sobre nós</a>
                </li>
                <li>
                    <a href="#">API</a>
                    <div class="dropdown">
                        <ul>
                            <li><a href="https://www.virustotal.com/gui/home/upload" target="_blank">VIRUS TOTAL</a></li>
                            <li><a href="https://leakcheck.io/" target="_blank">LEAK CHECKER</a></li>
                            <li><a href="https://rapidapi.com/hub" target="_blank">HETRIX TOOLS</a></li>
                            <li><a href="https://haveibeenpwned.com/" target="_blank">HAVE I BEEN PWNED</a></li>
                            <li><a href="https://safebrowsing.google.com/" target="_blank">SAFE BROWSING</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>


        <?php if(!isset($_SESSION['email'])){?>
        <div class="buttons">
            <a href="login.php"> 
                <button class="btn-entrar" 
                        style="padding: 10px 20px; font-size: 15px; margin: 10px; border: none; border-radius: 100px; cursor: pointer; transition: transform 0.4s ease; background-color: #0349ae; color: white;" 
                        onmouseover="this.style.transform='scale(1.1)';" 
                        onmouseout="this.style.transform='scale(1)';">
                    Entrar
                </button> 
            </a>
            <a href="register.php"> 
                <button class="btn-cadastrar" 
                        style="padding: 10px 20px; font-size: 14px; margin: 10px; border: none; border-radius: 100px; cursor: pointer; transition: transform 0.4s ease; background-color: #0349ae; color: white;" 
                        onmouseover="this.style.transform='scale(1.1)';" 
                        onmouseout="this.style.transform='scale(1)';">
                    Cadastrar
                </button> 
            </a>
            <?php 
           }else{
            $user = "<a href='user.php'><ion-icon name='person-circle-sharp' class='user-icon'></ion-icon></a>";
            /* $boas_vindas = "<h2>Olá, " . $_SESSION['nome'] . "</h2>"; */
            echo $user;
        }?>
        </div>
    </header>

</body>
</html>
