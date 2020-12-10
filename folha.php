<?php
require_once('conbd.php');


//funções para calcular descontos na folha
function calcula_desconto_prev($provento_recebido)
{
    return $provento_recebido * 0.11;
}

function calcula_desconto_ir($provento_recebido)
{
    $previdencia = calcula_desconto_prev($provento_recebido);
    if ($provento_recebido <= 1903.98) {
        return 0.00;
    } else if ($provento_recebido >= 1903.99 and $provento_recebido <= 2826.65) {
        return ((($provento_recebido - $previdencia) * 0.075) - 142.80);
    } else if ($provento_recebido >= 2826.66 and $provento_recebido <= 3751.05) {
        return ((($provento_recebido - $previdencia) * 0.15) - 354.80);
    } else if ($provento_recebido >= 3751.06 and $provento_recebido <= 4664.68) {
        return ((($provento_recebido - $previdencia) * 0.225) - 636.13);
    } else {
        return ((($provento_recebido - $previdencia) * 0.275) - 869.36);
    }
}
function getValorliquido($provento,$desconto1,$desconto2)
{
    return $provento - $desconto1 - $desconto2;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idfolha = (isset($_POST["idfolha"]) && $_POST["idfolha"] != null) ? $_POST["idfolha"] : "";
    $idservidor = (isset($_POST["idservidor"]) and $_POST["idservidor"] != null) ? $_POST["idservidor"] : "";
    $idevento = (isset($_POST["idevento"]) and $_POST["idevento"] != null) ? $_POST["idevento"] : "";
    $ano = (isset($_POST["ano"]) and $_POST["ano"] != null) ? $_POST["ano"] : "";
    $mes = (isset($_POST["mes"]) and $_POST["mes"] != null) ? $_POST["mes"] : "";

    //provento
    $exec = $conexao->prepare("select remuneracao from servidores where idservidor=$idservidor");
    $exec->execute();
    $auxprov = $exec->fetch(PDO::FETCH_OBJ);
    $provento = $auxprov->remuneracao;
    //end provento

    //desconto previdencia
    $desconto_previdencia = calcula_desconto_prev($provento);

    //desconto irrf
    $desconto_imposto = calcula_desconto_ir($provento);

    //valor liquido
    $valor_liquido=getValorliquido($provento,$desconto_previdencia,$desconto_imposto);
} else if (!isset($idfolha)) {
    $idfolha = (isset($_GET["idfolha"]) && $_GET["idfolha"] != null) ? $_GET["idfolha"] : "";
    $idservidor = NULL;
    $idevento = NULL;
    $ano = null;
    $mes = null;
    $provento = NULL;
    $desconto_previdencia = null;
    $desconto_imposto = null;
    $valor_liquido =null;
}



//cadastrando no bd
if (isset($_REQUEST["act"]) and $_REQUEST["act"] == "save") {
    try {

        if ($idfolha != null) {
            //$statement = $conexao->prepare("update folha_pagamento set idevento=? where idfolha=?");
            //$statement->bindParam(6, $idfolha);
        } else {
            $statement = $conexao->prepare("Insert into folha_pagamento (idservidor,
            idevento,ano,mes,provento,desconto_previdencia,desconto_imposto,valor_liquido) 
            values (?,?,?,?,?,$desconto_previdencia,$desconto_imposto,$valor_liquido)");
        }

        $statement->bindParam(1, $idservidor);
        $statement->bindParam(2, $idevento);
        $statement->bindParam(3, $ano);
        $statement->bindParam(4, $mes);
        $statement->bindParam(5, $provento);
      
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
    header("Location:/folha.php");
}




?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Folha de Pagamento</title>
</head>

<body>
    <?php require_once('menus.php'); ?>
    <header>
        <h3>Folha de Pagamento</h3>
    </header>

    <nav>
        <form action="?act=save" method="POST" name="folha">
            <section>
                <input type="hidden" name="idfolha" <?php
                                                    if (isset($idfolha) && $idfolha != null) {
                                                        echo "value=\"{$idfolha}\"";
                                                    }
                                                    ?> />


                <fieldset>
                    <legend>Dados para inclusão em Folha</legend>
                    <strong>Servidor</strong>
                    <select name="idservidor" required>
                        <option value="">Selecione</option>
                        <?php
                        $stm = $conexao->prepare("Select s.idservidor,p.nome from servidores s 
                        join pessoas p on p.id=s.idpessoa");;

                        if ($stm->execute()) {
                            while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                                echo $rs->idservidor . $rs->nome;
                                echo "<option value=" . $rs->idservidor . ">" . $rs->nome . "</option>";
                            }
                        }
                        ?>
                    </select>

                    <strong> Selecione o Evento</strong>
                    <select name="idevento" required>
                        <option value="">Selecione</option>
                        <?php

                        $stm = $conexao->prepare("Select idevento,nome_evento from eventos");

                        if ($stm->execute()) {
                            while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                                echo "<option value=" . $rs->idevento . ">" . $rs->nome_evento . "</option>";
                            }
                        }
                        ?>
                    </select>

                    <strong>Mes</strong>
                    <input type="number" name="mes" min="1" max="12" maxlength="12" required>

                    <strong>Ano</strong>
                    <input type="number" name="ano" required>
            </section>
            </fieldset>
            <br>
            <button type="submit">
                Cadastrar
            </button>
        </form>
        <section>

            <table>
                <tr>
                    <th>Ano</th>
                    <th>Mes</th>
                    <th>Matricula</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Cargo</th>
                    <th>Evento</th>
                    <th>Valor Provento</th>
                    <th>Valor Previdência</th>
                    <th>Valor IRRF</th>
                    <th>Valor Líquido</th>
                    
                </tr>

                <?php
                try {
                    $stm = $conexao->prepare("select f.ano,f.mes,s.matricula,p.nome,p.cpf,c.nome_cargo,e.nome_evento,f.provento,f.desconto_previdencia,f.desconto_imposto,f.valor_liquido from folha_pagamento f
                    join servidores s on s.idservidor=f.idservidor
                    join pessoas p on p.id=s.idpessoa
                    join eventos e on e.idevento=f.idevento
                    join orgaos o on o.idorgao = s.idorgao
                    join cargos c on c.idcargo = s.idcargo
                    ");
                    if ($stm->execute()) {
                        while ($rs = $stm->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>" . $rs->ano . "</td>" . "<td>" . $rs->mes . "</td>" . "<td>" . $rs->matricula . "</td>"
                                . "<td>" . $rs->nome . "</td>" . "<td>" . $rs->cpf . "</td>" . "<td>" . $rs->nome_cargo . "</td>"
                                . "<td>" . $rs->nome_evento . "</td>". "<td>" . $rs->provento . "</td>". "<td>" . $rs->desconto_previdencia . "</td>"
                                . "<td>" . $rs->desconto_imposto . "</td>". "<td>" . $rs->valor_liquido . "</td>";
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