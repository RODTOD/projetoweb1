<?php
/*Autor Rodrigo Moura*/

//conexão com o banco de dados
require_once('conbd.php');


#pegando campos do formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) and $_POST["nome"] != null) ? $_POST["nome"] : "";
    $cpf = (isset($_POST["cpf"]) and $_POST["cpf"] != null) ? $_POST["cpf"] : "";
    $nome_mae = (isset($_POST["nome_mae"]) and $_POST["nome_mae"] != null) ? $_POST["nome_mae"] : "";
    $data_nasc = (isset($_POST["data_nasc"]) and $_POST["data_nasc"] != null) ? $_POST["data_nasc"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
    $cpf = NULL;
    $nome_mae = NULL;
    $data_nasc = NULL;
}

//tive um bug onde tive que colocar esse bloco de código abaixo da conexão com o bd

//cadastrando no bd
if (isset($_REQUEST["act"]) and $_REQUEST["act"] == "save" and $nome <> null) {
    try {


        if ($id != "") {
            $statement = $conexao->prepare("update pessoas set nome=?,cpf=?,nome_mae=?,data_nasc=? where id=?");
            $statement->bindParam(5, $id);
        } else {
            $statement = $conexao->prepare("Insert into pessoas (nome,cpf,nome_mae,data_nasc) values (?,?,?,?)");
        }

        $statement->bindParam(1, $nome);
        $statement->bindParam(2, $cpf);
        $statement->bindParam(3, $nome_mae);
        $statement->bindParam(4, $data_nasc);
        if ($statement->execute()) {
            if ($statement->RowCount() > 0) {

                echo
                    "
                        Cadastro salvo com sucesso!
                    ";
                $nome = NULL;
                $cpf = NULL;
                $nome_mae = NULL;
                $data_nasc = NULL;
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

    #corrigiu o bug de ao atualizar o formulário inserir mais um registro
    header("Location:/cadastro_pessoas.php");
}


//alterando no bd
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id <> null) {
    try {
        echo 'aqui'.$id;
        $stm = $conexao->prepare("Select * from pessoas where id=?");
        $stm->bindParam(1, $id, PDO::PARAM_INT);

        if ($stm->execute()) {
            $rs = $stm->fetch(PDO::FETCH_OBJ);
            $id = $rs->id;
            $nome = $rs->nome;
            $cpf = $rs->cpf;
            $nome_mae = $rs->nome_mae;
            $data_nasc = $rs->data_nasc;
        } else {
            throw new PDOException("Não posso conectar a base de dados");
        }
    } catch (PDOException $error) {
        echo "Erro" . $error->getMessage();
    }
}

//deletando um registro do bd
if (isset($_REQUEST["act"]) and $_REQUEST["act"] == "del" and $id <> null) {
    try {
        #guarda "log"
        $stmlog = $conexao->prepare("insert into log_geral (nome_tabela,id_tabela,info_registro,data_op,tipo_op)
            values
            ('pessoas',?,(select nome from pessoas where id=?),now(),'Delete')");
        #tive que criar dois parâmetros mesmo sendo o mesmo ID (precisa otimizar)
        $stmlog->bindParam(1, $id, PDO::PARAM_INT);
        $stmlog->bindParam(2, $id, PDO::PARAM_INT);
        $stmlog->execute();

        #deletando o registro do BD
        $stm = $conexao->prepare("Delete from pessoas tos where id=?");
        $stm->bindParam(1, $id, PDO::PARAM_INT);

        if ($stm->execute()) {
            echo "Cadastro Excluído Com sucesso";
            $id = null;
        } else
            echo "Houve uma falha na exclusão do Cadastro";
    } catch (PDOException $error) {
        if (isset($_REQUEST["act"]) and $_REQUEST["act"] = "del" and $id <> null) {
            echo "<script>alert('Atenção! A exclusão não pode ser realizada quando houver vinculos. A edição é liberada.');  </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <title>Cadastro de Pessoas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



</head>

<body>
    <?php require_once('menus.php'); ?>

    <header>
        <h3>Cadastro de Pessoas</h3>
    </header>
    <nav>
    <form action="?act=save" method="POST" name="cadastraPessoa">
        <input type="hidden" name="id" <?php
                                        if (isset($id) && $id != null || $id != "") {
                                            echo "value=\"{$id}\"";
                                        }

                                        ?> />


        <div class="txtInsert">
            Nome:
            <input type="text" name="nome" required="" <?php
                                                        if (isset($nome) && $nome != null || $nome != "") {
                                                            echo "value=\"{$nome}\"";
                                                        }
                                                        ?> />

        </div>

        <div>
            CPF:
            <input type="text" name="cpf" required="" <?php
                                                        if (isset($cpf) and $cpf != null or $cpf != "") {
                                                            echo "value=\"{$cpf}\""; #isso é o que vai manter o texto no campo após o submit
                                                        }
                                                        ?> />
        </div>
        <div>
            Nome da Mãe:
            <input type="text" name="nome_mae" <?php
                                                if (isset($nome_mae) and $nome_mae != null or $nome_mae != "") {
                                                    echo "value=\"{$nome_mae}\"";
                                                }
                                                ?> />
        </div>
        <div>
            Data de Nascimento:
            <input type="date" name="data_nasc" <?php
                                                if (isset($data_nasc) and $data_nasc != null or $data_nasc != "") {
                                                    echo "value=\"{$data_nasc}\"";
                                                }
                                                ?> />
        </div>

        <button type="submit">
            Cadastrar
        </button>
        <hr>
    </form>

    <div>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Nome da Mãe</th>
                <th>Data de Nascimento</th>
                <th>Opção</th>
            </tr>

            <?php
            try {
                $stm = $conexao->prepare("Select * from pessoas");
                if ($stm->execute()) {
                    while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                        echo "<tr>";
                        echo "<td>" . $rs->id . "</td>" . "<td>" . $rs->nome . "</td>" . "<td>" . $rs->cpf . "</td>"
                            . "<td>" . $rs->nome_mae . "</td>" . "<td>" . $rs->data_nasc . "</td>" . "<td><center><a href=\"?act=upd&id=" . $rs->id . "\"><button class=\"btn-exclui" . "\">Alterar</button></a>"
                            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                            . "<a href=\"?act=del&id=" . $rs->id . "\"><button class=\"btn-exclui" . "\">Excluir</button></center></td>";
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
    </div>
    </nav>
</body>

</html>