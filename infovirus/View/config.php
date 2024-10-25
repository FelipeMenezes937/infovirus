<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações</title>
    <link rel="stylesheet" href="css/config.css">
    <link rel="stylesheet" href="darkmode/dark-mode.css"> <!-- Link do CSS do modo escuro -->
</head>
<body>
    <!-- Ícone de configurações -->
    <div id="config-icon"><ion-icon name="settings-outline"></ion-icon></div>

    <!-- Popup de configurações -->
    <div id="config-popup">
        <div>
            Tamanho da fonte
            <button onclick="alterarFonte('aumentar')">Aumentar</button>
            <button onclick="alterarFonte('diminuir')">Diminuir</button>
        </div>
        Modo Escuro
        <button id="toggle-dark-mode">Alterar</button>
    </div>

    <!-- Função de alterar fonte -->
    <script type="text/javascript">
        function alterarFonte(acao) {
            const elementos = document.querySelectorAll('*');
            elementos.forEach(elemento => {
                let tamanhoAtual = parseFloat(window.getComputedStyle(elemento, null).getPropertyValue('font-size'));
                if (acao === 'aumentar') {
                    tamanhoAtual += 1;
                } else if (acao === 'diminuir') {
                    tamanhoAtual -= 1;
                }
                elemento.style.fontSize = tamanhoAtual + 'px';
            });
        }

        // Função para alternar a visibilidade do popup
        document.getElementById('config-icon').addEventListener('click', () => {
            const popup = document.getElementById('config-popup');
            popup.style.display = popup.style.display === 'none' ? 'block' : 'none';
        });

        // Função para alterar as imagens com base no modo
        function alterarImagensParaModoEscuro() {
            const logoImage = document.getElementById('logo-image');
            const headerLogoImage = document.getElementById('hlogo-image');

            if (document.body.classList.contains('dark-mode')) {
                if (logoImage) logoImage.src = "imagens/logo-WfDk.png"; // Logo do modo escuro no corpo
                if (headerLogoImage) headerLogoImage.src = "imagens/logoc-WfG.png"; // Logo do modo escuro no header
            } else {
                if (logoImage) logoImage.src = "imagens/logo-Bsf.png"; // Logo do modo claro no corpo
                if (headerLogoImage) headerLogoImage.src = "imagens/logoc-BfW.png"; // Logo do modo claro no header
            }
        }

        // Função para alternar o modo escuro
        document.getElementById('toggle-dark-mode').addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            
            // Atualiza as imagens quando o modo é alterado
            alterarImagensParaModoEscuro();

            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled'); // Salva no localStorage
            } else {
                localStorage.setItem('darkMode', 'disabled'); // Salva no localStorage
            }
        });

        // Verifica o estado do modo escuro ao carregar a página e ajusta as imagens
        document.addEventListener('DOMContentLoaded', function() {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'enabled') {
                document.body.classList.add('dark-mode');
            }
            
            // Atualiza as imagens com base no estado do modo
            alterarImagensParaModoEscuro();
        });
    </script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
