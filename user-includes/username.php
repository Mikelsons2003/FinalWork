<?php
// tiek izveidota funkcija
function getUsername() {
    // tiek pārbaudīts vai sessijā ir definēti trīs mainīgie un vai logged mainīgajam ir vērtība 1
    if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1 && isset($_SESSION['username'])) {
        // ja visi nosacījumi izspildīti tad tiek atgriezts username
        return $_SESSION['username'];
    } else {
        // ja kāds no nosacījumiem nav izpildīts tiek atgriezts vārds Lietotājs
        return "Lietotājs";
    }
}
?>
