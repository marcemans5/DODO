<?php
session_start();

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
?>
<h1>Adminpanel</h1>
<button id="terugBTN" class="redBtn" onclick="terug()">Terug</button>
<table>
    <thead>
        <tr>
            <th>UserID</th>
            <th>Gebruikersnaam</th>
            <th>Email</th>
            <th>Voornaam</th>
            <th>Achternaam</th>
            <th>Admin</th>
            <th>Punten</th>
        </tr>
    </thead>
    <tbody>
        <?php
            include 'Config.php';

            $status = "Actueel";

            $pdo = new PDO("mysql:host=$DBhost;dbname=$DB", "$DBuser", "$DBpassw");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT * FROM `dodo_gebruikers`;");
            $stmt->bindParam(":st", $status, PDO::PARAM_STR);
            $stmt->execute();
            $Wedstrijden = array();
            while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                echo '<tr><td>';
                echo $result['GebruikerID'];
                echo '</td><td>';
                echo $result['Gebruikersnaam'];
                echo '</td><td>';
                echo $result['Email'];
                echo '</td><td>';
                echo $result['Voornaam'];
                echo '</td><td>';
                echo $result['Achternaam'];
                echo '</td><td>';
                echo $result['Admin'];
                echo '</td><td>';
                echo $result['Punten'];
                echo '</td></tr>';
            }
        ?>
    </tbody>
</table>

<script>
    function terug(){
        $.post("loginHome.php").done(function (data){
            location.reload();
        });
    }
</script>