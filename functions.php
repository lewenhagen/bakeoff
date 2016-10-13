<?php

function insertPerson($db, $newPerson)
{
    $sql = "INSERT INTO contestants (name) VALUES ('$newPerson')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
}

function getAll($db)
{
    $sql = "SELECT * FROM contestants";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

function getAvailableBakers($db)
{
    $sql = "SELECT * FROM contestants WHERE haveBaked = 0";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

function countBakers($db)
{
    $sql = "SELECT COUNT(*) FROM contestants";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

function printTableOfPersons($db)
{
    $sql = "SELECT * FROM contestants";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = null;
    $html = "<table class='table'><thead><tr><th>#</th><th>Name</th><th>Delete</th></tr></thead>";

    foreach ($res as $row) {
        $html .= "<tr><td>{$row['id']}</td>";
        $html .= "<td>{$row['name']}</td>";
        $html .= "<td><a href='?remove={$row['id']}'>X</a></td></tr>";
    }
    $html .= "</table>";

    return $html;
}

function printTableOfBakeoffs($db)
{
    $sql = "SELECT * FROM bakeoffs";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = null;
    $html = "<table class='table'><thead><tr><th>#</th><th>Baker</th><th>Letter</th><th>Week</th><th>Baked</th></tr></thead>";
    $reversed = array_reverse($res);
    foreach ($reversed as $row) {
        $html .= "<tr><td>{$row['id']}</td>";
        $html .= "<td><a href='?edit={$row['id']}'>{$row['name']}</a></td>";
        $html .= "<td>{$row['letter']}</td>";
        $html .= "<td>{$row['date']}</td>";
        $html .= "<td>{$row['baked']}</td></tr>";
    }
    $html .= "</table>";

    return $html;
}

function printAvailableBakers($db)
{
    $res = getAvailableBakers($db);

    $html = null;
    $html = "<table class='table'><thead><tr><th>#</th><th>Baker</th></tr></thead>";

    foreach ($res as $row) {
        $html .= "<tr><td>{$row['id']}</td>";
        $html .= "<td>{$row['name']}</td></tr>";
    }
    $html .= "</table>";

    return $html;

}

function removeBaker($db, $id)
{
    $sql = "DELETE FROM contestants WHERE id = ?";
    $stmt = $db->prepare($sql);
    $params = [$id];
    $stmt->execute($params);
}

function setBaked($db, $id)
{
    $sql = "UPDATE contestants SET haveBaked=1 WHERE id = $id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
}

function insertIntoBakeoff($db, $baker)
{
    $letter = chr(rand(65,90));

    while ($letter == "Q" || $letter == "Z" || $letter == "Y" || $letter == "X" || $letter == "W") {
        $letter = chr(rand(65,90));
    }

    $date = new DateTime(date("Y-m-d"));

    $currWeek = (int)$date->format("W") + 1;
    $currWeek2 = (string)$currWeek;


    $sql = "INSERT INTO bakeoffs (name, letter, date, baked) VALUES ('$baker', '$letter', '$currWeek2', 'N/A')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
}

function createBaker($db)
{
    if (date('l') == "Wednesday") {
        $res = getAvailableBakers($db);

        shuffle($res);

        $nextBaker = array_pop($res);

        setBaked($db, $nextBaker["id"]);

        insertIntoBakeoff($db, $nextBaker["name"]);
    } else {
        echo "<script type='text/javascript'>alert('IT´S NOT WEDNESDAY, CHEATER! GO AND BAKE SOMETHING!');</script>";
    }
}

function updateBakerWithBakedCookie($db, $id, $stuff)
{
    $sql = "UPDATE bakeoffs SET baked = '$stuff' WHERE id = $id";
    // $params = [$stuff, $id];
    $stmt = $db->prepare($sql);
    $stmt->execute();
}

function resetDB($db)
{
    $sql = "UPDATE contestants SET haveBaked=0";
    $stmt = $db->prepare($sql);

    $stmt->execute();
}

?>
