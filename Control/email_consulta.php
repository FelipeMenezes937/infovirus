<?php
function check_blacklist($email) {
    $api_key = '47c376d236c66659ea4eab2e3e1fcb48';
    $domain = explode('@', $email)[1];
    $url = "https://api.hetrixtools.com/v2/$api_key/blacklist-check/domain/$domain/";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data['status'] == 'SUCCESS') {
        if ($data['blacklisted_count'] > 0) {
            echo "O domínio $domain está listado em " . $data['blacklisted_count'] . " blacklists.\n";
            foreach ($data['blacklisted_on'] as $blacklist) {
                echo "Listada em: " . $blacklist['rbl'] . "\n";
            }
        } else {
            echo "O domínio $domain não está listado em nenhuma blacklist.\n";
        }
    } else {
        echo "Erro ao verificar a blacklist.\n";
    }
}

// Teste do código
$email = $_GET['femail'];
check_blacklist($email);

// o domínio "mailnator" é um exemplo de testes
?>
























?>
