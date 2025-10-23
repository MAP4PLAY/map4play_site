<?php
/**
 * Conexão com PostgreSQL para o MAP4PLAY
 */
include 'config.php';

// String de conexao
$conn_string = "host={$db_config['host']} port={$db_config['port']} dbname={$db_config['dbname']} user={$db_config['user']} password={$db_config['password']}";

// DEBUG: Mostra se está conectando (REMOVA DEPOIS)
error_log("Tentando conectar: host={$db_config['host']}, db={$db_config['dbname']}, user={$db_config['user']}");

// tenta conectar ao banco
$conn = pg_connect($conn_string);

// verifica se a conexão foi bem-sucedida
if (!$conn) {
    $error = pg_last_error();
    error_log("ERRO CONEXÃO: " . $error);
    die("Erro na conexão com o banco de dados: " . $error);
}

// DEBUG: Conexão bem-sucedida
error_log("Conexão PostgreSQL estabelecida com sucesso!");

// define o encoding para utf-8
pg_set_client_encoding($conn, "UTF8");
?>