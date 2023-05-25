<?php
declare(strict_types=1);
require_once "../php/funktioner.php";
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