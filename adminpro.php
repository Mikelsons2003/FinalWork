<?php
session_start();
// pārbauda vai lietotājs ir pieslēdzies un pārbauda vai tas ir admins
if (!(isset($_SESSION['logged']) && $_SESSION['logged'] == 1 && isset($_SESSION['admin']) && $_SESSION['admin'] == 'admin')) {
    // neatkarīgi no tā vai esi admin vai nēsi tu tiec pārvietots uz main.php
    header("Location: /ip19/miks/Finals1/main.php");
    exit(); // turpmākā lapas izpilde netiek veikta
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<?php
// tiek pievienota lapa navigācija josla
include "user-includes/product-header.php";
?>
<!-- Pievieno jaunu produktu -->
<div class="container mx-auto mt-8">
    <div class="text-center mt-24 mb-12 text-bold">
        <h1 class="text-3xl font-bold">PIEVIENOT JAUNU PRODUKTU</h1>
    </div>

    <?php
    // Pārbadua vai forma iesniegta, izsdpildīsies tikai tad kad forma tiks iesniegta ar POST metodi
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // tiek iegūti dati
        $table = $_POST['table_select'];
        $name = $_POST["name"];
        $apraksts = $_POST["apraksts"];
        $kategorija = $_POST["kategorija"];
        $cena = $_POST["cena"];
        $daudzums = $_POST["daudzums"];
        $image_path = "";

        // tiek pārbaudīts vai fails tiek augšupielādēts
        if ($_FILES["image"]["name"]) {
            // Ja fails tiek augšupielādēts, tad tiek izvēlēta mape kurā tas glabāsies
            if ($table === 'products_sieviesu') {
                $target_dir = "img/sieviesu/";
            } elseif ($table === 'products_viriesu') {
                $target_dir = "img/viriesu/";
            } elseif ($table === 'products_bernu') {
                $target_dir = "img/bernu/";
            }
            $timestamp = time(); // ģenēra laika zīmogu
            $image_name = pathinfo($_FILES["image"]["name"], PATHINFO_FILENAME); // tiek dabūts faila nosaukums
            $image_ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION); // tiek dabūts faila paplašinājums
            $image_path = $target_dir . $image_name . '_' . $timestamp . '.' . $image_ext; // tiek izveidots beigu ceļš ar mērķa direktoriju, faila nosukumu, laika zīmogu un faila paplašinājumu
            move_uploaded_file($_FILES["image"]["tmp_name"], $image_path); // fails tiek pārvietots uz mapi
        }

        // tiek definēts sql vaicājums
        $sql = "INSERT INTO $table (name, apraksts, kategorija, cena, image_path, daudzums) VALUES (?, ?, ?, ?, ?, ?)";
        // tiek izveidota sagatavota paziņojuma instance
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            // tiek saistīti sagatavotā paziņojuma parametri ar vērtībām, kas tiks ievietotas datubāzē
            mysqli_stmt_bind_param($stmt, "ssssss", $name, $apraksts, $kategorija, $cena, $image_path, $daudzums);
            // tiek pārbaudīts vai sagatavotā paziņojuma izpilde izdodas
            if (mysqli_stmt_execute($stmt)) {
                // tiek izvadīts paziņojums ja produkts pievienots veiksmīgi
                echo '<div class="bg-green-500 text-white font-bold py-2 px-4 mb-4">Product added successfully!</div>';
            } else {
                //tiek izvadīts paziņojums ja nav izdevies pievienot produtu
                echo '<div class="bg-red-500 text-white font-bold py-2 px-4 mb-4">Error adding product: ' . mysqli_error($conn) . '</div>';
            }
            // tiek aizvērta sagatavotā paziņojuma instance
            mysqli_stmt_close($stmt);
        } else {
            // ja sagatavotā paziņojuma izveide neizdodas tiek izvadīts paziņojums
            echo '<div class="bg-red-500 text-white font-bold py-2 px-4 mb-4">Error in prepared statement: ' . mysqli_error($conn) . '</div>';
        }
    }
    ?>
    <form action="adminpro.php" enctype="multipart/form-data" method="post">
        <div class="flex flex-col justify-center items-center">
            <label for="table_select" class="mb-2">Izvēlies kam pievienot jauno produktu:</label>
            <select id="table_select" name="table_select"
                    class="mb-6 px-3 py-2 rounded-md outline outline-offset-2 outline-1 w-60" required>
                <option value="products_sieviesu">Sieviešu Produkts</option>
                <option value="products_viriesu">Vīriešu Produkts</option>
                <option value="products_bernu">Bērnu Produkts</option>
            </select>
            <label for="name" class="mb-2">Firmas Nosaukums:</label>
            <input type="text" id="name" name="name" placeholder="ZoneOut.."
                   class="mb-6 px-3 py-2 rounded-md outline outline-offset-2 outline-1 w-60" required>
            <label for="apraksts" class="mb-2">Apraksts:</label>
            <textarea id="apraksts" name="apraksts"
                      class="mb-6 px-3 py-2 rounded-md outline outline-offset-2 outline-1 w-60" required></textarea>
            <label for="kategorija" class="mb-2">Kategorija:</label>
            <select id="nakategorijame" name="kategorija"
                    class="mb-6 px-3 py-2 rounded-md outline outline-offset-2 outline-1 w-60" required>
                <option value="Apavi">Apavi</option>
                <option value="Bikses">Bikses</option>
                <option value="Jaka">Jaka</option>
                <option value="Džemperis">Džemperis</option>
            </select>
            <label for="cena" class="mb-2">Cena:</label>
            <input type="number" id="cena" name="cena" step="0.01"
                   class="mb-6 px-3 py-2 rounded-md outline outline-offset-2 outline-1 w-60" min="0" max="500" required>
            <label for="daudzums" class="mb-2">Produkta Daudzums:</label>
            <input type="number" id="daudzums" name="daudzums"
                   class="mb-6 px-3 py-2 rounded-md outline outline-offset-2 outline-1 w-60" max="10" required>
            <label for="image" class="mb-2">Pievienot attēlu:</label>
            <input type="file" id="image" name="image" class="mb-6 px-3 py-2 w-60" required>
            <button type="submit"
                    class="bg-gray-300 font-bold py-2 px-4 rounded-md mb-6 w-60 hover:bg-lime-700 ease-in duration-200">
                Add Product
            </button>
        </div>
    </form>
</div>
<?php
// tiek pievienota lapas kājene
include "user-includes/footer1.php";
?>
</body>
</html>