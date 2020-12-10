<?php
/*Arquivo onde Guardo as inoformações para Conexão ao Banco de dados*/

try{
            $conexao=new PDO("mysql:host=localhost; dbname=projetoweb1", "root", "Rodrigo02",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexao->exec("set names utf8");
        }
    

        catch(PDOException $erro){
            echo "Erro na conexão:" . $erro->getMessage();

        }   
?>