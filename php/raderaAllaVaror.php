<?php
declare (strict_types=1);

//lägg till gemensamma funktioner
require_once "funktioner.php";

//kontrollera metod
if ($_SERVER['REQUEST_METHOD']!=='POST'){
    $error=new stdClass();
    $error->meddelande=["wrong method", "sidan ska anropas med POST"];
    skickaJSON($error, 405);
}

//koppla databas
$db=connectDB();

//radera alla varor
$sql = "DELETE FROM varor";
$db->query($sql);
//skicka svar
skickaJSON(["meddelande"=>"OK"]);