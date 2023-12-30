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