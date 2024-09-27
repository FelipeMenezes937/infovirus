<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Registrar</title>
</head>
<body>
<?php include 'header.php'; ?>
    <div class="main-login">
        <div class="left-login"> 
            <a href="home.php"> <img id="logo-image" src="imagens/logo-Bsf.png" alt="logo_login"> </a>
        </div>
        
        <form method="post" action="../control/processa_reg.php">
            <div class="right-login"> 
                <div class="card-login"> 
                    <h1>Registrar</h1> <br> <br>

                    <!-- Exibição de mensagens de erro -->
                    <?php
                    if (isset($_SESSION['mensagem_erro'])) {
                        echo "<p style='color:red; text-align: center;'>" . $_SESSION['mensagem_erro'] . "</p>";
                        unset($_SESSION['mensagem_erro']);
                    }
                    ?>

                    <!-- Espaço para exibir a mensagem de erro de senha -->
                    <p id="erro-senha" style="color:red; text-align: center; display: none;">As senhas não coincidem!</p>
                    <p id="senhaFraca" style="color:red; text-align: center; display: none;"> ou senha muito fraca!</p>
                    <div class="inputbox">
                        <ion-icon name="person-outline"></ion-icon>
                        <input type="text" required name="fname" id="nome">
                        <label for="">Nome</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" required name="femail" id="email">
                        <label for="usuario">Email</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" required name="fsenha" id="senha">
                        <label for="">Senha</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" required name="fconfirma_senha" id="confirma_senha">
                        <label for="">Confirmar Senha</label>
                    </div>
                    <br>
                    
                    
                    
                    <div class="termos">
                        <label>  <input type="checkbox" name="termos" required> 
                     </label> <label> Eu concordo com os <a href="terms.php"> Termos de Uso </a> e autorizo o uso dos meus dados de acordo com a Política de Privacidade. </label>
                    </div>
                    
                    
                    
                    <br>
                    <button type="submit" class="btn-login">Registrar</button>
                    <div class="register">
                        <br>
                    <p> <a href="login.php"> Entrar </a></p>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- Validação do lado do cliente -->
    <script>
     document.querySelector('form').addEventListener('submit', function(event) {
        let senha = document.getElementById('senha').value;
        let confirmaSenha = document.getElementById('confirma_senha').value;
        let erroSenha = document.getElementById('erro-senha');
        let senhaFraca = document.getElementById('senhaFraca');
        let resultado = AnalisaSenha(senha)
        console.log(resultado)

        if (senha == confirmaSenha) {
            event.preventDefault(); // Impede o envio do formulário
            erroSenha.style.display = 'block'; // Exibe a mensagem de erro
        }
        if (resultado <= 2) {
            event.preventDefault(); // Impede o envio do formulário
            senhaFraca.style.display = 'block'; // Exibe a mensagem de erro
        }
        






    });
    </script>
    <?php include 'vlibras.php'; ?>
    <?php include 'config.php'; ?>
    <?php include 'footer.php'; ?> 
</body>
</html>




























<script>
    function AnalisaSenha(senha){

let pontos = 0;
let smb = /\W|_/; // todos os caracteres não alfanuméricos
let classe
if(senha.length >= 8){
    pontos += 0;
}

if(/[a-z]/.test(senha)){
    pontos++
}

if(/[A-Z]/.test(senha)){
    pontos++
}

if(/[0-9]/.test(senha)){
    pontos++
}

if(smb.test(senha)){
    pontos++
}

if(senha.length < 5 || senha.includes("12345") || senha.includes("123456") || senha.includes("1234567") ){
    pontos -= 2;
    }

    function Sequencia(str) {
        const primeiroChar = str[0];

        for (let i = 1; i < str.length; i++) { // Começa do segundo caractere
            if (str[i] !== primeiroChar) {
                return false; // Se encontrar um diferente, retorna falso
            }
        }
        return true; // Se todos forem iguais, retorna verdadeiro
    }


if(Sequencia(senha)){
    pontos = 0;
}

/* switch(pontos){
    case 0: 
        classe = "sua senha é muito fraca";
        break;
    case 1: 
        classe = "sua senha é fraca";
        break;
    case 2: 
        classe = "sua senha é comum";
        break;
    case 3: 
        classe = "sua senha é boa";
        break;
    case 4: 
        classe = "sua senha é muito boa";
        break;
} */


return pontos;
}
</script>