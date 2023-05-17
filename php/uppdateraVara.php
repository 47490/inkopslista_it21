<?php
declare (strict_types=1);

//inkludera gemensamma funktioner
require_once "funktioner.php";
//kontrollera anropsmetod
if ($_SERVER['REQUEST_METHOD']!=='POST'){
    $error=new stdClass();
    $error->meddelande=["wrong method", "sidan ska anropas med POST"];
    skickaJSON($error, 405);
}
//kontrollera indata
$id=filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$vara=filter_input(INPUT_POST, 'vara', FILTER_SANITIZE_SPECIAL_CHARS);
//skapa ett objekt före felmeddelanden
$error = new stdClass();
$error->meddelande = [];
if(!isset($id) || $id===false || $id<1){
    //felaktigt id, lägg till meddelande till felobjektet
    $error->meddelande[] = "'id' saknas eller är felaktigt";
}

if(!isset($vara) || mb_strlen($vara)>50){
    //felaktig vara, lägg till meddelande till felobjektet
    $error->meddelande[] = "'vara' saknas eller är för långt";
}

if(count($error->meddelande)>0){
    //lägg till ett generellt meddelande först i arrayen
    array_unshift($error->meddelande, "bad request");
    skickaJSON($error, 400);
}

//koppla mot databas
$db=connectDB();

//uppdatera tabellen
$sql="UPDATE varor SET namn=:vara WHERE id=:id";
$stmt = $db->prepare($sql);

$stmt->execute(['id'=>$id, 'vara'=>$vara]);

//returnera svar
if($stmt->rowCount()>0){
    $out=new stdClass();
    $out->meddelande = "OK";
    skickaJSON($out);
}else{
    $error=new stdClass();
    $error->meddelande=["okänd fel","kunde inte uppdatera vara"];
    skickaJSON($error,500);
}