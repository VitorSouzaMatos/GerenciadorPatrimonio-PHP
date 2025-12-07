<?php
// includes/header.php
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /auth/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Sistema de Patrimônio' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .nav-link.active {
            background-color: #0d6efd;
            color: white !important;
        }
        .content-wrapper {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <h5 class="px-3 mb-3">Sistema Patrimônio</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="/index.php">
                                <i class="bi bi-house-door"></i> Dashboard
                            </a>
                        </li>
                        
                        <?php if ($_SESSION['usuario_role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/categorias/lista.php">
                                <i class="bi bi-tags"></i> Categorias
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/andares/lista.php">
                                <i class="bi bi-building"></i> Andares
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/salas/lista.php">
                                <i class="bi bi-door-open"></i> Salas
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="/objetos/lista.php">
                                <i class="bi bi-box-seam"></i> Objetos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/ocorrencias/lista.php">
                                <i class="bi bi-exclamation-triangle"></i> Ocorrências
                            </a>
                        </li>
                        
                        <hr>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="/relatorios/objetos_categoria.php">
                                <i class="bi bi-bar-chart"></i> Relatórios
                            </a>
                        </li>
                        
                        <hr>
                        
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="/auth/logout.php">
                                <i class="bi bi-box-arrow-right"></i> Sair
                            </a>
                        </li>
                    </ul>
                    
                    <div class="px-3 mt-4">
                        <small class="text-muted">
                            Logado como:<br>
                            <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong><br>
                            <span class="badge bg-<?= $_SESSION['usuario_role'] === 'admin' ? 'primary' : 'secondary' ?>">
                                <?= ucfirst($_SESSION['usuario_role']) ?>
                            </span>
                        </small>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 content-wrapper">
                <?php exibir_mensagem(); ?>