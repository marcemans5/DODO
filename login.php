<?php
if(!isset($_POST["Gebruikersnaam"]) || !isset($_POST["Wachtwoord"])){
    echo FALSE;
    exit();
}else{
    $login = new login($_POST["Gebruikersnaam"], $_POST["Wachtwoord"]);
    echo $login->isCorrect();
}

class login{
    
    private $gebruikersnaam;
    private $wachtwoord;
            
    function __construct($gebruikersnaam, $wachtwoord) {
        $this->gebruikersnaam = $gebruikersnaam;
        $this->wachtwoord = $wachtwoord;
    }
    
    function isCorrect(){
        include 'Config.php';
        
        if($this->gebruikersnaam == "" || $this->wachtwoord == ""){
            return FALSE;
        }

        $pdo = new PDO("mysql:host=localhost;dbname=deb43619_marc", "deb43619_marc", "Password.");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("SELECT * FROM dodo_gebruikers WHERE Gebruikersnaam=:gn;");
        $stmt->bindParam(":gn", $this->gebruikersnaam, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result != ""){
            if($result["Wachtwoord"] == md5($this->wachtwoord)){
                $this->pupulateSession($result);
                return TRUE;
            }
        }
        return FALSE;
    }
    
    function pupulateSession($qryResult){
        session_start();
        $_SESSION["GebruikerID"] = $qryResult["GebruikerID"];
        $_SESSION["Gebruikersnaam"] = $qryResult["Gebruikersnaam"];
        $_SESSION["Voornaam"] = $qryResult["Voornaam"];
        $_SESSION["Achternaam"] = $qryResult["Achternaam"];
        $_SESSION["Afbeelding"] = $qryResult["Afbeelding"];
        $_SESSION["Admin"] = $qryResult["Admin"];
        $_SESSION["Punten"] = $qryResult["Punten"];
    }
}