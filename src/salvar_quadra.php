<?php
/**
 * Script para salvar nova quadra no banco de dados PostgreSQL
 * Recebe dados via POST do formulário adicionar_quadra.html
 */

// inclui o arquivo de conexão
include 'conexao_pg.php';

// define o cabecalho como JSON
header('Content-Type: application/json; charset=utf-8');

// verifica se e uma requisicao post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Método não permitido. Use POST.'
    ]);
    exit;
}

// obtem e valida os dados do formulario
$nome_quadra = trim($_POST['nome_quadra'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');
$bairro = trim($_POST['bairro'] ?? '');
$zona = trim($_POST['zona'] ?? '');
$cep = trim($_POST['cep'] ?? '');
$tipo_esporte = trim($_POST['tipo_esporte'] ?? '');
$link_foto = trim($_POST['link_foto'] ?? '');

// coordenadas
$latitude = floatval($_POST['latitude'] ?? 0);
$longitude = floatval($_POST['longitude'] ?? 0);

// converte string 'true'/'false' tudo para booleano
$acessivel = ($_POST['acessivel'] ?? 'false') === 'true' ? 't' : 'f';
$tem_rampa = ($_POST['tem_rampa'] ?? 'false') === 'true' ? 't' : 'f';
$tem_banheiro_adaptado = ($_POST['tem_banheiro_adaptado'] ?? 'false') === 'true' ? 't' : 'f';
$tem_iluminacao = ($_POST['tem_iluminacao'] ?? 'false') === 'true' ? 't' : 'f';
$tem_vestiario = ($_POST['tem_vestiario'] ?? 'false') === 'true' ? 't' : 'f';
$tem_arquibancada = ($_POST['tem_arquibancada'] ?? 'false') === 'true' ? 't' : 'f';
$cobertura = ($_POST['cobertura'] ?? 'false') === 'true' ? 't' : 'f';

// validacoes
$erros = [];

if (empty($nome_quadra)) {
    $erros[] = 'Nome da quadra é obrigatório';
}

if (empty($endereco)) {
    $erros[] = 'Endereço é obrigatório';
}

if (empty($zona)) {
    $erros[] = 'Zona é obrigatória';
}

if (empty($tipo_esporte)) {
    $erros[] = 'Tipo de esporte é obrigatório';
}

if ($latitude === 0.0 || $longitude === 0.0) {
    $erros[] = 'Latitude e longitude são obrigatórias';
}

/*
// valida coordenadas de sp capital
if ($latitude < -24.0 || $latitude > -23.0) {
    $erros[] = 'Latitude inválida para São Paulo';
}

if ($longitude < -47.0 || $longitude > -46.0) {
    $erros[] = 'Longitude inválida para São Paulo';
}
*/

// se houver erros, retorna
if (!empty($erros)) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => implode(', ', $erros)
    ]);
    exit;
}

// prepara o SQL com prepared statement 
$sql = "INSERT INTO quadras (
            nome_quadra,
            descricao,
            endereco,
            bairro,
            zona,
            cep,
            tipo_esporte,
            acessivel,
            tem_rampa,
            tem_banheiro_adaptado,
            tem_iluminacao,
            tem_vestiario,
            tem_arquibancada,
            cobertura,
            link_foto,
            localizacao,
            created_at
        ) VALUES (
            $1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15,
            ST_SetSRID(ST_MakePoint($16, $17), 4326)::geography,
            NOW()
        ) RETURNING id";

// array com todos os parametros
$params = [
    $nome_quadra,
    $descricao,
    $endereco,
    $bairro,
    $zona,
    $cep,
    $tipo_esporte,
    $acessivel,
    $tem_rampa,
    $tem_banheiro_adaptado,
    $tem_iluminacao,
    $tem_vestiario,
    $tem_arquibancada,
    $cobertura,
    $link_foto,
    $longitude,  // prestar atencao aqui que eo postgis usa longitude/latitude
    $latitude
];

// Executa a query
$result = pg_query_params($conn, $sql, $params);

if ($result) {
    $row = pg_fetch_assoc($result);
    $quadra_id = $row['id'];
    
    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Quadra adicionada com sucesso!',
        'id' => $quadra_id
    ]);
} else {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro ao adicionar quadra: ' . pg_last_error($conn)
    ]);
}

// Fecha a conexão
pg_close($conn);
?>