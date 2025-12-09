<?php 
require_once("funcoes.php"); 
expulsa(); 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Patrimônio</title>
    <style>
       
        body { font-family: sans-serif; margin: 0; padding: 0; background-color: #fff; }
        
     
        nav { background-color: #333; overflow: hidden; padding: 10px; }
        nav a { float: left; color: white; text-align: center; padding: 10px 15px; text-decoration: none; font-size: 16px; }
        nav a:hover { background-color: #ddd; color: black; }
        nav .direita { float: right; background-color: #d9534f; }
        
    
        .container { padding: 20px; max-width: 900px; margin: auto; }
     
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        

        input, select { padding: 8px; margin: 5px 0; width: 100%; box-sizing: border-box; }
        button { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #45a049; }
        
        .sucesso { background-color: #dff0d8; color: #3c763d; padding: 10px; margin: 10px 0; border: 1px solid #d6e9c6; }
        .erro { background-color: #f2dede; color: #a94442; padding: 10px; margin: 10px 0; border: 1px solid #ebccd1; }
    </style>
</head>
<body>

<nav>
    <a href="index.php">Início</a>
    <a href="mapa.php">Relatório</a>
    
    <?php if($_SESSION['nivel'] == 0):  ?>
        <a href="admin_locais.php">Gerir Locais</a>
    <?php endif; ?>

    <?php if($_SESSION['nivel'] <= 1):  ?>
        <a href="operador_patrimonio.php">Novo Patrimônio</a>
    <?php endif; ?>

    <a href="logout.php" class="direita">Sair (<?php echo $_SESSION['username']; ?>)</a>
</nav>

<div class="container">