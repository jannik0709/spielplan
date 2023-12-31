<?php
    
    require_once 'includes/dhb.inc.php';
    require_once 'includes/functions_turnierverantwortlichler_registrieren.inc.php';

    if (isset($_POST["turnierverantwortlicher_registrieren"]) == true){

        $turnierverantwortlicher_email = mysqli_real_escape_string($conn,$_POST['turnierverantwortlicher_e_mail_adresse']);
        $turnierverantwortlicher_passwort = mysqli_real_escape_string($conn,$_POST['turnierverantwortlicher_passwort']);
        $turnierverantwortlicher_name = mysqli_real_escape_string($conn,$_POST['turnierverantwortlicher_name']);

        if (leeresEingabefeld($turnierverantwortlicher_email, $turnierverantwortlicher_passwort, $turnierverantwortlicher_name) !== false){
            header("location: ../spielplan/turnierverantwortlicher_registrieren.php?error=nichtallefelderausgefüllt");
            exit();
        }

        if (email_existiert($conn, $turnierverantwortlicher_email) !== false){
            header("location: ../spielplan/turnierverantwortlicher_registrieren.php?error=vergebene_email_adresse");
            exit();
        }

        registieren_turnierverantwortlicher($conn, $turnierverantwortlicher_email, $turnierverantwortlicher_passwort, $turnierverantwortlicher_name);    }

    ?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Turnierverantwortlicher anmelden</title>
        <meta name="description" content="Turnierverantwortlicher anmelden.">
        <link rel="stylesheet" href="main.css">
    </head>


    <body>

        <!-- Felder werden zur dem Turnierverantwortlicher zur Verfügung gestellt, über welchen dieser sich anmelden kann -->

        <fieldset>
            <legend> Anmeldung Turnierverantwortlicher</legend>

                <form method = "POST" action = "turnierverantwortlicher_aktionen.php">
        
                    <label> E-Mail Adresse: <input type="text" name="turnierverantwortlicher_e_mail_adresse" >
                    </label>
                    <br>
                    <br>
                    <label> Passwort: <input type="password" name="turnierverantwortlicher_passwort" >
                    </label>
                    <br>
                    <br> 
                   
                    <button type = "submit" name="turnierverantwortlicher_anmelden" > anmelden</button>
      
                </form>
        
        </fieldset>

        <?php

            if (isset($_GET["error"])){
                if($_GET["error"] == "bitteallefelderausfüllen"){
                    echo "<p> Bitte füllen Sie alle Felder aus!</p>";
                } else if ($_GET["error"] == "emailadressenichtvorhanden"){
                    echo "<p> Bitte geben Sie eine andere E-Mail Adresse an!</p>";
                } else if($_GET["error"] == "statement_fehlgeschlagen"){
                    echo "<p> Unbekannter Fehler, bitte versuchen Sie es erneut </p>";
                } else if ($_GET["error"] == "falschespasswort"){
                    echo "<p> Bitte geben Sie das korrekte Passwort ein </p>";
                }
            }

        ?>
</html>   

