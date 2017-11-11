<?php
    if (isset($_POST["tabela"]) && isset($_POST["cpf"])) {
        require_once("setup.php");
        $db = new mysqli(DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME);
        $statement = $db->prepare("SELECT cpf FROM " . $_POST["tabela"] . " WHERE cpf = ?");
        if ($statement->bind_param("s", $_POST["cpf"])) {
            if ($statement->execute()) {
                $statement->store_result();
                echo $statement->num_rows;
                exit();
            }
        }
        echo "-1";
    }
    exit();
?>