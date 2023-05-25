<?php
declare(strict_types=1);

try{

}catch (Exception $e) {
    echo"<p class='error'>";
    echo "something went really wrong <br>";
    echo $e->getMessage();
    echo "</p>";
}/* finally{

}

function raderaValda($curlHandle){
    //koppla mot databas
    $db=connectDB();

    //läs in alla varor (för att återställa senare)
    $varor = hamtaAllaVaror();

    //kryssa alla varor
    foreach($varor as $value){
        kryssaVara($varor['id']);
    }

    //anropa sidan
    curl_setopt($curlHandle, CURLOPT_POST, true);
    $jsonSvar = curl_exec($curlHandle);
    $status= curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    //kontrollera svaret
    if($status===200){
        echo "<p class='ok'>radera valda varor fungerade</p>";
    }else{
        echo "<p class='error'>radera valda varor fungerade inte, fick status=$status istället för 200</p>";
    }

    //återställ alla varor
    aterstallDB($varor);
    }
*/