<?php
declare(strict_types=1);
require_once "../php/funktioner.php";
function hamtaAllaVaror(): array
{
    $db = connectDB();
    $stmt = $db->query("SELECT * FROM varor");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function aterstallDB($varor): void
{
    $db = connectDB();
    $sql = "INSERT INTO varor (id, namn, checked) VALUES (:id, :namn, :checked)";
    $stmt = $db->prepare($sql);

    foreach ($varor as $value) {
        $stmt->execute($value);
    }
}
function idBokstav($curlHandle, string $vara=null){

    //sätt anropsmetod till POST
    curl_setopt($curlHandle, CURLOPT_POST, true);
    
    //lägg till data till anropet
    $data = ['id'=>"id"];

    //sätt optional data....
    if($vara){
        $data=['vara'=>$vara];
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
    }

    //skicka anrop
    $jsonSvar=curl_exec($curlHandle);
    $status=curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    //kontrollera svar och skriv ut resultatet
    if($status===400){
        echo "<p class='ok'>förväntat svar 400</p>";
    }else{
        echo "<p class='error'>fick status=$status istället för förväntat 400</p>";
    }
    }
function idNegativt($curlHandle, string $vara=null){

    //sätt anropsmetod till POST
    curl_setopt($curlHandle, CURLOPT_POST, true);

    //lägg till data till anropet
        $data=['id'=>-1];

    //sätt optional data....
    if($vara){
        $data=['vara'=>$vara];
    }

    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
    
    //skicka anrop
    $jsonSvar=curl_exec($curlHandle);
    $status=curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    //kontrollera svar och skriv ut resultatet
    if($status===400){
        echo "<p class='ok'>förväntat svar 400</p>";
    }else{
        echo "<p class='error'>fick status=$status istället för förväntat 400</p>";
    }
    }
function idFinnsInte($curlHandle, string $vara=null){

    //koppla mot databas och starta transaktion
    $db=connectDB();

    //skapa ny post
    $id=skapaVara("test");

    //radera den nya posten
    raderaVara($id);

    //sätt anropsmetod till POST
    curl_setopt($curlHandle, CURLOPT_POST, true);

    //lägg till data till anropet
    $data = ['id'=> $id];
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);

    //sätt optional data....
    if($vara){
        $data=['vara'=>$vara];
    }
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);

    //skicka anrop
    $jsonSvar=curl_exec($curlHandle);
    $status=curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    //kontrollera svar och skriv ut reslutat
    if($status===400){
        echo "<p class='ok'>förväntat svar 400</p>";
    }else{
        echo "<p class='error'>fick status=$status istället för 400</p>";
    }
    }
function felMetod($curlHandle){
    //gör anrop och ta hand om terunsträngen
    $jsonSvar = curl_exec($curlHandle);
    //hämta status för anropet
    $status=curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

        if($status===405){
            echo "<p class='ok'>svar 405 stämmer med förväntat svar</p>";
        }else{
            echo "<p class='error'> fick status=$status istället för förväntat 405...wait. it works?</p>";
        }
    }

function skapaVara(string $vara):int{
    $db=connectDB();
    if($db->exec("INSERT INTO varor (namn) VALUES ('$vara')")){
        return (int) $db->lastInsertId();
    }
    return 0;
    }

function raderaVara(int $id):void{
    $db=connectDB();
    $db->exec("DELETE FROM varor WHERE id=$id");
    }

function lasVara(int $id):stdClass{
    $db= connectDB();
    $row = $db->query("SELECT * FROM varor WHERE id=$id");
    return $row->fetchObject();
    }
function kryssaVara(int $id):void{
    $db=connectDB();
    $db->query("UPDATE varor SET checked=1 WHERE id=$id");
    }
function idSaknas($curlHandle, string $vara=null){
    //sätt anropsmetod till POST
    curl_setopt($curlHandle, CURLOPT_POST, true);

    //sätt optional data....
    if($vara){
        $data=['vara'=>$vara];
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
    }
    //anropa och ta hand om svaret 
    $jsonSvar = curl_exec($curlHandle);
    $status = curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    //kontrollera svar och skriv ut text
    if($status===400){
        echo "<p class='ok'> svar 400</p>";
    }else{
        echo "<p class='error'>svar med status=$status istället för 400</p>";
        }
    }  

