<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<?php
//pievienu lapas navigācijas joslu
include "../../user-includes/header.php";
?>
<?php
// izvēlas visus laukus no products_sieviesu tabulas kur kategorijas kolona atbilst noteiktai vērtībai
$sql = "SELECT * FROM products_bernu WHERE kategorija = ?";
// Sagatavo vaicājumu, izmantojot mysqli_prepare(), kura rezultāts tiek saglabāts mainīgajā $stmt
$stmt = mysqli_prepare($conn, $sql);
// Saista parametrus ar sagatavoto vaicājumu. Šajā gadījumā, "s" norāda, ka pirmajam parametram būs virkne (string), un $category vērtība tiks piešķirta šim parametram.
mysqli_stmt_bind_param($stmt, "s", $category);
// norāda kategorijas vērtību, ar kuru tiks salīdzināta kategoriju kolonna datubāzē
$category = 'Jaka';
// izpilda sagatavoto vaicājumu ar piesaistītajiem parametriem
mysqli_stmt_execute($stmt);
// iegūst rezultātu no vaicājuma un glabā to $results
$result = mysqli_stmt_get_result($stmt);
// Pārveido rezultātu masīvā, kur katrs ieraksts ir asociatīvs masīvs, saglabā to mainīgajā $products
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="container mx-auto py-8">
    <!-- pievienojam virsrakstu -->
    <div class="text-center mb-10 mt-10 text-bold">
        <h1 class="text-3xl font-bold">BĒRNU JAKAS</h1>
    </div>
    <!-- izveidojam grid priekš produktiem -->
    <div class="grid grid-cols-2 md:grid-cols-4 place-items-center">
        <!-- izvadam produktus -->
        <?php foreach ($products as $product) { ?>
            <!-- link ved uz product.php lapu un tajā tiek padots produkta id un tabula ar kuru saistīts šis produkts -->
            <!-- htmlspecialchars aizsargā URl no HTML tagu injekcijas -->
      <a href="../../product.php?productId=<?php echo htmlspecialchars($product['bernuProducts_id']); ?>&table=products_bernu">
      <div class="h-[360px] sm:h-[400px] lg:h-[480px] w-[150px] sm:w-[186px] lg:w-60 border-2 border-zinc-900 rounded-[12px] m-4 sm:m-8 hover:box-shadow hover:cursor-pointer">
        <div class="relative w-46 h-[240px] sm:h-[280px] lg:h-[360px] flex items-center justify-center overflow-hidden">
          <img src="<?php echo "../../". htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="object-contain w-full h-full border-2 border-b-zinc-900 rounded-t-lg">
        </div>
        <div class="text-center py-2">
          <span class=""><?php echo htmlspecialchars($product['name']); ?></span>
          <p class="font-semibold ellipsis"><?php echo htmlspecialchars($product['apraksts']); ?></p>
          <p class="text-gray-700 text-base"><?php echo htmlspecialchars($product['kategorija']); ?></p>
          <h1 class="mt-2 text-darkGreen font-semibold">$<?php echo number_format($product['cena'], 2); ?></h1>
        </div>
      </div>
      </a>
    <?php } ?>
  </div>
</div>
<?php
// pievieno lapas kājeni
include "../../user-includes/footer.php";
?>
</body>
</html>