<?php 
    require_once('menus.php');
    require_once('conbd.php');
    


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <H3>CONSULTA DE LOGS</H3>
    </header>

    <nav>
    <section>
            <table>
                <tr>
                    <th>ID</th>
                    <th>NOME DA TABELA</th>
                    <th>ID DA TABELA</th>
                    <th>INFORMAÇÃO NO REGISTRO QUE FOI ALTERADO</th>
                    <TH>DATA DA OPERAÇÃO</TH>
                    <TH>TIPO DA OPERAÇÃO</TH>
                </tr>
                <?php
                try {
                    $stm = $conexao->prepare("Select * from log_geral");
                    if ($stm->execute()) {
                        while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>" . $rs->id . "</td>" . "<td>" . $rs->nome_tabela."</td>"
                            . "<td>" . $rs->id_tabela."</td>" . "<td>" . $rs->info_registro."</td>". "<td>" . $rs->data_op."</td>". "<td>" . $rs->tipo_op."</td>";     
                            echo "</tr>";
                        }
                    } else {
                        echo "Dados não encontrados";
                    }
                } catch (PDOException $erro) {
                    echo "Erro:" . $erro->getMessage();
                }
                ?>
            </table>
        </section>
    </nav>
</body>
</html>