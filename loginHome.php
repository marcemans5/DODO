<?php
if(!function_exists("isLoggedIn")){
    header("Location: index.php");
}
?>

<h1>Komende wedstrijden</h1>
<hr/>
<table class="wedstrijdTbl">
    <tr>
        <th>Thuis</th>
        <th>Uit</th>
    </tr>
    <?php
    include 'Config.php';
    
    $komend = "Komend";
    
    $pdo = new PDO("mysql:host=$DBhost;dbname=$DB", "$DBuser", "$DBpassw");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //SQL HIER AANPASSEN
    $stmt = $pdo->prepare("SELECT w.WedstrijdID, Team, Stempercentage, Thuis, doelpunten FROM `dodo_wedstrijd` w INNER JOIN `dodo_wedteam` wt ON w.WedstrijdID = wt.WedstrijdID WHERE Status = :st ORDER BY w.WedstrijdID, Thuis DESC;");
    $stmt->bindParam(":st", $komend, PDO::PARAM_STR);
    $stmt->execute();
    $Wedstrijden = array();
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $Wedstrijden[$result["WedstrijdID"]] = array();
        if($result["Thuis"] == 1){
            $Wedstrijden[$result["WedstrijdID"]]["TTeam"] = $result["Team"];
            $Wedstrijden[$result["WedstrijdID"]]["TStemPerc"] = $result["Stempercentage"];
            $Wedstrijden[$result["WedstrijdID"]]["TDoelpunten"] = $result["Doelpunten"];
        }else{
            $Wedstrijden[$result["WedstrijdID"]]["UTeam"] = $result["Team"];
            $Wedstrijden[$result["WedstrijdID"]]["UStemPerc"] = $result["Stempercentage"];
            $Wedstrijden[$result["WedstrijdID"]]["UDoelpunten"] = $result["Doelpunten"];
        }
    }
    
    foreach ($Wedstrijden as $WedstrijdID => $rij){
        
    }
    
    ?>
</table>