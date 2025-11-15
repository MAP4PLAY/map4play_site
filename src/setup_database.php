<?php
/**
 * Script de inicialização do banco de dados
 * Acesse: https://seu-site.onrender.com/setup_database.php
 * 
 * ⚠️ IMPORTANTE: Delete este arquivo após executar!
 */

header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Setup Database - MAP4PLAY</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .warning { background: #fff3cd; color: #856404; padding: 15px; margin: 10px 0; border-radius: 5px; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🏀 Setup Database - MAP4PLAY</h1>";

try {
    // Carrega configuração
    if (!file_exists('config.php')) {
        throw new Exception('❌ Arquivo config.php não encontrado!');
    }
    
    include 'config.php';
    
    echo "<div class='success'>✅ Configuração carregada</div>";
    echo "<pre>Host: {$db_config['host']}\nDatabase: {$db_config['dbname']}\nUser: {$db_config['user']}</pre>";
    
    // Conecta ao banco
    $dsn = "pgsql:host={$db_config['host']};port={$db_config['port']};dbname={$db_config['dbname']}";
    $conn = new PDO($dsn, $db_config['user'], $db_config['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div class='success'>✅ Conexão com PostgreSQL estabelecida</div>";
    
    // Verifica versão PostgreSQL
    $version = $conn->query('SELECT version()')->fetchColumn();
    echo "<div class='success'>🐘 PostgreSQL: " . substr($version, 0, 50) . "...</div>";
    
    // Ativa PostGIS
    echo "<h2>1️⃣ Ativando PostGIS...</h2>";
    $conn->exec('CREATE EXTENSION IF NOT EXISTS postgis');
    
    $postgis_version = $conn->query('SELECT PostGIS_version()')->fetchColumn();
    echo "<div class='success'>✅ PostGIS ativo: {$postgis_version}</div>";
    
    // Cria tabela quadras
    echo "<h2>2️⃣ Criando tabela 'quadras'...</h2>";
    $conn->exec("
        CREATE TABLE IF NOT EXISTS quadras (
            id SERIAL PRIMARY KEY,
            nome_quadra VARCHAR(255) NOT NULL,
            descricao TEXT,
            endereco VARCHAR(500) NOT NULL,
            bairro VARCHAR(100),
            zona VARCHAR(50) NOT NULL,
            cep VARCHAR(10),
            tipo_esporte VARCHAR(50) NOT NULL,
            acessivel BOOLEAN DEFAULT FALSE,
            tem_rampa BOOLEAN DEFAULT FALSE,
            tem_banheiro_adaptado BOOLEAN DEFAULT FALSE,
            tem_iluminacao BOOLEAN DEFAULT FALSE,
            tem_vestiario BOOLEAN DEFAULT FALSE,
            tem_arquibancada BOOLEAN DEFAULT FALSE,
            cobertura BOOLEAN DEFAULT FALSE,
            link_foto TEXT,
            localizacao GEOGRAPHY(POINT, 4326),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "<div class='success'>✅ Tabela 'quadras' criada</div>";
    
    // Cria índices
    echo "<h2>3️⃣ Criando índices...</h2>";
    
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_quadras_localizacao ON quadras USING GIST(localizacao)");
    echo "<div class='success'>✅ Índice espacial criado (localizacao)</div>";
    
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_quadras_zona ON quadras(zona)");
    echo "<div class='success'>✅ Índice criado (zona)</div>";
    
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_quadras_tipo_esporte ON quadras(tipo_esporte)");
    echo "<div class='success'>✅ Índice criado (tipo_esporte)</div>";
    
    // Cria tabela contatos (opcional)
    echo "<h2>4️⃣ Criando tabela 'contatos' (opcional)...</h2>";
    $conn->exec("
        CREATE TABLE IF NOT EXISTS contatos (
            id SERIAL PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            celular VARCHAR(20),
            email VARCHAR(100),
            mensagem TEXT NOT NULL,
            data_contato TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "<div class='success'>✅ Tabela 'contatos' criada</div>";
    
    // Verifica se já existem quadras
    $count = $conn->query("SELECT COUNT(*) FROM quadras")->fetchColumn();
    
    if ($count == 0) {
        echo "<h2>5️⃣ Inserindo dados de exemplo...</h2>";
        
        $conn->exec("
            INSERT INTO quadras (
                nome_quadra, descricao, endereco, bairro, zona, tipo_esporte,
                acessivel, tem_iluminacao, tem_vestiario, link_foto,
                localizacao
            ) VALUES 
            (
                'Quadra do Parque Ibirapuera',
                'Quadra poliesportiva com excelente estrutura no Parque Ibirapuera',
                'Av. Pedro Álvares Cabral, s/n',
                'Vila Mariana',
                'Zona Sul',
                'Poliesportiva',
                true,
                true,
                true,
                'https://images.unsplash.com/photo-1589487391730-58f20eb2c308?w=500',
                ST_SetSRID(ST_MakePoint(-46.6575, -23.5875), 4326)::geography
            ),
            (
                'CEU Paz',
                'Centro Educacional Unificado com quadra coberta',
                'Rua Haparanda, 75',
                'Brasilândia',
                'Zona Norte',
                'Futsal',
                true,
                true,
                false,
                'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=500',
                ST_SetSRID(ST_MakePoint(-46.6883, -23.4667), 4326)::geography
            ),
            (
                'Quadra do Parque da Juventude',
                'Quadra ao ar livre no Parque da Juventude',
                'Av. Cruzeiro do Sul, 2630',
                'Santana',
                'Zona Norte',
                'Basquete',
                false,
                false,
                false,
                'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=500',
                ST_SetSRID(ST_MakePoint(-46.6297, -23.5153), 4326)::geography
            ),
            (
                'Quadra do SESC Itaquera',
                'Quadra coberta com estrutura completa',
                'Av. Fernando Espírito Santo Alves de Mattos, 1000',
                'Itaquera',
                'Zona Leste',
                'Vôlei',
                true,
                true,
                true,
                'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?w=500',
                ST_SetSRID(ST_MakePoint(-46.4556, -23.5411), 4326)::geography
            ),
            (
                'Quadra da Vila Olímpia',
                'Quadra moderna no coração da Vila Olímpia',
                'Rua Funchal, 418',
                'Vila Olímpia',
                'Zona Oeste',
                'Futebol',
                false,
                true,
                false,
                'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=500',
                ST_SetSRID(ST_MakePoint(-46.6867, -23.5953), 4326)::geography
            )
        ");
        
        echo "<div class='success'>✅ 5 quadras de exemplo inseridas</div>";
    } else {
        echo "<div class='warning'>⚠️ Já existem {$count} quadras cadastradas. Dados de exemplo não inseridos.</div>";
    }
    
    // Resumo final
    echo "<h2>📊 Resumo Final</h2>";
    
    $total_quadras = $conn->query("SELECT COUNT(*) FROM quadras")->fetchColumn();
    echo "<div class='success'>✅ Total de quadras: {$total_quadras}</div>";
    
    // Testa consulta espacial
    $stmt = $conn->query("
        SELECT 
            nome_quadra, 
            zona,
            ST_Y(localizacao::geometry) as lat,
            ST_X(localizacao::geometry) as lng
        FROM quadras 
        LIMIT 3
    ");
    
    echo "<h3>🗺️ Teste de Consulta Espacial (3 primeiras quadras):</h3>";
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Nome</th><th>Zona</th><th>Latitude</th><th>Longitude</th></tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['nome_quadra']}</td>";
        echo "<td>{$row['zona']}</td>";
        echo "<td>" . number_format($row['lat'], 6) . "</td>";
        echo "<td>" . number_format($row['lng'], 6) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // Mensagem final
    echo "
    <div class='success' style='margin-top: 30px;'>
        <h2>🎉 Setup Concluído com Sucesso!</h2>
        <p><strong>Próximos passos:</strong></p>
        <ol>
            <li>Teste adicionar uma quadra: <a href='adicionar_quadra.html'>adicionar_quadra.html</a></li>
            <li>Veja a lista de quadras: <a href='services.php'>services.php</a></li>
            <li><strong style='color: red;'>⚠️ IMPORTANTE: Delete este arquivo (setup_database.php) por segurança!</strong></li>
        </ol>
    </div>";
    
} catch (PDOException $e) {
    echo "<div class='error'>❌ Erro no banco de dados:<br><pre>" . htmlspecialchars($e->getMessage()) . "</pre></div>";
    echo "<div class='warning'>
        <strong>Possíveis soluções:</strong>
        <ul>
            <li>Verifique se as variáveis de ambiente estão configuradas no Render</li>
            <li>Confirme que o banco PostgreSQL está ativo</li>
            <li>Verifique a External Database URL no painel do Render</li>
        </ul>
    </div>";
    
} catch (Exception $e) {
    echo "<div class='error'>❌ Erro:<br><pre>" . htmlspecialchars($e->getMessage()) . "</pre></div>";
}

echo "
    <hr>
    <p style='text-align: center; color: #666; margin-top: 30px;'>
        MAP 4 PLAY © 2025 | Setup Database Script<br>
        <small>Desenvolvido para o Projeto Integrador II - UNIVESP</small>
    </p>
</body>
</html>";
?>