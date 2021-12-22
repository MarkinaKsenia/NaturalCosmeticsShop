<?php

    $dblocation = "127.0.0.1";
    $dbname = "beauty_formula";
    $dbuser = "root";
    $dbpassword ="root";

    $db = new mysqli($dblocation, $dbuser, $dbpassword, $dbname);
    
    if ($db->connect_errno){
        echo "Ошибка доступа к MySQL";
        exit();

    }

    return $db;
?>
