<!DOCTYPE html>
<?php
session_start();

function isLoggedIn(){
    include 'Config.php';
    if(isset($_SESSION["GebruikerID"])){
        $pdo = new PDO("mysql:host=$DBhost;dbname=$DB", $DBuser, $DBpassw);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("SELECT * FROM dodo_gebruikers WHERE GebruikerID=:gid;");
        $stmt->bindParam(":gid", $_SESSION["GebruikerID"], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result != "";
    }else{
        return false;
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="CSS/main.css">
        <script src="js/jquery.min.js"></script>
        <script src="getNews.js"></script>
        <title>DODO</title>
    </head>
    <body>
        <div id="logoDiv">
            <img src="img/Logo.png" id="logo" />
        </div>
        <div id="newsDiv" class="box">
            <h3 class="centerText">Laatste nieuws</h3>
            <div class="innerContent" id="newsItems">
                <svg id="loading" width='120px' height='120px' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100' preserveAspectRatio='xMidYMid' class='uil-ring'><rect x='0' y='0' width='100' height='100' fill='none' class='bk'></rect><defs><filter id='uil-ring-shadow' x='-100%' y='-100%' width='300%' height='300%'><feOffset result='offOut' in='SourceGraphic' dx='0' dy='0'></feOffset><feGaussianBlur result='blurOut' in='offOut' stdDeviation='0'></feGaussianBlur><feBlend in='SourceGraphic' in2='blurOut' mode='normal'></feBlend></filter></defs><path d='M10,50c0,0,0,0.5,0.1,1.4c0,0.5,0.1,1,0.2,1.7c0,0.3,0.1,0.7,0.1,1.1c0.1,0.4,0.1,0.8,0.2,1.2c0.2,0.8,0.3,1.8,0.5,2.8 c0.3,1,0.6,2.1,0.9,3.2c0.3,1.1,0.9,2.3,1.4,3.5c0.5,1.2,1.2,2.4,1.8,3.7c0.3,0.6,0.8,1.2,1.2,1.9c0.4,0.6,0.8,1.3,1.3,1.9 c1,1.2,1.9,2.6,3.1,3.7c2.2,2.5,5,4.7,7.9,6.7c3,2,6.5,3.4,10.1,4.6c3.6,1.1,7.5,1.5,11.2,1.6c4-0.1,7.7-0.6,11.3-1.6 c3.6-1.2,7-2.6,10-4.6c3-2,5.8-4.2,7.9-6.7c1.2-1.2,2.1-2.5,3.1-3.7c0.5-0.6,0.9-1.3,1.3-1.9c0.4-0.6,0.8-1.3,1.2-1.9 c0.6-1.3,1.3-2.5,1.8-3.7c0.5-1.2,1-2.4,1.4-3.5c0.3-1.1,0.6-2.2,0.9-3.2c0.2-1,0.4-1.9,0.5-2.8c0.1-0.4,0.1-0.8,0.2-1.2 c0-0.4,0.1-0.7,0.1-1.1c0.1-0.7,0.1-1.2,0.2-1.7C90,50.5,90,50,90,50s0,0.5,0,1.4c0,0.5,0,1,0,1.7c0,0.3,0,0.7,0,1.1 c0,0.4-0.1,0.8-0.1,1.2c-0.1,0.9-0.2,1.8-0.4,2.8c-0.2,1-0.5,2.1-0.7,3.3c-0.3,1.2-0.8,2.4-1.2,3.7c-0.2,0.7-0.5,1.3-0.8,1.9 c-0.3,0.7-0.6,1.3-0.9,2c-0.3,0.7-0.7,1.3-1.1,2c-0.4,0.7-0.7,1.4-1.2,2c-1,1.3-1.9,2.7-3.1,4c-2.2,2.7-5,5-8.1,7.1 c-0.8,0.5-1.6,1-2.4,1.5c-0.8,0.5-1.7,0.9-2.6,1.3L66,87.7l-1.4,0.5c-0.9,0.3-1.8,0.7-2.8,1c-3.8,1.1-7.9,1.7-11.8,1.8L47,90.8 c-1,0-2-0.2-3-0.3l-1.5-0.2l-0.7-0.1L41.1,90c-1-0.3-1.9-0.5-2.9-0.7c-0.9-0.3-1.9-0.7-2.8-1L34,87.7l-1.3-0.6 c-0.9-0.4-1.8-0.8-2.6-1.3c-0.8-0.5-1.6-1-2.4-1.5c-3.1-2.1-5.9-4.5-8.1-7.1c-1.2-1.2-2.1-2.7-3.1-4c-0.5-0.6-0.8-1.4-1.2-2 c-0.4-0.7-0.8-1.3-1.1-2c-0.3-0.7-0.6-1.3-0.9-2c-0.3-0.7-0.6-1.3-0.8-1.9c-0.4-1.3-0.9-2.5-1.2-3.7c-0.3-1.2-0.5-2.3-0.7-3.3 c-0.2-1-0.3-2-0.4-2.8c-0.1-0.4-0.1-0.8-0.1-1.2c0-0.4,0-0.7,0-1.1c0-0.7,0-1.2,0-1.7C10,50.5,10,50,10,50z' fill='#59ebff' filter='url(#uil-ring-shadow)'><animateTransform attributeName='transform' type='rotate' from='0 50 50' to='360 50 50' repeatCount='indefinite' dur='1s'></animateTransform></path></svg>
            </div>
        </div>
        <div id="mainContent" class="box">
            <div class="innerContent">
                <?php
                $srcStr = $_POST["search"];
                if(isLoggedIn()){
                    include 'Config.php';
                    
                    $pdo = new PDO("mysql:host=$DBhost;dbname=$DB", "$DBuser", "$DBpassw");
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $stmt = $pdo->prepare("SELECT DISTINCT WedstrijdID FROM `dodo_wedteam` WHERE Team LIKE :ss;");
                    $stmt->bindParam(":ss", $srcStr, PDO::PARAM_STR);
                    $stmt->execute();
                    $wedArr = array();
                    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $wedArr[] = $result["WedstrijdID"];
                    }
                    ?>
                    <h1>Actuele wedstrijden</h1>
                    <hr />
                    <table class="wedstrijdTbl">
                        <colgroup>
                            <col span="2" style="width: 10%">
                            <col>
                            <col style="width: 10%">
                            <col>
                            <col style="width: 10%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Tijd</th>
                                <th>Thuis</th>
                                <th>%Stemmen</th>
                                <th>Uit</th>
                                <th>%Stemmen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $status = "Actueel";

                            $stmt = $pdo->prepare("SELECT w.WedstrijdID, Team, Stempercentage, Thuis, Doelpunten, SpeelDT FROM `dodo_wedstrijd` w INNER JOIN `dodo_wedteam` wt ON w.WedstrijdID = wt.WedstrijdID WHERE Status = :st ORDER BY w.WedstrijdID, Thuis DESC;");
                            $stmt->bindParam(":st", $status, PDO::PARAM_STR);
                            $stmt->execute();
                            $Wedstrijden = array();
                            while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                                error_log($result["WedstrijdID"] . " weusdbaflhw s");
                                if(in_array($result["WedstrijdID"], $wedArr)){
                                    if($result["Thuis"] == 1){
                                        $Wedstrijden[$result["WedstrijdID"]] = array();
                                        $Wedstrijden[$result["WedstrijdID"]]["TTeam"] = $result["Team"];
                                        $Wedstrijden[$result["WedstrijdID"]]["TStemPerc"] = $result["Stempercentage"];
                                        $Wedstrijden[$result["WedstrijdID"]]["TDoelpunten"] = $result["Doelpunten"];
                                        $Wedstrijden[$result["WedstrijdID"]]["SpeelDT"] = $result["SpeelDT"];
                                    }else{
                                        $Wedstrijden[$result["WedstrijdID"]]["UTeam"] = $result["Team"];
                                        $Wedstrijden[$result["WedstrijdID"]]["UStemPerc"] = $result["Stempercentage"];
                                        $Wedstrijden[$result["WedstrijdID"]]["UDoelpunten"] = $result["Doelpunten"];
                                    }
                                }
                            }
                            if(empty($Wedstrijden)){
                                echo '<tr><td><span style="color: darkred">Geen data</span></td><td></td><td></td><td></td><td></td><td></td></tr>';
                            }
                            foreach ($Wedstrijden as $WedstrijdID => $rij){
                                echo '<tr><td>';
                                echo date("d-m-Y", strtotime($rij["SpeelDT"]));
                                echo '</td><td>';
                                echo date("H:i", strtotime($rij["SpeelDT"]));
                                echo '</td><td>';
                                echo $rij["TTeam"];
                                echo '</td><td>';
                                echo $rij["TStemPerc"];
                                echo '</td><td>';
                                echo $rij["UTeam"];
                                echo '</td><td>';
                                echo $rij["UStemPerc"];
                                echo '</td></tr>';
                            }

                            ?>
                        </tbody>
                    </table>
                    <hr />
                    <h1>Komende wedstrijden</h1>
                    <hr />
                    <table class="wedstrijdTbl">
                        <colgroup>
                            <col span="2" style="width: 10%">
                            <col>
                            <col style="width: 10%">
                            <col>
                            <col style="width: 10%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Tijd</th>
                                <th>Thuis</th>
                                <th>%Stemmen</th>
                                <th>Uit</th>
                                <th>%Stemmen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $status = "Komend";

                            //SQL HIER AANPASSEN
                            $stmt = $pdo->prepare("SELECT w.WedstrijdID, Team, Stempercentage, Thuis, Doelpunten, SpeelDT FROM `dodo_wedstrijd` w INNER JOIN `dodo_wedteam` wt ON w.WedstrijdID = wt.WedstrijdID WHERE Status = :st ORDER BY w.WedstrijdID, Thuis DESC;");
                            $stmt->bindParam(":st", $status, PDO::PARAM_STR);
                            $stmt->execute();
                            $Wedstrijden = array();
                            while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                                print_r($wedArr);
                                if(in_array($result["WedstrijdID"], $wedArr)){
                                    if($result["Thuis"] == 1){
                                        $Wedstrijden[$result["WedstrijdID"]] = array();
                                        $Wedstrijden[$result["WedstrijdID"]]["TTeam"] = $result["Team"];
                                        $Wedstrijden[$result["WedstrijdID"]]["TStemPerc"] = $result["Stempercentage"];
                                        $Wedstrijden[$result["WedstrijdID"]]["TDoelpunten"] = $result["Doelpunten"];
                                        $Wedstrijden[$result["WedstrijdID"]]["SpeelDT"] = $result["SpeelDT"];
                                    }else{
                                        $Wedstrijden[$result["WedstrijdID"]]["UTeam"] = $result["Team"];
                                        $Wedstrijden[$result["WedstrijdID"]]["UStemPerc"] = $result["Stempercentage"];
                                        $Wedstrijden[$result["WedstrijdID"]]["UDoelpunten"] = $result["Doelpunten"];
                                    }
                                }
                            }
                            if(empty($Wedstrijden)){
                                echo '<tr><td><span style="color: darkred">Geen data</span></td><td></td><td></td><td></td><td></td><td></td></tr>';
                            }
                            foreach ($Wedstrijden as $WedstrijdID => $rij){
                                echo '<tr><td>';
                                echo date("d-m-Y", strtotime($rij["SpeelDT"]));
                                echo '</td><td>';
                                echo date("H:i", strtotime($rij["SpeelDT"]));
                                echo '</td><td>';
                                echo $rij["TTeam"];
                                echo '</td><td>';
                                echo $rij["TStemPerc"];
                                echo '</td><td>';
                                echo $rij["UTeam"];
                                echo '</td><td>';
                                echo $rij["UStemPerc"];
                                echo '</td></tr>';
                            }

                            ?>
                        </tbody>
                    </table>
                    <hr />
                    <h1>Afgelopen wedstrijden</h1>
                    <hr />
                    <table class="wedstrijdTbl">
                        <colgroup>
                            <col span="2" style="width: 10%">
                            <col>
                            <col style="width: 10%">
                            <col>
                            <col style="width: 10%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Tijd</th>
                                <th>Thuis</th>
                                <th>%Stemmen</th>
                                <th>Uit</th>
                                <th>%Stemmen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $status = "Afgelopen";

                            //SQL HIER AANPASSEN
                            $stmt = $pdo->prepare("SELECT w.WedstrijdID, Team, Stempercentage, Thuis, Doelpunten, SpeelDT FROM `dodo_wedstrijd` w INNER JOIN `dodo_wedteam` wt ON w.WedstrijdID = wt.WedstrijdID WHERE Status = :st ORDER BY w.WedstrijdID, Thuis DESC;");
                            $stmt->bindParam(":st", $status, PDO::PARAM_STR);
                            $stmt->execute();
                            $Wedstrijden = array();
                            while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                                if(in_array($result["WedstrijdID"], $wedArr)){
                                    if($result["Thuis"] == 1){
                                        $Wedstrijden[$result["WedstrijdID"]] = array();
                                        $Wedstrijden[$result["WedstrijdID"]]["TTeam"] = $result["Team"];
                                        $Wedstrijden[$result["WedstrijdID"]]["TStemPerc"] = $result["Stempercentage"];
                                        $Wedstrijden[$result["WedstrijdID"]]["TDoelpunten"] = $result["Doelpunten"];
                                        $Wedstrijden[$result["WedstrijdID"]]["SpeelDT"] = $result["SpeelDT"];
                                    }else{
                                        $Wedstrijden[$result["WedstrijdID"]]["UTeam"] = $result["Team"];
                                        $Wedstrijden[$result["WedstrijdID"]]["UStemPerc"] = $result["Stempercentage"];
                                        $Wedstrijden[$result["WedstrijdID"]]["UDoelpunten"] = $result["Doelpunten"];
                                    }
                                }
                            }
                            if(empty($Wedstrijden)){
                                echo '<tr><td><span style="color: darkred">Geen data</span></td><td></td><td></td><td></td><td></td><td></td></tr>';
                            }
                            foreach ($Wedstrijden as $WedstrijdID => $rij){
                                echo '<tr><td>';
                                echo date("d-m-Y", strtotime($rij["SpeelDT"]));
                                echo '</td><td>';
                                echo date("H:i", strtotime($rij["SpeelDT"]));
                                echo '</td><td>';
                                echo $rij["TTeam"];
                                echo '</td><td>';
                                echo $rij["TStemPerc"];
                                echo '</td><td>';
                                echo $rij["UTeam"];
                                echo '</td><td>';
                                echo $rij["UStemPerc"];
                                echo '</td></tr>';
                            }

                            ?>
                        </tbody>
                    </table>
                    <?php
                }else{
                    header("Location: index.php");
                }
                ?>
            </div>
        </div>
        <div id="userDiv" class="box">
            <?php
                if(isLoggedIn()){
                    include 'loginUser.php';
                }else{
                    include 'logoutUser.php';
                }
            ?>
        </div>
    </body>
</html>