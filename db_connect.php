<?php

    // Conexão com o banco de dados.

    $serverName = "localhost";
    $username = "root";
    $password = "";
    $db_name = "login_db";

    $connect = mysqli_connect($serverName, $username, $password, $db_name);

    if(mysqli_connect_error()) {
        echo "Falha na conexão. ".mysqli_connect_error();
    }

?>