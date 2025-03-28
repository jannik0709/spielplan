<?php

require_once 'includes/general.inc.php';
require_once 'includes/dhb.inc.php';

?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Turnier erstellen</title>
        <meta name="description" content="Turnier erstellen.">
        <link rel="stylesheet" href="main.css">
    </head>


    <body>

        <!-- Felder werden zur dem Turnierverantwortlicher zur Verfügung gestellt, über welchen dieser sich anmelden kann -->

        <fieldset>
            <legend> Turnier erstellen</legend>

                <form method = "POST" action = "turnier_gruppen_erfassen.php?error=none">

                    <label> Turniername: <input type="text" name="turnier_name" >
                    </label>
                    <br>
                    <br>
                    <label> Anzahl Mannschaften: <input type="text" name="turnier_anzahl_mannschaften" >
                    </label>
                    <br>
                    <br>
                    <label> Minimale Gruppengröße: <input type="text" name="turnier_maximale_gruppengröße" >
                    </label>
                    <br>
                    <br>
                    <label> Anzahl Spielfelder <input type="text" name="turnier_anzahl_spielfelder" >
                    </label>
                    <br>
                    <br>  
                    <label> Mit Endrunde? <input type="checkbox" name="mit_ohne_endrunde" value="mit_endrunde">
                    </label>
                    <br>
                    <br>
                    <label> Mit Platzierungsspiele? <input type="checkbox" name="mit_ohne_platzierungsspiele" value="mit_endrunde">
                    </label>
                    <br>
                    <br>
                    <button type = "submit" name="turnier_erstellen" > Turnier erstellen </button>
      
                </form>
        
        </fieldset>

    <?php

        if (isset($_GET["error"])){
            if($_GET["error"] == "nichtallefelderausgefüllt"){
                echo "<p> Bitte füllen Sie alle Felder aus!</p>";
            }
            if($_GET["error"] == "turniernameexistiertbereits"){
                echo "<p> Bitte geben Sie einen anderen Turniernamen ein!</p>";
            }
        }

    ?>  