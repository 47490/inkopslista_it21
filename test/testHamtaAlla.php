<?php
declare(strict_types=1);

try{
    //skapa ett "handle" till curl för att läsa svaret från angiven sida
    $sch=curl_init('http://localhost/inkopslista/php/hamtaAlla.php');
//return the transfer as a string
    curl_setopt($sch, CURLOPT_RETURNTRANSFER, 1);
    
    //testa
    testOK($sch);

}catch (Exception $e) {
    echo"<p class='error'>";
    echo "something went really wrong <br>";
    echo $e->getMessage();
    echo "</p>";
} finally{
    //stäng "handle" för att frigöra resurser
    curl_close($sch);
}

function testOK($curlHandle)
{
    //anropar hämta alla och sparar svaret i en variabel
    $svarJSON= curl_exec($curlHandle);

    //gör om till objekt
    $svar = json_decode($svarJSON);
    if(is_array($svar)){    //svaret är en array
        if(count($svar)>0){ //det finns radera
            echo "<p class='ok'>hämta alla OK, " .count($svar) . "rader returnerades</p>";
        } else{
            echo "<p class='ok'> hämta alla OK, inga rader fanns</p>";
        }
    }else{
        echo "<p class='error'>hämta alla misslyckades</p>";
    }
}