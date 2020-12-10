<?php
require_once('conbd.php');



#atribuicao das variaveis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idservidor = (isset($_POST["idservidor"]) && $_POST["idservidor"] != null) ? $_POST["idservidor"] : "";
    $matricula = (isset($_POST['matricula']) && $_POST['matricula'] != null) ? $_POST['matricula'] : "";
    $idpessoa = (isset($_POST['idpessoa']) && $_POST['idpessoa'] != null) ? $_POST['idpessoa'] : "";
    $idcargo = (isset($_POST['idcargo']) && $_POST['idcargo'] != null) ? $_POST['idcargo'] : "";
    $idorgao = (isset($_POST['idorgao']) && $_POST['idorgao'] != null) ? $_POST['idorgao'] : "";
    $remuneracao = (isset($_POST['remuneracao']) && $_POST['remuneracao'] != null) ? $_POST['remuneracao'] : "";
    $remuneracao = str_replace(',', '.', $remuneracao);
} else if (!isset($idservidor)) {
    $idservidor = (isset($_GET["idservidor"]) && $_GET["idservidor"] != null) ? $_GET["idservidor"] : "";
    $matricula = null;
    $idcargo = null;
    $idpessoa = null;
    $idorgao = null;
    $remuneracao = null;
}


//PERSISTINDO NO BANCO 

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $matricula <> null) {
    try {

        if ($idservidor != "") {
            $statement = $conexao->prepare("update servidores set matricula=?,idcargo=?,idpessoa=?,idorgao=?,remuneracao=? where idservidor=?");
            $statement->bindParam(6, $idservidor);


            $stmlog = $conexao->prepare("insert into log_geral (nome_tabela,id_tabela,info_registro,data_op,tipo_op)
            values
            ('servidores',?,(select matricula from servidores where idservidor=?),now(),'Update')");
            #tive que criar dois parâmetros mesmo sendo o mesmo ID (precisa otimizar)
            $stmlog->bindParam(1, $idservidor, PDO::PARAM_INT);
            $stmlog->bindParam(2, $idservidor, PDO::PARAM_INT);
            $stmlog->execute();
        } else {
            $statement = $conexao->prepare("Insert into servidores (matricula,idcargo,idpessoa,idorgao,remuneracao) 
                values (?,?,?,?,?)");
        }

        $statement->bindParam(1, $matricula);
        $statement->bindParam(2, $idcargo);
        $statement->bindParam(3, $idpessoa);
        $statement->bindParam(4, $idorgao);
        $statement->bindParam(5, $remuneracao);

        if ($statement->execute()) {
            if ($statement->RowCount() > 0) {

                echo
                    "
                    Servidor salvo com sucesso!
                    ";
                $matricula = NULL;
                $idcargo = null;
                $idpessoa = null;
                $remuneracao = null;
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
    header("Location:/cadastro_servidores.php");
}

//alterando no bd
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idservidor <> null) {
    try {
        $stm = $conexao->prepare("Select * from servidores where idservidor=?");
        $stm->bindParam(1, $idservidor, PDO::PARAM_INT);

        if ($stm->execute()) {

            $rs = $stm->fetch(PDO::FETCH_OBJ);
            $idservidor = $rs->idservidor;
            $matricula = $rs->matricula;
            $idcargo = $rs->idcargo;
            $idorgao = $rs->idorgao;
            $remuneracao = $rs->remuneracao;
        } else {
            throw new PDOException("Não posso conectar a base de dados");
        }
    } catch (PDOException $error) {
        echo "Erro" . $error->getMessage();
    }
}


//deletando um registro do bd
if (isset($_REQUEST["act"]) and $_REQUEST["act"] = "del" and $idservidor <> null) {
    try {
        #guarda "log"
        $stmlog = $conexao->prepare("insert into log_geral (nome_tabela,id_tabela,info_registro,data_op,tipo_op)
            values
            ('servidores',?,(select nome from servidores where id=?),now(),'Delete')");
        #tive que criar dois parâmetros mesmo sendo o mesmo ID (precisa otimizar)
        $stmlog->bindParam(1, $idservidor, PDO::PARAM_INT);
        $stmlog->bindParam(2, $idservidor, PDO::PARAM_INT);
        $stmlog->execute();

        #deletando o registro do BD
        $stm = $conexao->prepare("Delete from servidores tos where id=?");
        $stm->bindParam(1, $idservidor, PDO::PARAM_INT);

        if ($stm->execute()) {
            echo "Cadastro Excluído Com sucesso";
            $id = null;
        } else
            echo "Houve uma falha na exclusão do Cadastro";
    } catch (PDOException $error) {
        if (isset($_REQUEST["act"]) and $_REQUEST["act"] = "del" and $idservidor <> null) {
            echo "<script>alert('Atenção! A exclusão não pode ser realizada quando houver vinculos. A edição é liberada.');  </script>";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Servidores</title>
</head>

<body>
    <?php require_once('menus.php'); ?>
    <header>
        <h3>Cadastro de Servidores</h3>
    </header>


    <nav>
        <form action="?act=save" method="POST" name="cadastraServidores">
            <section>
                <input type="hidden" name="idservidor" <?php
                                                        if (isset($idservidor) && $idservidor != null) {
                                                            echo "value=\"{$idservidor}\"";
                                                        }

                                                        ?> />
            </section>
            <section>

            </section>
            <section>
                <strong> Matricula:</strong>
                <input type="text" name="matricula" required <?php
                                                                if (isset($matricula) && $matricula != null || $matricula != "") {
                                                                    echo "value=\"{$matricula}\"";
                                                                }
                                                                ?> />
                <br>
                <strong> Dados Pessoais:</strong>
                <select name="idpessoa" required>
                    <option value="">Selecione</option>
                    <?php

                    $stm = $conexao->prepare("Select id,nome from pessoas");;

                    if ($stm->execute()) {
                        while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                            echo "<option value=" . $rs->id . ">" . $rs->nome . "</option>";
                        }
                    }
                    ?>

                </select>

                <strong>Órgão:</strong>
                <select name="idorgao" required>
                    <option value="">Selecione</option>
                    <?php

                    $stm = $conexao->prepare("Select idorgao,nome_orgao from orgaos");;

                    if ($stm->execute()) {
                        while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                            echo "<option value=" . $rs->idorgao . ">" . $rs->nome_orgao . "</option>";
                        }
                    }
                    ?>

                </select>

                <strong>Cargo:</strong>
                <select name="idcargo" required>
                    <option value="">Selecione</option>
                    <?php

                    $stm = $conexao->prepare("Select idcargo,nome_cargo from cargos");;

                    if ($stm->execute()) {
                        while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                            echo "<option value=" . $rs->idcargo . ">" . $rs->nome_cargo . "</option>";
                        }
                    }
                    ?>

                </select>

                <strong>Remuneração:</strong>
                <input type="text" name="remuneracao" required="" <?php
                                                                    if (isset($remuneracao) && $remuneracao != null || $remuneracao != "") {
                                                                        echo "value=\"{$remuneracao}\"";
                                                                    }
                                                                    ?> />
            </section>
            <br>
            <section>
                <button type="submit">
                    <!--Perdi 2 horas por causa de uma informação nesse button-->
                    Cadastrar
                </button>
            </section>
            <br>
        </form>


        <section>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Matricula</th>
                    <th>CPF</th>
                    <th>Órgão</th>
                    <th>Cargo</th>
                    <th>Remuneração</th>
                    <th>Opção</th>
                </tr>

                <?php
                try {
                    $stm = $conexao->prepare("Select s.idservidor,p.nome,s.matricula,p.cpf,o.nome_orgao,c.nome_cargo,s.remuneracao from servidores s 
                        join pessoas p on p.id=s.idpessoa
                        join orgaos o on o.idorgao =s.idorgao
                        join cargos c on c.idcargo=s.idcargo");
                    if ($stm->execute()) {
                        while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>" . $rs->idservidor . "</td>" . "<td>" . $rs->nome . "</td>" . "<td>" . $rs->matricula . "</td>"
                                . "<td>" . $rs->cpf . "</td>" . "<td>" . $rs->nome_orgao . "</td>" . "<td>" . $rs->nome_cargo . "</td>"
                                . "<td>" . $rs->remuneracao . "</td>"
                                . "<td><center><a href=\"?act=upd&idservidor=" . $rs->idservidor . "\"><button class=\"btn-exclui" . "\">Alterar</button></a>"
                                . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                . "<a href=\"?act=del&idservidor=" . $rs->idservidor . "\"><button disabled=\"disabled" . "\" class=\"btn-exclui" . "\">Excluir</button></center></td>";
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


    <footer>


    </footer>
</body>

</html>