<?php
require_once("includes/cabecalho.php");
verificarPermissao(0); 
if(isset($_POST['btnCad'])) {
    $sala = limpeza($_POST['nome_sala']);
    $andar = limpeza($_POST['andar']);
    
    if(!empty($sala) && !empty($andar)) {

        $sql = "INSERT INTO tb_locais (nome_sala, andar) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($con);
        
        if(mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $sala, $andar);
            mysqli_stmt_execute($stmt);
            echo "<div class='sucesso'>Local Cadastrado com Sucesso!</div>";
        } else {
            echo "<div class='erro'>Erro no SQL.</div>";
        }
    } else {
        echo "<div class='erro'>Preencha todos os campos.</div>";
    }
}
?>

<h2>Gerenciar Locais</h2>
<form method="post" style="background: #f9f9f9; padding: 15px; border: 1px solid #ddd;">
    <label>Nome da Sala:</label>
    <input type="text" name="nome_sala" required placeholder="Ex: Laboratório 3">
    
    <label>Andar:</label>
    <select name="andar">
        <option value="Térreo">Térreo</option>
        <option value="1º Andar">1º Andar</option>
        <option value="2º Andar">2º Andar</option>
    </select>
    
    <br><br>
    <button type="submit" name="btnCad">Salvar Local</button>
</form>

<h3>Salas Existentes</h3>
<table>
    <thead>
        <tr>
            <th>Sala</th>
            <th>Andar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $res = mysqli_query($con, "SELECT * FROM tb_locais ORDER BY andar, nome_sala");
        while($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            echo "<td>" . $row['nome_sala'] . "</td>";
            echo "<td>" . $row['andar'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

