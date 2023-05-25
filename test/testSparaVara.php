<?php
declare(strict_types=1);
require_once "../php/funktioner.php";
try{
    //skapa handle till curl för att läsa svaret
$ch=curl_init('http://localhost/inkopslista/php/sparaVara.php');

    //se till att vi får svaret som en sträng
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //anropa till sidan som ska testas

    //fel anrop (get)
    echo "<p class='info'>test av fel anropsmetod</p>";
    felMetod($ch);
    //vara saknas
    echo "<p class='info'>test vara saknas</p>";
    varaSaknas($ch);
    //vara är >50 tecken
    echo "<p class='info'>test vara längre än 50 tecken</p>";
    varaLangNamn($ch);
    //vara är ok
    echo "<p class='info'>vara är ok</p>";
    varaOk($ch);

}catch (Exception $e) {
    echo"<p class='error'>";
    echo "something went really wrong <br>";
    echo $e->getMessage();
    echo "</p>";
}finally{
    //stäng handle till curl
    curl_close($ch);
}
function varaOk($curlHandle){
    
    //koppla databas och sätt möjlighet att ångra förändringar
    $db=connectDB();

    //sätt anrop till POST
    curl_setopt($curlHandle, CURLOPT_POST, true);

    //lägg till vara 
    $data=['vara'=>'milk'];
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);

    //gör anrop och ta hand om retursträng
    $jsonSvar = curl_exec($curlHandle);

    //läs status för anropet
    $status = curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    //skriv ut resultatet
    if ($status===200){
        echo "<p class='ok'>förväntat svar 200</p>";
        $svar = json_decode($jsonSvar);
        $id=$svar->id;
        $db->exec("DELETE FROM varor WHERE id=$id");
    }else{
        echo "<p class='error'>fick status=$status istället för förväntat 200</p>";
    }
}
function varaLangNamn($curlHandle){
    //sätt anrop till POST
    curl_setopt($curlHandle, CURLOPT_POST, true);

    //lägg till vara med långt namn
    $data=['vara'=>'a very long and meaningless text that has no purpose other than be long for the test'];
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
    //gör anrop och ta hand om retursträng
    $jsonSvar = curl_exec($curlHandle);

    //läs status för anropet
    $status = curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    //skriv ut resultatet
    if ($status===400){
        echo "<p class='ok'>förväntat svar 400</p>";
    }else{
        echo "<p class='error'>fick status=$status istället för förväntat 400</p>";
    }
}
function varaSaknas($curlHandle){
    
    //sätt anrop till POST
    curl_setopt($curlHandle, CURLOPT_POST, true);
    
    //gör anrop och ta hand om retursträng
    $jsonSvar = curl_exec($curlHandle);

    //läs status för anropet
    $status = curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    //skriv ut resultatet
    if ($status===400){
        echo "<p class='ok'>förväntat svar 400</p>";
    }else{
        echo "<p class='error'>fick status=$status istället för förväntat 400</p>";
    }
}
