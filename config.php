<?php

$mydb = "bake.sqlite";

function connect()
{
    global $mydb;
    $fileName = __DIR__ . "/db/" . $mydb;

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
