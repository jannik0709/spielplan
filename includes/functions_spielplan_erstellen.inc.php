<?php

ini_set('max_execution_time', 300);

require_once 'includes/general.inc.php';
require_once 'includes/dhb.inc.php';

function spielplan_erstellen($conn, $turnier_name, $turnier_beginn, $spiel_pausen){

        $sql_gruppen_turnier = $conn->query("SELECT * FROM gruppe WHERE turnier_id = '$turnier_name'");
        
        $anzahl_gruppen = mysqli_num_rows($sql_gruppen_turnier);
        echo 'Anzahl der Gruppen:';
        echo $anzahl_gruppen;
        echo '<br>';

        for($anzahl_gr=1;$anzahl_gr<=$anzahl_gruppen;$anzahl_gr++){

        $sql_mannschaften_in_gruppe = mysqli_query($conn, "SELECT * FROM mannschaft WHERE mannschaft_turnier = '$turnier_name' AND mannschaft_gruppe = '$anzahl_gr'");
           $anzahl_mannschaften_in_gruppe = mysqli_num_rows($sql_mannschaften_in_gruppe);
           echo 'Anzahl der Mannschaften in der Gruppe:';
           echo $anzahl_mannschaften_in_gruppe;
           echo '<br>';

            $mannschaften_abfragefdsf = "SELECT * FROM mannschaft WHERE mannschaft_turnier = '$turnier_name' AND mannschaft_gruppe = '$anzahl_gr'";
            $mannschaften_abfrage = mysqli_query($conn, $mannschaften_abfragefdsf);

            $i = 1;
            ${$anzahl_gr.$i} = 1;
            while($row2 = $mannschaften_abfrage->fetch_assoc()){
               
                
                ${$anzahl_gr.$i} = $row2['mannschaft_name'];
                echo ${$anzahl_gr.$i};
                $i++;
                echo '<br>';
            }
        

            echo 'Anzahl Spiele in Gruppe';
            $anzahl_spiele_in_gruppe = ($anzahl_mannschaften_in_gruppe*($anzahl_mannschaften_in_gruppe-1))/2;
            echo $anzahl_spiele_in_gruppe;
        
    
            
            for($mannschaft_uno=1;$mannschaft_uno<=$anzahl_mannschaften_in_gruppe;$mannschaft_uno++){
                for($mannschaft_dos = $mannschaft_uno+1;$mannschaft_dos<=$anzahl_mannschaften_in_gruppe;$mannschaft_dos++){
                $sql_check_spiel_vorhanden_1 = mysqli_query($conn, "SELECT * FROM spiele_vorbereitung WHERE  turnier = '$turnier_name' AND team_1 = '${$anzahl_gr.$mannschaft_uno}' AND team_2 = '${$anzahl_gr.$mannschaft_dos}'");
                    $anzahl_gesuchter_spiele_1 = mysqli_num_rows($sql_check_spiel_vorhanden_1); 
                $sql_check_spiel_vorhanden_2 = mysqli_query($conn, "SELECT * FROM spiele_vorbereitung WHERE  turnier = '$turnier_name' AND team_1 = '${$anzahl_gr.$mannschaft_dos}' AND team_2 = '${$anzahl_gr.$mannschaft_uno}'");
                    $anzahl_gesuchter_spiele_2 = mysqli_num_rows($sql_check_spiel_vorhanden_2);
                if($anzahl_gesuchter_spiele_1==0 && $anzahl_gesuchter_spiele_2 ==0){
                    $sql_einfügen_spiel_vorbereitung = "INSERT INTO spiele_vorbereitung (spiel_id, team_1, team_2, gruppe, turnier) VALUES (?,?,?,?,?);";
                    $sql_statement_einfügen_spiel_vorbereitung = mysqli_stmt_init($conn);
            
                if(!mysqli_stmt_prepare($sql_statement_einfügen_spiel_vorbereitung, $sql_einfügen_spiel_vorbereitung)){
                header("location: ../spielplan/turnier_spiele_erfassen.php?error=statement_fehlgeschlagen");
                exit();
                }

                $sql_check_spiel_vorhanden_3 = mysqli_query($conn, "SELECT * FROM spiele_vorbereitung WHERE  turnier = '$turnier_name'");
                    $anzahl_gesuchter_spiele_3 = mysqli_num_rows($sql_check_spiel_vorhanden_3); 
                    $spiel_id = $anzahl_gesuchter_spiele_3+1;
                mysqli_stmt_bind_param($sql_statement_einfügen_spiel_vorbereitung, "sssss", $spiel_id, ${$anzahl_gr.$mannschaft_uno}, ${$anzahl_gr.$mannschaft_dos}, $anzahl_gr, $turnier_name);
                mysqli_stmt_execute($sql_statement_einfügen_spiel_vorbereitung);
                mysqli_stmt_close($sql_statement_einfügen_spiel_vorbereitung);
                }
                }
        }
           
            }

            //Schauen, dass jedes Team gleich oft Erstgenannter und gleich oft Zweitgenannter ist

            $sql_anzahl_vorrundenspiele = mysqli_query($conn, "SELECT * FROM spiele_vorbereitung WHERE  turnier = '$turnier_name'");
            $anzahl_vorrundenspiele = mysqli_num_rows($sql_anzahl_vorrundenspiele);

            $sql_anzahl_teams_gesamt = mysqli_query($conn, "SELECT * FROM mannschaft WHERE mannschaft_turnier = '$turnier_name'");
            $anzahl_teams_gesamt = mysqli_num_rows( $sql_anzahl_teams_gesamt);

            for($tz=1;$tz<=$anzahl_vorrundenspiele;$tz++){
                $sql_abfrage_pro_spiel = "SELECT team_1, team_2  FROM spiele_vorbereitung WHERE spiel_id = '$tz' AND turnier = '$turnier_name'";
                $result0 = $conn->query($sql_abfrage_pro_spiel);

                if($result0->num_rows >0){
                $row_spiel = $result0->fetch_assoc();
                $team_1 = $row_spiel["team_1"];
                $team_2 = $row_spiel["team_2"];
                }
                $sql_anzahl_team_1_erstgenannt = mysqli_query($conn, "SELECT * FROM spiele_vorbereitung WHERE team_1 = '$team_1' AND turnier = '$turnier_name'");
                $anzahl_team_1_erstgenannt = mysqli_num_rows($sql_anzahl_team_1_erstgenannt);
                
                $sql_anzahl_team_2_erstgenannt = mysqli_query($conn, "SELECT * FROM spiele_vorbereitung WHERE team_1 = '$team_2' AND turnier = '$turnier_name'");
                $anzahl_team_2_erstgenannt = mysqli_num_rows($sql_anzahl_team_2_erstgenannt);

                if(($anzahl_team_1_erstgenannt-$anzahl_team_2_erstgenannt)>1){

                    $update_spiel = "UPDATE spiele_vorbereitung SET team_1 = '$team_2', team_2 = '$team_1' WHERE spiel_id = '$tz'";

                    if ($conn->query($update_spiel) === TRUE) {
                        echo "Record updated successfully";
                      } else {
                        echo "Error updating record: " . $conn->error;
                      }
                      
                }

            }

                



            $sql_abfrage_spielfelder = "SELECT anzahl_spielfelder FROM turnier WHERE turnier_name = '$turnier_name'";
            $result3 = $conn->query($sql_abfrage_spielfelder);
            if($result3->num_rows >0){
                $row_spielspielder = $result3->fetch_assoc();
                $anzahl_spielfelder = $row_spielspielder["anzahl_spielfelder"];
            
                }
            echo 'Spielfelder:';
            echo '<br>';
            echo $anzahl_spielfelder;
            echo '<br>';

            $sql_abfrage_anzahl_vorrundenspiele = $conn->query("SELECT * FROM spiele_vorbereitung  WHERE turnier = '$turnier_name'");
        
            $anzahl_vorrundenspiele = mysqli_num_rows($sql_abfrage_anzahl_vorrundenspiele);
            echo 'Vorrundenspiele';
            echo '<br>';
            echo $anzahl_vorrundenspiele;
            echo '<br>';
            
            $anzahl_spiele_rest =  $anzahl_vorrundenspiele % $anzahl_spielfelder;
            echo $anzahl_spiele_rest;

        
}     

           

            

            /*for($i=0;$i<$anzahl_mannschaften_in_gruppe;$i++){
                for($j = $i+1;$j<$anzahl_mannschaften_in_gruppe;$j++){
                    echo strval($mannschaftenNamen[$i]);
                    echo strval($mannschaftenNamen[$j]);
                }
            }
            */
        




?>