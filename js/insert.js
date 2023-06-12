function getValue1(inputSet, event, getForm) {
  // nodrošina ka notika noklusējuma darbība netiek izpildīta
  event.preventDefault();
  // iegūst atsauci uz html elementu
  let msg = document.getElementById('msg');
  // iegūst atsauci uz html formu elementu
  let form = document.getElementById(getForm);
  // izveido formdata objektu
  let xmlhttp = new XMLHttpRequest();
  // Šī rinda izveido XMLHttpRequest objektu, kas tiek izmantots, lai veiktu AJAX pieprasījumus.
  let formData = new FormData(form);
  // šis ir notikuma apdarinātājs, kas tiek izsaukts, kad mainās XMLHttpRequest objekta stāvolis
  xmlhttp.onreadystatechange = function() {
    // tiek pārbaudīts, vai pieprasījums ir pabeigts un vai tika saņemts veiksmīgs atbildes statuss (status200)
    if (this.readyState == 4 && this.status == 200) {
      msg.innerHTML = this.responseText;
    }
  };
  xmlhttp.open("POST", "query/insert.php", true);
  // nosūta pieprasījumu uz serveri
  xmlhttp.send(formData);
}