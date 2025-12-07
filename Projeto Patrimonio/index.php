<?php
// index.php
require_once 'includes/funcoes.php';
require_once 'config/conexao.php';
verificar_login();

$pdo = conectar();

// Estatísticas
$total_objetos = $pdo->query("SELECT COUNT(*) FROM tb_objetos")->fetchColumn();
$total_categorias = $pdo->query("SELECT COUNT(*) FROM tb_categorias")->fetchColumn();
$total_salas = $pdo->query("SELECT COUNT(*) FROM tb_salas")->fetchColumn();
$ocorrencias_abertas = $pdo->query("SELECT COUNT(*) FROM tb_ocorrencias WHERE status != 'resolvida'")->fetchColumn();

$valor_total = $pdo->query("SELECT SUM(valor) FROM tb_objetos WHERE status = 'ativo'")->fetchColumn() ?? 0;

// Objetos por status
$stmt = $pdo->query("SELECT status, COUNT(*) as total FROM tb_objetos GROUP BY status");
$objetos_status = $stmt->fetchAll();

// Últimas ocorrências
$stmt = $pdo->prepare("
    SELECT o.*, obj.nome as objeto_nome, u.nome as usuario_nome
    FROM tb_ocorrencias o
    JOIN tb_objetos obj ON o.id_objeto = obj.id_objeto
    JOIN tb_usuarios u ON o.id_usuario = u.id_usuario
    ORDER BY o.data_criacao DESC
    LIMIT 5
");
$stmt->execute();
$ultimas_ocorrencias = $stmt->fetchAll();

$titulo = 'Dashboard';
include 'includes/header.php';
?>

<h1 class="mb-4">Dashboard</h1>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total de Objetos</h5>
                <h2><?= $total_objetos ?></h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Categorias</h5>
                <h2><?= $total_categorias ?></h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Salas</h5>
                <h2><?= $total_salas ?></h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Ocorrências Pendentes</h5>
                <h2><?= $ocorrencias_abertas ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Valor Total do Patrimônio Ativo</h5>
            </div>
            <div class="card-body">
                <h3 class="text-success"><?= formatar_moeda($valor_total) ?></h3>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Objetos por Status</h5>
            </div>
            <div class="card-body">
                <?php foreach ($objetos_status as $status): ?>
                    <div class="mb-2">
                        <?= badge_status_objeto($status['status']) ?>
                        <strong><?= $status['total'] ?></strong> objetos
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Últimas Ocorrências</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Objeto</th>
                                <th>Tipo</th>
                                <th>Usuário</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($ultimas_ocorrencias)): ?>
                                <tr><td colspan="5" class="text-center">Nenhuma ocorrência registrada</td></tr>
                            <?php else: ?>
                                <?php foreach ($ultimas_ocorrencias as $oc): ?>
                                    <tr>
                                        <td><?= formatar_data($oc['data_ocorrencia']) ?></td>
                                        <td><?= htmlspecialchars($oc['objeto_nome']) ?></td>
                                        <td><?= traduzir_tipo_ocorrencia($oc['tipo']) ?></td>
                                        <td><?= htmlspecialchars($oc['usuario_nome']) ?></td>
                                        <td><?= badge_status_ocorrencia($oc['status']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>