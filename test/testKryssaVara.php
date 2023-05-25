<?php
declare(strict_types=1);
require_once "../php/funktioner.php";

try{
    
    //skapa handle till curl för att läsa svaret
    $ch=curl_init('http://localhost/inkopslista/php/kryssaVara.php');

    //se till att vi får svaret som en sträng
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


    //anropa till sidan som ska testas
    //fel metod
    echo "<p class='info'>test av fel anropsmetod</p>";
    felMetod($ch);

    //id saknas i anropet
    echo "<p class='info'>ID saknas i anropet</p>";
    idSaknas($ch);

    //id felaktigt (inte en siffra)
    echo "<p class='info'>felaktig id (inte en siffra)</p>";
    idBokstav($ch);
    //id felaktigt (-1)
    echo "<p class='info'>felaktig id (-1)</p>";
    idNegativt($ch);

    //angivet id saknas
    echo "<p class='info'>angivet id finns inte</p>";
    idSaknas($ch);
    //ok - sätt kryss
    echo "<p class='info'>test ok- sätt kryss</p>";
    sattKryss($ch);

    //ok - ta bort kryss
    echo "<p class='info'>ok -ta bort kryss</p>";
    taBortKryss($ch);

}catch (Exception $e) {
    echo"<p class='error'>";
    echo "something went really wrong <br>";
    echo $e->getMessage();
    echo "</p>";
} finally{
    curl_close($ch);
}
function taBortKryss($curlHandle){
    //koppla mot databas
    $db=connectDB();

    //lägg till vara
    $id= skapaVara('test');

    //sätt kryss och kontrollera att det är satt
    kryssaVara($id);
    $vara=lasVara($id);
    if(!$vara->checked){
        echo "<p class='error'>kunde inte sätta kryss, avbryter testet</p>";
        raderaVara($id);
    }

    //anropa sidan
    curl_setopt($curlHandle, CURLOPT_POST, true);
    $data = ['id'=>$id];
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
    $jsonSvar=curl_exec($curlHandle);
    $status=curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    //skriv ut svaret
    if($status===200){
        echo "<p class='ok'>kryssa av vara fungerade</p>";
    }else{
        echo "<p class='error'>kryssa av vara fungerar inte, fick status=$status istället för 200";
    }

    //radera vara
    raderaVara($id);
    }
function sattKryss($curlHandle){
        //koppla mot databas
        $db=connectDB();

        //skapa post
        $id = skapaVara('test');

        //kontrollera att kryss är tomt - läs vara och kontrollera svaret
        $vara = lasVara($id);
        if($vara->checked){
            echo "<p class='error'>kunde inte skapa vara utan kryss</p>";
            raderaVara($id);
            return;
        }
        //sätt kryss - anropa sidan med POST och rätt data
        curl_setopt($curlHandle, CURLOPT_POST, true);
        $data=['id'=>$id];
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);

        

        //kontrollera att kryss är satt
        $jsonSvar=curl_exec($curlHandle);
        $status=curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);
        //skriva ut resultat
        if($status===200){
                echo "<p class='ok'>kryssa vara fungerar</p>";
        }else{
                echo "<p class='error'>kryssa vara fungerar inte, status=$status istället för 200</p>";
        }
        //radera post
        raderaVara($id);
    }
