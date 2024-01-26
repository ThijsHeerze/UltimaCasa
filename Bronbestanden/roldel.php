<?php
include_once("functions.php");

$db = ConnectDB();

$ID = isset($_GET["wis"]) ? $_GET["wis"] : null;
$relatieID = isset($_GET["RID"]) ? $_GET["RID"] : null;

if ($ID !== null) {
    $sql = "DELETE FROM rollen WHERE ID = :id";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $ID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo 'De rol is verwijderd';
    } else {
        echo 'Fout bij het verwijderen van de rol.<br><br>';
        print_r($stmt->errorInfo());
    }
} else {
    echo 'Error: ID not set.';
}

echo '<br><br>
      <button class="action-button"><a href="admin.php?RID=' . $relatieID . '">Ok</a></button>
      </div>
      </div>
      </body>
      </html>';
?>
