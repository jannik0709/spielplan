<?php

require_once 'includes/general.inc.php';
require_once 'includes/dhb.inc.php';
require_once 'includes/functions_gruppen_erfassen.inc.php';

if (isset($_POST["turnier_erstellen"]) == true){

    $turnier_name = mysqli_real_escape_string($conn,$_POST['turnier_name']);
    $turnier_anzahl_mannschaften = mysqli_real_escape_string($conn,$_POST['turnier_anzahl_mannschaften']);
    $turnier_maximale_gruppengröße = mysqli_real_escape_string($conn,$_POST['turnier_maximale_gruppengröße']);
    $turnier_anzahl_spielfelder = mysqli_real_escape_string($conn,$_POST['turnier_anzahl_spielfelder']);


    if (leeresEingabefeld($turnier_name, $turnier_anzahl_mannschaften, $turnier_maximale_gruppengröße, $turnier_anzahl_spielfelder) !== false){
        header("location: ../spielplan/turnier_erstellen.php?error=nichtallefelderausgefüllt");
        exit();
    }

    if (turniername_existiert($conn, $turnier_name) !== false) {
        header("location: ../spielplan/turnier_erstellen.php?error=turniernameexistiertbereits");
        exit();
    }
    
    turnier_aufnehmen($conn, $turnier_name, $turnier_anzahl_mannschaften, $turnier_maximale_gruppengröße, $turnier_anzahl_spielfelder);

    
    gruppen_erfassen($conn, $turnier_name, $turnier_anzahl_mannschaften, $turnier_maximale_gruppengröße);

    $_SESSION["turnier_name"] = $turnier_name;
    $_SESSION["anzahl_mannschaften"] = $turnier_anzahl_mannschaften;
  



$sql2 = "select * from gruppe where turnier_id ='$turnier_name';";
    $result2 = mysqli_query($conn, $sql2);
    $i = 1;

    

    echo '<fieldset>
    <legend> Übersicht zu den gruppen '.$turnier_name.' </legend>

    <form method = "POST" action = "turnier_mannschaften_eingeben.php?error=none">

    <table width="800px border: 1px solid black border-collapse: collapse cellspacing="2" cellpadding="2"> 
    <tr>
    <th> Gruppe </th>
    <th> Turnier </th>
    </tr>';

    while($row1 = mysqli_fetch_assoc($result2)){
        $_SESSION['gruppe '.$i.''] = $row1['gruppe_id'];
        echo   '<tr>
                        <td> '.$row1['gruppe_id'].' </td>
                        <td> '.$turnier_name.' </td>
                </tr>';
            $i++;
    }
    
    echo    '<button type = "submit" name="mannschaften_erfassen" > Mannschaften erfassen </button>
        </fieldset>';

}















/*echo '<fieldset>
            <legend> Mannschaften erfassen für das Turnier '.$turnier_name.' </legend>

                <form method = "POST" action ="turnier_mannschaften_erfassen.php">';

            for($i=1;$i<=$turnier_anzahl_mannschaften;$i++){

                 echo '<label> Mannschaft '.$i.' <input type="text" name="mannschaft_'.$i.'"></label>
                    </label>
                    <br>
                    <br>';
                }

echo    '<button type = "submit" name="mannschaften_erfassen" > Mannschaften erfassen </button>
        </fieldset>';

        <tr>
        <th> Turnier </th>
        <th> Gruppe </th>
    </tr>';

    while($row1 = mysqli_fetch_assoc($result2)){
        $_SESSION['getraenk_name '.$i.''] = $row1['getraenk_name'];
        $_SESSION['getraenk_hersteller '.$i.''] = $row1['getraenk_hersteller'];
       echo   '<tr>
                   <td> '.$row1['getraenk_name'].' </td>
                   <td> '.$row1['getraenk_hersteller'].' </td>
                   <td> <label> Lagerbestand: <input type="number" min="0" value="0" name="lagerbestand_'.$i.'"></label> </td>
               </tr>';
       $i++;

*/


/* echo ' <table width="800px border="2" cellspacing="2" cellpadding="2"> 
                <tr>
                    <th> Getränkname </th>
                    <th> Getränkhersteller </th>
                    <th> Lagerbestand </th>
                </tr>';
    // Alle entsprechende Datensätze auslesen und in einer Tabelle anzeigen, zudem wird über das Label ein Feld geschaffen, über welcher der Marktverantwortliche den aktuellen Lagerbestand für das Getränk erfassen kann
    while($row1 = mysqli_fetch_assoc($result2)){
             $_SESSION['getraenk_name '.$i.''] = $row1['getraenk_name'];
             $_SESSION['getraenk_hersteller '.$i.''] = $row1['getraenk_hersteller'];
            echo   '<tr>
                        <td> '.$row1['getraenk_name'].' </td>
                        <td> '.$row1['getraenk_hersteller'].' </td>
                        <td> <label> Lagerbestand: <input type="number" min="0" value="0" name="lagerbestand_'.$i.'"></label> </td>
                    </tr>';
            $i++;
*/
?>