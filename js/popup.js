// popup script for login/register
// iegūst atsauci uz html elementu, tas atver uzplaukuma logu
const openPopupButton = document.getElementById('open-popup-button');
// iegūst atsauci uz html elementu, tas aizver uzplaukuma logu
const closePopupButton = document.getElementById('close-popup-button');
// iegūst atsauci uz html elementu, tas ir pats uzplaukuma logs
const popup = document.getElementById('popup');

// kad tiek nospiests uz pogas, hidden klase tiek noņemta, kas padara logu redzamu.
openPopupButton.addEventListener('click', () => {
  popup.classList.remove('hidden');
});

// kad tiek nospiests uz pogas, hidden klase tiek pievienota, kas padara logu neredzamu.
closePopupButton.addEventListener('click', () => {
  popup.classList.add('hidden');
});