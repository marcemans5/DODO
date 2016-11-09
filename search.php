<?php
$srcStr = $_GET['src'];
$type = $_GET['type'];

include 'Config.php';

if($type == 'wed'){
    $pdo = new PDO("mysql:host=$DBhost;dbname=$DB", "$DBuser", "$DBpassw");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT DISTINCT WedstrijdID FROM `dodo_wedteam` WHERE Team LIKE :ss;");
    $stmt->bindValue(":ss", $srcStr . '%', PDO::PARAM_STR);
    $stmt->execute();
    $WedIds = "";
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $WedIds =  $WedIds . $result["WedstrijdID"] . ',';
    }

    $WedIds = rtrim($WedIds, ',');
    echo $WedIds;
}elseif($type == 'user'){
    $pdo = new PDO("mysql:host=$DBhost;dbname=$DB", "$DBuser", "$DBpassw");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT DISTINCT GebruikerID FROM `dodo_gebruikers` WHERE Gebruikersnaam LIKE :ss OR Email LIKE :ss OR Voornaam LIKE :ss OR Achternaam LIKE :ss;");
    $stmt->bindValue(":ss", $srcStr . '%', PDO::PARAM_STR);
    $stmt->execute();
    $userIds = "";
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $userIds =  $userIds . $result["GebruikerID"] . ',';
    }

    $userIds = rtrim($userIds, ',');
    echo $userIds;
}