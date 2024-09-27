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
    <header>
        <div class="logo">
            <a href="home.php"> 
                <img id="hlogo-image" src="imagens/logo-clean.png" alt="logo_login" class="hlogo-image">
                <div class="logo-text"> 
                    <h1><i>INFO VIRUS</i></h1> 
                </div>
            </a>
        </div>

        <nav class="nav-bar">
            <ul>
                <li><a href="head_cons.php">Conscientização</a></li>
                <li><a href="head_sobre.php">Sobre nós</a></li>
                <li>
                    <a href="#">API</a>
                    <div class="dropdown">
                        <ul>
                            <li><a href="https://www.virustotal.com/gui/home/upload" target="_blank">Virus Total</a></li>
                            <li><a href="https://leakcheck.io/" target="_blank">Leak Checker</a></li>
                            <li><a href="https://rapidapi.com/hub" target="_blank">Rapid API</a></li>
                            <li><a href="https://haveibeenpwned.com/" target="_blank">Have i been pwned</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="buttons">
            <a href="login.php"> <button class="btn-entrar">Entrar</button> </a>
            <a href="register.php"> <button class="btn-cadastrar">Cadastrar</button> </a>
        </div>
    </header>
</body>
</html>
