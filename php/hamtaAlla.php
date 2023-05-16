<?php
declare (strict_types=1);

require_once "funktioner.php";

//kopppla mot databasen
$db=connectDB();

//hämta data
$sql="SELECT id, namn, checked FROM varor";
$stmt=$db->query($sql);

$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
$resultat=[];
foreach($rows as $post){
    $resultat[]=$post;
}

//skicka svar
skickaJSON($resultat);