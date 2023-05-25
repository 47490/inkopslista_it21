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

    <h2>hämta alla varor</h2>
    <?php require_once "testHamtaAlla.php" ?>
    <h2>kryssa vara</h2>
    <?php require_once "testKryssaVara.php" ?>
    <h2>radera alla varor</h2>
    <?php require_once "testRaderaAlla.php" ?>
    <h2>radera valda varor</h2>
    <?php require_once "testRaderaValda.php" ?>
    <h2>radera enskild vara</h2>
    <?php require_once "testRaderaVara.php" ?>
    <h2>spara vara</h2>
    <?php require_once "testSparaVara.php" ?>
    <h2>uppdatera varor</h2>
    <?php require_once "testUppdateraVara.php" ?>
</body>
</html>