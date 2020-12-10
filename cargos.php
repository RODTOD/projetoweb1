<?php
require_once('conbd.php');
//pegando o valor dos inputs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idcargo = (isset($_POST['idcargo']) and $_POST['idcargo'] <> null) ? $_POST['idcargo'] : "";
    $nome_cargo = (isset($_POST['nome_cargo']) and $_POST['nome_cargo'] <> null) ? $_POST['nome_cargo'] : "";
} else if (!isset($idcargo)) {
    $idcargo = (isset($_GET["idcargo"]) && $_GET["idcargo"] != null) ? $_GET["idcargo"] : "";
    $nome_cargo = null;
}

//cadastrando no bd
if (isset($_REQUEST["act"]) and $_REQUEST["act"] == "save" and $nome_cargo <> null) {
    try {


        if ($idcargo != "") {
            $statement = $conexao->prepare("update cargos set nome_cargo=? where idcargo=?");
            $statement->bindParam(2, $idcargo);
        } else {
            $statement = $conexao->prepare("Insert into cargos (nome_cargo) values (?)");
        }

        $statement->bindParam(1, $nome_cargo);
        if ($statement->execute()) {
            if ($statement->RowCount() > 0) {

                echo
                    "
                    Cadastro salvo com sucesso!
                ";
                $nome_cargo = NULL;
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
    header("Location:/cargos.php");
}
//alterando no bd
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idcargo<>null) {
    try {
        $stm = $conexao->prepare("Select * from cargos where idcargo=?");
        $stm->bindParam(1, $idcargo, PDO::PARAM_INT);

        if ($stm->execute()) {
            $rs = $stm->fetch(PDO::FETCH_OBJ);
            $idcargo = $rs->idcargo;
            $nome_cargo = $rs->nome_cargo;
        } else {
            throw new PDOException("Não posso conectar a base de dados");
        }
    } catch (PDOException $error) {
        echo "Erro" . $error->getMessage();
    }
}
//deletando um registro do bd
if (isset($_REQUEST["act"]) and $_REQUEST["act"] == "del" and $idcargo <> null) {
    try {
        #guarda "log"
        $stmlog = $conexao->prepare("insert into log_geral (nome_tabela,id_tabela,info_registro,data_op,tipo_op)
            values
            ('cargos',?,(select nome_cargo from cargos where idcargo=?),now(),'Delete')");
        #tive que criar dois parâmetros mesmo sendo o mesmo ID (precisa otimizar)
        $stmlog->bindParam(1, $idcargo, PDO::PARAM_INT);
        $stmlog->bindParam(2, $idcargo, PDO::PARAM_INT);
        $stmlog->execute();

        #deletando o registro do BD
        $stm = $conexao->prepare("Delete from cargos tos where idcargo=?");
        $stm->bindParam(1, $idcargo, PDO::PARAM_INT);

        if ($stm->execute()) {
            echo "Cadastro Excluído Com sucesso";
            $idcargo = null;
        } else
            echo "Houve uma falha na exclusão do Cadastro";
    } catch (PDOException $error) {
        if (isset($_REQUEST["act"]) and $_REQUEST["act"] = "del" and $idcargo <> null) {
            echo "('Atenção! A exclusão não pode ser realizada quando houver vinculos. A edição é liberada.')";
            
        }
    }
    header("Location:/cargos.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cargos</title>
</head>

<body>
    <?php require_once('menus.php'); ?>
    <header>
        <h3>Cadastro de Cargos</h3>
    </header>

    <nav>
        <section>
            <form action="?act=save" method="POST" name="CadastraCargo">

                <input type="hidden" name="idcargo" <?php
                                                    if (isset($idcargo) && $idcargo != null) {
                                                        echo "value=\"{$idcargo}\"";
                                                    }

                                                    ?> />

                <label for="nome_cargo">Cargo</label>
                <input type="text" name="nome_cargo" required="" placeholder="Digite o nome do Cargo" 
                <?php
                    if (isset($nome_cargo) && $nome_cargo != null || $nome_cargo != "") {
                    echo "value=\"{$nome_cargo}\"";
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
                    $stm = $conexao->prepare("Select * from cargos");
                    if ($stm->execute()) {
                        while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>" . $rs->idcargo . "</td>" . "<td>" . $rs->nome_cargo 
                                . "<td><center><a href=\"?act=upd&idcargo=" . $rs->idcargo 
                                . "\"><button class=\"btn-exclui" 
                                . "\">Alterar</button></a>"
                                . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                . "<a href=\"?act=del&idcargo=" . $rs->idcargo 
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