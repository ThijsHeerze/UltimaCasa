<?php

include_once("functions.php");

// Check if the required keys are set in the $_GET array
if (isset($_GET['RID'], $_GET['AID'], $_GET['HID'], $_GET['Straat'], $_GET['Postcode'], $_GET['Plaats'])) {
    $db = ConnectDB();

    $relatieid = $_GET["RID"];
    $adresid = $_GET["AID"];
    $huisid = $_GET["HID"];

    // Sanitize and prepare values for SQL query
    $straat = $db->quote(trim($_GET["Straat"]));
    $postcode = $db->quote(strtoupper(str_replace(' ', '', $_GET["Postcode"])));
    $plaats = $db->quote(trim($_GET["Plaats"]));

    echo
        '<!DOCTYPE html>
     <html lang="nl">
          <head>
               <title>Mijn Ultima Casa</title>
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
                         <h3>Huis te koop aanbieden.</h3>';

    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE adressen 
                SET Straat = $straat, 
                    Postcode = $postcode, 
                    Plaats = $plaats
              WHERE ID = :adresid";

    // Prepare the statement
    $stmt = $db->prepare($sql);

    // Bind the parameter
    $stmt->bindParam(':adresid', $adresid, PDO::PARAM_INT);

    // Execute the query
    if ($stmt->execute()) {
        // Rest of your code...
        $db->commit();
        $text = "<p>De verkoopgegevens zijn gewijzigd.</p>";
    } else {
        $db->rollback();
        $text = '<p>Fout bij het wijzigen van de verkoopgegevens.</p>
                   <p>' . $sql . '</p>';
    }

    echo $text . '<br><br>
                         <button class="action-button"><a href="relatie.php?RID=' . $relatieid . '" >Ok</a>
                         </button>
                    </div>
               </div>
          </body>
     </html>';
} else {
    echo "Required keys are not set.";
}

?>
