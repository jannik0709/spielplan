<?php

require_once 'includes/general.inc.php';

function leeresEingabefeld($turnierverantwortlicher_email, $turnierverantwortlicher_passwort){
    if(empty($turnierverantwortlicher_email) || empty($turnierverantwortlicher_passwort)){
        $result = true; 
    } else{
        $result = false;
    }
    return $result;
} 

// Funktion zum Überprüfen, ob eingegebene E-Mail-Adresse vorhanden ist 
function checkEmail($conn, $turnierverantwortlicher_email){

    $sql = "SELECT * FROM turnier_verantwortlicher where turnier_verantwortlicher_email = ?;";
    $sql_statement = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($sql_statement,$sql)){
        header("location: ../spielplan/turnierverantwortlicher_anmelden.php?error=statement_fehlgeschlagen");
        exit();
    }

    mysqli_stmt_bind_param($sql_statement, "s", $turnierverantwortlicher_email);

    mysqli_stmt_execute($sql_statement);

    $resultData = mysqli_stmt_get_result($sql_statement);

    if ($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close();
}

function anmeldenTurnierverantwortlicher($conn, $turnierverantwortlicher_email, $turnierverantwortlicher_passwort){
    
    $checkEmail = checkEmail($conn, $turnierverantwortlicher_email);

    if($checkEmail == false){
        header("location: ../spielplan/turnierverantwortlicher_anmelden.php?error=emailadressenichtvorhanden");
        exit;
    }

    $pwdHashed = $checkEmail["turnier_verantwortlicher_passwort"];
    $checkPwd = password_verify($turnierverantwortlicher_passwort, $pwdHashed);

    if($checkPwd == false){
        header("location: ../spielplan/turnierverantwortlicher_anmelden.php?error=falschespasswort");
        exit;
    } else if($checkPwd == true){
        $_SESSION['turnier_verantwortlicher_email'] = $turnierverantwortlicher_email;
        header("location: ../spielplan/turnierverantwortlicher_aktionen.php?error=keinfehler");
    }

}


