<?php
include_once("functions.php");

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = filter_input(INPUT_POST, 'Naam', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL);
    $wachtwoord = filter_input(INPUT_POST, 'Wachtwoord', FILTER_SANITIZE_STRING);
    $telefoon = filter_input(INPUT_POST, 'Telefoon', FILTER_SANITIZE_STRING);
    $consent = isset($_POST['Consent']);

    // Validatie
    if (empty($naam)) {
        $errors[] = "Vul uw naam in.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Vul een geldig e-mailadres in.";
    }

    if (empty($wachtwoord) || !preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}/', $wachtwoord)) {
        $errors[] = "Het wachtwoord moet minimaal 8 tekens hebben, minimaal 1 hoofdletter, 1 cijfer, en 1 speciaal teken.";
    }

    if (empty($telefoon) || !preg_match('/^[\d\s()+-]+$/', $telefoon)) {
        $errors[] = "Vul een geldig telefoonnummer in.";
    }

    if (!$consent) {
        $errors[] = "U moet toestemming geven voor het verwerken van uw persoonlijke gegevens.";
    }

    // Als er geen fouten zijn, voeg het account toe aan de database
    if (empty($errors)) {
        // Voeg het account toe aan de database
        // ...

        echo '<div class="alert alert-success" role="alert">
                  Uw account is succesvol aangemaakt. U kunt nu inloggen.
              </div>';
    }
}

echo '
<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Ultima Casa account aanvragen</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="ucstyle.css?' . mt_rand() . '">
</head>
<body>
    <div class="container">
        <div class="col-sm-4 col-md-6 col-lg-4 col-sm-offset-4 col-md-offset-3 col-lg-offset-4">                                     
            <h4 class="text-center">Ultima Casa account aanvragen</h4>
            <form action="maakaccount.php" method="POST" onsubmit="return validatePassword()">
                <div class="form-group">
                    <label for="Naam">Naam:</label>
                    <input type="text" class="form-control" id="Naam" name="Naam" placeholder="Naam" required>
                </div>
                <div class="form-group">
                    <label for="Email">E-mailadres:</label>
                    <input type="email" class="form-control" id="Email" name="Email" placeholder="E-mailadres" required pattern="' . $emailpattern . '">
                </div>
                <div class="form-group">
                    <label for="Wachtwoord">Wachtwoord:</label>
                    <input type="password" class="form-control" id="Wachtwoord" name="Wachtwoord" placeholder="Wachtwoord" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}">
                </div>
                <div class="form-group">
                    <label for="Telefoon">Mobiel telefoonnummer:</label>
                    <input type="tel" class="form-control" id="Telefoon" name="Telefoon" placeholder="Telefoonnummer" pattern="' . $telefoonpattern . '" required>
                </div>
                <div class="form-group">
                    <label for="Consent">
                        <input type="checkbox" id="Consent" name="Consent" required>
                        Ik geef toestemming voor het verwerken van mijn persoonlijke gegevens.
                    </label>
                </div>   
                <div class="form-group">
                    <button type="submit" class="action-button" title="Uw account aanmaken">Maak account</button>
                    <button class="action-button"><a href="index.html" >Annuleren</a></button>
                </div>
            </form>

            <!-- Toon foutmeldingen -->
            ' . (!empty($errors) ? '<div class="alert alert-danger" role="alert">' . implode('<br>', $errors) . '</div>' : '') . '
        </div>
    </div>

    <script>
        function validatePassword() {
            var password = document.getElementById("Wachtwoord").value;
            var passwordPattern = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}/;

            if (!passwordPattern.test(password)) {
                alert("Het wachtwoord moet minimaal 8 tekens hebben, minimaal 1 hoofdletter, 1 cijfer, en 1 speciaal teken.");
                return false;
            }

            // Check if consent checkbox is checked
            if (!document.getElementById("Consent").checked) {
                alert("U moet toestemming geven voor het verwerken van uw persoonlijke gegevens.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>';
?>
