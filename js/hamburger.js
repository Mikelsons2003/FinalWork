// iegūst atsauci uz html elementu
const btn = document.getElementById('menu-btn');
// iegūst atsauci uz html elementu
const nav = document.getElementById('menu');

function toggleMenu() {
  // pievieno/noņem open klasi(atver, aizver)
  btn.classList.toggle('open');
  // pievieno/noņem flex klasi(layouts)
  nav.classList.toggle('flex');
  // pievieno/noņem hidden klasi(izvēlnes redzamība)
  nav.classList.toggle('hidden');
}

// atver un aizver izvēlni
btn.addEventListener('click', toggleMenu);