<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<?php
// tiek ievietota lapas navigācija josla
include "user-includes/product-header.php";
?>
<?php
// Tiek izveidot masīvs
$tables = array(
     // tiek saistīts tabulas nosaukums ar atbildtošās tabulas kolonas nosaukumu
    'products_viriesu' => 'viriesuProducts_id',
    'products_sieviesu' => 'sieviesuProducts_id',
    'products_bernu' => 'bernuProducts_id'
);
// Pārbauda vai ir norādīti productid un table parametri GET pieprasījumā
if (isset($_GET['productId']) && isset($_GET['table'])) {
    // Ja abiem parametriem ir vērtības tie tiek saglabāti
    $productId = $_GET['productId'];
    $table = $_GET['table'];
    // Pārabuda vai norādītais tabulas nosaukums eksistē masīvā $tables
    if (array_key_exists($table, $tables)) {
        // ja esksitē tas tiek saglabāts $idcolumn
        $idColumn = $tables[$table];
        // izmanto funkciju lai iegūtu produkta datus
        $product = getProductById($productId, $table, $idColumn);
        if ($product) {
            // tiek izvadīts produkts
            echo
            "<div class='grid grid-cols-1 sm:grid-cols-2'>",
            "<div class='mx-auto pt-20 pb-20'>",
            "<div class='flex flex-col'>",
            "<h1 class='text-4xl text-center mb-6'>PRODUKTA BILDE</h1>",
                "<img src='" . $product['image_path'] . "' class='object-contain w-96 border-2 border-zinc-900 rounded-lg'>",
            "</div>",
            "</div>",
            "<div class='mx-auto my-auto'>",
            "<div class='flex flex-col text-start mb-6'>",
            "<h1 class='mb-6 text-2xl'>PRODUKTA DETAĻAS</h1>",
                "<p class='mb-2'>PRODUKTA FIRMA: " . $product['name'] . "</p>",
                "<p class='mb-2'>PRODUKTA APRAKSTS: " . $product['apraksts'] . "</p>",
                "<p class='mb-2'>PRODUKTA CENA: $" . $product['cena'] . "</p>",
                "<p class='mb-2'>PRODUKTA DAUDZUMS: " . $product['daudzums'] . "</p>",
            "<form action='checkout.php' method='post'>",
                "<input type='hidden' name='product_id' value='" . $product[$tables[$table]] . "'>",
            "<input type='number' name='quantity' min='1' value='1' class='w-16 h-10 mr-2 border-2 border-gray-300 rounded-md'>",
            "<button type='submit' class='w-32 h-10 bg-green rounded-md ease-in-out duration-300 hover:text-white'>PIRKT</button>",
            "</form>",
            "</div>",
            "</div>",
            "</div>";
        } else {
            echo "Product not found.";
        }
    } else {
        echo "Invalid table name.";
    }
} else {
    echo "Invalid product ID or table name.";
}
// Function to fetch product information by ID from the database
function getProductById($productId, $table, $idColumn)
{
    //norāda datubāzes parametra savienojumus
    $host = 'localhost';
    $user = 'skolnieks';
    $pass = 'pQcM10ClEn3lSWy';
    $dbName = 'miks_mikelsons';

    // Izveido jaunu mysqli savienojumu ar norādītajiem parametriem
    $conn = new mysqli($host, $user, $pass, $dbName);
    // Pārbauda savienojuma veiksmīgumu
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sagatavo SQL vaicājumu ar aizvietotājiem tabulas nosaukumam un ID kolonnai
    $query = "SELECT * FROM " . $table . " WHERE " . $idColumn . " = ?";

    // Inicializē jaunu mysqli_stmt objektu
    $stmt = mysqli_stmt_init($conn);

    // Sagatavo vaicājumu
    if (mysqli_stmt_prepare($stmt, $query)) {
        // Piesaista produkta ID kā parametru katram SELECT vaicājumam
        mysqli_stmt_bind_param($stmt, "i", $productId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Pārbauda, vai ir atgriezti kādi ieraksti
        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
        } else {
            $product = false;
        }
        // Aizver stmt objektu
        mysqli_stmt_close($stmt);
    } else {
        die("Error: " . mysqli_error($conn));
    }
    // Aizver datu bāzes savienojumu
    mysqli_close($conn);
    // Atgriež iegūto produktu
    return $product;
}
?>

<?php
// Tiek pievienota lapas kājene
include "user-includes/footer1.php";
?>
</body>
</html>