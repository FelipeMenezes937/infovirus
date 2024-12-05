<?php
session_start();
include "../Model/conexaobd.php"; // Incluindo a conexão com o banco

require 'vendor/autoload.php';
use GuzzleHttp\Client;

// Função para buscar dados da API usando Guzzle
function buscarDadosDaApi($caractereConsulta) {
    $client = new Client();
    $url = 'https://api.pwnedpasswords.com/range/' . $caractereConsulta;
    $response = $client->request('GET', $url);
    
    if ($response->getStatusCode() !== 200) {
        throw new RuntimeException('Erro ao buscar: ' . $response->getReasonPhrase());
    }
    
    return $response->getBody()->getContents();
}

function contarOcorrenciasDeSenha($hashes, $hashParaVerificar) {
    $linhas = explode("\n", trim($hashes));
    foreach ($linhas as $linha) {
        list($hash, $contagem) = explode(':', $linha);
        if ($hash === $hashParaVerificar) {
            return (int)$contagem;
        }
    }
    return 0;
}

function verificarSenhaNaApi($senha) {
    $sha1Senha = strtoupper(sha1($senha, false));
    $primeiros5Caracteres = substr($sha1Senha, 0, 5);
    $restante = substr($sha1Senha, 5);
    
    $resposta = buscarDadosDaApi($primeiros5Caracteres);
    return contarOcorrenciasDeSenha($resposta, $restante);
}

function processarDados($senha) {
    $contagem = verificarSenhaNaApi(trim($senha));
    
    if ($contagem) {
        return "A senha foi encontrada $contagem vez(es)... você provavelmente deve trocá-la.";
    } else {
        return "<strong>A senha não foi encontrada</strong>. Continue com segurança!";
    }
}

// Processar o envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['fsenha'])) {
        $senha = $_POST['fsenha'];
        $resultado = processarDados($senha);
        
        // Verificar se o email ou nome de usuário do usuário está armazenado na sessão
        if (isset($_SESSION['email'])) {  // Ou 'user_username', dependendo de como você identificou o usuário
            $userEmail = $_SESSION['email']; // Pega o email do usuário da sessão
            
            // Agora, recuperar o ID do usuário no banco de dados com base no email
            $sql = "SELECT idUsuario FROM usuario WHERE email = ?";
            
            if ($stmt = $conexao->prepare($sql)) {
                $stmt->bind_param("s", $userEmail); // 's' para string (email)
                
                if ($stmt->execute()) {
                    $stmt->bind_result($userId);
                    $stmt->fetch(); // Recupera o ID do usuário
                    
                    // Liberando os resultados antes de executar a próxima consulta
                    $stmt->free_result(); 
                    $stmt->close();  // Fechando a consulta
                    
                    // Verifica se o ID foi encontrado
                    if ($userId) {
                        // Inserir a data da consulta, idTipo e idUsuario no banco de dados
                        $data = date('Y-m-d H:i:s'); // Usando o formato correto de data e hora
                        $idTipo = 2; // O valor fixo do idTipo
                        
                        // Verifica a contagem de ocorrências da senha (se foi vazada)
                        $contagem = verificarSenhaNaApi(trim($senha));
                        $ValorS = ($contagem > 0) ? 1 : 0;  // Se a senha foi encontrada, envia 1, senão envia 0
                        
                        // Consulta SQL para inserir os dados no banco
                        $sqlInsert = "INSERT INTO ConsSValor (dataConsulta, fkidTipo, fkidUsuario, ValorS) VALUES (?, ?, ?, ?)";
                        
                        // Preparando a consulta para inserção
                        if ($stmtInsert = $conexao->prepare($sqlInsert)) {
                            // Vinculando os parâmetros
                            $stmtInsert->bind_param("siii", $data, $idTipo, $userId, $ValorS);  // Agora incluindo o ValorS
                            
                            // Executando a consulta de inserção
                            if ($stmtInsert->execute()) {
                                // Redirecionamento após a execução bem-sucedida
                                header("Location: ../view/resultado.php?resultado=" . urlencode($resultado));
                                exit(); 
                            } else {
                                // Em caso de erro ao executar a consulta de inserção
                                echo "Erro ao inserir no banco de dados: " . $stmtInsert->error;
                            }
                        } else {
                            // Em caso de erro ao preparar a consulta de inserção
                            echo "Erro ao preparar a consulta de inserção: " . $conexao->error;
                        }
                    } else {
                        // Caso o ID não seja encontrado no banco
                        echo "Usuário não encontrado.";
                    }
                } else {
                    // Em caso de erro ao executar a consulta de busca do ID
                    echo "Erro ao consultar ID do usuário: " . $stmt->error;
                }
            } else {
                // Em caso de erro ao preparar a consulta de busca do ID
                echo "Erro ao preparar a consulta de busca do ID: " . $conexao->error;
            }
        } else {
            echo "Erro: O email do usuário não está encontrado na sessão.";
        }
    } else {
        $resultado = "Nenhuma senha foi fornecida.";
    }
} else {
    $resultado = "Método de solicitação inválido.";
}
?>
