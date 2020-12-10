<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&family=Roboto&display=swap');

        body {
            padding: 5px;
            margin: 10px;
            font-family: 'Roboto', sans-serif;
            overflow: auto;
        }

        H3 {
            text-transform: uppercase;
        }

        /*Menu superior*/
        #menu ul {
            padding: 0px;
            margin: 0px;
            float: left;
            width: 100%;
            background-color: #EDEDED;
            list-style: none;
            font: 80% Tahoma;
        }

        #menu ul li {
            display: inline;
        }

        #menu ul li a {
            background-color: #EDEDED;
            color: #333;
            text-decoration: none;
            border-bottom: 3px solid #333;
            padding: 2px 10px;
            float: left;
        }

        #menu ul li a:hover {
            background-color: #D6D6D6;
            color: #6D6D6D;
            border-bottom: 3px solid #4abdac;
        }

        /*Inputs*/
        input {
            border: 0;
            border-bottom: 2px solid black;
            outline: none;
            transition: .2s ease-in-out;
            box-sizing: border-box;
        }

        /*Tables*/
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;

        }

        table {
            width: 100%;
        }

        th {
            height: 50px;
        }

        th,
        td {
            border-bottom: 0px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        th {
            background-color: #4abdac;
            color: white;
        }

        /*botoes*/
        button {
            background-color: #4abdac;
            border: none;
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            font-size: 16px;
            border-radius: 4px;

        }

        button:hover {
            background-color: #1accac;
        }

        .btn-exclui:disabled {
            background-color: gray;

            /* Green */
            border: none;
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            font-size: 16px;
            border-radius: 4px;
        }

        /*select*/
        select {

            appearance: none;

            background-color: transparent;
            border: 1px solid;
            border-radius: 4px;
            padding: 0 1em 0 0;
            margin: 0;
            width: 100%;
            font-family: inherit;
            font-size: inherit;

            line-height: inherit;
        }

        /*links*/
        a {
            border-bottom: none;
            text-decoration: none;
        }

        /*footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 30PX;
            background-color: #eeeeee;
            color: black;
            text-align: center;
        }*/
    </style>
</head>

<body>
    <header>

        <div id="menu">
            <ul>
            <li><a href="inicio.php">Inicio</a></li>
                <li><a href="cadastro_pessoas.php">Cadastro de Pessoas</a></li>
                <li><a href="cadastro_servidores.php">Cadastro de Servidores</a></li>
                <li><a href="cargos.php">Cadastro de Cargos</a></li>
                <li><a href="orgaos.php">Cadastro de Órgãos</a></li>
                <li><a href="processos.php">Processos</a></li>
                <li><a href="consulta_processo.php">Consulta Processos</a></li>
                <li><a href="tipo_processo.php">Tipos Processos</a></li>
                <li><a href="folha.php">Folha de Pagamento</a></li>
                <li><a href="eventos.php">Eventos de Folha</a></li>
                <li><a href="parametros.php">Parâmetros</a></li>
                <li><a href="log_geral.php">Logs do Sistema</a></li>
            </ul>
        </div>

    </header>


    <!--<footer>
        <h6>2020 - UFMT</h6>
    </footer>-->
</body>

</html>