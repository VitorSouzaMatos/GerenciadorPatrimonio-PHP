<?php
// categorias/form.php
require_once '../includes/funcoes.php';
require_once '../config/conexao.php';
verificar_admin();

$pdo = conectar();
$id = $_GET['id'] ?? null;
$categoria = null;

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM tb_categorias WHERE id_categoria = ?");
    $stmt->execute([$id]);
    $categoria = $stmt->fetch();
    
    if (!$categoria) {
        redirecionar('lista.php', 'Categoria não encontrada', 'erro');
    }
}

$titulo = $id ? 'Editar Categoria' : 'Nova Categoria';
include '../includes/header.php';
?>

<h1 class="mb-4"><?= $titulo ?></h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="salvar.php">
            <?php if ($id): ?>
                <input type="hidden" name="id_categoria" value="<?= $id ?>">
            <?php endif; ?>
            
            <div class="mb-3">
                <label for="nome" class="form-label">Nome *</label>
                <input type="text" class="form-control" id="nome" name="nome" 
                       value="<?= htmlspecialchars($categoria['nome'] ?? '') ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= htmlspecialchars($categoria['descricao'] ?? '') ?></textarea>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Salvar
                </button>
                <a href="lista.php" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>