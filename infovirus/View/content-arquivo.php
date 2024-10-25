<form action="../control/testa_virus.php" method="post" enctype="multipart/form-data">

<div class="upload-box">
    <label class="upload-btn">
        ESCOLHA UM ARQUIVO
        <input type="file" class="file-input" name="arquivo" required/>
    </label>
    <div class="upload-icon">
        <ion-icon name="document-outline"></ion-icon>
    </div>
    <p>ou</p>
    <p>Arraste o arquivo que você gostaria de selecionar para que possamos realizar a verificação quanto à presença de vírus.</p>
</div>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <div class="button-container">
<button type="submit"class="test-button">Testar</button></div>
</form>