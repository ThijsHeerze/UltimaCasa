<?php
include_once("functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = ConnectDB();

    $naam = $_POST['Naam'];
    $email = $_POST['Email'];
    $telefoon = $_POST['Telefoon'];
    $wachtwoord = $_POST['Wachtwoord'];

    $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

    $sql = "INSERT INTO relaties (Naam, Email, Telefoon, Wachtwoord, FKrollenID)
               VALUES (:naam, :email, :telefoon, :wachtwoord, :fkrollenid)";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':naam', $naam, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':telefoon', $telefoon, PDO::PARAM_STR);
    $stmt->bindParam(':wachtwoord', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindValue(':fkrollenid', 10, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $result = 'De gegevens zijn naar uw e-mail adres verstuurd.';

        // Remove the unnecessary query execution here
        if (StuurMail($email,
            "Account gegevens Ultima Casa",
            "Uw inlog gegevens zijn:

                    Naam: " . $naam . "
                    E-mailadres: " . $email . "
                    Telefoon: " . $telefoon . "
                    Wachtwoord: " . $wachtwoord . "

                    Bewaar deze gegevens goed!

                    Met vriendelijke groet,

                    Het Ultima Casa team.",
            "From: noreply@uc.nl")) {
            $result = 'De gegevens zijn naar uw e-mail adres verstuurd.';
        } else {
            $result = 'Fout bij het bewaren van uw gegevens.';
        }
        echo $result;
    }
}
?>