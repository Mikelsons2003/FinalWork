function myFunction() {
  // novērš lapas pārlādi
  event.preventDefault();
  // iegūst atsauci uz html elementu, pirmais div
  var x = document.getElementById("myDIV");
  // iegūst atsauci uz html elementu, otrais div
  var y = document.getElementById("myDIVs");
  // iegūst atsauci uz html elementu, poga ar texta maiņu
  var btn = document.getElementById("btn");

  if (x.style.display === "none") { // pārbauda vai mydiv elemets ir neredzams
    btn.textContent = 'Register'; // atjauno pogas tekstu uz register
    x.style.display = "block"; // iestata mydiv uz block, kas padara to redzamu
    y.style.display = "none"; // iestata mydivs uz none, kas paslēpj to.
  } else {
    btn.textContent = 'Login'; // atjauno pogas tekstu uz login
    x.style.display = "none"; // iestata mydiv uz none, kas paslēpj to.
    y.style.display = "block"; // iestata mydivs uz block, kas padara to redzamu
  }
}
