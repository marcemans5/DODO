<?php
if(!function_exists("isLoggedIn")){
    header("Location: index.php");
}
?>

<input type="text" placeholder="Zoeken" id="search" oninput="searchWed()" />
<h1>Actuele wedstrijden</h1>
<hr />
<table class="Tbl">
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
        include 'Config.php';

        $status = "Actueel";

        $pdo = new PDO("mysql:host=$DBhost;dbname=$DB", "$DBuser", "$DBpassw");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT w.WedstrijdID, Team, Stempercentage, Thuis, Doelpunten, SpeelDT FROM `dodo_wedstrijd` w INNER JOIN `dodo_wedteam` wt ON w.WedstrijdID = wt.WedstrijdID WHERE Status = :st ORDER BY w.SpeelDT, Thuis DESC;");
        $stmt->bindParam(":st", $status, PDO::PARAM_STR);
        $stmt->execute();
        $Wedstrijden = array();
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
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
        
        if(empty($Wedstrijden)){
            echo '<tr id="geenData"><td><span style="color: darkred">Geen data</span></td><td></td><td></td><td></td><td></td><td></td></tr>';
        }else{
            echo '<tr id="geenData" style="display: none"><td><span style="color: darkred">Geen data</span></td><td></td><td></td><td></td><td></td><td></td></tr>';
        }
        
        foreach ($Wedstrijden as $WedstrijdID => $rij){
            echo '<tr id="' . $WedstrijdID . '" class="wedsRij Displayed"><td>';
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
<table class="Tbl">
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

        $pdo = new PDO("mysql:host=$DBhost;dbname=$DB", "$DBuser", "$DBpassw");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT w.WedstrijdID, Team, Stempercentage, Thuis, Doelpunten, SpeelDT FROM `dodo_wedstrijd` w INNER JOIN `dodo_wedteam` wt ON w.WedstrijdID = wt.WedstrijdID WHERE Status = :st ORDER BY w.SpeelDT, Thuis DESC;");
        $stmt->bindParam(":st", $status, PDO::PARAM_STR);
        $stmt->execute();
        $Wedstrijden = array();
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
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
        
        if(empty($Wedstrijden)){
            echo '<tr id="geenData"><td><span style="color: darkred">Geen data</span></td><td></td><td></td><td></td><td></td><td></td></tr>';
        }else{
            echo '<tr id="geenData" style="display: none"><td><span style="color: darkred">Geen data</span></td><td></td><td></td><td></td><td></td><td></td></tr>';
        }
        
        foreach ($Wedstrijden as $WedstrijdID => $rij){
            echo '<tr id="' . $WedstrijdID . '" class="wedsRij Displayed"><td>';
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
<table class="Tbl">
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

        $pdo = new PDO("mysql:host=$DBhost;dbname=$DB", "$DBuser", "$DBpassw");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT w.WedstrijdID, Team, Stempercentage, Thuis, Doelpunten, SpeelDT FROM `dodo_wedstrijd` w INNER JOIN `dodo_wedteam` wt ON w.WedstrijdID = wt.WedstrijdID WHERE Status = :st ORDER BY w.SpeelDT, Thuis DESC;");
        $stmt->bindParam(":st", $status, PDO::PARAM_STR);
        $stmt->execute();
        $Wedstrijden = array();
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
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
        
        if(empty($Wedstrijden)){
            echo '<tr id="geenData"><td><span style="color: darkred">Geen data</span></td><td></td><td></td><td></td><td></td><td></td></tr>';
        }else{
            echo '<tr id="geenData" style="display: none"><td><span style="color: darkred">Geen data</span></td><td></td><td></td><td></td><td></td><td></td></tr>';
        }
        
        foreach ($Wedstrijden as $WedstrijdID => $rij){
            echo '<tr id="' . $WedstrijdID . '" class="wedsRij Displayed"><td>';
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
<script>
    function searchWed(){
        var searchStr = $("#search").val();
        $.get("search.php", { type: 'wed', src: searchStr }).done(function (data){
            filterWed(data);
            
        });
    }
    
    function filterWed(data){
        var WedIds = data.split(',');
        
        $.each($(".wedsRij"), function (index, wedstrijd){
            if(WedIds.indexOf(wedstrijd.id) === -1){
                $(wedstrijd).css("display", "none");
                $(wedstrijd).removeClass("Displayed");
            }else{
                $(wedstrijd).css("display", "table-row");
                $(wedstrijd).addClass("Displayed");
            }
            $.each($("tbody"), function (index, tbody){
                if($(tbody).find('tr.Displayed').length == 0){
                    $(tbody).find("#geenData").css("display", "table-row");
                }else{
                    $(tbody).find("#geenData").css("display", "none");
                }
            });
        });
    }
</script>