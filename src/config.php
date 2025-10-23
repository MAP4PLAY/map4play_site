<?php
// config.php - configurações sensíveis (VERSÃO TESTE)

// DESCOMENTE e use as credenciais DIRETAMENTE para testar:
$db_config = [
    //'host' => 'localhost',
    'host' => 'postgres',
    'port' => '5432', 
    'dbname' => 'map4play',
    'user' => 'postgres',
    'password' => '1234' 
];

/*
// COMENTE a parte do .env temporariamente:
if (file_exists('.env')) {
    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        putenv(trim($line));
    }
}

$db_config = [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'port' => getenv('DB_PORT') ?: '5432',
    'dbname' => getenv('DB_NAME') ?: 'map4play',
    'user' => getenv('DB_USER') ?: 'postgres',
    'password' => getenv('DB_PASSWORD') ?: ''
];
*/

if (empty($db_config['password'])) {
    die("Erro: Senha do banco de dados não configurada.");
}
?>