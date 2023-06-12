<?php
session_start();
// tiek pievienots datubāzes connection
include "../config/db.php";
// tiek pievienotas insert un select funkcijas
include "../functions/functions.php";

//tiek pārbaudīts vai ir iesniegta e-pasta adrese un parole
if (isset($_POST['gmail2']) && isset($_POST['password2'])) {
    //tiek saglabāti dati atbilstošajos mainīgajos
    $gmail = $_POST['gmail2'];
    $password = $_POST['password2'];
    // sagatavo sql vaicājumu, kas izvēlas leitotāja datus no datubāzes, kur atbilst ievadītais e-pasts
    $stmt = $conn->prepare("SELECT * FROM users WHERE gmail = ?");
    // saista sagatavoto vaicājumu ar ievadīto e-pasta adresi, lai novērstu sql injekciju
    $stmt->bind_param("s", $gmail);
    // izpilda sagatavoto vaicājumu un iegūst rezultātus, kas atgriezti no datubāzes
    $stmt->execute();
    $result = $stmt->get_result();

    //pārbauda vai rezultātu skaits ir lielāks par nulli, ja ir, atd tas nozīmē ka ir atrasts lietotājs ar ievadīto e-pasta adresi
    if ($result->num_rows > 0) {
        //iegūst pirmo rezultātu rindu ka asociatīvo masīvu, kurā ir lietotāja dati
        $row = $result->fetch_assoc();
        // pārbauda vai lietotāja parole atbilst saglabātajai paroļu hashei datu bāzē
        if (password_verify($password, $row['password'])) {
            // saglabā lietotāja id
            $_SESSION['user'] = $row['id'];
            // saglabā pieteikšanās statusu
            $_SESSION['logged'] = 1;
            // saglabā lietotāja vārdu
            $_SESSION['username'] = $row['vards'];

            // pārbauda vai lietotājam $row ir 1, ja ir tad lietotājs ir administrators
            if ($row['admin'] == 1) {
                $_SESSION['admin'] = 'admin';
            } else {
                $_SESSION['admin'] = 'main';
            }
        } else {
            $users = "Parole vai Epasts nav pareizs, mēģini vēlreiz!";
        }
    } else {
        $users = "Lietotājs neeksistē";
    }
} else {
    $users = "Aizpildīt visus laukus!";
}

if (!empty($users)) {
    echo $users;
}
?>
