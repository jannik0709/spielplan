<?php

require_once 'includes/general.inc.php';
require_once 'includes/dhb.inc.php';
require_once 'includes/functions_mannschaften_erfassen.inc.php';

//Als erstes muss herausgefunden werden, wie viel Gruppen es zu einem Turnier überhaupt gibt


// Version 1: bis Zeile 54 
/*
//Nun werden die Mannschaften entsprechend erfasst und zufällig einer Gruppe zugewiesen
if (isset($_POST["mannschaften_erfassen_ready"]) == true){

    $turnier_name = $_SESSION["turnier_name"];
    $sql_1 = mysqli_query($conn, "SELECT * FROM gruppe WHERE turnier_id = '$turnier_name'");
    $anzahl_gruppen = mysqli_num_rows($sql_1);

    $anzahl_mannschaften = $_SESSION["anzahl_mannschaften"];

    echo $anzahl_gruppen;
    echo $anzahl_mannschaften;
    

        // Berechne die Mannschaften pro Gruppe
        $mannschaften_pro_gruppe = floor($anzahl_mannschaften/$anzahl_gruppen);

        // Array zum Speichern der Mannschaten pro Gruppe
        $mannschaften_in_gruppe = array_fill(1, $anzahl_mannschaften, $mannschaften_pro_gruppe);

        //Verteile den Rest der Teams gleichmäßig auf die Gruppen
        $verbleibende_mannschaften = $anzahl_mannschaften % $anzahl_gruppen;
        for ($x=1; $x<=$verbleibende_mannschaften;$x++){
            $mannschaften_in_gruppe[$x]++;
        }

        //Loop durch jedes Team und weise es einer Gruppe zu
        $mannschaft_zähler = 0;
        for($gruppen_nummer=1;$gruppen_nummer<=$anzahl_gruppen;$gruppen_nummer++){
             for ($y = 0; $y < $mannschaften_in_gruppe[$gruppen_nummer]; $y++) {
                $mannschaft_zähler++;
                $mannschaft = mysqli_real_escape_string($conn,$_POST['mannschaft_'.$mannschaft_zähler.'']);
            
                $sql = "INSERT INTO mannschaft (mannschaft_name, mannschaft_gruppe, mannschaft_turnier) VALUES ('$mannschaft', '$gruppen_nummer', '$turnier_name');";

            // Führen Sie den SQL-Befehl aus
            if ($conn->query($sql) === TRUE) {
                echo "Team '$mannschaft' wurde der Gruppe $gruppen_nummer zugewiesen.<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}  
*/               


    //Version 2: ab 58 bis 186

    if (isset($_POST["mannschaften_erfassen_ready"]) == true){

        $turnier_name = $_SESSION["turnier_name"];
        $sql_1 = mysqli_query($conn, "SELECT * FROM gruppe WHERE turnier_id = '$turnier_name'");
        $anzahl_gruppen = mysqli_num_rows($sql_1);

        $SESSION_["anzahl_gruppen"] = $anzahl_gruppen;
    
        $anzahl_mannschaften = $_SESSION["anzahl_mannschaften"];

        echo '<fieldset>
        <legend> Weiter zur Erstellung des Spielplans </legend>
        
            <form method = "POST" action = "turnier_spielplan_erstellen.php?error=none">
            <br>
            <br>
              
                <button type = "submit" name="turnier_erstellen" > Turnier erstellen </button>
        
            </form>
        
        </fieldset>';
    
   

        
    
    for($w=1;$w<=$anzahl_mannschaften;$w++){
    
        $mannschaft = mysqli_real_escape_string($conn,$_POST['mannschaft_'.$w.'']);

        //Zufallsgruppe auswählen, um der Mannschaft eine Gruppe zuzuweisen
        $zufallsgruppe = rand(1,$anzahl_gruppen);

        //herausfinden, wie viel Mannschaft bereits in der Zufallsgruppe sind
        $sql_abfrage_mannschaften_in_gruppe = mysqli_query($conn, "SELECT * FROM mannschaft WHERE mannschaft_turnier = '$turnier_name' AND mannschaft_gruppe = '$zufallsgruppe'");
        $anzahl_mannschaften_in_zufallsgruppe = mysqli_num_rows($sql_abfrage_mannschaften_in_gruppe);
        
        //heraufinden, wie viel mannschaften in einer Gruppe sein könnne (dadurch werden nur alle eingefügt, bis dato es aufgeht von den mannschaften)
        $sql_abfrage_maximale_mannschaften_in_gruppe = "SELECT maximale_gruppengroeße FROM turnier WHERE turnier_name =?;";
        $sql_statement_abfrage_maximale_mannschaften_in_gruppe = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($sql_statement_abfrage_maximale_mannschaften_in_gruppe,$sql_abfrage_maximale_mannschaften_in_gruppe)){
            header("location: ../spielplan/turnier_mannschaften_erfassen.php?error=statement_fehlgeschlagen");
            exit();
        } 

        mysqli_stmt_bind_param($sql_statement_abfrage_maximale_mannschaften_in_gruppe, "s", $turnier_name);
        mysqli_stmt_execute($sql_statement_abfrage_maximale_mannschaften_in_gruppe);
      
        $result_maximale_mannschaften_in_gruppe = mysqli_stmt_get_result($sql_statement_abfrage_maximale_mannschaften_in_gruppe);

        // hier wird ausgegeben wie groß die gruppengroeße ist, wenn die Anzahl der Mannschaften gleichmäßig verteilt werden kann
        if ($row = mysqli_fetch_assoc($result_maximale_mannschaften_in_gruppe)){
            $maximale_gruppengroeße = $row['maximale_gruppengroeße'];
            
        }
        
        //überprüfen, ob mannschaft eingefügt werden kann 8falls die maximale gruppengröße erreicht ist, sollen die anderen Gruppen überprüft werden
        if($anzahl_mannschaften_in_zufallsgruppe==$maximale_gruppengroeße){ 
    

        for($x=1;$x<=$anzahl_gruppen;$x++){
            $sql_abfrage_mannschaften_in_aktueller_gruppe = mysqli_query($conn, "SELECT * FROM mannschaft WHERE mannschaft_turnier = '$turnier_name' AND mannschaft_gruppe = '$x'");
            $anzahl_mannschaften_in_aktueller_gruppe = mysqli_num_rows($sql_abfrage_mannschaften_in_aktueller_gruppe);
        

            if($anzahl_mannschaften_in_aktueller_gruppe<$maximale_gruppengroeße){

                $sql_einfügen_mannschaft = "INSERT INTO mannschaft (mannschaft_gruppe, mannschaft_name, mannschaft_turnier) VALUES (?,?,?);";
                $sql_statement_einfügen_mannschaft = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($sql_statement_einfügen_mannschaft,$sql_einfügen_mannschaft)){
                header("location: ../spielplan/turniermannschaften_erfassen.php?error=statement_fehlgeschlagen");
                exit();
                }

                mysqli_stmt_bind_param($sql_statement_einfügen_mannschaft, "sss", $x, $mannschaft, $turnier_name);
                mysqli_stmt_execute($sql_statement_einfügen_mannschaft);
                mysqli_stmt_close($sql_statement_einfügen_mannschaft);  
                
                echo 'Team '.$mannschaft .'in Gruppe '.$x. 'eingefügt.';
                echo '<br>';  
            
                break; 
            }
        }
    
    // im zweiten Fall kann die Mannschaft direkt der Zufallsgruppe zugewiesen werden
    } else {
        $sql_einfügen_mannschaft = "INSERT INTO mannschaft (mannschaft_gruppe, mannschaft_name, mannschaft_turnier) VALUES (?,?,?);";
        $sql_statement_einfügen_mannschaft = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($sql_statement_einfügen_mannschaft,$sql_einfügen_mannschaft)){
        header("location: ../spielplan/turniermannschaften_erfassen.php?error=statement_fehlgeschlagen");
        exit();
        }

       
        mysqli_stmt_bind_param($sql_statement_einfügen_mannschaft, "sss", $zufallsgruppe, $mannschaft, $turnier_name);
        mysqli_stmt_execute($sql_statement_einfügen_mannschaft);
        mysqli_stmt_close($sql_statement_einfügen_mannschaft); 
        
        echo 'Team '.$mannschaft .'in Gruppe '.$zufallsgruppe. 'eingefügt.';
        echo '<br>';  
        
    }
    }
 



// zusätlich sollen jetzt noch alle Mannschaften einer Gruppe zugewiesen werden, welche bis jetzt noch nirgends sind

$turnier_name1 = $_SESSION["turnier_name"];
$sql = mysqli_query($conn, "SELECT * FROM gruppe WHERE turnier_id = '$turnier_name1'");
$anzahl_gruppen1 = mysqli_num_rows($sql);

//herausfinden, wie viel Mannschaften bereits eingespielt wurden
$sql_abfrage_mannschaften_gesamt_in_turnier1 = mysqli_query($conn, "SELECT * FROM mannschaft WHERE mannschaft_turnier = '$turnier_name1'");
$anzahl_mannschaften_gesamt_in_turnier1 = mysqli_num_rows($sql_abfrage_mannschaften_gesamt_in_turnier1);

$nächste_mannschaft = $anzahl_mannschaften_gesamt_in_turnier1+1;
$z=1;

for($nächste_mannschaft;$nächste_mannschaft<=$anzahl_mannschaften;$nächste_mannschaft++){

    $mannschaft_zus = mysqli_real_escape_string($conn,$_POST['mannschaft_'.$nächste_mannschaft.'']);

    $sql_einfügen_mannschaft_neu = "INSERT INTO mannschaft (mannschaft_gruppe, mannschaft_name, mannschaft_turnier) VALUES (?,?,?);";
    $sql_statement_einfügen_mannschaft_neu = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($sql_statement_einfügen_mannschaft_neu,$sql_einfügen_mannschaft_neu)){
    header("location: ../spielplan/turniermannschaften_erfassen.php?error=statement_fehlgeschlagen");
    exit();
    }

    mysqli_stmt_bind_param($sql_statement_einfügen_mannschaft_neu, "sss", $z, $mannschaft_zus, $turnier_name1);
    mysqli_stmt_execute($sql_statement_einfügen_mannschaft_neu);
    mysqli_stmt_close($sql_statement_einfügen_mannschaft_neu);     

    echo 'Team '.$mannschaft .'in Gruppe '.$z. 'eingefügt.';
    echo '<br>';    
    $z++;
}

    // zusätlich sollen jetzt noch alle Gruppen mit den mMannschaften in einer extra Tabelle aufgelistet werden

    echo '<fieldset>
    <legend> Übersicht zu den gruppen von Turnier: '.$turnier_name.' </legend>';



    for($a=1;$a<=$anzahl_gruppen;$a++){

        $sql3 = "select * from mannschaft where mannschaft_turnier ='$turnier_name' and mannschaft_gruppe='$a'";
        $result3 = mysqli_query($conn, $sql3);
        
        echo 
        '<table width="800px border: 1px solid black border-collapse: collapse cellspacing="2" cellpadding="2"> 
            <tr>
                <th> Gruppe </th>
                <th> Mannschaft </th>
            </tr>';

    while($row1 = mysqli_fetch_assoc($result3)){
        echo   '<tr>
                        <td> '.$row1['mannschaft_gruppe'].' </td>
                        <td> '.$row1['mannschaft_name'].' </td>
                </tr>';
    }
}
    echo '</fieldset>';}




    /*
        //heraufinden, wie viel Mannschaften in der aktuellen Vergleichsgruppe sind
        $sql_abfrage_mannschaften_in_aktueller_gruppe = mysqli_query($conn, "SELECT * FROM mannschaft WHERE mannschaft_turnier = '$turnier_name' AND mannschaft_gruppe = '$x'");
        $anzahl_mannschaften_in_aktueller_gruppe = mysqli_num_rows($sql_abfrage_mannschaften_in_aktueller_gruppe);
        echo 'Aktuelle Gruppe';
        echo "<br>";
        echo $x;
        echo "<br>";
        echo 'Anzahl Mannschaften in aktueller Gruppe:';
        echo "<br>";
        echo $anzahl_mannschaften_in_aktueller_gruppe;
        echo "<br>";

        // deckt den Fall ab, wenn in jeder Mannschaft aktuell gleich viel Gruppen sind
            if($anzahl_mannschaften_in_zufallsgruppe==$anzahl_mannschaften_in_aktueller_gruppe){
                
                $counter=1000000000;
                
                for($w=1;$w<=$anzahl_gruppen;$w++){
                $sql_abfrage_mannschaften_in_gruppen_gesamt = mysqli_query($conn, "SELECT * FROM mannschaft WHERE mannschaft_turnier = '$turnier_name' AND mannschaft_gruppe = '$w'");
                $anzahl_mannschaften_gruppen_gesamt = mysqli_num_rows($sql_abfrage_mannschaften_in_gruppen_gesamt);
                

                if($anzahl_mannschaften_gruppen_gesamt==$anzahl_mannschaften_in_zufallsgruppe){
                    $counter = $counter/2;
                } else $counter=$counter*0;
                    
                }
                echo $counter;
                if($counter!=0){
                $sql_einfügen_mannschaft = "INSERT INTO mannschaft (mannschaft_gruppe, mannschaft_name, mannschaft_turnier) VALUES (?,?,?);";
                $sql_statement_einfügen_mannschaft = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($sql_statement_einfügen_mannschaft,$sql_einfügen_mannschaft)){
                header("location: ../spielplan/turniermannschaften_erfassen.php?error=statement_fehlgeschlagen");
                exit();
                }

                echo 'Ausgewählte Gruppe x';
                echo "<br>";
                echo $zufallsgruppe;
                echo "<br>";

                mysqli_stmt_bind_param($sql_statement_einfügen_mannschaft, "sss", $zufallsgruppe, $mannschaft, $turnier_name);
                mysqli_stmt_execute($sql_statement_einfügen_mannschaft);
                mysqli_stmt_close($sql_statement_einfügen_mannschaft);
                echo 'eingefügt';
                echo "<br>";
                break;
            }
                if ($counter==0){
                $sql_einfügen_mannschaft_2 = "INSERT INTO mannschaft (mannschaft_gruppe, mannschaft_name, mannschaft_turnier) VALUES (?,?,?);";
                $sql_statement_einfügen_mannschaft_2 = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($sql_statement_einfügen_mannschaft_2,$sql_einfügen_mannschaft_2)){
                header("location: ../spielplan/turniermannschaften_erfassen.php?error=statement_fehlgeschlagen");
                exit();
                }

                echo 'Ausgewählte Gruppe xx';
                echo "<br>";
                echo $zufallsgruppe;
                echo "<br>";

                mysqli_stmt_bind_param($sql_statement_einfügen_mannschaft_2, "sss", $x, $mannschaft, $turnier_name);
                mysqli_stmt_execute($sql_statement_einfügen_mannschaft_2);
                mysqli_stmt_close($sql_statement_einfügen_mannschaft_2);
                echo 'eingefügt 1';
                echo "<br>";
                break;
                 }
            }
        
                
            if($anzahl_mannschaften_in_zufallsgruppe<$anzahl_mannschaften_in_aktueller_gruppe){
                $sql_einfügen_mannschaft_zufallsgruppe = "INSERT INTO mannschaft (mannschaft_gruppe, mannschaft_name, mannschaft_turnier) VALUES (?,?,?);";
                $sql_statement_einfügen_mannschaft_zufallsgruppe = mysqli_stmt_init($conn);

                echo 'Ausgewählte Gruppe xxx';
                echo "<br>";
                echo $i;

                if(!mysqli_stmt_prepare($sql_statement_einfügen_mannschaft_zufallsgruppe,$sql_einfügen_mannschaft_zufallsgruppe)){
                    header("location: ../spielplan/turniermannschaften_erfassen.php?error=statement_fehlgeschlagen");
                    exit();
                    }
                

                mysqli_stmt_bind_param($sql_statement_einfügen_mannschaft_zufallsgruppe, "sss", $x, $mannschaft, $turnier_name);
                mysqli_stmt_execute($sql_statement_einfügen_mannschaft_zufallsgruppe);
                mysqli_stmt_close( $sql_statement_einfügen_mannschaft_zufallsgruppe);
                echo 'eingefügt 2';
                echo "<br>";
            break;
            }

            if($anzahl_mannschaften_in_zufallsgruppe>$anzahl_mannschaften_in_aktueller_gruppe){
                $sql_einfügen_mannschaft_aktuelle_gruppe = "INSERT INTO mannschaft (mannschaft_gruppe, mannschaft_name, mannschaft_turnier) VALUES (?,?,?);";
                $sql_statement_einfügen_mannschaft_aktuelle_gruppe = mysqli_stmt_init($conn);

                echo 'Ausgewählte Gruppe xxxx';
                echo "<br>";
                echo $i;

                if(!mysqli_stmt_prepare($sql_statement_einfügen_mannschaft_aktuelle_gruppe, $sql_einfügen_mannschaft_aktuelle_gruppe)){
                    header("location: ../spielplan/turniermannschaften_erfassen.php?error=statement_fehlgeschlagen");
                    exit();
                    }
                

                mysqli_stmt_bind_param($sql_statement_einfügen_mannschaft_aktuelle_gruppe, "sss", $x, $mannschaft, $turnier_name);
                mysqli_stmt_execute($sql_statement_einfügen_mannschaft_aktuelle_gruppe);
                mysqli_stmt_close($sql_statement_einfügen_mannschaft_aktuelle_gruppe);
                echo 'eingefügt 3';
                echo "<br>";
            break;
            }
        }
    
    }
}
*/



?>