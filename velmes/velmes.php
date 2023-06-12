<?php
session_start();
include "../user-includes/username.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/77fb6ff9fe.js" crossorigin="anonymous"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <title>ZoneOut</title>
  <script>
    tailwind.config = {
      theme: {
        screen: {
          sm: '480px',
          md: '768px',
          lg: '976px',
          xl: '1440px'
        },
        extend: {
          colors: {
            darkGray1: 'hsl(0, 0%, 16%)',
            lightGray1: 'hsl(0, 0%, 26%)',
            white: 'hsl(0, 0%, 91%)',
            red: 'hsl(0, 74%, 42%)',
            darkGreen: 'hsl(159, 92%, 10%)',
            yellow: 'hsl(45.4,93.4%,47.5%)'
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
  <nav class="absolute py-2 px-2 xl:px-36 min-h-[4vh] w-full bg-darkGray1 text-sm sticky top-0 z-50">
    <div class="flex items-center justify-between">
      <div class="cursor-pointer">
        <a href="../main.php"><img src="../img/logo.png" class="w-40"></a>
      </div>
      <!-- Menu Items -->
      <div class="md:flex text-white">
        <!-- Lietotajs -->
        <button id="open-popup-button"
        class="md:w-14 md:h-14 w-7 h-7 hover:bg-lightGray1 rounded-[12px] hover:rounded-[12px] md:mr-4 ease-in duration-200">
        <span><i class="fa-solid fa-user"></i></span>
        <div class="hidden md:block">
            <?php echo getUsername(); ?>
        </div>
        </button>
        <!-- Vēlmes -->
        <a href="velmes.php"><button id="open-popup-button"
          class="md:w-14 md:h-14 w-7 h-7 hover:bg-lightGray1 rounded-[12px] hover:rounded-[12px] md:mr-4 ease-in duration-200">
          <span><i class="fa-solid fa-heart"></i></span>
          <div class="hidden md:block">Vēlmes</div>
        </button></a>
        <!-- Grozs -->
      </div>
      <!-- popup window Lietotajs-->
      <div id="popup" class="fixed top-0 left-0 w-full h-full bg-gray-600 bg-opacity-50 hidden">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 rounded">
          <div class="flex flex-col justify-center text-center">
            <!-- login form -->
            <form id="logForm">
              <div id="myDIV" style="display:none">
                <div class="flex flex-row justify-between mx-1">
                  <h1 class="text-xl font-bold mb-2">PIESLĒGTIES</h1>
                  <button id="close-popup-button" class="justify-end hover:text-red ease-in duration-200"><i
                      class="fa-solid fa-xmark fa-2x"></i></button>
                </div>
                <input type="email" name="gmail2" placeholder="example@gmail.com"
                  class="block mb-2 px-3 py-2 outline-none rounded-md w-[334px]">
                <input type="password" name="password2" placeholder="Parole..."
                  class="block mb-2 px-3 py-2 outline-none rounded-md w-[334px]">
                <button onclick="getValue('select.php', event, 'logForm')"
                  class="bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded mb-2 w-[334px]">Login</button>
              </div>
            </form>
            <!-- registration form -->
            <form id="regForm" autocomplete="off">
              <div id="myDIVs" style="display:block">
                <div class="flex flex-row justify-between mx-1">
                  <h1 class="text-xl font-bold mb-2">IZVEIDOT PROFILU</h1>
                  <button id="close-popup-button" class="justify-end hover:text-red ease-in duration-200"><i
                      class="fa-solid fa-xmark fa-2x"></i></button>
                </div>
                <div class="flex flex-row">
                  <input type="text" name="vards" placeholder="Vārds....  " id="vards"
                    class="mb-2 mr-[2px] px-3 py-2 outline-none rounded-md">
                  <input type="text" name="uzvards" placeholder="Uzvārds..." id="uzvards"
                    class="mb-2 ml-[2px] px-3 py-2 outline-none rounded-md">
                </div>
                <input type="email" name="gmail" placeholder="example@gmail.com" id="gmail"
                  class="block mb-2 px-3 py-2 outline-none rounded-md w-full">
                <input type="password" name="password" placeholder="Parole...." id="password"
                  class="block mb-2 px-3 py-2 outline-none rounded-md w-full">
                <input type="password" name="repeatpassword" placeholder="Atkartoti parole..." id="repeatpassword"
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
  <!-- Shopping cart -->
  <nav class="relative py-2 px-2 md:px-5 xl:px-36 w-full h-12 bg-lightGray1 sticky top-[66px] md:top-[72px] z-50 text-white">
    <h1 class="text-center text-2xl">JŪSU FAVORĪTĀKIE PRODUKTI</h1>
  </nav>


  <script src="../js/change.js"></script>
  <script src="../js/insert.js"></script>
  <script src="../js/popup.js"></script>
  <script src="../js/select.js"></script>
</body>
</html>