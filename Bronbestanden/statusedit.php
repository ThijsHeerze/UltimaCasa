<?php
include_once("functions.php");

$db = ConnectDB();

$relatieid = isset($_GET['RID']) ? $_GET['RID'] : null;
$id = isset($_GET['edit']) ? $_GET['edit'] : null;

echo '
<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>Ultima Casa Admin</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="ucstyle.css?' . mt_rand() . '">
    </head>
    <body>
        <div class="container">
            <div class="col-sm-5 col-md-7 col-lg-5 col-sm-offset-4 col-md-offset-3 col-lg-offset-4">
                <h3>Status wijzigen</h3>';

if ($relatieid !== null && $id !== null) {
    $sql = "SELECT StatusCode, Status 
               FROM statussen 
              WHERE ID = $id";

    $record = $db->query($sql)->fetch();

    if ($record) {
        echo ' <form action="statusupd.php" method="GET">
                  <!-- ... rest of your form ... -->
               </form>';
    } else {
        echo 'Fout bij het ophalen van de gegevens<br><br>
                  <button class="action-button"><a href="admin.php?RID=' . $relatieid . '" >Ok</a></button>';
    }
} else {
    echo 'Error: "RID" or "edit" parameter is not set.';
}

echo '</div></div></body></html>';
?>
