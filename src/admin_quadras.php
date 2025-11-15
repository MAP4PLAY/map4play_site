<?php
include 'config.php';

header('Content-Type: text/html; charset=utf-8');

$dsn = "pgsql:host={$db_config['host']};port={$db_config['port']};dbname={$db_config['dbname']}";
$conn = new PDO($dsn, $db_config['user'], $db_config['password']);

// Processar exclusão
if (isset($_GET['deletar'])) {
    $id = intval($_GET['deletar']);
    $stmt = $conn->prepare("DELETE FROM quadras WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header('Location: admin_quadras.php?msg=deletado');
    exit;
}

// Buscar todas as quadras
$stmt = $conn->query("SELECT id, nome_quadra, zona, tipo_esporte, endereco FROM quadras ORDER BY id");
$quadras = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin - Gerenciar Quadras</title>
    <style>
        body { font-family: Arial; max-width: 1200px; margin: 30px auto; padding: 20px; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border: 1px solid #ddd; }
        th { background: #f6815e; color: white; }
        tr:hover { background: #f5f5f5; }
        .btn-deletar { background: #dc3545; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; }
        .btn-deletar:hover { background: #c82333; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .btn-voltar { background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h1> Gerenciar Quadras</h1>
    
    <a href="index.html" class="btn-voltar">← Voltar para Início</a>
    
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deletado'): ?>
        <div class="success"> Quadra deletada com sucesso!</div>
    <?php endif; ?>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Zona</th>
            <th>Tipo</th>
            <th>Endereço</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($quadras as $quadra): ?>
        <tr>
            <td><?= $quadra['id'] ?></td>
            <td><?= htmlspecialchars($quadra['nome_quadra']) ?></td>
            <td><?= $quadra['zona'] ?></td>
            <td><?= $quadra['tipo_esporte'] ?></td>
            <td><?= htmlspecialchars($quadra['endereco']) ?></td>
            <td>
                <a href="?deletar=<?= $quadra['id'] ?>" 
                   class="btn-deletar" 
                   onclick="return confirm('Tem certeza que deseja deletar <?= htmlspecialchars($quadra['nome_quadra']) ?>?')">
                     Deletar
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <p style="margin-top: 20px; color: #666;">
        Total de quadras: <strong><?= count($quadras) ?></strong>
    </p>
</body>
</html>
