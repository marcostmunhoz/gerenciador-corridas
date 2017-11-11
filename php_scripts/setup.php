<?php
    ini_set("error_reporting", "true");
    error_reporting(E_ALL|E_STRCT);

    define("DB_HOST", "us-cdbr-iron-east-05.cleardb.net");
    define("DB_NAME", "heroku_de5dfc1975ecdc6");
    define("DB_LOGIN", "b7c929ef6f1a1f");
    define("DB_PASSWD", "fe8607a4");

    function format_string(string $str, string $mask) {
        $result = "";
        $counter = 0;
        for ($i = 0; $i < strlen($mask); $i++) {
            if ($mask[$i] == "#") {
                if (isset($str[$counter])) {
                    $result .= $str[$counter];
                    $counter++;
                } else {
                    break;
                }
            } else {
                $result .= $mask[$i];
            }
        }
        return $result;
    }
?>
