<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <title>infovirus</title>
</head>
<body>
    <?php require_once 'header.php'; ?>
    
    <div class="main-test">
        <div class="conteudo-test">
            <div class="text-test"> 
            <br> <br>    
            <div class="title"> SEGURANÇA ONLINE <br> </div>
           
                <div class="subtitle">Proteja seus dados com nossa segurança digital de ponta!</div>
            </div>
            

            
            
            <div class="content-area">
                <?php
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                        switch ($page) {
                            case 'arquivo':
                                include 'content-arquivo.php';
                                break;
                            case 'url':
                                include 'content-url.php';
                                break;
                            case 'senha':
                                include 'content-senha.php';
                                break;
                            case 'porta':
                                include 'content-porta.php';
                                break;
                            case 'comparador':
                                include 'content-comparador.php';
                                break;
                            case 'email':
                                include 'content-email.php';
                                break;
                            default:
                                include 'content-url.php'; // Padrão para URL
                                break;
                        }
                    } else {
                        include 'content-url.php'; // Padrão para URL
                    }
                ?>
            </div>
        </div>

        <?php
   
        $page = isset($_GET['page']) ? $_GET['page'] : 'url'; // Padrão é 'url'
        ?>

        <nav class="options">
    <a href="?page=arquivo" class="option-button <?php echo ($page == 'arquivo') ? 'active' : ''; ?>">Arquivo</a>
    <a href="?page=url" class="option-button <?php echo ($page == 'url') ? 'active' : ''; ?>">URL</a>
    <a href="?page=senha" class="option-button <?php echo ($page == 'senha') ? 'active' : ''; ?>">Senha</a>
    <a href="?page=porta" class="option-button <?php echo ($page == 'porta') ? 'active' : ''; ?>">Porta</a>
    <a href="?page=comparador" class="option-button <?php echo ($page == 'comparador') ? 'active' : ''; ?>">Comparador de Arquivos</a>
    <a href="?page=email" class="option-button <?php echo ($page == 'email') ? 'active' : ''; ?>">Email</a>
    
</nav>

<script>
const $loadingBtn = document.querySelector(".button-container");

$loadingBtn.addEventListener("click", (event) => {
  document.body.classList.add("loading");
});

</script>

<?php include 'vlibras.php'; ?>
<?php include 'config.php'; ?>
<?php require_once 'footer.php'; ?> 

</body>
</html>
