<?php
// IMPORTANTE: Não coloque NADA antes desta linha (nem espaços em branco)
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
ob_start();

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido. Use POST.');
    }

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

    // Converte TODOS os booleanos
    $acessivel = ($_POST['acessivel'] ?? 'false') === 'true' ? 't' : 'f';
    $tem_rampa = ($_POST['tem_rampa'] ?? 'false') === 'true' ? 't' : 'f';
    $tem_banheiro_adaptado = ($_POST['tem_banheiro_adaptado'] ?? 'false') === 'true' ? 't' : 'f';
    $tem_iluminacao = ($_POST['tem_iluminacao'] ?? 'false') === 'true' ? 't' : 'f';
    $tem_vestiario = ($_POST['tem_vestiario'] ?? 'false') === 'true' ? 't' : 'f';
    $tem_arquibancada = ($_POST['tem_arquibancada'] ?? 'false') === 'true' ? 't' : 'f';
    $cobertura = ($_POST['cobertura'] ?? 'false') === 'true' ? 't' : 'f';
    $piso_tatil = ($_POST['piso_tatil'] ?? 'false') === 'true' ? 't' : 'f';
    $elevador = ($_POST['elevador'] ?? 'false') === 'true' ? 't' : 'f';
    $estacionamento_reservado = ($_POST['estacionamento_reservado'] ?? 'false') === 'true' ? 't' : 'f';
    $area_descanso = ($_POST['area_descanso'] ?? 'false') === 'true' ? 't' : 'f';
    $corrimao_duplo = ($_POST['corrimao_duplo'] ?? 'false') === 'true' ? 't' : 'f';
    $sinalizacao_braille = ($_POST['sinalizacao_braille'] ?? 'false') === 'true' ? 't' : 'f';
    $sinalizacao_visual = ($_POST['sinalizacao_visual'] ?? 'false') === 'true' ? 't' : 'f';
    $material_libras = ($_POST['material_libras'] ?? 'false') === 'true' ? 't' : 'f';
    $mapa_tatil = ($_POST['mapa_tatil'] ?? 'false') === 'true' ? 't' : 'f';
    $banheiro_trocador = ($_POST['banheiro_trocador'] ?? 'false') === 'true' ? 't' : 'f';
    $professores_capacitados = ($_POST['professores_capacitados'] ?? 'false') === 'true' ? 't' : 'f';
    $aulas_esporte_adaptado = ($_POST['aulas_esporte_adaptado'] ?? 'false') === 'true' ? 't' : 'f';
    $equipamentos_adaptados = ($_POST['equipamentos_adaptados'] ?? 'false') === 'true' ? 't' : 'f';
    $cadeira_rodas_disponivel = ($_POST['cadeira_rodas_disponivel'] ?? 'false') === 'true' ? 't' : 'f';
    $transporte_publico_acessivel = ($_POST['transporte_publico_acessivel'] ?? 'false') === 'true' ? 't' : 'f';
    $calcadas_acessiveis = ($_POST['calcadas_acessiveis'] ?? 'false') === 'true' ? 't' : 'f';
    $entrada_acessivel = ($_POST['entrada_acessivel'] ?? 'false') === 'true' ? 't' : 'f';

    // Validações
    $erros = [];
    if (empty($nome_quadra)) $erros[] = 'Nome da quadra é obrigatório';
    if (empty($endereco)) $erros[] = 'Endereço é obrigatório';
    if (empty($zona)) $erros[] = 'Zona é obrigatória';
    if (empty($tipo_esporte)) $erros[] = 'Tipo de esporte é obrigatório';
    if ($latitude === 0.0 || $longitude === 0.0) $erros[] = 'Coordenadas são obrigatórias';

    if (!empty($erros)) {
        throw new Exception(implode(', ', $erros));
    }

    // SQL com TODOS os campos
    $sql = "INSERT INTO quadras (
                nome_quadra, descricao, endereco, bairro, zona, cep, tipo_esporte,
                acessivel, tem_rampa, tem_banheiro_adaptado, tem_iluminacao, 
                tem_vestiario, tem_arquibancada, cobertura,
                piso_tatil, elevador, estacionamento_reservado, area_descanso,
                corrimao_duplo, sinalizacao_braille, sinalizacao_visual, material_libras,
                mapa_tatil, banheiro_trocador, professores_capacitados, aulas_esporte_adaptado,
                equipamentos_adaptados, cadeira_rodas_disponivel, transporte_publico_acessivel,
                calcadas_acessiveis, entrada_acessivel,
                link_foto, localizacao, created_at
            ) VALUES (
                :nome_quadra, :descricao, :endereco, :bairro, :zona, :cep, :tipo_esporte,
                :acessivel, :tem_rampa, :tem_banheiro_adaptado, :tem_iluminacao,
                :tem_vestiario, :tem_arquibancada, :cobertura,
                :piso_tatil, :elevador, :estacionamento_reservado, :area_descanso,
                :corrimao_duplo, :sinalizacao_braille, :sinalizacao_visual, :material_libras,
                :mapa_tatil, :banheiro_trocador, :professores_capacitados, :aulas_esporte_adaptado,
                :equipamentos_adaptados, :cadeira_rodas_disponivel, :transporte_publico_acessivel,
                :calcadas_acessiveis, :entrada_acessivel,
                :link_foto,
                ST_SetSRID(ST_MakePoint(:longitude, :latitude), 4326)::geography,
                NOW()
            ) RETURNING id";

    $stmt = $conn->prepare($sql);
    
    // Bind de TODOS os parâmetros
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
    $stmt->bindValue(':piso_tatil', $piso_tatil, PDO::PARAM_STR);
    $stmt->bindValue(':elevador', $elevador, PDO::PARAM_STR);
    $stmt->bindValue(':estacionamento_reservado', $estacionamento_reservado, PDO::PARAM_STR);
    $stmt->bindValue(':area_descanso', $area_descanso, PDO::PARAM_STR);
    $stmt->bindValue(':corrimao_duplo', $corrimao_duplo, PDO::PARAM_STR);
    $stmt->bindValue(':sinalizacao_braille', $sinalizacao_braille, PDO::PARAM_STR);
    $stmt->bindValue(':sinalizacao_visual', $sinalizacao_visual, PDO::PARAM_STR);
    $stmt->bindValue(':material_libras', $material_libras, PDO::PARAM_STR);
    $stmt->bindValue(':mapa_tatil', $mapa_tatil, PDO::PARAM_STR);
    $stmt->bindValue(':banheiro_trocador', $banheiro_trocador, PDO::PARAM_STR);
    $stmt->bindValue(':professores_capacitados', $professores_capacitados, PDO::PARAM_STR);
    $stmt->bindValue(':aulas_esporte_adaptado', $aulas_esporte_adaptado, PDO::PARAM_STR);
    $stmt->bindValue(':equipamentos_adaptados', $equipamentos_adaptados, PDO::PARAM_STR);
    $stmt->bindValue(':cadeira_rodas_disponivel', $cadeira_rodas_disponivel, PDO::PARAM_STR);
    $stmt->bindValue(':transporte_publico_acessivel', $transporte_publico_acessivel, PDO::PARAM_STR);
    $stmt->bindValue(':calcadas_acessiveis', $calcadas_acessiveis, PDO::PARAM_STR);
    $stmt->bindValue(':entrada_acessivel', $entrada_acessivel, PDO::PARAM_STR);
    $stmt->bindValue(':link_foto', $link_foto, PDO::PARAM_STR);
    $stmt->bindValue(':longitude', $longitude, PDO::PARAM_STR);
    $stmt->bindValue(':latitude', $latitude, PDO::PARAM_STR);

    $stmt->execute();
    $quadra_id = $stmt->fetchColumn();

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