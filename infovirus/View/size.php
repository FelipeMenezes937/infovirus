<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./css/?size.css">
</head>
<body>
    <div class="popup">
        tamanho da fonte
        <button onclick="alterarFonte('aumentar')">+</button>
        <button onclick="alterarFonte('diminuir')">-</button>
    </div>

    <script type="module">
        import alterarFonte from './font-size/main.js';
        window.alterarFonte = alterarFonte;
    </script>
</body>
</html>
