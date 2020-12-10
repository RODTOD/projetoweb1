<?php
require_once('conbd.php');

//pegando o valor dos inputs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idorgao = (isset($_POST['idorgao']) and $_POST['idorgao'] <> null) ? $_POST['idorgao'] : "";
    $nome_orgao = (isset($_POST['nome_orgao']) and $_POST['nome_orgao'] <> null) ? $_POST['nome_orgao'] : "";
} else if (!isset($idorgao)) {
    $idorgao = (isset($_GET["idorgao"]) && $_GET["idorgao"] != null) ? $_GET["idorgao"] : "";
    $nome_orgao = null;
}

//cadastrando no bd
if (isset($_REQUEST["act"]) and $_REQUEST["act"] == "save" and $nome_orgao <> null) {
    try {


        if ($idorgao != "") {
            $statement = $conexao->prepare("update orgaos set nome_orgao=? where idorgao=?");
            $statement->bindParam(2, $idorgao);
        } else {
            $statement = $conexao->prepare("Insert into orgaos (nome_orgao) values (?)");
        }

        $statement->bindParam(1, $nome_orgao);
        if ($statement->execute()) {
            if ($statement->RowCount() > 0) {

                echo
                    "
                    Órgão salvo com sucesso!
                ";
                $nome_orgao = NULL;
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
    header("Location:/orgaos.php");
}
//alterando no bd
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idorgao<>null) {
    try {
        $stm = $conexao->prepare("Select * from orgaos where idorgao=?");
        $stm->bindParam(1, $idorgao, PDO::PARAM_INT);

        if ($stm->execute()) {
            $rs = $stm->fetch(PDO::FETCH_OBJ);
            $idorgao = $rs->idorgao;
            $nome_orgao = $rs->nome_orgao;
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
    <title>Cadastro de Orgãos</title>
</head>

<body>
    <?php require_once('menus.php'); ?>
    <header>
        <h3>Cadastro de Orgãos</h3>
    </header>

    <nav>
        <section>
            <form action="?act=save" method="POST" name="cadOrgao">

                <input type="hidden" name="idorgao" <?php
                                                    if (isset($idorgao) && $idorgao != null) {
                                                        echo "value=\"{$idorgao}\"";
                                                    }

                                                    ?> />

                <label for="nome_orgao">Órgão</label>
                <input type="text" name="nome_orgao" required="" placeholder="Digite o nome do Órgao" <?php
                                                                                                        if (isset($nome_orgao) && $nome_orgao != null || $nome_orgao != "") {
                                                                                                            echo "value=\"{$nome_orgao}\"";
                                                                                                        }
                                                                                                        ?> />
                <button type="submit">
                    Cadastrar
                </button>
            </form>
        </section>
        <br>
        <section>
            <table>
                <tr>
                    <th>ID</th>
                    <th>NOME</th>
                    <th>OPÇÃO</th>
                </tr>
                <?php
                try {
                    $stm = $conexao->prepare("Select * from orgaos");
                    if ($stm->execute()) {
                        while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>" . $rs->idorgao . "</td>" . "<td>" . $rs->nome_orgao
                                . "<td><center><a href=\"?act=upd&idorgao=" . $rs->idorgao
                                . "\"><button class=\"btn-exclui"
                                . "\">Alterar</button></a>"
                                . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                . "<a href=\"?act=del&idorgao=" . $rs->idorgao
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
</body>

</html>