<?php
// config.php
$db_config = [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'port' => getenv('DB_PORT') ?: '5432',
    'dbname' => getenv('DB_NAME') ?: 'map4play',
    'user' => getenv('DB_USER') ?: 'postgres',
    'password' => getenv('DB_PASSWORD') ?: ''
];

if (empty($db_config['password'])) {
    die("Erro: Senha do banco de dados não configurada.");
}
?>