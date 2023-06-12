function getValue(inputSet, event, getForm) {
    // nodrošina ka notika noklusējuma darbība netiek izpildīta
    event.preventDefault();
    // iegūst atsauci uz html elementu
    let msg = document.getElementById('msg');
    // iegūst atsauci uz html formu elementu
    let form = document.getElementById(getForm);
    // izveido formdata objektu
    let formData = new FormData(form);
    // Šī rinda izveido XMLHttpRequest objektu, kas tiek izmantots, lai veiktu AJAX pieprasījumus.
    let xmlhttp = new XMLHttpRequest();
    // šis ir notikuma apdarinātājs, kas tiek izsaukts, kad mainās XMLHttpRequest objekta stāvolis
    xmlhttp.onreadystatechange = function() {
        // tiek pārbaudīts, vai pieprasījums ir pabeigts un vai tika saņemts veiksmīgs atbildes statuss (status200)
        if (this.readyState == 4 && this.status == 200) {
            // ja atbilde ir admin vai main, tiek veikta pāradresācija uz main.php
            if (this.responseText === "admin") {
                window.location = "main.php";
            } else if (this.responseText === "main") {
                window.location = "main.php";
            } else {
                msg.innerHTML = this.responseText;
            }
        }
    };
    xmlhttp.open("POST", "query/select.php", true);
    // nosūta pieprasījumu uz serveri
    xmlhttp.send(formData);
}