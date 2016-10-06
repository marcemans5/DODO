<?php
include 'Config.php';

$admin = 0;
$punten = 10;

$fileType = substr($_FILES['Foto']['name'], strpos($_FILES['Foto']['name'], '.'));

$uploaddir = 'C:\\wamp\\www\\DODO\\img\\user\\';
$uploadfile = $uploaddir . $_POST['Gebruikersnaam'] . $fileType;
if($_POST['Wachtwoord'] == $_POST['Wachtwoord2']){
    $pdo = new PDO("mysql:host=localhost;dbname=deb43619_marc", "deb43619_marc", "Password.");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT GebruikerID FROM dodo_gebruikers WHERE Gebruikersnaam=:gn;");
    $stmt->bindParam(":gn", $_POST["Gebruikersnaam"], PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if(empty($row)){
        if (move_uploaded_file($_FILES['Foto']['tmp_name'], $uploadfile)) {
            $afbeelding = $_POST['Gebruikersnaam'] . $fileType;
        }else{
            $afbeelding = NULL;
        }
        $stmt = $pdo->prepare("SELECT GebruikerID FROM dodo_gebruikers ORDER BY GebruikerID DESC LIMIT 1;");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $UID = $row['GebruikerID'] + 1;
        $WW = md5($_POST["Wachtwoord"]);

        $stmt = $pdo->prepare("INSERT INTO dodo_gebruikers VALUES (:uid, :gn, :ww, :em, :vn, :an, :ad, :af, :punt);");
        $stmt->bindParam(":uid", $UID, PDO::PARAM_INT);
        $stmt->bindParam(":gn", $_POST["Gebruikersnaam"], PDO::PARAM_STR);
        $stmt->bindParam(":ww", $WW, PDO::PARAM_STR);
        $stmt->bindParam(":em", $_POST["Email"], PDO::PARAM_STR);
        $stmt->bindParam(":vn", $_POST["Voornaam"], PDO::PARAM_STR);
        $stmt->bindParam(":an", $_POST["Achternaam"], PDO::PARAM_STR);
        $stmt->bindParam(":ad", $admin, PDO::PARAM_INT);
        $stmt->bindParam(":af", $afbeelding, PDO::PARAM_STR);
        $stmt->bindParam(":punt", $punten, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() < 1){
            echo "1";
        }else{
            echo "0";
        }
    }else{
        echo "4";
    }
} else {
    echo "3";
};