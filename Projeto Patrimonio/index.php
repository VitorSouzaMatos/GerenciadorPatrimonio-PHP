<?php require_once("includes/cabecalho.php"); ?>

<h1>Bem-vindo, <?php echo $_SESSION['username']; ?></h1>
<p>Utilize o menu acima para navegar no sistema.</p>
<hr>

<div style="display: flex; gap: 20px;">
    <div style="flex: 1; border: 1px solid #ccc; padding: 20px; text-align: center;">
        <h1>Mapa</h1>
        <p>Visualize todos os itens e onde eles estão.</p>
        <a href="mapa.php"><button>Ver Relatório</button></a>
    </div>

    <?php if($_SESSION['nivel'] <= 1): ?>
    <div style="flex: 1; border: 1px solid #ccc; padding: 20px; text-align: center;">
        <h1>Cadastrar</h1>
        <p>Registre novos itens no sistema.</p>
        <a href="operador_patrimonio.php"><button>Novo Item</button></a>
    </div>
    <?php endif; ?>
</div>

