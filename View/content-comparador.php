<form action="../control/comHash.php" method="post" enctype="multipart/form-data">

<div class="comparator-box">
    <label class="upload-btn">
        SELECIONE O PRIMEIRO ARQUIVO
        <input type="file" class="file-input" name="arquivo1" id="fileInput1" required/>
    </label>
    <div id="fileName1" class="file-name"></div>
    <div class="upload-icon">
        <ion-icon name="swap-horizontal-outline"></ion-icon>
    </div>
    <label class="upload-btn">
        SELECIONE O SEGUNDO ARQUIVO
        <input type="file" class="file-input" name="arquivo2" id="fileInput2" required/>
    </label>
    <div id="fileName2" class="file-name"></div>
    <p>ou</p>
    <p>Arraste os arquivos que você gostaria de comparar para que possamos realizar a verificação.</p>
</div>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<div class="button-container">
    <button type="submit" class="test-button">Testar</button>
</div>

</form>


<script>
// Captura os inputs de arquivo e os elementos onde os nomes dos arquivos serão exibidos
const fileInput1 = document.getElementById('fileInput1');
const fileInput2 = document.getElementById('fileInput2');
const fileNameDisplay1 = document.getElementById('fileName1');
const fileNameDisplay2 = document.getElementById('fileName2');

// Função para atualizar a exibição do nome do arquivo
function updateFileName(fileInput, displayElement) {
    const file = fileInput.files[0];
    if (file) {
        displayElement.textContent = `Arquivo selecionado: ${file.name}`;
    } else {
        displayElement.textContent = '';
    }
}

// Adiciona os eventos de mudança para os dois inputs de arquivo
fileInput1.addEventListener('change', () => {
    updateFileName(fileInput1, fileNameDisplay1);
});

fileInput2.addEventListener('change', () => {
    updateFileName(fileInput2, fileNameDisplay2);
});
</script>