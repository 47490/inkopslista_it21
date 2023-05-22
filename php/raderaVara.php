<?php
declare (strict_types=1);

// inkludera
require_once "funktioner.php";

//kontrollera metod
if ($_SERVER['REQUEST_METHOD']!=='POST'){
    $error=new stdClass();
    $error->meddelande=["wrong method", "sidan ska anropas med POST"];
    skickaJSON($error, 405);
}

// kontrollera id
$id=filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
if(!isset($id) || !$id || $id<1){
    $error=new stdClass();
    $error->meddelande=["bad request", "id saknas eller är ogiltig"];
    skickaJSON($error, 400);
}

//koppla mot databas
$db=connectDB();

//skapa sql och ecekvera den
$sql = "DELETE FROM varor WHERE id=:id";
$stmt = $db->prepare($sql);
$stmt->execute(['id'=> $id]);

//skicka svar
$out = new stdClass();
if($stmt->rowCount()===0){
    $out->meddelande = ["posten kunde inte raderas"];
    skickaJSON($out, 400);
} else{
    $out->meddelande = ["OK"];
    skickaJSON($out);
}