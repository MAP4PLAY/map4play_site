<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// USA O MESMO CONFIG DOS OUTROS ARQUIVOS
include 'config.php';

try {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id || $id <= 0) {
        http_response_code(400);
        echo json_encode(['erro' => true, 'mensagem' => 'ID inválido']);
        exit;
    }
    
    // Conecta usando PDO
    $dsn = "pgsql:host={$db_config['host']};port={$db_config['port']};dbname={$db_config['dbname']}";
    $conn = new PDO($dsn, $db_config['user'], $db_config['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn->prepare("
        SELECT 
            id,
            nome_quadra,
            endereco,
            bairro,
            zona,
            tipo_esporte,
            descricao,
            link_foto,
            acessivel,
            tem_iluminacao,
            tem_vestiario,
            ST_Y(localizacao::geometry) as latitude,
            ST_X(localizacao::geometry) as longitude,
            created_at
        FROM quadras 
        WHERE id = :id
    ");
    
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $quadra = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($quadra) {
        // Converter booleanos do PostgreSQL
        $quadra['acessivel'] = ($quadra['acessivel'] === 't');
        $quadra['tem_iluminacao'] = ($quadra['tem_iluminacao'] === 't');
        $quadra['tem_vestiario'] = ($quadra['tem_vestiario'] === 't');
        
        echo json_encode($quadra);
    } else {
        http_response_code(404);
        echo json_encode(['erro' => true, 'mensagem' => 'Quadra não encontrada']);
    }
    
} catch (PDOException $e) {
    error_log("Erro PostgreSQL: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['erro' => true, 'mensagem' => 'Erro interno do servidor']);
} catch (Exception $e) {
    error_log("Erro geral: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['erro' => true, 'mensagem' => 'Erro inesperado']);
}
?>