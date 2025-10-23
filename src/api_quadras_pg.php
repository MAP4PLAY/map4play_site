<?php
/**
 * API para buscar quadras do banco PostgreSQL
 * 
 * endpoints disponíveis:
 * - api_quadras_pg.php (todas as quadras)
 * - api_quadras_pg.php?zona=Zona%20Leste (filtrar por zona)
 * - api_quadras_pg.php?lat=-23.5505&lng=-46.6333&raio=5000 (busca por proximidade)
 * - api_quadras_pg.php?pagina=1&limite=6 (paginação - padrão 6 por página)
 */

// INCLUI O ARQUIVO DE CONEXAO
include 'conexao_pg.php';

try {
    // DEFINE O CABECALHO COMO JSON
    header('Content-Type: application/json; charset=utf-8');

    // Array para armazenar as quadras
    $quadras = array();

    // 🔽 PAGINACAO 6 QUADRAS POR PAGINA (OTIMIZADO PARA INTERNET LENTA) 
    $pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
    $limite = isset($_GET['limite']) ? min(20, max(1, intval($_GET['limite']))) : 6; // PADRÃO: 6
    $offset = ($pagina - 1) * $limite;

    // verifica se foi solicitada busca por proximidade
    if (isset($_GET['lat']) && isset($_GET['lng'])) {
        $lat = floatval($_GET['lat']);
        $lng = floatval($_GET['lng']);
        $raio = isset($_GET['raio']) ? intval($_GET['raio']) : 5000; // Padrão: 5km
        
        // query para buscar quadras proximas
        $sql = "SELECT 
                    id,
                    nome_quadra,
                    descricao,
                    endereco,
                    bairro,
                    zona,
                    tipo_esporte,
                    acessivel,
                    tem_iluminacao,
                    tem_vestiario,
                    link_foto,
                    ST_Y(localizacao::geometry) as latitude,
                    ST_X(localizacao::geometry) as longitude,
                    ROUND(
                        ST_Distance(
                            localizacao,
                            ST_SetSRID(ST_MakePoint($2, $1), 4326)::geography
                        )::numeric
                    ) as distancia_metros
                FROM quadras
                WHERE ST_DWithin(
                    localizacao,
                    ST_SetSRID(ST_MakePoint($2, $1), 4326)::geography,
                    $3
                )
                ORDER BY distancia_metros
                LIMIT $limite OFFSET $offset";
        
        $result = pg_query_params($conn, $sql, array($lat, $lng, $raio));
        
    } else if (isset($_GET['zona'])) {
        
        // FILTRAR POR ZONAA
        $zona = $_GET['zona'];
        
        $sql = "SELECT 
                    id,
                    nome_quadra,
                    descricao,
                    endereco,
                    bairro,
                    zona,
                    tipo_esporte,
                    acessivel,
                    tem_iluminacao,
                    tem_vestiario,
                    link_foto,
                    ST_Y(localizacao::geometry) as latitude,
                    ST_X(localizacao::geometry) as longitude
                FROM quadras
                WHERE zona = $1
                ORDER BY nome_quadra
                LIMIT $limite OFFSET $offset";
        
        $result = pg_query_params($conn, $sql, array($zona));
        
    } else {
        // BUSCAR TODAS AS QADRAS
        $sql = "SELECT 
                    id,
                    nome_quadra,
                    descricao,
                    endereco,
                    bairro,
                    zona,
                    tipo_esporte,
                    acessivel,
                    tem_iluminacao,
                    tem_vestiario,
                    link_foto,
                    ST_Y(localizacao::geometry) as latitude,
                    ST_X(localizacao::geometry) as longitude
                FROM quadras
                ORDER BY nome_quadra
                LIMIT $limite OFFSET $offset";
        
        $result = pg_query($conn, $sql);
    }

    //VERIFICA SE A QUERY FOI SUBIU FOI FOI BEMSUCEDIDA
    if (!$result) {
        echo json_encode(array(
            'erro' => true,
            'mensagem' => 'Erro ao buscar quadras: ' . pg_last_error($conn)
        ));
        exit;
    }

    // ITERA SOBRE OS RESULTADOS E ARMAZENA EM UM ARRAY
    while ($row = pg_fetch_assoc($result)) {
        // converte valores booleanos de 't'/'f' para true/false
        $row['acessivel'] = ($row['acessivel'] === 't');
        $row['tem_iluminacao'] = ($row['tem_iluminacao'] === 't');
        $row['tem_vestiario'] = ($row['tem_vestiario'] === 't');
        
        $quadras[] = $row;
    }

    // informações de paginacaoo na resposta 
    $resposta = [
        'sucesso' => true,
        'pagina' => $pagina,
        'limite' => $limite,
        'total_quadras' => count($quadras),
        'quadras' => $quadras,
        'mensagem' => 'Carregadas ' . count($quadras) . ' quadras (página ' . $pagina . ')'
    ];

    // retorna o JSON
    echo json_encode($resposta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    // fecha a conexao
    pg_close($conn);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'erro' => true,
        'mensagem' => 'Erro interno do servidor: ' . $e->getMessage()
    ]);
    exit;
}
?>