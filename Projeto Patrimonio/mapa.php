<?php require_once("includes/cabecalho.php"); ?>

<h2>Relatório de Patrimônio (Mapa)</h2>

<table>
    <thead>
        <tr>
            <th>Andar</th>
            <th>Sala</th>
            <th>Placa (Etiqueta)</th>
            <th>Item</th>
            <th>Categoria</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
    <?php

    $sql = "SELECT i.codigo_etiqueta, i.nome_item, i.estado, 
                   l.nome_sala, l.andar, 
                   c.nome_categoria
            FROM tb_itens i
            JOIN tb_locais l ON i.id_local = l.id_local
            JOIN tb_categorias c ON i.id_categoria = c.id_categoria
            ORDER BY l.andar, l.nome_sala";

    $res = mysqli_query($con, $sql);

    if(mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)){
            echo "<tr>";
            echo "<td>" . $row['andar'] . "</td>";
            echo "<td>" . $row['nome_sala'] . "</td>";
            echo "<td><strong>" . $row['codigo_etiqueta'] . "</strong></td>";
            echo "<td>" . $row['nome_item'] . "</td>";
            echo "<td>" . $row['nome_categoria'] . "</td>";
            echo "<td>" . $row['estado'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6' style='text-align:center'>Nenhum item cadastrado.</td></tr>";
    }
    ?>
    </tbody>
</table>
