<?php

include_once("functions.php");

$db = ConnectDB();

$relatieid = isset($_GET["RID"]) ? $_GET["RID"] : null;
$naam = isset($_GET["Naam"]) ? trim($_GET["Naam"]) : null;
$omschrijving = isset($_GET["Omschrijving"]) ? trim($_GET["Omschrijving"]) : null;
$waarde = isset($_GET["Waarde"]) ? $_GET["Waarde"] : null;
$landingspagina = isset($_GET["Landingspagina"]) ? trim($_GET["Landingspagina"]) : null;

if ($relatieid !== null && $naam !== null && $omschrijving !== null && $waarde !== null && $landingspagina !== null) {
    $sql = "INSERT INTO rollen (Naam, Omschrijving, Waarde, Landingspagina) VALUES (:naam, :omschrijving, :waarde, :landingspagina)";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':naam', $naam, PDO::PARAM_STR);
    $stmt->bindParam(':omschrijving', $omschrijving, PDO::PARAM_STR);
    $stmt->bindParam(':waarde', $waarde, PDO::PARAM_INT);
    $stmt->bindParam(':landingspagina', $landingspagina, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo 'De rol is toegevoegd.';
    } else {
        echo 'Fout bij het toevoegen van deze rol.<br><br>';
        print_r($stmt->errorInfo());  // Print the error information for debugging
    }
} else {
    echo 'Error: Missing parameters.';
}

echo '<br><br>
      <button class="action-button"><a href="admin.php?RID=' . $relatieid . '">Ok</a></button>
      </div>
      </div>
      </body>
      </html>';
?>
