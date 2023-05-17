<?php
declare (strict_types=1);

//lägg till gemensamma funktioner
require_once "funktioner.php";
//kontrollera anropsmetod
if ($_SERVER['REQUEST_METHOD']!=='POST'){
    $error=new stdClass();
    $error->meddelande=["wrong method", "sidan ska anropas med POST"];
    skickaJSON($error, 405);
}
//koppla databas
$db=connectDB();
//radera valda varor
$sql="DELETE FROM varor WHERE checked=1";
$stmt=$db->query($sql);
//skicka svar
$out = new stdClass();
$out->meddelande = "OK";
skickaJSON($out);