<?php
declare(strict_types=1);
require_once "../php/funktioner.php";
try{
    //skapa handle till curl för att läsa svaret
    $ch =curl_init('http://localhost/inkopslista/php/raderaVara.php');

    //se till att vi får svaret som en sträng
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //anropen till sidan som ska testas
    //fel metod
    echo "<p class='info'>test fel metod</p>";
    felMetod($ch);

    //anropa utan id
    echo "<p class='info'>testa anropa utan id</p>";
    idSaknas($ch);

    //anropa med id som inte finns
    echo "<p class='info'>testa anropa med id som inte finns</p>";
    idFinnsInte($ch);

    //anropa med ogiltigt id (-1)
    echo "<p class='info'>testa anropa med ogiltigt id(-1)</p>";
    idNegativt($ch);

    //anropa med felaktigt id (bokstav)
    echo "<p class='info'>testa anropa med felaktigt id (bokstav)</p>";
    idBokstav($ch);
    
    //anropa med id som finns - ok
    echo "<p class='info'>testa korrekt anrop</p>";
    idOKRaderaVara($ch);

}catch (Exception $e) {
    echo"<p class='error'>";
    echo "something went really wrong <br>";
    echo $e->getMessage();
    echo "</p>";
}

function idOKRaderaVara($curlHandle){
    //koppla mot databas
    $db=connectDB();

    //skapa vara
    $id=skapaVara('test');

    //anropa sidan
    curl_setopt($curlHandle, CURLOPT_POST, true);
    $data = ['id'=>$id];
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
    $jsonSvar = curl_exec($curlHandle);
    $status= curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    //kontrollera svaret
    if($status===200){
        echo "<p class='ok'>radera vara fungerade</p>";
    }else{
        echo "<p class='error'>radera vara fungerade inte, fick status=$status istället för 200</p>";
        raderaVara($id);
    }
}