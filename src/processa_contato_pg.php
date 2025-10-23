<?php
/**
 * Processa o formulario de contato e salva no PostgreSQL
 */

// inclui o arquivo de conexao
include 'conexao_pg.php';

// obtem os dados do formulario
$nome = trim($_POST['Nome'] ?? '');
$celular = trim($_POST['Celular'] ?? '');
$email = trim($_POST['E-mail'] ?? '');
$mensagem = trim($_POST['Mensagem'] ?? '');

// validacao basica
if (empty($nome) || empty($mensagem)) {
    header('Location: contact.html?erro=campos_obrigatorios');
    exit();
}

// validacao de tamanho dos campos
if (strlen($nome) > 100) {
    header('Location: contact.html?erro=nome_longo');
    exit();
}

if (strlen($mensagem) > 1000) {
    header('Location: contact.html?erro=mensagem_longa');
    exit();
}

if (strlen($celular) > 20) {
    header('Location: contact.html?erro=celular_longo');
    exit();
}

if (strlen($email) > 100) {
    header('Location: contact.html?erro=email_longo');
    exit();
}

// validacao de email
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: contact.html?erro=email_invalido');
    exit();
}

// pprepara o sql com placeholders seguros
$sql = "INSERT INTO contatos (nome, celular, email, mensagem, data_contato) 
        VALUES ($1, $2, $3, $4, NOW())";

// executa a query com parametros 
$result = pg_query_params($conn, $sql, array($nome, $celular, $email, $mensagem));

if ($result) {
    // sucesso
    pg_close($conn);
    
    // redireciona com mensagem de sucesso
    header('Location: contact.html?sucesso=1');
    exit();
} else {
    // log do erro para debug
    error_log("Erro PostgreSQL ao processar contato: " . pg_last_error($conn));
    
    // redireciona para pagina de erro
    header('Location: contact.html?erro=banco_dados');
    exit();
}
?>