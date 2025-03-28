<?php

require_once 'includes/general.inc.php';

function leeresEingabefeld($turnier_name, $turnier_anzahl_mannschaften, $turnier_maximale_gruppengröße, $turnier_anzahl_spielfelder){
    if(empty($turnier_name) || empty($turnier_anzahl_mannschaften) || empty($turnier_maximale_gruppengröße) || empty($turnier_anzahl_spielfelder)){
        $result = true; 
    } else{
        $result = false;
    }
    return $result;
}

function turniername_existiert($conn, $turnier_name){

    // SQL Statement formulieren
    $sql = "SELECT * FROM turnier WHERE turnier_name = ?;";

    // Verbindung zur Datenbank herstellen
    $sql_statement = mysqli_stmt_init($conn);

    // Falls Fehler im Statement wird ein Fehler geworfen
    if(!mysqli_stmt_prepare($sql_statement,$sql)){
        header("location: ../spielplan/turnier_erstellen.php?error=statement_fehlgeschlagen");
        exit();
    }

    // SQL Statement mit der Variablen entsprechend befüllen
    mysqli_stmt_bind_param($sql_statement, "s", $turnier_name);

    // SQL Statement ausführen auf der Datenbank
    mysqli_stmt_execute($sql_statement);

    // Liefert Ergebnis der Datenbankabfrage
    $resultData = mysqli_stmt_get_result($sql_statement);

    // Überprüfung des Ergebnisses, falls ein Datensatz gefunden wird $row geliefert, ansonsten wird false geliefert
    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }

    // Beenden des SQL Statements
    mysqli_stmt_close();

}

function turnier_aufnehmen($conn, $turnier_name, $turnier_anzahl_mannschaften, $turnier_minimale_gruppengröße, $turnier_anzahl_spielfelder){
  
    $turnier_verantwortlicher =  $_SESSION['turnier_verantwortlicher_email'];
    
    $sql = "INSERT INTO turnier (turnier_name, turnier_verantwortlicher, anzahl_mannschaften, maximale_gruppengroeße, anzahl_spielfelder) VALUES (?,?,?,?,?);";
    $sql_statement = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($sql_statement,$sql)){
        header("location: ../spielplan/turnier_erstellen.php?error=statement_fehlgeschlagen");
        exit();
    }



    mysqli_stmt_bind_param($sql_statement, "sssss", $turnier_name, $turnier_verantwortlicher, $turnier_anzahl_mannschaften, $turnier_minimale_gruppengröße, $turnier_anzahl_spielfelder);
    mysqli_stmt_execute($sql_statement);
    mysqli_stmt_close($sql_statement);

}

function gruppen_erfassen($conn, $turnier_name, $turnier_anzahl_mannschaften, $turnier_minimale_gruppengröße){

    $berechnung_gruppenanzahl = $turnier_anzahl_mannschaften / $turnier_minimale_gruppengröße;
    
    if(is_numeric($berechnung_gruppenanzahl)){
        $gruppenanzahl=$berechnung_gruppenanzahl;
    }else{
        $gruppenanzahl=floor($berechnung_gruppenanzahl);
    }

    for($i=1;$i<=$gruppenanzahl;$i++){
        $aktuelle_gruppe = $i;
        $sql = "INSERT INTO gruppe (gruppe_id, turnier_id) VALUES (?,?);";
        $sql_statement = mysqli_stmt_init($conn);
    
        if(!mysqli_stmt_prepare($sql_statement,$sql)){
            header("location: ../spielplan/turnier_gruppen_erfassen.php?error=statement_fehlgeschlagen");
            exit();
        }

        mysqli_stmt_bind_param($sql_statement, "ss", $aktuelle_gruppe, $turnier_name);
        mysqli_stmt_execute($sql_statement);
        mysqli_stmt_close($sql_statement);
    }
}


?>