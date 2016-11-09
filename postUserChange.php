<?php
session_start();
include 'Config.php';

function isAdmin(){
    include 'Config.php';
    if(isset($_SESSION["GebruikerID"])){
        $pdo = new PDO("mysql:host=$DBhost;dbname=$DB", $DBuser, $DBpassw);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("SELECT * FROM dodo_gebruikers WHERE GebruikerID=:gid AND Admin=1;");
        $stmt->bindParam(":gid", $_SESSION["GebruikerID"], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result != "";
    }else{
        return false;
    }
}
if(!isAdmin()){
    echo "Error: u bent niet ingelogd";
    exit();
}

$posFields = array("Gebruikersnaam", "Wachtwoord", "Email", "Voornaam", "Achternaam", "Admin", "Punten");
if(in_array($_POST['field'], $posFields)){
    $field = $_POST['field'];
    
    $pdo = new PDO("mysql:host=$DBhost;dbname=$DB", $DBuser, $DBpassw);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("UPDATE dodo_gebruikers SET {$field} = :value WHERE GebruikerID = :id;");
    $stmt->bindParam(":value", $_POST["value"], PDO::PARAM_STR);
    $stmt->bindParam(":id", $_POST["id"], PDO::PARAM_INT);
    $stmt->execute();
}else{
    echo 'error';
}
?>