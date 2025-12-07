<?php
// categorias/excluir.php
require_once '../includes/funcoes.php';
require_once '../config/conexao.php';
verificar_admin();

$id = $_GET['id'] ?? null;

if (!$id) {
    redirecionar('lista.php', 'ID inválido', 'erro');
}

$pdo = conectar();

try {
    // Verifica se há objetos vinculados
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tb_objetos WHERE id_categoria = ?");
    $stmt->execute([$id]);
    $total = $stmt->fetchColumn();
    
    if ($total > 0) {
        redirecionar('lista.php', "Não é possível excluir. Existem $total objeto(s) vinculado(s) a esta categoria.", 'erro');
    }
    
    $stmt = $pdo->prepare("DELETE FROM tb_categorias WHERE id_categoria = ?");
    $stmt->execute([$id]);
    redirecionar('lista.php', 'Categoria excluída com sucesso!');
} catch (PDOException $e) {
    redirecionar('lista.php', 'Erro ao excluir: ' . $e->getMessage(), 'erro');
}
?>