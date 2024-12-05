<form action="../control/testa_virus.php" method="post" enctype="multipart/form-data">

<div class="upload-box">
    <label class="upload-btn">
        ESCOLHA UM ARQUIVO
        <input type="file" class="file-input" name="arquivo" required id="fileInput" required/>
        
    </label>

    <div id="fileName" class="file-name"></div>
    
    <div class="upload-icon">
        <ion-icon name="document-outline"></ion-icon>
    </div>
    <p>ou</p>
    <p>Arraste o arquivo que você gostaria de selecionar para que possamos realizar a verificação quanto à presença de vírus.</p>

    <!-- Exibe o nome do arquivo selecionado -->
    <div id="fileName" class="file-name"></div>
</div>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<div class="button-container">
    <button type="submit" class="test-button">Testar</button>
</div>

</form>


<script>// Captura o input de arquivo e o elemento onde o nome do arquivo será exibido
const fileInput = document.getElementById('fileInput');
const fileNameDisplay = document.getElementById('fileName');

// Adiciona um evento que será acionado quando o usuário selecionar um arquivo
fileInput.addEventListener('change', () => {
    // Verifica se um arquivo foi selecionado
    const file = fileInput.files[0];
    if (file) {
        // Exibe o nome do arquivo
        fileNameDisplay.textContent = `Arquivo selecionado: ${file.name}`;
    } else {
        // Se não houver arquivo selecionado, limpa a exibição
        fileNameDisplay.textContent = '';
    }
});
 </script>