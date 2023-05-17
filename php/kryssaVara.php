<?php
declare (strict_types=1);

// läs in gemensamma funktioner
require_once "funktioner.php";

// läs och kontrollera indata
// rätt metod
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

// koppla mot databasen
$db=connectDB();

//  toggla checked-värdet
$sql="UPDATE varor SET checked=NOT(checked) where id=:id";
$stmt=$db->prepare($sql);
$stmt->execute(['id'=>$id]);

if(!$stmt->rowCount()===0){
    $error=new stdClass();
    $error->meddelande=["server error", "kunde inte uppdatera varan"];
    skickaJSON($error, 400);
}

// skicka svar
skickaJSON(['meddelande'=>'OK']);