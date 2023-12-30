<?php
//Eine Verbindung zur Datenbank in phpmyadmin wird aufgebaut

    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName ="db_unser_spielplan";

    $conn=mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);

    if (!$conn){
        die("Verbindung fehlgeschlagen: " . mysqli_connect_error());
    }

?>