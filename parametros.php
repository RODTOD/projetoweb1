<?php
require_once('conbd.php');
require_once('menus.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $idparam = (isset($_POST["idparam"]) and $_POST["idparam"] != null) ? $_POST["idparam"] : "";
    $idorgao = (isset($_POST["idorgao"]) and $_POST["idorgao"] != null) ? $_POST["idorgao"] : "";
    $missao = (isset($_POST["missao"]) and $_POST["missao"] != null) ? $_POST["missao"] : "";
    $visao = (isset($_POST["visao"]) and $_POST["visao"] != null) ? $_POST["visao"] : "";
    $valores = (isset($_POST["valores"]) and $_POST["valores"] != null) ? $_POST["valores"] : "";
    $endereco = (isset($_POST["endereco"]) and $_POST["endereco"] != null) ? $_POST["endereco"] : "";
    $contato = (isset($_POST["contato"]) and $_POST["contato"] != null) ? $_POST["contato"] : "";
} 
else if (!isset($idparam)) {
    $idparam = (isset($_GET["idparam"]) && $_GET["idparam"] != null) ? $_GET["idparam"] : "";
    $idorgao=NULL;
    $missao = NULL;
    $visao = NULL;
    $valores = NULL;
    $endereco = NULL;
    $contato = NULL;
}


//cadastrando no bd
if (isset($_REQUEST["act"]) and $_REQUEST["act"] == "save") {
    try {

            $statement = $conexao->prepare("Insert into parametros (missao,
            visao,valores,endereco,contato,idorgao) values (?,?,?,?,?,?)");
        

        $statement->bindParam(1, $missao);
        $statement->bindParam(2, $visao);
        $statement->bindParam(3, $valores);
        $statement->bindParam(4, $endereco);
        $statement->bindParam(5, $contato);
        $statement->bindParam(6, $idorgao);

        if ($statement->execute()) {
            if ($statement->RowCount() > 0) {

                echo
                    "
                         Parâmetro salvo com sucesso!
                    ";
                    $missao = NULL;
                    $visao = NULL;
                    $valores = NULL;
                    $endereco = NULL;
                    $contato = NULL;
                    $idorgao= null;
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
    header("Location:/parametros.php");
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parâmetros</title>
</head>

<body>
    <header>
        <h3>Parâmetros Visuais</h3>
    </header>

    <nav>
        <section>
            <h4></h4>
        </section>
        <form action="?act=save" method="POST">
            <fieldset>
                <legend>Informações Gerais</legend>

                <select name="idorgao" required>
                    <option value="">Selecione o Órgão</option>
                    <?php

                    $stm = $conexao->prepare("Select idorgao,nome_orgao from orgaos");;

                    if ($stm->execute()) {
                        while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                            echo "<option value=" . $rs->idorgao . ">" . $rs->nome_orgao . "</option>";
                        }
                    }
                    ?>
                </select>

                <input type="text" style="width: 50%;" name="endereco" placeholder="Insira o Endereço">

                <input type="text" name="contato" placeholder="Insira o Telefone">


            </fieldset>
            <fieldset>
                <legend>Missão</legend>
                <textarea name="missao" style="width: 100%;" cols="10" rows="5" placeholder="Insrira a Missão"></textarea>
            </fieldset>
            <fieldset>
                <legend>Visão</legend>
                <textarea name="visao" style="width: 100%;" cols="10" rows="5" placeholder="Insrira a Visão"></textarea>
            </fieldset>
            <fieldset>
                <legend>Valores</legend>
                <textarea name="valores" style="width: 100%;" cols="10" rows="5" placeholder="Insrira os Valores"></textarea>
            </fieldset>
            <button type="submit">
                Cadastrar
            </button>
        </form>
    </nav>


</body>

</html>