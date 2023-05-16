<?php
declare (strict_types=1);

// inkludera
require_once "funktioner.php";

//läs indata och sanera
//kontrollera metod
if ($_SERVER['REQUEST_METHOD']!=='POST'){
    $error=new stdClass();
    $error->meddelande=["wrong method", "sidan ska anropas med POST"];
    skickaJSON($error, 405);
}

// läs indata
$vara=filter_input(INPUT_POST, 'vara', FILTER_SANITIZE_SPECIAL_CHARS);
if(!isset($vara) || mb_strlen($vara)>50){
    $error=new stdClass();
    $error->meddelande=["bad input", "parametern 'vara' saknas eller är mer än 50 tecken"];
    skickaJSON($error, 400);
}

//koppla mot databas
$db=connectDB();

//spara data
$sql="INSERT INTO varor (namn) VALUES (:vara)";
$stmt=$db->prepare($sql);

$stmt->execute(['vara'=>$vara]);
$id=$db->lastInsertId();

//skicka tillbaka svar
skickaJSON(['id'=>$id]);