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
