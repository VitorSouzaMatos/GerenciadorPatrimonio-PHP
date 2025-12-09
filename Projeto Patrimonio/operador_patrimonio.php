<?php
require_once("includes/cabecalho.php");
verificarPermissao(1);  
if(isset($_POST['btnItem'])) {

    $placa = limpeza($_POST['placa']);
    $nome = limpeza($_POST['nome']);
    $cat = limpeza($_POST['categoria']);
    $local = limpeza($_POST['local']);

    if(!empty($placa) && !empty($nome) && !empty($cat) && !empty($local)){
 
        $sql = "INSERT INTO tb_itens (codigo_etiqueta, nome_item, id_categoria, id_local) VALUES (?, ?, ?, ?)";
        
        $stmt = mysqli_stmt_init($con);
        
        if(mysqli_stmt_prepare($stmt, $sql)) {
  
            mysqli_stmt_bind_param($stmt, "ssii", $placa, $nome, $cat, $local);
            
            if(mysqli_stmt_execute($stmt)) {
                echo "<div class='sucesso'>Patrimônio cadastrado com sucesso!</div>";
            } else {

                echo "<div class='erro'>Erro: Verifique se a etiqueta já não existe.</div>";
            }
        } else {
            echo "<div class='erro'>Erro na preparação do SQL.</div>";
        }
    } else {
        echo "<div class='erro'>Preencha todos os campos!</div>";
    }
}
?>

<h1>Novo Patrimônio</h1>

<form method="post" style="background: #f9f9f9; padding: 15px; border: 1px solid #ddd;">
    
    <label>Código da Etiqueta:</label>
    <input type="text" name="placa" required placeholder="Ex: lab1-dsktop">

    <label>Descrição do Item:</label>
    <input type="text" name="nome" required placeholder="Ex: desktop01">
    
    <label>Categoria:</label>
    <select name="categoria">
        <?php
 
        $resCat = mysqli_query($con, "SELECT * FROM tb_categorias");
        while($c = mysqli_fetch_assoc($resCat)) {
            echo "<option value='{$c['id_categoria']}'>{$c['nome_categoria']}</option>";
        }
        ?>
    </select>

    <label>Localização (Sala):</label>
    <select name="local">
        <?php
 
        $resLoc = mysqli_query($con, "SELECT * FROM tb_locais ORDER BY nome_sala");
        while($l = mysqli_fetch_assoc($resLoc)) {
            echo "<option value='{$l['id_local']}'>{$l['nome_sala']} - {$l['andar']}</option>";
        }
        ?>
    </select>

    <br><br>
    <button type="submit" name="btnItem" style="width: 100%; font-size: 1.1em;">Cadastrar Item</button>

</form>

