<?php
require_once('conbd.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idprocesso = (isset($_POST["idprocesso"]) && $_POST["idprocesso"] != null) ? $_POST["idprocesso"] : "";
    $idservidor = (isset($_POST["idservidor"]) and $_POST["idservidor"] != null) ? $_POST["idservidor"] : "";
    $idTpProcesso = (isset($_POST["idTpProcesso"]) and $_POST["idTpProcesso"] != null) ? $_POST["idTpProcesso"] : "";
    $dt_abertura = (isset($_POST["dt_abertura"]) and $_POST["dt_abertura"] != null) ? $_POST["dt_abertura"] : "";
    $descricao_processo = (isset($_POST["descricao_processo"]) and $_POST["descricao_processo"] != null) ? $_POST["descricao_processo"] : "";

} else if (!isset($idprocesso)) {
    $idservidor = (isset($_GET["idprocesso"]) && $_GET["idprocesso"] != null) ? $_GET["idprocesso"] : "";
    $idservidor = NULL;
    $idTpProcesso = NULL;
    $dt_abertura = NULL;
    $descricao_processo = NULL;
}



//cadastrando no bd
if (isset($_REQUEST["act"]) and $_REQUEST["act"] == "save") {
    try {

        if ($idprocesso != null) {
            $statement = $conexao->prepare("update processo set nome_tipo_processo=? where idTpProcesso=?");
            $statement->bindParam(5, $idTpProcesso);
        } else {
            $statement = $conexao->prepare("Insert into processo (idservidor,
            idTpProcesso,dt_abertura,descricao_processo) values (?,?,?,?)");
        }

        $statement->bindParam(1, $idservidor);
        $statement->bindParam(2, $idTpProcesso);
        $statement->bindParam(3, $dt_abertura);
        $statement->bindParam(4, $descricao_processo);




        if ($statement->execute()) {
            if ($statement->RowCount() > 0) {

                echo
                    "
                         Processo salvo com sucesso!
                    ";
                $idservidor = NULL;
                $idTpProcesso = NULL;
                $dt_abertura = NULL;
                $descricao_processo = NULL;
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
    header("Location:/processos.php");
}




?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processos Administrativos</title>
</head>

<body>
    <?php require_once('menus.php'); ?>
    <header>
        <h3>Processos</h3>
    </header>

    <nav>
        <form action="?act=save" method="POST" name="cadprocesso">
            <section>
                <input type="hidden" name="idprocesso" <?php
                                                        if (isset($idprocesso) && $idprocesso != null) {
                                                            echo "value=\"{$idprocesso}\"";
                                                        }
                                                        ?> />


                <fieldset>
                    <legend>Dados do Processo </legend>
                    <strong> Tipo de Processo Administrativo</strong>
                    <select name="idTpProcesso" required>
                        <option value="">Selecione</option>
                        <?php
                        $stm = $conexao->prepare("Select idTpProcesso,nome_tipo_processo from tipo_processo");;

                        if ($stm->execute()) {
                            while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                                echo $rs->idTpProcesso . $rs->nome_tipo_processo;
                                echo "<option value=" . $rs->idTpProcesso . ">" . $rs->nome_tipo_processo . "</option>";
                            }
                        }
                        ?>
                    </select>

                    <strong> Selecione o Servidor</strong>
                    <select name="idservidor" required>
                        <option value="">Selecione</option>
                        <?php

                        $stm = $conexao->prepare("Select idservidor,p.nome from servidores s
                inner join pessoas p on p.id=s.idpessoa");

                        if ($stm->execute()) {
                            while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                                echo "<option value=" . $rs->idservidor . ">" . $rs->nome . "</option>";
                            }
                        }
                        ?>
                    </select>

                    <strong>Data de Abertura</strong>
                    <input type="date" name="dt_abertura" required>
            </section>
            </fieldset>
            <section>
                <fieldset>
                <legend><strong>Detalhes do Processo</strong></legend>
                <br>
                <textarea name="descricao_processo" style="width: 100%;" id="" cols="40" rows="10" required placeholder="Escreva aqui os detalhes do texto"></textarea>
                </fieldset>
            </section>
            <br>
                <button type="submit">
                    Cadastrar
                </button>
        </form>
    </nav>
    <footer></footer>

</body>

</html>