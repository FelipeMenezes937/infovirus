
export default function alterarFonte(acao) {
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
    