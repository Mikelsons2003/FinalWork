<?php
// satur datubāzes pieslēgumu
include "../config/db.php";
// satur insert un select funkcijas
include "../functions/functions.php";

// Select Insert for register
//pārbauda vai ir iesniegts POST pieprasījums, kas norāda ka dati ir nosūtīti
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //tiek saglabāti dati atbilstošajos mainīgajos
    $vards = $_POST['vards'];
    $uzvards = $_POST['uzvards'];
    $gmail = $_POST['gmail'];
    $password = $_POST['password'];
    $repeatpassword = $_POST['repeatpassword'];

    // tiek veiktas pārbaudes lai validētu datu ievadi
    if (!empty($vards)) {
        if (!empty($uzvards)) {
            if (!empty($gmail)) {
                if (!empty($password)) {
                    if ($password == $repeatpassword) {
                        // Paroles validācijas noteikumi
                        // Jābūt lielajiem burtiem
                        $uppercase = preg_match('@[A-Z]@', $password);
                        // Jābūt mazajiem burtiem
                        $lowercase = preg_match('@[a-z]@', $password);
                        // Jābūt cipariem
                        $number = preg_match('@[0-9]@', $password);
                        // Pārbauda vai parole ir vismaz 8 rakstzīmju gara un satur konkrētos validācijas noteikumus
                        if (strlen($password) < 8 || !$uppercase || !$lowercase || !$number) {
                            // ja nosacījumi nav piepildīti tiek attēlots paziņojums
                            echo '<span style="width: 300px; display: inline-block;">Nepareiza parole! Parolei jābūt vismaz 8 simbolus garai un jāsatur vismaz viens lielais burts, viens mazais burts un viens cipars</span>';
                        // Pārbauda vai pēc e-pasts satur @ simbolu, un vai pēc šī simbola vēl ir texts
                        } else if (!filter_var($gmail, FILTER_VALIDATE_EMAIL) || strpos($gmail, '@') === false) {
                            // ja nosacījumi nav piepildīti tiek attēlots paziņojums
                            echo '<span style="width: 300px; display: inline-block;">Nepareizs formāts! Ievadītā e-pasta adresei ir jāsatur \'@\' simbols un jābūt derīgam e-pasta formātam.</span>';
                        } else {
                            // šī funkcija izveido parole hašu no ievadītās paroles
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                            // pārbauda vai šāds e-pasts jau nepastāv
                            $sql = "SELECT * FROM users WHERE gmail=?";
                            $stmt = $conn->prepare($sql);
                            // šis kods piesaista e-pasta adresi sagatavotam sql vaicājumam, nodrošinot, ka tas tiek pareizi aiztāts jautājum zīmēs
                            $stmt->bind_param("s", $gmail);
                            // izpilda sagatavoto sql vaicājumu
                            $stmt->execute();
                            // iegūst rezultātu kopu no izpildītā SQL vaicājuma
                            $result = $stmt->get_result();

                            // pārbauda vai iegūtajā rezultātu kopā ir vairāk nekā 0 ieraksti
                            if ($result->num_rows > 0) {
                                echo "Lietotājs ar šādu email jau eksistē";
                            } else {
                                // tiek sagatavots insert vaicājums, kas ievieto datus datubāzē
                                $sql = "INSERT INTO users(vards, uzvards, gmail, `password`, `admin`)
                                    VALUES (?, ?, ?, ?, ?)";

                                $stmt = $conn->prepare($sql);
                                // Šis kods piesaista vērtības sagatavotam INSERT vaicājumam.
                                $stmt->bind_param("sssss", $vards, $uzvards, $gmail, $hashedPassword, $admin);
                                // vaicājums tiek izpildīts
                                $stmt->execute();

                                // šis nosacījums pārbauda, vai ievietošanas vaicājums ir ietekmējis vismaz vienu ierasktu datu bāzēs
                                if ($stmt->affected_rows > 0) {
                                    echo "Veiksmīgi izveidots lietotājs.";
                                } else {
                                    echo "Kļūda! Neizdevās izveidot.";
                                }
                            }
                        }
                    } else {
                        echo "Paroles nesakrīt.";
                    }
                } else {
                    echo "Nav ievadīta parole.";
                }
            } else {
                echo "Nav ievadīts Gmail.";
            }
        } else {
            echo "Nav ievadīts uzvārds.";
        }
    } else {
        echo "Nav ievadīts vārds.";
    }
}
?>
