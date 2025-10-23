<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste de Conexão - MAP4PLAY</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>🏀 Teste de Conexão - MAP4PLAY</h1>
    
    <?php
    $host = 'postgres';
    $port = '5432';
    $dbname = 'map4play';
    $user = 'postgres';
    $password = '1234';

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "<div class='success'>✅ Conexão bem-sucedida com PostgreSQL!</div>";
        
        $version = $pdo->query('SELECT version()')->fetchColumn();
        echo "<div class='success'>🐘 PostgreSQL: $version</div>";
        
        $postgis_version = $pdo->query('SELECT PostGIS_version()')->fetchColumn();
        echo "<div class='success'>✅ PostGIS: $postgis_version</div>";
        
        $count = $pdo->query("SELECT COUNT(*) FROM quadras")->fetchColumn();
        echo "<div class='success'>🏟️ Total de quadras: $count</div>";
        
    } catch (PDOException $e) {
        echo "<div class='error'>❌ Erro: " . $e->getMessage() . "</div>";
    }
    ?>
</body>
</html>