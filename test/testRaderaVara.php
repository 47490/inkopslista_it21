<?php
declare(strict_types=1);
require_once "../php/funktioner.php";

try {
    // Skapa handle till cUrl för att läsa svaret
    $ch = curl_init('http://localhost/inkopslista/php/raderaVara.php');

    // Se till att vi får svaret som en sträng
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Anropen till sidan som ska testas
    // Fel metod
    echo "<p class='info'>Test fel metod</p>";
    felMetod($ch);

    // Anropa utan id
    echo "<p class='info'>Testa anropa utan id</p>";
    idSaknas($ch);

    // Anropa med id som inte finns
    echo "<p class='info'>Testa anropa med id som inte finns</p>";
    idFinnsInte($ch);

    // Anropa med ogiltigt id (-1)
    echo "<p class='info'>Testa anropa med ogiltigt id (-1)</p>";
    idNegativt($ch);

    // Anropa med felaktigt id (bokstav)
    echo "<p class='info'>Testa anropa med felaktigt id (bokstav)</p>";
    idBokstav($ch);

    // Anropa med id som finns - OK
    echo "<p class='info'>Testa korrekt anrop</p>";
    idOKRaderaVara($ch);

} catch (Exception $e) {
    echo "<p class='error'>";
    echo "Något gick JÄTTEfel!<br>";
    echo $e->getMessage();
    echo "</p>";
}
