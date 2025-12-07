<?php
// objetos/lista.php
require_once '../includes/funcoes.php';
require_once '../config/conexao.php';
verificar_login();

$pdo = conectar();

// Filtros
$busca = $_GET['busca'] ?? '';
$categoria_filtro = $_GET['categoria'] ?? '';
$status_filtro = $_GET['status'] ?? '';
$sala_filtro = $_GET['sala'] ?? '';

// Query base
$sql = "SELECT o.*, c.nome as categoria_nome, s.nome as sala_nome, a.nome as andar_nome
        FROM tb_objetos o
        JOIN tb_categorias c ON o.id_categoria = c.id_categoria
        JOIN tb_salas s ON o.id_sala = s.id_sala
        JOIN tb_andares a ON s.id_andar = a.id_andar
        WHERE 1=1";

$params = [];

if ($busca) {
    $sql .= " AND (o.nome LIKE ? OR o.placa LIKE ?)";
    $params[] = "%$busca%";
    $params[] = "%$busca%";
}

if ($categoria_filtro) {
    $sql .= " AND o.id_categoria = ?";
    $params[] = $categoria_filtro;
}

if ($status_filtro) {
    $sql .= " AND o.status = ?";
    $params[] = $status_filtro;
}

if ($sala_filtro) {
    $sql .= " AND o.id_sala = ?";
    $params[] = $sala_filtro;
}

$sql .= " ORDER BY o.data_criacao DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$objetos = $stmt->fetchAll();

// Dados para filtros
$categorias = $pdo->query("SELECT id_categoria, nome FROM tb_categorias ORDER BY nome")->fetchAll();
$salas = $pdo->query("SELECT s.id_sala, s.nome, a.nome as andar_nome FROM tb_salas s JOIN tb_andares a ON s.id_andar = a.id_andar ORDER BY a.ordem, s.nome")->fetchAll();

$titulo = 'Objetos';
include '../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Objetos do Patrimônio</h1>
    <?php if ($_SESSION['usuario_role'] === 'admin'): ?>
        <a href="form.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Novo Objeto
        </a>
    <?php endif; ?>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="busca" class="form-control" placeholder="Buscar..." value="<?= htmlspecialchars($busca) ?>">
                </div>
                <div class="col-md-3">
                    <select name="categoria" class="form-select">
                        <option value="">Todas as categorias</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id_categoria'] ?>" <?= $categoria_filtro == $cat['id_categoria'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Todos os status</option>
                        <option value="ativo" <?= $status_filtro == 'ativo' ? 'selected' : '' ?>>Ativo</option>
                        <option value="inativo" <?= $status_filtro == 'inativo' ? 'selected' : '' ?>>Inativo</option>
                        <option value="manutencao" <?= $status_filtro == 'manutencao' ? 'selected' : '' ?>>Manutenção</option>
                        <option value="descartado" <?= $status_filtro == 'descartado' ? 'selected' : '' ?>>Descartado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="sala" class="form-select">
                        <option value="">Todas as salas</option>
                        <?php foreach ($salas as $sala): ?>
                            <option value="<?= $sala['id_sala'] ?>" <?= $sala_filtro == $sala['id_sala'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($sala['andar_nome'] . ' - ' . $sala['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Placa</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Localização</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($objetos)): ?>
                        <tr><td colspan="7" class="text-center">Nenhum objeto encontrado</td></tr>
                    <?php else: ?>
                        <?php foreach ($objetos as $obj): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($obj['placa'] ?? '-') ?></strong></td>
                                <td><?= htmlspecialchars($obj['nome']) ?></td>
                                <td><?= htmlspecialchars($obj['categoria_nome']) ?></td>
                                <td><?= htmlspecialchars($obj['andar_nome'] . ' - ' . $obj['sala_nome']) ?></td>
                                <td><?= formatar_moeda($obj['valor']) ?></td>
                                <td><?= badge_status_objeto($obj['status']) ?></td>
                                <td>
                                    <a href="visualizar.php?id=<?= $obj['id_objeto'] ?>" class="btn btn-sm btn-info" title="Visualizar">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if ($_SESSION['usuario_role'] === 'admin'): ?>
                                        <a href="form.php?id=<?= $obj['id_objeto'] ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="excluir.php?id=<?= $obj['id_objeto'] ?>" class="btn btn-sm btn-danger btn-excluir" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            <strong>Total: <?= count($objetos) ?> objeto(s)</strong>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>