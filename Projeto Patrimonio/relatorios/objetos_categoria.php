<?php
// relatorios/objetos_categoria.php
require_once '../includes/funcoes.php';
require_once '../config/conexao.php';
verificar_login();

$pdo = conectar();

$sql = "SELECT 
            c.nome as categoria,
            COUNT(o.id_objeto) as total_objetos,
            SUM(CASE WHEN o.status = 'ativo' THEN 1 ELSE 0 END) as ativos,
            SUM(o.valor) as valor_total
        FROM tb_categorias c
        LEFT JOIN tb_objetos o ON c.id_categoria = o.id_categoria
        GROUP BY c.id_categoria, c.nome
        ORDER BY total_objetos DESC";

$stmt = $pdo->query($sql);
$dados = $stmt->fetchAll();

$titulo = 'Relatório - Objetos por Categoria';
include '../includes/header.php';
?>

<h1 class="mb-4">Relatório: Objetos por Categoria</h1>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Total de Objetos</th>
                        <th>Objetos Ativos</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_geral = 0;
                    $valor_geral = 0;
                    foreach ($dados as $linha): 
                        $total_geral += $linha['total_objetos'];
                        $valor_geral += $linha['valor_total'];
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($linha['categoria']) ?></td>
                            <td><?= $linha['total_objetos'] ?></td>
                            <td><?= $linha['ativos'] ?></td>
                            <td><?= formatar_moeda($linha['valor_total']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <th>TOTAL</th>
                        <th><?= $total_geral ?></th>
                        <th>-</th>
                        <th><?= formatar_moeda($valor_geral) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="mt-3">
            <button onclick="window.print()" class="btn btn-secondary">
                <i class="bi bi-printer"></i> Imprimir
            </button>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>