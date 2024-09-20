<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <title>Seu Antivirus</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="main-test">
        <div class="conteudo-test">
            <div class="text-test"> 
                <div class="title"> SEU<br>ANTIVIRUS<br> </div>
                <div class="subtitle">Selecione a opção para verificar a presença de vírus.</div>
            </div>

            <!-- Aqui é onde o conteúdo será incluído dinamicamente -->
            <div class="content-area">
                <?php
                    // Verifica se o parâmetro 'page' foi passado na URL, e inclui o conteúdo correspondente
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
    // Verifica qual página está sendo passada na query string
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

    </div>

    

    <?php include 'footer.php'; ?>
</body>
</html>
