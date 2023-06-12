<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<?php
// pievienojam lapas navigācija joslu
include "user-includes/product-header.php";
?>

<div class="flex flex-col justify-center items-center mt-24 text-center">
  <h1 class="text-3xl font-bold">APMAKSAS UN SŪTĪŠANAS INFORMĀCIJA</h1>
  <p>Lūgums prasīto informāciju norādīt precīzi</p>
  <p class="mb-8">Pieņemam MasterCard & Visa kartes</p>
  
  <label for="vards-uzvards">IEVADIET UZ KARTES NORĀDĪTO VĀRDU UN UZVĀRDU*</label>
  <input type="text" id="vards-uzvards" class="w-72 sm:w-96 h-8 mt-2 mb-2 border border-black rounded-md p-2">
  
  <label for="KartesNumurs">KARTES NUMURS*</label>
  <input type="text" id="KartesNumurs" class="w-72 sm:w-96 h-8 mt-2 mb-2 border border-black rounded-md p-2">
  
  <label for="datums">DERĪGUMA TERMIŅŠ (MĒNSESIS / GADS)*</label>
  <div class="flex flex-row">
    <input type="text" id="datums" class="w-20 h-8 mt-2 mr-4 border border-black rounded-md p-2">
    <p class="mt-2 h-8">/</p>
    <input type="text" id="datums" class="w-20 h-8 mt-2 ml-4 border border-black rounded-md p-2 mb-2">
  </div>
  
  <label for="CVC">CVV2/CVC2*</label>
  <input type="text" id="CVC" class="w-20 h-8 mt-2 border border-black rounded-md p-2 mb-3">
  
  <label for="Pilseta">PILSĒTA*</label>
  <input type="text" id="Pilseta" class="w-72 sm:w-96 h-8 mt-2 mb-2 border border-black rounded-md p-2">
  
  <label for="Adrese">ADRESE*</label>
  <input type="text" id="Adrese" class="w-72 sm:w-96 h-8 mt-2 mb-2 border border-black rounded-md p-2">
  
  <label for="Indekss">PILNAIS PASTA INDEKSS*</label>
  <input type="text" id="Indekss" class="w-72 sm:w-96 h-8 mt-2 mb-6 border border-black rounded-md p-2 mb-2">

  <label for="message">Lauki norādīti ar * obligāti jāaizspilda</label>
  
  <button type="submit" class="w-32 h-10 bg-green rounded-md mb-12 ease-in-out duration-300 hover:text-white mt-2">PIRKT</button>
</div>


<?php
// pievienojam lapas kājeni
include "user-includes/footer1.php";
?>
</body>
</html>