<?php
    require_once('conbd.php');
    require_once('menus.php');

    /*Autor Rodrigo Moura
    Esse arquivo tem por objetivo ser a tela inicial do sistema;

    Usei HTML injection de consultas na tabela de parâmetros para mostrar os resultados nessa tela;
    
    */
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <header>
        <?php
                $stm=$conexao->prepare("select o.nome_orgao 
                from parametros p 
                join orgaos o on o.idorgao = p.idorgao
                order by p.idparam desc limit 1");
                if($stm->execute()){
                    if ($stm->RowCount() > 0)
                    {
                    $rs=$stm->fetch(PDO::FETCH_OBJ);
                    echo "<h3>".$rs->nome_orgao."</h3>";
                    }
                    else{
                        echo"Por gentileza, preencha os parâmetros para visualizar as informações na tela inicial.";
                    }

                }
            ?>
    </header>

    <nav>
        <section><h4></h4></section>
        <fieldset>
            <legend><strong>Missão</strong></legend>
            <?php
                $stm=$conexao->prepare("select missao from parametros order by idparam desc limit 1");
                if($stm->execute()){
                    if ($stm->RowCount() > 0)
                    {
                    $rs=$stm->fetch(PDO::FETCH_OBJ);
                    echo $rs->missao;
                    }
                    else{
                        echo"Por gentileza, preencha os parâmetros para visualizar as informações na tela inicial.";
                    }

                }
            ?>
        </fieldset>
        <fieldset>
            <legend><strong>Visão</strong></legend>
            <?php
                $stm=$conexao->prepare("select visao from parametros order by idparam desc limit 1");
                if($stm->execute()){
                    if ($stm->RowCount() > 0)
                    {
                    $rs=$stm->fetch(PDO::FETCH_OBJ);
                    echo $rs->visao;
                    }
                    else{
                        echo"Por gentileza, preencha os parâmetros para visualizar as informações na tela inicial.";
                    }

                }
            ?>
        </fieldset>
        <fieldset>
            <legend><strong>Valores</strong></legend>
            <?php

                $stm=$conexao->prepare("select valores from parametros order by idparam desc limit 1");
                if($stm->execute()){
                    if ($stm->RowCount() > 0)
                    {
                    $rs=$stm->fetch(PDO::FETCH_OBJ);
                    echo $rs->valores;
                    }
                    else{
                        echo"Por gentileza, preencha os parametros para visualizar as informações na tela inicial.";
                    }

                }
            ?>
        </fieldset>
        <fieldset>
            <legend><strong>Informações Gerais</strong></legend>
            <?php
                $stm=$conexao->prepare("select contato,endereco from parametros order by idparam desc limit 1");
                if($stm->execute()){
                    if($stm->rowCount()>0)
                    {
                    $rs=$stm->fetch(PDO::FETCH_OBJ);
                    echo "<strong>Contato:</strong>".$rs->contato."<br>"."<strong>Endereço:</strong>".$rs->endereco;
                    }
                    else{
                        echo"Por gentileza, preencha os parametros para visualizar as informações na tela inicial.";
                    }
                }
            ?>
        </fieldset>
    </nav>
    
    
</body>
</html>