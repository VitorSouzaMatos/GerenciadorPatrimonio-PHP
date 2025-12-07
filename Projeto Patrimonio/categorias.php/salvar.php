<?php
// categorias/salvar.php
require_once '../includes/funcoes.php';
require_once '../config/conexao.php';
verificar_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar('lista.php');
}

$pdo = conectar();
$id = $_POST['id_categoria'] ?? null;
$nome = limpar($_POST['nome']);
$descricao = limpar($_POST['descricao'] ?? '');

if (empty($nome)) {
    redirecionar('form.php' . ($id ? "?id=$id" : ''), 'Nome é obrigatório', 'erro');
}

try {
    if ($id) {
        // Atualizar
        $stmt = $pdo->prepare("UPDATE tb_categorias SET nome = ?, descricao = ? WHERE id_categoria = ?");
        $stmt->execute([$nome, $descricao, $id]);
        redirecionar('lista.php', 'Categoria atualizada com sucesso!');
    } else {
        // Inserir
        $stmt = $pdo->prepare("INSERT INTO tb_categorias (nome, descricao) VALUES (?, ?)");
        $stmt->execute([$nome, $descricao]);
        redirecionar('lista.php', 'Categoria cadastrada com sucesso!');
    }
} catch (PDOException $e) {
    redirecionar('form.php' . ($id ? "?id=$id" : ''), 'Erro ao salvar: ' . $e->getMessage(), 'erro');
}
?>