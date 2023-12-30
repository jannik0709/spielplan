<?php

    //Überprüfung, ob eines der Eingabefelder leer ist
    function leeresEingabefeld($turnierverantwortlicher_email, $turnierverantwortlicher_passwort, $turnierverantwortlicher_name){
        if(empty($turnierverantwortlicher_email) || empty($turnierverantwortlicher_passwort) || empty($turnierverantwortlicher_name)){
            $result = true; 
        } else{
            $result = false;
        }
        return $result;
    }

    //Überprüfung, ob die E-Mail Adresse bereits existiert, falls diese bereits vorhanden ist, wird ein Fehler geworfen
    function email_existiert($conn, $turnierverantwortlicher_email){

        // SQL Statement formulieren
        $sql = "SELECT * FROM turnierverantwortlicher WHERE turnierverantwortlicher_email = ?;";

        // Verbindung zur Datenbank herstellen
        $sql_statement = mysqli_stmt_init($conn);

        // Falls Fehler im Statement wird ein Fehler geworfen
        if(!mysyli_stmt_prepare($sql_statement,$sql)){
            header("location: ../spielplan/turnierverantwortlicher_registrieren.php?error=statement_fehlgeschlagen");
            exit();
        }

        // SQL Statement mit der Variablen entsprechend befüllen
        mysqli_stmt_bind_param($sql_statement, "s", $turnierverantwortlicher_email);

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

    
    function registieren_turnierverantwortlicher($conn, $turnierverantwortlicher_email, $turnierverantwortlicher_passwort, $turnierverantwortlicher_name){
        
        $sql = "INSERT INTO turnierverantwortlicher (turnierverantwortlicher_email, turnierverantwortlicher_passwort, turnierverantwortlicher_name ) VALUES (?,?,?);";
        $sql_statement = mysqli_stmt_init($conn);

        if(!mysyli_stmt_prepare($sql_statement,$sql)){
            header("location: ../spielplan/turnierverantwortlicher_registrieren.php?error=statement_fehlgeschlagen");
            exit();
        }

        $hashedPwd = password_hash($turnierverantwortlicher_passwort, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($sql_statement, "sss", $turnierverantwortlicher_email, $turnierverantwortlicher_passwort, $turnierverantwortlicher_name );
        mysqli_stmt_execute($sql_statement);
        mysqli_stmt_close($sql_statement);


    }

?>