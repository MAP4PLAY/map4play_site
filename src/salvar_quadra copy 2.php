<?php
// IMPORTANTE: Não coloque NADA antes desta linha (nem espaços em branco)
error_reporting(0); // Desabilita warnings no output
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// Buffer output para evitar qualquer saída prematura
ob_start();

try {
    // Verifica método
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido. Use POST.');
    }

    // Carrega configuração
    if (!file_exists('config.php')) {
        throw new Exception('Arquivo de configuração não encontrado.');
    }
    
    include 'config.php';
    
    if (empty($db_config['password'])) {
        throw new Exception('Configuração de banco de dados inválida.');
    }

    // Conecta ao banco
    $dsn = "pgsql:host={$db_config['host']};port={$db_config['port']};dbname={$db_config['dbname']}";
    $conn = new PDO($dsn, $db_config['user'], $db_config['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtém e valida dados
    $nome_quadra = trim($_POST['nome_quadra'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    $bairro = trim($_POST['bairro'] ?? '');
    $zona = trim($_POST['zona'] ?? '');
    $cep = trim($_POST['cep'] ?? '');
    $tipo_esporte = trim($_POST['tipo_esporte'] ?? '');
    $link_foto = trim($_POST['link_foto'] ?? '');

    $latitude = floatval($_POST['latitude'] ?? 0);
    $longitude = floatval($_POST['longitude'] ?? 0);

    // Converte booleanos
    $acessivel = ($_POST['acessivel'] ?? 'false') === 'true' ? 't' : 'f';
    $tem_rampa = ($_POST['tem_rampa'] ?? 'false') === 'true' ? 't' : 'f';
    $tem_banheiro_adaptado = ($_POST['tem_banheiro_adaptado'] ?? 'false') === 'true' ? 't' : 'f';
    $tem_iluminacao = ($_POST['tem_iluminacao'] ?? 'false') === 'true' ? 't' : 'f';
    $tem_vestiario = ($_POST['tem_vestiario'] ?? 'false') === 'true' ? 't' : 'f';
    $tem_arquibancada = ($_POST['tem_arquibancada'] ?? 'false') === 'true' ? 't' : 'f';
    $cobertura = ($_POST['cobertura'] ?? 'false') === 'true' ? 't' : 'f';

    // Validações
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
        $erros[] = 'Coordenadas são obrigatórias';
    }

    if (!empty($erros)) {
        throw new Exception(implode(', ', $erros));
    }

    // Prepara SQL
    $sql = "INSERT INTO quadras (
                nome_quadra, descricao, endereco, bairro, zona, cep, tipo_esporte,
                acessivel, tem_rampa, tem_banheiro_adaptado, tem_iluminacao, 
                tem_vestiario, tem_arquibancada, cobertura, link_foto, 
                localizacao, created_at
            ) VALUES (
                :nome_quadra, :descricao, :endereco, :bairro, :zona, :cep, :tipo_esporte,
                :acessivel, :tem_rampa, :tem_banheiro_adaptado, :tem_iluminacao,
                :tem_vestiario, :tem_arquibancada, :cobertura, :link_foto,
                ST_SetSRID(ST_MakePoint(:longitude, :latitude), 4326)::geography,
                NOW()
            ) RETURNING id";

    $stmt = $conn->prepare($sql);
    
    // Bind dos parâmetros
    $stmt->bindValue(':nome_quadra', $nome_quadra, PDO::PARAM_STR);
    $stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
    $stmt->bindValue(':endereco', $endereco, PDO::PARAM_STR);
    $stmt->bindValue(':bairro', $bairro, PDO::PARAM_STR);
    $stmt->bindValue(':zona', $zona, PDO::PARAM_STR);
    $stmt->bindValue(':cep', $cep, PDO::PARAM_STR);
    $stmt->bindValue(':tipo_esporte', $tipo_esporte, PDO::PARAM_STR);
    $stmt->bindValue(':acessivel', $acessivel, PDO::PARAM_STR);
    $stmt->bindValue(':tem_rampa', $tem_rampa, PDO::PARAM_STR);
    $stmt->bindValue(':tem_banheiro_adaptado', $tem_banheiro_adaptado, PDO::PARAM_STR);
    $stmt->bindValue(':tem_iluminacao', $tem_iluminacao, PDO::PARAM_STR);
    $stmt->bindValue(':tem_vestiario', $tem_vestiario, PDO::PARAM_STR);
    $stmt->bindValue(':tem_arquibancada', $tem_arquibancada, PDO::PARAM_STR);
    $stmt->bindValue(':cobertura', $cobertura, PDO::PARAM_STR);
    $stmt->bindValue(':link_foto', $link_foto, PDO::PARAM_STR);
    $stmt->bindValue(':longitude', $longitude, PDO::PARAM_STR);
    $stmt->bindValue(':latitude', $latitude, PDO::PARAM_STR);

    $stmt->execute();
    
    $quadra_id = $stmt->fetchColumn();

    // Limpa buffer e retorna JSON
    ob_end_clean();
    
    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Quadra adicionada com sucesso!',
        'id' => $quadra_id
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    ob_end_clean();
    http_response_code(500);
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro no banco de dados: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    ob_end_clean();
    http_response_code(400);
    echo json_encode([
        'sucesso' => false,
        'mensagem' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

exit;
?>