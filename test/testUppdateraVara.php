<?php
declare(strict_types=1);
require_once "../php/funktioner.php";

try{
    //skapa handle till curl för att läsa svaret
    $ch =curl_init('http://localhost/inkopslista/php/uppdateraVara.php');

    //se till att vi får svaret som en sträng
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //anropen till sidan som ska testas
    //fel metod
    echo "<p class='info'>test fel metod</p>";
    felMetod($ch);

    //anropa utan id
    echo "<p class='info'>testa anropa utan id</p>";
    idSaknas($ch, "Nyttnamn");
    
    //anropa med ogiltigt id (-1)
    echo "<p class='info'>testa anropa med ogiltigt id(-1)</p>";
    idNegativt($ch, "Nyttnamn");

    //anropa med felaktigt id (bokstav)
    echo "<p class='info'>testa anropa med felaktigt id (bokstav)</p>";
    idBokstav($ch, "Nyttnamn");

    //anropa med id som inte finns
    echo "<p class='info'>testa anropa med id som inte finns</p>";
    idFinnsInte($ch, "Nyttnamn");
    

    //uppdatera med för lång vara (>50 tecken)
    echo "<p class='info'>testa uppdatera vara med för lång namn</p>";
    uppdateraLangNamn($ch);

    //anropa utan vara
    echo "<p class='info'>testa anropa utan vara</p>";
    uppdateraVaraSaknas($ch);
    //uopdatera ok
    echo "<p class='info'>testa korrekt anrop</p>";
    uppdateraOK($ch);

}catch (Exception $e) {
    echo"<p class='error'>";
    echo "something went really wrong <br>";
    echo $e->getMessage();
    echo "</p>";
}
function uppdateraOK($curlHandle){
    //koppla mot databas
    $db=connectDB();

    //skapa post
    $id = skapaVara('test');

    //sätt data och skicka anrop
    $data=['id'=> $id, 'vara'=>'asc'];
    curl_setopt($curlHandle, CURLOPT_POST, true);
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);

    $jsonSvar=curl_exec($curlHandle);
    $status = curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    //kontrollera svar
    if ($status===200){
        echo "<p class='ok'>uppdatera vara  returnerade 200</p>";
    }else{
        echo "<p class='error>uppdatera vara  returnerade status=$status istället för 200";
    }
    //radera posten
    raderaVara($id);
}
function uppdateraLangNamn($curlHandle){
    //koppla mot databas
    $db=connectDB();

    //skapa post
    $id = skapaVara('test');

   //sätt data och skicka anrop
    $data=['id'=> $id, 'vara'=>'pointlessly long name for a test that has its only purpose to be stupidly long'];
    curl_setopt($curlHandle, CURLOPT_POST, true);
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);

    $jsonSvar=curl_exec($curlHandle);
    $status = curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    //kontrollera svar
    if ($status===400){
        echo "<p class='ok'>uppdatera vara med för långt namn returnerade 400</p>";
    }else{
        echo "<p class='error>uppdatera vara med för långt namn returnerade status=$status istället för 400";
    }
    //radera posten
    raderaVara($id);
}
function uppdateraVaraSaknas($curlHandle){
    //koppla mot databas
    $db=connectDB();

    //skapa ny post
    $id = skapaVara('test');

    //sätt data och anropa sidan
    curl_setopt($curlHandle, CURLOPT_POST, true);
    $data = ['id'=>$id];
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);

    $jsonSvar = curl_exec($curlHandle);
    $status = curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    //kontrollera svar
    if($status===400){
        echo "<p class='ok'>uppdatera vara utan vara returnerade 400 som förväntat</p>";
    }else{
        echo "<p class='error'>uppdatera vara utan vara returnerade status=$status istället för 400</p>";
    }

    //radera post
    raderaVara($id);
}