
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="darkmode/dark-mode.css">
    <title>Login</title>
</head>
<body>
<?php include 'header.php'; ?>
    <div class="main-login">
        <div class="left-login"> 
            <button id="toggle-dark-mode">Alternar Modo Escuro</button>
            <a href="home.php"> <img id="logo-image" src="imagens/logo-BfW.png" alt="logo_login" class="logoimage"> </a>
        </div>
        <div class="right-login"> 
            <div class="card-login"> 
                <h1>Login</h1> <br> <br>
                <!-- Verificação da mensagem de erro -->
                <?php
                session_start();
                if (isset($_SESSION['mensagem_erro'])) {
                    echo "<p style='color:red;'>" . $_SESSION['mensagem_erro'] . "</p>";
                    unset($_SESSION['mensagem_erro']); // Limpa a mensagem de erro após exibi-la
                }

                ?>
                <div class="social-login">
                    <li> <a href="#"> <ion-icon name="logo-facebook"> </ion-icon></a></li>
                    <li> <a href="#"> <ion-icon name="logo-google"> </ion-icon></a></li>
                    <li> <a href="#"> <ion-icon name="logo-linkedin"></ion-icon> </a></li>
                </div>
                <form action="../Control/processa_log.php" method="post">
                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="text" required name="email" id="email">
                    <label for="usuario"> Email </label>
                </div>
                <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" required name="senha" id="senha">
                    <label for=""> Senha </label>
                </div>
                <br>
                <center> <button class="btn-login" type="submit">Login</button> </center>
                </form>

                <div class="register">
                    <br>
                    <p> <a href="register.php"> Criar nova conta </a></p> 
                </div>
            </div>
        </div>
    </div>

    <script src="dark.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
    <?php include 'footer.php'; ?>
</body>
</html>
