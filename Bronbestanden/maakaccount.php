<?php
include_once("functions.php");

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
                    <table>
                         <tr>
                              <th>&nbsp;</th>
                              <th class="text-center">Account</th>
                              <th>&nbsp;</th>
                         </tr>
                         <tr>
                              <td>&nbsp;</td>
                              <td>               
                                   <form action="maakaccount-save.php" method="POST" onsubmit="return validatePassword()">
                                   <div class="form-group">
                                   <label for="Consent">
                                        <input type="checkbox" id="Consent" name="Consent" required>
                                        Ik geef toestemming voor het verwerken van mijn persoonlijke gegevens.
                                   </label>
                              </div>

                              <div class="form-group"><br><br>
                                   <button type="submit" class="action-button" title="Uw account aanmaken">Maak account</button>
                                   <button class="action-button"><a href="index.html" >Annuleren</a></button>
                              </div>
                         </form>
                    </td>
                    <td>&nbsp;</td>
               </tr>
          </table>
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