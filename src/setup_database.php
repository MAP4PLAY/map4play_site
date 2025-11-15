<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Setup Database - MAP4PLAY</title>
    <style>
        body { font-family: Arial; max-width: 900px; margin: 30px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #28a745; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #dc3545; }
        .warning { background: #fff3cd; color: #856404; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #ffc107; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #17a2b8; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; border: 1px solid #dee2e6; }
        h1 { color: #333; border-bottom: 3px solid #f6815e; padding-bottom: 10px; }
        h2 { color: #555; margin-top: 30px; }
        code { background: #f8f9fa; padding: 2px 6px; border-radius: 3px; color: #e83e8c; }
    </style>
</head>
<body>
<div class='container'>
    <h1>Setup Database - MAP4PLAY</h1>";

try {
    if (!file_exists('config.php')) {
        throw new Exception('Arquivo config.php não encontrado!');
    }
    
    include 'config.php';
    
    echo "<div class='success'>Configuração carregada com sucesso</div>";
    echo "<pre>Host: {$db_config['host']}\nPort: {$db_config['port']}\nDatabase: {$db_config['dbname']}\nUser: {$db_config['user']}</pre>";
    
    $dsn = "pgsql:host={$db_config['host']};port={$db_config['port']};dbname={$db_config['dbname']}";
    $conn = new PDO($dsn, $db_config['user'], $db_config['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div class='success'>Conexão com PostgreSQL estabelecida</div>";
    
    $version = $conn->query('SELECT version()')->fetchColumn();
    echo "<div class='success'>PostgreSQL: " . substr($version, 0, 80) . "...</div>";
    
    echo "<h2>1. Verificando PostGIS...</h2>";
    
    try {
        $conn->exec('CREATE EXTENSION IF NOT EXISTS postgis');
        
        $postgis_version = $conn->query('SELECT PostGIS_version()')->fetchColumn();
        echo "<div class='success'>PostGIS ATIVO: {$postgis_version}</div>";
        $tem_postgis = true;
        
    } catch (PDOException $e) {
        echo "<div class='error'>PostGIS NÃO disponível: " . $e->getMessage() . "</div>";
        echo "<div class='warning'>
            O Render não suporta PostGIS no plano gratuito.<br>
            Vou criar a tabela SEM PostGIS (usando latitude/longitude simples).
        </div>";
        $tem_postgis = false;
    }
    
    echo "<h2>2. Criando tabela 'quadras'...</h2>";
    
    if ($tem_postgis) {
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
        echo "<div class='success'>Tabela 'quadras' criada COM PostGIS</div>";
        
    } else {
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
                latitude NUMERIC(10, 8) NOT NULL,
                longitude NUMERIC(11, 8) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        echo "<div class='warning'>Tabela 'quadras' criada SEM PostGIS (usando latitude/longitude)</div>";
        echo "<div class='info'>Você precisará ajustar os arquivos PHP para funcionarem sem PostGIS.</div>";
    }
    
    echo "<h2>3. Criando índices...</h2>";
    
    if ($tem_postgis) {
        $conn->exec("CREATE INDEX IF NOT EXISTS idx_quadras_localizacao ON quadras USING GIST(localizacao)");
        echo "<div class='success'>Índice espacial criado (GIST)</div>";
    } else {
        $conn->exec("CREATE INDEX IF NOT EXISTS idx_quadras_coords ON quadras(latitude, longitude)");
        echo "<div class='success'>Índice criado (latitude/longitude)</div>";
    }
    
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_quadras_zona ON quadras(zona)");
    echo "<div class='success'>Índice criado (zona)</div>";
    
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_quadras_tipo_esporte ON quadras(tipo_esporte)");
    echo "<div class='success'>Índice criado (tipo_esporte)</div>";
    
    echo "<h2>4. Criando tabela 'contatos'...</h2>";
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
    echo "<div class='success'>Tabela 'contatos' criada</div>";
    
    $count = $conn->query("SELECT COUNT(*) FROM quadras")->fetchColumn();
    
    echo "<h2>5. Verificando dados...</h2>";
    
    if ($count == 0) {
        echo "<div class='info'>Banco vazio. Nenhuma quadra cadastrada ainda.</div>";
        echo "<div class='info'>Vá para <a href='adicionar_quadra.html'><strong>adicionar_quadra.html</strong></a> para cadastrar a primeira quadra!</div>";
    } else {
        echo "<div class='warning'>Já existem <strong>{$count}</strong> quadra(s) cadastrada(s) no banco.</div>";
    }
    
    echo "<h2>Resumo Final</h2>";
    
    $total_quadras = $conn->query("SELECT COUNT(*) FROM quadras")->fetchColumn();
    
    if ($total_quadras == 0) {
        echo "<div class='info'>
            <strong>Banco vazio - pronto para usar!</strong><br>
            Total de quadras: <strong>0</strong>
        </div>";
    } else {
        echo "<div class='success'>
            <strong>Banco com dados</strong><br>
            Total de quadras: <strong>{$total_quadras}</strong>
        </div>";
    }
    
    echo "<div class='success' style='margin-top: 40px; padding: 25px;'>
        <h2 style='margin-top: 0;'>Setup Concluído!</h2>
        <p><strong>Próximos passos:</strong></p>
        <ol style='line-height: 2;'>
            <li>Acesse: <a href='adicionar_quadra.html' target='_blank'><strong>adicionar_quadra.html</strong></a></li>
            <li>Cadastre uma quadra de teste</li>
            <li>Veja em: <a href='services.php' target='_blank'><strong>services.php</strong></a></li>
            <li><strong style='color: #dc3545;'>IMPORTANTE: Delete este arquivo por segurança!</strong></li>
        </ol>
    </div>";
    
    if (!$tem_postgis) {
        echo "<div class='warning' style='margin-top: 20px;'>
            <h3>Atenção: Banco SEM PostGIS</h3>
            <p>Os arquivos PHP foram criados esperando PostGIS. Você tem duas opções:</p>
            <ul>
                <li><strong>Opção 1:</strong> Upgrade no plano do Render para ter PostGIS</li>
                <li><strong>Opção 2:</strong> Usar outro provedor (Supabase, Neon) que tem PostGIS grátis</li>
                <li><strong>Opção 3:</strong> Me peça para adaptar os arquivos PHP (trabalho manual)</li>
            </ul>
        </div>";
    }
    
} catch (PDOException $e) {
    echo "<div class='error'>
        <h3>Erro no Banco de Dados</h3>
        <pre>" . htmlspecialchars($e->getMessage()) . "</pre>
    </div>";
    
    echo "<div class='info'>
        <h4>Possíveis Causas:</h4>
        <ul>
            <li>Variáveis de ambiente não configuradas no Render</li>
            <li>Banco de dados offline</li>
            <li>Credenciais incorretas</li>
        </ul>
        <p><strong>Verifique:</strong> Dashboard do Render → Seu banco → Environment Variables</p>
    </div>";
    
} catch (Exception $e) {
    echo "<div class='error'>
        <h3>Erro Geral</h3>
        <pre>" . htmlspecialchars($e->getMessage()) . "</pre>
    </div>";
}

echo "
    <hr style='margin: 40px 0; border: none; border-top: 2px solid #dee2e6;'>
    <p style='text-align: center; color: #6c757d; margin-top: 30px;'>
        <strong>MAP 4 PLAY</strong> © 2025 | Setup Database Script<br>
        <small>Desenvolvido para o Projeto Integrador II - UNIVESP</small>
    </p>
</div>
</body>
</html>";
?>