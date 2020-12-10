<?php
require_once('conbd.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idevento = (isset($_POST['idevento']) and $_POST['idevento'] <> null) ? $_POST['idevento'] : "";
    $codigo = (isset($_POST['codigo']) and $_POST['codigo'] <> null) ? $_POST['codigo'] : "";
    $nome_evento = (isset($_POST['nome_evento']) and $_POST['nome_evento'] <> null) ? $_POST['nome_evento'] : "";
} else if (!isset($idevento)) {
    $idevento = (isset($_GET["idevento"]) && $_GET["idevento"] != null) ? $_GET["idevento"] : "";
    $nome_evento = null;
    $codigo=null;
}


#inserindo no banco
if (isset($_REQUEST["act"]) and $_REQUEST["act"] == "save" and $nome_evento <> null) {
    try {

        if ($idevento != null) {
            $statement = $conexao->prepare("update eventos set nome_evento=?,codigo=? where idevento=?");
            $statement->bindParam(3, $idevento);
        } else {
            $statement = $conexao->prepare("Insert into eventos (nome_evento,codigo) values (?,?)");
        }

        $statement->bindParam(1, $nome_evento);
        $statement->bindParam(2, $codigo);

        if ($statement->execute()) {
            if ($statement->RowCount() > 0) {

                echo
                    "
                        Evento cadastrado com sucesso!
                    ";
                $nome_evento = NULL;
                $codigo = NULL;
            } else {
                echo
                    "
                        Ocorreu um erro no cadastramento;
                    ";
            }
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: " . $erro->getMessage();
    }
    header("Location:/eventos.php");
}

//alterando no bd
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idevento <> null) {
    try {
        $stm = $conexao->prepare("Select * from eventos where idevento=?");
        $stm->bindParam(1, $idevento, PDO::PARAM_INT);

        if ($stm->execute()) {
            $rs = $stm->fetch(PDO::FETCH_OBJ);
            $idevento = $rs->idevento;
            $nome_evento = $rs->nome_evento;
            $codigo = $rs->codigo;
        } else {
            throw new PDOException("Não posso conectar a base de dados");
        }
    } catch (PDOException $error) {
        echo "Erro" . $error->getMessage();
    }
}

//deletando um registro do bd
if (isset($_REQUEST["act"]) and $_REQUEST["act"] == "del" and $idevento <> null) {
    try {
        #guarda "log"
        $stmlog = $conexao->prepare("insert into log_geral (nome_tabela,id_tabela,info_registro,data_op,tipo_op)
            values
            ('eventos',?,(select nome_evento from eventos where idevento=?),now(),'Delete')");
        #tive que criar dois parâmetros mesmo sendo o mesmo ID (precisa otimizar)
        $stmlog->bindParam(1, $idevento, PDO::PARAM_INT);
        $stmlog->bindParam(2, $idevento, PDO::PARAM_INT);
        $stmlog->execute();

        #deletando o registro do BD
        $stm = $conexao->prepare("Delete from eventos tos where idevento=?");
        $stm->bindParam(1, $idevento, PDO::PARAM_INT);

        if ($stm->execute()) {
            echo "Evento Excluído Com sucesso";
            $idorgao = null;
        } else
            echo "Houve uma falha na exclusão do Cadastro";
    } catch (PDOException $error) {
        echo $error->getMessage();
    }
    header("Location:/eventos.php");
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastros de Proventos de Folha</title>
</head>

<body>
    <?php require_once('menus.php'); ?>
    <header>
        <h3>Cadastros de Proventos de Folha</h3>
    </header>

    <nav>
        <form action="?act=save" method="POST" name="cadEvento">
            <section>
                <input type="hidden" name="idevento" <?php
                                                        if (isset($idevento) && $idevento != null) {
                                                            echo "value=\"{$idevento}\"";
                                                        }
                                                        ?> />
                <label for="nome_evento">Nome do Evento</label>
                <input type="text" name="nome_evento" required <?php
                                                                if (isset($nome_evento) and $nome_evento != null) {

                                                                    echo "value=\"{$nome_evento}\"";
                                                                }
                                                                ?> />

                <label for="codigo">Código do Evento</label>
                <input type="text" name="codigo" required <?php
                                                            if (isset($codigo) and $codigo != null) {

                                                                echo "value=\"{$codigo}\"";
                                                            }
                                                            ?> />
                <button type="submit">
                    Cadastrar
                </button>
                
            </section>
            </form>
            <br>
            <section>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>NOME</th>
                        <th>CÓDIGO</th>
                        <th>OPÇÃO</th>
                    </tr>
                    <?php
                    try {
                        $stm = $conexao->prepare("Select * from eventos");
                        if ($stm->execute()) {
                            while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>" . $rs->idevento . "</td>" . "<td>" . $rs->nome_evento . "</td>" . "<td>" . $rs->codigo . "</td>" . "<td><center><a href=\"?act=upd&idevento=" . $rs->idevento
                                    . "\"><button class=\"btn-exclui"
                                    . "\">Alterar</button></a>"
                                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                    . "<a href=\"?act=del&idevento=" . $rs->idevento
                                    . "\"><button class=\"btn-exclui"
                                    . "\">Excluir</button></center></td>";
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

    <footer></footer>

</body>

</html>