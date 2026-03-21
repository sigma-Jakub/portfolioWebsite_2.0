<?php
    $dbHandler = null;

    try {
        $dbHandler = new PDO("mysql:host=mysql;dbname=portfoliodb;charset=utf8", "root", "qwerty");
    } catch (Exception $ex) {
        echo $ex;
    }
?>