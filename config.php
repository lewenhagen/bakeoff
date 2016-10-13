<?php

function connect()
{
    $fileName = __DIR__ . "/db/bakeoff.sqlite";
    $dsn = "sqlite:$fileName";

    try {
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // echo "Failed to connect to the database using DSN:<br>$dsn<br>";
        throw $e;
    }

    return $db;
}

?>
