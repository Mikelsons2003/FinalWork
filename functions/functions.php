<?php
// tiek padoti divi parametri, vaicājums un datu bāzes savienojums, veic select vaicājumu uz datubāzi
function select($sql, $conn) {
  $result = $conn->query($sql);
  // pārbauda vai rezultāts satur vismaz vienu ierakstu
  if($result->num_rows >0){
      // atgriež rezultātu
      return $result;
  }else{
      // citādi false
      return false;
  }
}
// tiek padoti divi parametri, vaicājums un datu bāzes savienojums, veic insert vaicājumu uz datubāzi
function insert($sql, $conn){
    // pārbauda vai vaicājums izpildīts veiksmīgi
  if($conn->query($sql)===TRUE){
      // ja veiksmīgi atgriež true
      return true;
  }else{
      // ja nē, atgriež false
      return false;
  }
}
?>