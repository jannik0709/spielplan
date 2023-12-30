<?php
include_once 'includes/general.inc.php';
?>

<!DOCTYPE html>
<html>
<!-- Aufbau eines html-Dokuments, um die grafische Einstiegsfolie darzustellen -->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Einstieg Turniespielplan</title>
        <meta name="description" content="Wegweiser.">
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
    
    <h1> Turnierspielplan erstellen </h1>
    <h2> Nachfolgend werden Ihnen verschiedenen Instrumente und Funktionalitäten zur Verfügung gestellt, um einen Spielplan für ein beliebiges Turnier zu erstellen </h2>
    
    <h3> Um die Funktionalitäten nutzen zu können ist eine entsprechende Registrierung notwendig </h3>

    <br>
    <form method = "POST" action = "turnierverantwortlicher_registrieren.php">
            <input type = "submit" name = "turnierverantwortlicher_registrieren" value = "Zur Registrierung Turnierverantwortlicher">
        </form>
        <br>
        <form method = "POST" action = "turnierverantwortlicher_anmelden.php">
            <input type = "submit" name = "turnierverantwortlicher_anmelden" value = "Zur Anmeldung Turnierverantwortlicher">
        </form>
        <br>
        <form method = "POST" action = "uebersicht_spielplan.php">
            <input type = "submit" name = "uebersicht_spielplan_anschauen" value = "Zur Spielplansübersicht">
        </form>
        <br>
        <form method = "POST" action = "uebersicht_tabelle.php">
            <input type = "submit" name = "uebersicht_tabellen_anschauen" value = "Zur Tabellenübersicht">
        </form>
    </body>
</html>