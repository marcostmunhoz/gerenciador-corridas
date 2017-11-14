<?php
    ini_set("error_reporting", "true");
    error_reporting(E_ALL|E_STRCT);

    define("DB_HOST", "us-cdbr-iron-east-05.cleardb.net"); // Define o host do banco de dados
    define("DB_NAME", "heroku_de5dfc1975ecdc6"); // Define o nome do banco
    define("DB_LOGIN", "b7c929ef6f1a1f"); // Define o login
    define("DB_PASSWD", "fe8607a4"); // Define a senha

    function mask($str) { // Função auxiliar para mascarar valores
        return vsprintf("%s%s%s.%s%s%s.%s%s%s-%s%s", str_split($str));
    }
?>
