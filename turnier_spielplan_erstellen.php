<?php
include_once 'includes/general.inc.php';

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
            <legend> Vorrundenspielplan erstellen</legend>

                <form method = "POST" action = "turnier_spiele_erfassen.php?error=none">

                     <label> Uhrzeit Beginn Spielplan: <input type="time" name="uhrzeit_beginn" >
                    </label>
                    <br>  
                    <br>
                    <label> Pause zwischen den Spielen: <input type="time" name="pause_zwischen_spielen" >
                    </label>
                    <br>
                    <br>
                    <button type = "submit" name="spielplan_erstellen" > Vorrundenspielplan_erstellen </button>
      
                </form>
        
        </fieldset>

