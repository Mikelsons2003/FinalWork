<?php
// savienojums ar datubāzi
$host = 'localhost'; // satur host nosukumu
$user = 'skolnieks'; // datubāzes lietotāja vārds
$pass = 'pQcM10ClEn3lSWy'; // datubāzes lietotāja parole
$dbName = 'miks_mikelsons'; // datubāzes nosaukums
// izveido jaunu mysqli objektu
$conn = new mysqli($host, $user, $pass, $dbName);
//pārbauda vai svaienojums ir veiksmīgs
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

?>