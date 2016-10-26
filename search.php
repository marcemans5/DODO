<?php
$srcStr = $_GET['src'];
include 'Config.php';

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