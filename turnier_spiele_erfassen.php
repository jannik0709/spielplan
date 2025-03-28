<?php

require_once 'includes/general.inc.php';
require_once 'includes/dhb.inc.php';
require_once 'includes/functions_spielplan_erstellen.inc.php';


if (isset($_POST["spielplan_erstellen"]) == true){

    $turnier_name = $_SESSION["turnier_name"];
    $turnier_anzahl_mannschaften = $_SESSION["anzahl_mannschaften"];

    $turnier_beginn = mysqli_real_escape_string($conn,$_POST['uhrzeit_beginn']);
    $spiel_pausen = mysqli_real_escape_string($conn,$_POST['pause_zwischen_spielen']);

    spielplan_erstellen($conn, $turnier_name, $turnier_beginn, $spiel_pausen);

}
    