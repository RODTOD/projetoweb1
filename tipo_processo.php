<?php
require_once('conbd.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idTpProcesso = (isset($_POST['idTpProcesso']) and $_POST['idTpProcesso'] <> null) ? $_POST['idTpProcesso'] : "";
    $nome_tipo_processo = (isset($_POST['nome_tipo_processo']) and $_POST['nome_tipo_processo'] <> null) ? $_POST['nome_tipo_processo'] : "";
} else if (!isset($idTpProcesso)) {
    $idTpProcesso = (isset($_GET["idTpProcesso"]) && $_GET["idTpProcesso"] != null) ? $_GET["idTpProcesso"] : "";
    $nome_tipo_processo = null;
}


//INSERT E UPDATE
if (isset($_REQUEST["act"]) and $_REQUEST["act"] == "save" and $nome_tipo_processo <> null) {
    try {

        if ($idTpProcesso != "") {
            $statement = $conexao->prepare("update tipo_processo set nome_tipo_processo=? where idTpProcesso=?");
            $statement->bindParam(2, $idTpProcesso);
        } else {
            $statement = $conexao->prepare("Insert into tipo_processo (nome_tipo_processo) values (?)");
        }

        $statement->bindParam(1, $nome_tipo_processo);

        if ($statement->execute()) {
            if ($statement->RowCount() > 0) {

                echo
                    "
                        Tipo de Processo salvo com sucesso!
                    ";
                $nome_tipo_processo = NULL;
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
    header("Location:/tipo_processo.php");
}

//alterando no bd
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idTpProcesso<>null) {
    try {
        $stm = $conexao->prepare("Select * from tipo_processo where idTpProcesso=?");
        $stm->bindParam(1, $idTpProcesso, PDO::PARAM_INT);
        
        if ($stm->execute()) {
            $rs = $stm->fetch(PDO::FETCH_OBJ);
            $idTpProcesso = $rs->idTpProcesso;
            $nome_tipo_processo = $rs->nome_tipo_processo;
        } else {
            throw new PDOException("Não posso conectar a base de dados");
        }
    } catch (PDOException $error) {
        echo "Erro" . $error->getMessage();
    }
}

//deletando um registro do bd
if (isset($_REQUEST["act"]) and $_REQUEST["act"] == "del" and $idorgao <> null) {
    try {
        #guarda "log"
        $stmlog = $conexao->prepare("insert into log_geral (nome_tabela,id_tabela,info_registro,data_op,tipo_op)
            values
            ('orgaos',?,(select nome_orgao from orgaos where idorgao=?),now(),'Delete')");
        #tive que criar dois parâmetros mesmo sendo o mesmo ID (precisa otimizar)
        $stmlog->bindParam(1, $idorgao, PDO::PARAM_INT);
        $stmlog->bindParam(2, $idorgao, PDO::PARAM_INT);
        $stmlog->execute();

        #deletando o registro do BD
        $stm = $conexao->prepare("Delete from orgaos tos where idorgao=?");
        $stm->bindParam(1, $idorgao, PDO::PARAM_INT);

        if ($stm->execute()) {
            echo "Cadastro Excluído Com sucesso";
            $idorgao = null;
        } else
            echo "Houve uma falha na exclusão do Cadastro";
    } catch (PDOException $error) {
            echo $error->getMessage();
            
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Tipos de Processos Administrativos</title>
</head>

<body>
    <?php require_once('menus.php'); ?>
    <header>
        <h3>Cadastro de Tipos de Processos</h3>
    </header>

    <nav>
        <form action="?act=save" method="POST" name="cadTipoProcesso">
            <section>
            <input type="hidden" name="idTpProcesso" <?php
                                                    if (isset($idTpProcesso) && $idTpProcesso != null) {
                                                        echo "value=\"{$idTpProcesso}\"";
                                                    }

                                                    ?> />


                <label for="nome_tipo_processo">Tipo de Processo</label>
                <input type="text" name="nome_tipo_processo" required 
                <?php
                    if (isset($nome_tipo_processo) and $nome_tipo_processo != null) {
                        echo "value=\"{$nome_tipo_processo}\"";
                    }
                ?> />
            </section>
            <section>
                <button type="submit">
                    Cadastrar
                </button>
            </section>
        </form>

        </section>
        <br>
        <section>
            <table>
                <tr>
                    <th>ID</th>
                    <th>TIPO PROCESSO</th>
                    <th>OPÇÃO</th>
                </tr>
                <?php
                try {
                    $stm = $conexao->prepare("Select * from tipo_processo");
                    if ($stm->execute()) {
                        while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>" . $rs->idTpProcesso . "</td>" . "<td>" . $rs->nome_tipo_processo
                                . "<td><center><a href=\"?act=upd&idTpProcesso=" . $rs->idTpProcesso
                                . "\"><button class=\"btn-exclui"
                                . "\">Alterar</button></a>"
                                . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                . "<a href=\"?act=del&idTpProcesso=" . $rs->idTpProcesso
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