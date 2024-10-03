<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="darkmode/dark-mode.css">
    <title>Cabeçalho</title>
    <style>
        /* CSS ajustado aqui */
        .nav-bar ul li {
            position: relative;
            display: inline-block;
        }

        .nav-bar ul li a {
            text-decoration: none;
            color: black; /* Cor inicial do texto */
            padding: 10px;
        }

        .nav-bar ul li a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 99%;
            height: 2px; /* Altura da linha */
            background: black; /* Cor da linha */
            transform: scaleX(0);
            transition: transform 0.5s ease;
        }

        .nav-bar ul li a:hover::after {
            transform: scaleX(1);
        }

        .nav-bar .dropdown {
            display: none; /* Esconde o submenu inicialmente */
            width: 600px;
            position: absolute;
            background: white; /* Fundo do submenu */
            border: 1px solid #ccc; /* Borda do submenu */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra para destaque */
            z-index: 1000; /* Certifique-se de que está acima de outros elementos */
            margin-top: 20px;
        }

            .nav-bar ul li:hover .dropdown {
                display: block; /* Mostra o submenu ao passar o mouse */
    }

        .dropdown ul {
            list-style: none; /* Remove os marcadores */
            padding: 0; /* Remove o padding */
            margin: 0; /* Remove a margem */
        }

        .dropdown ul li a {
           
            padding: 10px; /* Espaçamento interno */
            color: black; /* Cor do texto */
            text-decoration: none; /* Remove o sublinhado */
        }

        .dropdown ul li a:hover {
            background-color: #f0f0f0; /* Cor de fundo ao passar o mouse */
        }
    </style>
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
                            <li><a href="https://rapidapi.com/hub" target="_blank">HETRIXTOOLS</a></li>
                            <li><a href="https://haveibeenpwned.com/" target="_blank">HAVE I BEEN PWNED</a></li>
                            <li><a href="https://safebrowsing.google.com/" target="_blank">SAFE BROWSING</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>

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
        </div>
    </header>
</body>
</html>
