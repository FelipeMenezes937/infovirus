document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggle-dark-mode');
    const logoImage = document.getElementById('logo-image');

    toggleButton.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        if (document.body.classList.contains('dark-mode')) {
            logoImage.src = "imagens/logo-WfG.png"; // Altere o caminho para o logotipo escuro
        } else {
            logoImage.src = "imagens/logo-BfW.png"; // Altere o caminho para o logotipo claro
        }
    });
});
