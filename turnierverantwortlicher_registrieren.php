<?php

include_once 'includes/dhb.inc.php';

?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Turnierverantwortlicher registrieren</title>
        <meta name="description" content="Turnierverantwortlicher registrieren.">
        <link rel="stylesheet" href="main.css">
    </head>


    <body>

        <!-- Felder werden zur dem Turnierverantwortlicher zur Verfügung gestellt, über welchen dieser seine Daten erfassen kann -->

        <fieldset>
            <legend> Registrierung Turnierverantwortlicher</legend>

                <form method = "POST" action ="turnierverantwortlicher_anmelden.php?error=none">
        
                    <label> E-Mail Adresse: <input type="text" name="turnierverantwortlicher_e_mail_adresse" >
                    </label>
                    <br>
                    <br>
                    <label> Passwort: <input type="password" name="turnierverantwortlicher_passwort" >
                    </label>
                    <br>
                    <br> 
                    <label> Name: <input type="text" name="turnierverantwortlicher_name" >
                    </label>
                    <br>
                    <br>

                    <button type = "submit" name="turnierverantwortlicher_registrieren" > registrieren</button>
      
                </form>
        
        </fieldset>   

        <?php

            if (isset($_GET["error"])){
                if($_GET["error"] == "nichtallefelderausgefüllt"){
                    echo "<p> Bitte füllen Sie alle Felder aus!</p>";
                } else if ($_GET["error"] == "vergebene_email_adresse"){
                    echo "<p> Bitte geben Sie eine andere E-Mail Adresse an!</p>";
                } else if($_GET["error"] == "statement_fehlgeschlagen"){
                    echo "<p> Unbekannter Fehler, bitte versuchen Sie es erneut </p>";
                }
            }

        ?>

    </body>

</html>