<?php
session_start();
// tiek pievienots datubāzes connection
include "../../config/db.php";
// tiek pievienotas insert un select funkcijas
include "../../functions/functions.php";
// tiek pievienots fails kas satur sessiju ar username
include "username.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- atbalsta dažādas valodas un simbolus -->
    <meta charset="UTF-8" />
    <!-- Šis metatags norāda, ka lapai jāizmanto vislabākā atbalstītā versija no IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Šis metatags norāda lapas skatīšanas iestatījumus mobilo ierīču skatījumā. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Šī saite iepriekš saistās ar Google Fonts serveri, lai uzlabotu lapas ielādes veiktspēju, kad tiek izmantotas Google Fonts. -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- Šī saite iepriekš saistās ar Google Fonts servera resursiem, lai uzlabotu lapas ielādes veiktspēju, kad tiek izmantotas Google Fonts. -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- google fonti -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400&display=swap" rel="stylesheet">
    <!-- tiek izmantots lai iegūtu ikonas -->
    <script src="https://kit.fontawesome.com/77fb6ff9fe.js" crossorigin="anonymous"></script>
    <!-- ievieto tailwind css bibliotēkas kodu -->
    <script src="https://cdn.tailwindcss.com"></script>
  <title>ZONEOUT</title>
  <script>
    tailwind.config = {
      theme: {
          <!-- definē dažādas ekrān izmēra vērtības -->
        screen: {
          sm: '480px',
          md: '768px',
          lg: '976px',
          xl: '1440px'
        },
        extend: {
            <!-- definē krāsas -->
          colors: {
            darkGray1: 'hsl(0, 0%, 16%)',
            lightGray1: 'hsl(0, 0%, 26%)',
            white: 'hsl(0, 0%, 91%)',
            red: 'hsl(0, 74%, 42%)',
            darkGreen: 'hsl(159, 92%, 10%)',
          }
        }
      }
    }
  </script>
  <style type="text/tailwindcss">
    @layer utilities {
      *{
        font-family: 'Roboto Condensed';
      }
      .box-shadow{
        box-shadow: 0 5px 15px rgb(0 0 0 / 50%);
      }
      .hamburger {
        cursor: pointer;
        width: 24px;
        height: 24px;
        transition: all 0.25s;
        position: relative;
      }
      .hamburger-top,
      .hamburger-middle,
      .hamburger-bottom {
        position: absolute;
        top: 0;
        left: 0;
        width: 24px;
        height: 2px;
        background: black;
        transform: rotate(0);
        transition: all 0.5s;
      }
      .hamburger-middle{
        transform: translateY(7px);
      }
      .hamburger-bottom{
        transform: translateY(14px);
      }
      .open{
        transform: rotate(90deg);
        transform: translateY(0px);
      }
      .open .hamburger-top{
        transform: rotate(45deg) translateY(6px) translate(6px);
      }
      .open .hamburger-middle{
        display: none;
      }
      .open .hamburger-bottom{
        transform: rotate(-45deg) translateY(6px) translate(-6px);
      }
      .top-17{
        top: 78px;
      }
      .block{
        display: block;
      }
      .none{
        display: none;
      }
      .relative:hover > div {
        opacity: 1;
      }
      .ellipsis {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
      }
    }
  </style>
</head>
<body>
  <!-- nav bar -->
  <nav class="fixed top-0 left-0 py-2 px-2 xl:px-36 min-h-[4vh] w-full bg-darkGray1 text-sm z-50 overflow-y-hidden">
  <div class="flex items-center justify-between">
      <div class="cursor-pointer">
        <a href="../../main.php"><img src="../../img/logo.png" class="w-40"></a>
      </div>
      <!-- Menu Items -->
      <div class="md:flex text-white">
        <!-- Lietotajs -->
        <button id="open-popup-button"
        class="md:w-14 md:h-14 w-7 h-7 hover:bg-lightGray1 rounded-[12px] hover:rounded-[12px] md:mr-4 ease-in duration-200">
        <span><i class="fa-solid fa-user"></i></span>
        <div class="hidden md:block">
            <!-- izsauc username funkciju -->
          <?php echo getUsername(); ?>
        </div>
        </button>
        <!-- Admin add product button -->
        <?php
        // pārbauda vai lietotājs ir admin
        if (isset($_SESSION['admin']) && $_SESSION['admin'] === 'admin') {
            // Ja lietotājs ir admin tam parādas papildus opcija
            echo '
            <a href="../../adminpro.php">
                <button id="open-popup-button" class="md:w-14 md:h-14 w-7 h-7 hover:bg-lightGray1 rounded-[12px] hover:rounded-[12px] md:mr-4 ease-in duration-200">
                    <span><i class="fa-solid fa-plus"></i></span>
                    <div class="hidden md:block">Add PRO</div>
                </button>
            </a>';
            // Ja lietotājs nav admin, papildus opcija tam netiek rādīta
        } else if (isset($_SESSION['admin']) && $_SESSION['admin'] === 'main') {
            echo '
            <a href="../../adminpro.php" class="hidden">
                <button id="open-popup-button" class="md:w-14 md:h-14 w-7 h-7 hover:bg-lightGray1 rounded-[12px] hover:rounded-[12px] md:mr-4 ease-in duration-200">
                    <span><i class="fa-solid fa-plus"></i></span>
                    <div class="hidden md:block">Add PRO</div>
                </button>
            </a>';
        }
        ?>
      </div>
      <!-- popup window Lietotajs-->
      <div id="popup" class="fixed top-0 left-0 w-full h-full bg-gray-600 bg-opacity-50 hidden">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 rounded">
          <div class="flex flex-col justify-center text-center">
            <!-- login form -->
            <form id="logForm" method="POST">
              <div id="myDIV" style="display:none">
                <div class="flex flex-row justify-between mx-1">
                  <h1 class="text-xl font-bold mb-2">PIESLĒGTIES</h1>
                  <button id="close-popup-button" class="justify-end hover:text-red ease-in duration-200"><i
                      class="fa-solid fa-xmark fa-2x"></i></button>
                </div>
                <input type="email" name="gmail2" id="login-email" placeholder="example@gmail.com"
                  class="block mb-2 px-3 py-2 outline-none rounded-md w-[334px]">
                <input type="password" name="password2" id="login-password" placeholder="Parole..."
                  class="block mb-2 px-3 py-2 outline-none rounded-md w-[334px]">
                <button onclick="getValue('select.php', event, 'logForm')"
                  class="bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded mb-2 w-[334px]">Login</button>
              </div>
            </form>
            <!-- registration form -->
            <form id="regForm" autocomplete="off" method="POST">
              <div id="myDIVs" style="display:block">
                <div class="flex flex-row justify-between mx-1">
                  <h1 class="text-xl font-bold mb-2">IZVEIDOT PROFILU</h1>
                  <button id="close-popup-button" class="justify-end hover:text-red ease-in duration-200"><i
                      class="fa-solid fa-xmark fa-2x"></i></button>
                </div>
                <div class="flex flex-row">
                  <input type="text" name="vards" id="reg-name" placeholder="Vārds....  " id="vards"
                    class="mb-2 mr-[2px] px-3 py-2 outline-none rounded-md">
                  <input type="text" name="uzvards" id="reg-surname" placeholder="Uzvārds..." id="uzvards"
                    class="mb-2 ml-[2px] px-3 py-2 outline-none rounded-md">
                </div>
                <input type="email" name="gmail" id="reg-email" placeholder="example@gmail.com" id="gmail"
                  class="block mb-2 px-3 py-2 outline-none rounded-md w-full">
                <input type="password" name="password" id="reg-password" placeholder="Parole...." id="password"
                  class="block mb-2 px-3 py-2 outline-none rounded-md w-full">
                <input type="password" name="repeatpassword" id="reg-repassword" placeholder="Atkartoti parole..." id="repeatpassword"
                  class="block mb-2 px-3 py-2 outline-none rounded-md w-full">
                <button onclick="getValue1('insert.php', event, 'regForm')"
                  class="bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded mb-2 w-full">Register</button>
              </div>
              <button id="btn" onclick="myFunction()" name="Login"
              class="bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded mb-2 w-full">Login</button>
              <p id="msg"></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- Categorys nav -->
  <nav class="relative py-2 px-2 md:px-5 xl:px-36 w-full h-12 bg-lightGray1 sticky top-[66px] md:top-[72px] z-10">
  <div class="flex justify-between items-center">
      <div class="flex flex-row text-white text-bold">
        <div class="flex flex-col">
          <button class="peer px-3 bg-lightGray1 text-white h-full"><a class="hidden md:flex mr-4 hover:text-red ease-in duration-200"
              href="../sieviesu/sieviesu.php">SIEVIETĒM</a></button>
          <div
            class="absolute hidden w-24 peer-hover:flex hover:flex flex-col bg-white drop-shadow-lg text-center mt-6">
            <a class="hover:text-red text-black text-bold mb-2 ease-in duration-200 pt-2"
              href="../sieviesu/s_apavi.php">APAVI</a>
            <a class="hover:text-red text-black text-bold mb-2 ease-in duration-200"
              href="../sieviesu/s_dzemperi.php">DŽEMPERI</a>
            <a class="hover:text-red text-black text-bold mb-2 ease-in duration-200"
              href="../sieviesu/s_bikses.php">BIKSES</a>
            <a class="hover:text-red text-black text-bold ease-in duration-200 pb-2"
              href="../sieviesu/s_jakas.php">JAKAS</a>
          </div>
        </div>
        <div class="flex flex-col">
          <button class="peer px-3 bg-lightGray1 text-white h-full"><a class="hidden md:flex mr-4 hover:text-red ease-in duration-200"
              href="../viriesu/viriesu.php">VĪRIEŠIEM</a></button>
          <div
            class="absolute hidden w-24 peer-hover:flex hover:flex flex-col bg-white drop-shadow-lg text-center mt-6">
            <a class="hover:text-red text-black text-bold mb-2 ease-in duration-200 pt-2"
              href="../viriesu/v_apavi.php">APAVI</a>
            <a class="hover:text-red text-black text-bold mb-2 ease-in duration-200"
              href="../viriesu/v_dzemperi.php">DŽEMPERI</a>
            <a class="hover:text-red text-black text-bold mb-2 ease-in duration-200"
              href="../viriesu/v_bikses.php">BIKSES</a>
            <a class="hover:text-red text-black text-bold ease-in duration-200 pb-2"
              href="../viriesu/v_jakas.php">JAKAS</a>
          </div>
        </div>
        <div class="flex flex-col">
          <button class="peer px-3 bg-lightGray1 text-white h-full"><a class="hidden md:flex mr-4 hover:text-red ease-in duration-200" href="../bernu/bernu.php">BĒRNIEM</a></button>
          <div
            class="absolute hidden w-24 peer-hover:flex hover:flex flex-col bg-white drop-shadow-lg text-center mt-6">
            <a class="hover:text-red text-black text-bold mb-2 ease-in duration-200 pt-2"
              href="../bernu/b_apavi.php">APAVI</a>
            <a class="hover:text-red text-black text-bold mb-2 ease-in duration-200"
              href="../bernu/b_dzemperi.php">DŽEMPERI</a>
            <a class="hover:text-red text-black text-bold mb-2 ease-in duration-200"
              href="../bernu/b_bikses.php">BIKSES</a>
            <a class="hover:text-red text-black text-bold ease-in duration-200 pb-2"
              href="../bernu/b_jakas.php">JAKAS</a>
          </div>
        </div>
      </div>
      <!-- hamburger -->
      <button id="menu-btn" class="block hamburger md:hidden focus:outline-none mr-2">
        <span class="hamburger-top"></span>
        <span class="hamburger-middle"></span>
        <span class="hamburger-bottom"></span>
      </button>
    </div>
    <!-- Mobile Menu -->
    <div class="md:hidden">
      <div id="menu"
        class="absolute flex-col items-center self-end hidden py-8 mt-8 space-y-6 font-bold bg-white sm:w-auto sm:self-center left-6 right-6 drop-shadow-md">
        <a href="../sieviesu/sieviesu.php" class="text-red">SIEVIETĒM</a>
        <div class="flex flex-col items-center gap-y-2">
          <a href="../sieviesu/s_apavi.php" class="hover:text-darkGray1ishBlue">APAVI</a>
          <a href="../sieviesu/s_dzemperi.php" class="hover:text-darkGray1ishBlue">DZEMPERI</a>
          <a href="../sieviesu/s_bikses.php" class="hover:text-darkGray1ishBlue">BIKSES</a>
          <a href="../sieviesu/s_jakas.php" class="hover:text-darkGray1ishBlue">JAKAS</a>
        </div>
        <a href="../viriesu/viriesu.php" class="text-red">VĪRIEŠIEM</a>
        <div class="flex flex-col items-center gap-y-2">
          <a href="../viriesu/v_apavi.php" class="hover:text-darkGray1ishBlue">APAVI</a>
          <a href="../viriesu/v_dzemperi.php" class="hover:text-darkGray1ishBlue">DZEMPERI</a>
          <a href="../viriesu/v_bikses.php" class="hover:text-darkGray1ishBlue">BIKSES</a>
          <a href="../viriesu/v_jakas.php" class="hover:text-darkGray1ishBlue">JAKAS</a>
        </div>
        <a href="../bernu/bernu.php" class="text-red">BĒRNIEM</a>
        <div class="flex flex-col items-center gap-y-2">
          <a href="../bernu/b_apavi.php" class="hover:text-darkGray1ishBlue">APAVI</a>
          <a href="../bernu/b_dzemperi.php" class="hover:text-darkGray1ishBlue">DZEMPERI</a>
          <a href="../bernu/b_bikses.php" class="hover:text-darkGray1ishBlue">BIKSES</a>
          <a href="../bernu/b_jakas.php" class="hover:text-darkGray1ishBlue">JAKAS</a>
        </div>
      </div>
    </div>
  </nav>
  <!-- Categorys-images -->
  <div class="text-center mt-24 mb-12 text-bold">
    <h1 class="text-3xl font-bold block">KATEGORIJAS</h1>
  </div>
  <div class="flex flex-col justify-center items-center gap-2 lg:gap-10 xl:gap-24 md:flex-row">
    <div class="relative md:ml-2">
      <a href="../sieviesu/sieviesu.php" class="hover:box-shadow"><img src="../../img/women.png"
          class="w-96 rounded-md hover:box-shadow"></a>
      <p class="absolute bottom-8 pl-4 text-2xl font-bold text-black">SIEVIETĒM</p>
    </div>
    <div class="relative">
      <a href="../viriesu/viriesu.php" class="hover:box-shadow"><img src="../../img/men.png"
          class="w-96 rounded-md hover:box-shadow"></a>
      <p class="absolute bottom-8 pl-4 text-2xl font-bold text-black">VĪRIEŠIEM</p>
    </div>
    <div class="relative md:mr-2">
      <a href="../bernu/bernu.php"><img src="../../img/bernu.png" class="w-96 rounded-md hover:box-shadow"></a>
      <p class="absolute bottom-8 pl-4 text-2xl font-bold text-black">BĒRNIEM</p>
    </div>
  </div>
  <!-- tiek pievienots hamburger menu kods priekš animācijas -->
  <script src="../../js/hamburger.js"></script>
  <!-- tiek pievienots change kods priekš login/register pogas -->
  <script src="../../js/change.js"></script>
  <!-- tiek pievienots inser.js, jo tas satur AJAX priekš register-->
  <script src="../../js/insert.js"></script>
  <!-- tiek pievienots poput priekš login/register animācijas -->
  <script src="../../js/popup.js"></script>
  <!-- tiek pievienots select.js, jo tas satur AJAX  priekš login-->
  <script src="../../js/select.js"></script>
</body>
</html>