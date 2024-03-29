<?php
include_once("functions.php");

$db = ConnectDB();

// Check if the required keys are set in the $_GET array
if (isset($_GET["ID"], $_GET["upd"])) {
    $id = $_GET["ID"];
    $relatieID = $_GET["upd"];

    // Validate and sanitize user inputs
    $naam = filter_input(INPUT_GET, 'Naam', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_GET, 'Email', FILTER_VALIDATE_EMAIL);
    $telefoon = filter_input(INPUT_GET, 'Telefoon', FILTER_SANITIZE_STRING);

    if ($naam === false || $email === false || $telefoon === false) {
        // Handle invalid input
        echo "Invalid input data.";
        exit;
    }

    echo '
    <!DOCTYPE html>
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
                <h3>Mijn account wijzigen</h3>';

    // Use prepared statement to prevent SQL injection
    $sql = "UPDATE relaties 
            SET Naam = :naam, Email = :email, Telefoon = :telefoon ";

    if (!empty($_GET["Wachtwoord"])) {
        $wachtwoord = $_GET["Wachtwoord"];
        $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $sql .= ", Wachtwoord = :wachtwoord ";
    }

    $sql .= "WHERE ID = :relatieID";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':naam', $naam);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefoon', $telefoon);
    $stmt->bindParam(':relatieID', $relatieID);

    if (!empty($_GET["Wachtwoord"])) {
        $stmt->bindParam(':wachtwoord', $hashedPassword);
    }

    if ($stmt->execute()) {
        // Send email securely
        $emailSent = StuurMail(
            $email,
            "Wijziging gegevens Ultima Casa account",
            "Uw gegevens zijn als volgt gewijzigd:

            Naam: " . $naam . "
            E-mailadres: " . $email . "
            Telefoon: " . $telefoon . "
            Wachtwoord: " . $wachtwoord . "
            
            Bewaar deze gegevens goed!
            
            Met vriendelijke groet,
            
            Het Ulima Casa team.",
            "From: noreply@uc.nl"
        );

        if ($emailSent) {
            echo '<p>De gewijzigde gegevens zijn naar uw e-mail adres verstuurd.</p>';
        } else {
            echo '<p>Fout bij het versturen van de e-mail met uw gegevens.</p>';
        }
    } else {
        echo '<p>Fout bij het bewaren van uw account gegevens.</p>
              <p>' . htmlspecialchars($stmt->errorInfo()[2]) . '</p>';
    }

    echo '<br><br>
                <button class="action-button"><a href="relatie.php?RID=' . $relatieID . '" >Ok</a>
                </button>
            </div>
        </div>
    </body>
    </html>';
} else {
    echo "Required keys are not set.";
}
?>