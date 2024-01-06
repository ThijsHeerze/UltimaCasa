<?php

include_once("functions.php");

$db = ConnectDB();

$relatieid = isset($_GET["RID"]) ? $_GET["RID"] : null;
$status = isset($_GET["Status"]) ? trim($_GET["Status"]) : null;
$statuscode = isset($_GET["Statuscode"]) ? $_GET["Statuscode"] : null;

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
            <h3>Status toevoegen.</h3>';

if ($relatieid !== null && $status !== null && $statuscode !== null) {
    $status = $db->quote($status); // Quote the status value to prevent SQL injection

    $sql = "INSERT INTO statussen (StatusCode, Status) VALUES ($statuscode, $status)";

    if ($db->query($sql) == true) {
        echo 'De status is toegevoegd.';
    } else {
        echo 'Fout bij het toevoegen van de status.<br><br>' . $sql;
    }
} else {
    echo 'Error: "RID," "Status," or "Statuscode" parameter is not set.';
}

echo '<br><br>
<button class="action-button"><a href="admin.php?RID=' . $relatieid . '" >Ok</a></button>
</div>
</div>
</body>
</html>';
?>
