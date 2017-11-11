<?php
    define("DB_HOST", "localhost");
    define("DB_NAME", "banco_corridas");
    define("DB_LOGIN", "marcos");
    define("DB_PASSWD", "98564831");

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