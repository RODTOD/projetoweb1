<?php
    require_once('conbd.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSULTA DE PROCESSOS</title>
    <?php require_once('menus.php'); ?>
</head>

<body>
    <header>
        <H3>CONSULTA DE PROCESSOS</H3>
    </header>

    <nav>
        <section>
            <table>
                <tr>
                    <th>Número Processo</th>
                    <th>MATRICÚLA</th>
                    <th>NOME</th>
                    <th>DATA ABERTURA</th>
                    <TH>ESCOPO DO PROCESSO</TH>
                    
                </tr>
                <?php
                try {
                    $stm = $conexao->prepare("Select 
                    p.idprocesso,
                    s.matricula,
                    pe.nome,
                    p.dt_abertura,
                    p.descricao_processo 
                    from processo p
                    join servidores s on s.idservidor = p.idservidor
                    join pessoas pe on pe.id=s.idpessoa");
                    if ($stm->execute() && $stm->rowCount()>0) {
                        while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>" . $rs->idprocesso . "</td>" . "<td>" . $rs->matricula . "</td>"
                                . "<td>" . $rs->nome . "</td>" . "<td>" . $rs->dt_abertura . "</td>" . "<td>" . $rs->descricao_processo . "</td>";
                            echo "</tr>";
                            
                        }
                    } else {
                        echo "<tr>Não Foram cadastrados Processos. Gentileza Cadastrar um Processo.</tr>";
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