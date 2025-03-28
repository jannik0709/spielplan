<?php

require_once 'includes/general.inc.php';
require_once 'includes/dhb.inc.php';
require_once 'includes/functions_turnierverantwortlicher_anmelden.inc.php';

if (!isset($_GET["error"])){
    $turnierverantwortlicher_email = mysqli_real_escape_string($conn, $_POST["turnierverantwortlicher_e_mail_adresse"]);
    $turnierverantwortlicher_passwort = mysqli_real_escape_string($conn, $_POST["turnierverantwortlicher_passwort"]);
    

if (leeresEingabefeld($turnierverantwortlicher_email, $turnierverantwortlicher_passwort) !== false){
    header("location: ../spielplan/turnierverantwortlicher_anmelden.php?error=bitteallefelderausfüllen");
        exit();
}

anmeldenTurnierverantwortlicher($conn, $turnierverantwortlicher_email, $turnierverantwortlicher_passwort);
}

?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Turnierverantwortlicher registrieren</title>
        <meta name="description" content="Turnierverantwortlicher Aktionen>
        <link rel="stylesheet" href="main.css">
    </head>

    <body>

    <fieldset>
            <legend> Aktionen Turnierverantwortlicher</legend>

                <form method = "POST" action = "turnier_erstellen.php">
        
                   <button type = "submit" name="turnierverantwortlicher_turnier_erstellen" > TURNIER erstellen</button>
      
                </form>

                <br>

                <form method = "POST" action = "turnier_bearbeiten.php">
        
                   <button type = "submit" name="turnierverantwortlicher_turnier_bearbeiten" > TURNIER bearbeiten </button>
      
                </form>

                <br>

                <form method = "POST" action = "turnier_löschen.php">
        
                   <button type = "submit" name="turnierverantwortlicher_turnier_löschen" > TURNIER löschen </button>
      
                </form>
        
        </fieldset>

    </body>

</html>
