<?php
// categorias/lista.php
require_once '../includes/funcoes.php';
require_once '../config/conexao.php';
verificar_admin();

$pdo = conectar();

// Busca
$busca = $_GET['busca'] ?? '';
$sql = "SELECT * FROM tb_categorias WHERE nome LIKE ? OR descricao LIKE ? ORDER BY nome";
$stmt = $pdo->prepare($sql);
$stmt->execute(["%$busca%", "%$busca%"]);
$categorias = $stmt->fetchAll();

$titulo = 'Categorias';
include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Categorias</h1>
    <a href="form.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nova Categoria
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="busca" class="form-control" placeholder="Buscar categoria..." value="<?= htmlspecialchars($busca) ?>">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Data Criação</th>
                        <th width="150">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categorias)): ?>
                        <tr><td colspan="5" class="text-center">Nenhuma categoria encontrada</td></tr>
                    <?php else: ?>
                        <?php foreach ($categorias as $cat): ?>
                            <tr>
                                <td><?= $cat['id_categoria'] ?></td>
                                <td><?= htmlspecialchars($cat['nome']) ?></td>
                                <td><?= htmlspecialchars($cat['descricao'] ?? '-') ?></td>
                                <td><?= formatar_data($cat['data_criacao']) ?></td>
                                <td>
                                    <a href="form.php?id=<?= $cat['id_categoria'] ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="excluir.php?id=<?= $cat['id_categoria'] ?>" class="btn btn-sm btn-danger btn-excluir">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>