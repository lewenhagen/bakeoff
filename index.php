<?php

include("config.php");
include("functions.php");

$addNewBaker = isset($_POST["newBaker"]) ? "yes" : null;
$addNew = isset($_POST["newPerson"]) ? htmlentities($_POST["newPerson"]) : null;
$removeBaker = isset($_GET["remove"]) ? $_GET["remove"] : null;
$editBaker = isset($_GET["edit"]) ? $_GET["edit"] : null;
$bakerStuff = isset($_POST["bakerStuff"]) ? htmlentities($_POST["bakerStuff"]) : null;

$buttonText = "Get new baker";
$buttonClasses = "btn btn-lg btn-success";

$db = connect();

if ($addNewBaker != null) {
    global $buttonText;
    global $buttonClasses;
    $nrLeft = count(getAvailableBakers($db));
    if ($nrLeft == 1) {
        $buttonText = "Reset database";
        $buttonClasses = "btn btn-lg btn-warning";

        createBaker($db);
    } else if ($nrLeft == 0) {
        resetDB($db);

    } else {
        createBaker($db);
    }
}

if ($removeBaker != null) {
    removeBaker($db, $removeBaker);
}

if ($addNew != null) {
    insertPerson($db, $addNew);
}

if ($editBaker != null && $bakerStuff != null) {
    global $editBaker;

    updateBakerWithBakedCookie($db, $editBaker, $bakerStuff);

    $editBaker = null;
}
?>

<!doctype html>
<html>
<head>
    <title>Webb Bakeoff!</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="row">
        <div class="jumbotron">
            <h1>Webbprogramming Bakeoff</h1>
            <p></p>
        </div>

    </div>
    <div class="container">

        <div class="row">
            <div class="col-md-4">
                <h2>Latest bakers</h2><form class="singleButton" method="POST"><button class="<?=$buttonClasses;?>" name="newBaker" type="submit"><?=$buttonText;?></button></form>
                <?=printTableOfBakeoffs($db);?>

            </div>

            <div class="col-md-4">
                <h2>Available bakers</h2>
                <?=printAvailableBakers($db);?>
            </div>

            <div class="col-md-4">
              <h2>Contestants</h2>
              <?=printTableOfPersons($db);?>
              <form method="POST">
                  <input type="text" name="newPerson">
                  <button type="submit">Add person</button>
              </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h2>Edit baker</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="bakerId">Baker id:</label>
                        <input type="number" name="bakerId" value="<?=$editBaker;?>" class="form-control" id="bakerId" readonly>
                    </div>
                    <div class="form-group">
                        <label for="bakerStuff">What got baked?</label>
                        <input type="text" name="bakerStuff" class="form-control" id="bakerStuff">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-warning">Edit baker</button>
                    </div>

                </form>
            </div>
            <div class="col-md-4">
              <h2>The Rules</h2>
              <ul class="list-group">
                  <li class="list-group-item">Only choose new baker on Wednesdays, when all are present</li>
                  <li class="list-group-item">You have to bake it yourself. If you buy it - you lose it!</li>
                  <li class="list-group-item">At least one piece of cookie/cake/biscuit for each contestant</li>
              </ul>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>
