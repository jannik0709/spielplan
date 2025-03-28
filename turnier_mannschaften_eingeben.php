<?php

require_once 'includes/general.inc.php';
require_once 'includes/dhb.inc.php';

if (isset($_POST["mannschaften_erfassen"]) == true){

$turnier_name = $_SESSION["turnier_name"];
$turnier_anzahl_mannschaften = $_SESSION["anzahl_mannschaften"];

echo '<fieldset>
            <legend> Mannschaften erfassen für das Turnier '.$turnier_name.' </legend>

                <form method = "POST" action ="turnier_mannschaften_erfassen.php">';

            for($i=1;$i<=$turnier_anzahl_mannschaften;$i++){

                 echo '<label> Mannschaft '.$i.' <input type="text" name="mannschaft_'.$i.'"></label>
                    </label>
                    <br>
                    <br>';
                }

echo    '<button type = "submit" name="mannschaften_erfassen_ready" > Mannschaften erfassen </button>
        </fieldset>';

}
?>