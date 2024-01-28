<?php
include_once("functions.php");

$email = isset($_GET["Email"]) ? $_GET["Email"] : null;
$password = isset($_GET["Wachtwoord"]) ? $_GET["Wachtwoord"] : null;

if ($email !== null && $password !== null) {
     $db = ConnectDB();

     $sql = "SELECT relaties.ID as RID, Wachtwoord, rollen.Waarde as Rol, Landingspagina 
          FROM relaties
          LEFT JOIN rollen ON relaties.FKrollenID = rollen.ID
          WHERE Email = :email";

     $stmt = $db->prepare($sql);
     $stmt->bindParam(':email', $email, PDO::PARAM_STR);
     $stmt->execute();

     $inlog = $stmt->fetch();

     $redirect_url = 'index.php?NOAccount';
     if ($inlog && password_verify($password, $inlog['Wachtwoord'])) {
          $_SESSION['user'] = $inlog['RID'];
          header("Location: " . $inlog['Landingspagina'] . '?RID=' . $inlog['RID']);
          exit();
     } else {
          header("Location: index.php?NOAccount");
          exit();
     }
} else {
     echo 'Error: Missing parameters.';
}
?>
