<?php

define(MYDB, "bake2.sqlite");

function connect()
{
    $fileName = __DIR__ . "/db/" . MYDB;

    $dsn = "sqlite:$fileName";

    try {
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        throw $e;
    }

    return $db;
}

?>
