<?php
declare(strict_types=1);

require_once "gemensammaTester.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="test.css">
    <title>test</title>

</head>
<body>
    <h1>testpage for api</h1>

    <h1>hämta alla varor</h1>
    <?php require_once "testHamtaAlla.php" ?>
    <h1>kryssa vara</h1>
    <?php require_once "testKryssaVara.php" ?>
    <h1>radera alla varor</h1>
    <?php require_once "testRaderaAlla.php" ?>
    <h1>radera valda varor</h1>
    <?php require_once "testRaderaValda.php" ?>
    <h1>radera enskild vara</h1>
    <?php require_once "testRaderaVara.php" ?>
    <h1>spara vara</h1>
    <?php require_once "testSparaVara.php" ?>
    <h1>uppdatera varor</h1>
    <?php require_once "testUppdateraVara.php" ?>
</body>
</html>