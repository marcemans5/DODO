<?php
if(!function_exists("isLoggedIn")){
    header("Location: index.php");
}
?>
<h3 class="centerText"><?php echo $_SESSION["Voornaam"] . " " . $_SESSION["Achternaam"]; ?></h3>
<div class="innerContent">
    <img src="img/user/<?php echo $_SESSION["Afbeelding"] == NULL ? 'def.png' : $_SESSION["Afbeelding"]; ?>" id="userImg" />
    <table id="userTbl">
        <tr><td><b>Punten:</b></td></tr>
        <tr><td><?php
            include 'Config.php';
            
            $pdo = new PDO("mysql:host=$DBhost;dbname=$DB", "$DBuser", "$DBpassw");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("SELECT Punten FROM `dodo_gebruikers` WHERE Gebruikersnaam = :gebr;");
            $stmt->bindParam(":gebr", $_SESSION['Gebruikersnaam'], PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $result["Punten"];
        ?></td></tr>
    </table>
        <?php
            if($_SESSION["Admin"] == 1){
                ?>
                <button id="adminBtn" class="greenBtn" onclick="admin()">Adminpanel</button>
                <?php
            }
        ?>
    <button id="logoutBtn" class="redBtn" onclick="logout()">Logout</button>
</div>

<script>
    function logout(){
        $.ajax("logout.php").done(function (){
            location.reload();
        });
    }
    
    function admin(){
        $.ajax("AdminPanel.php").done(function (data){
            $("#mainInnerContent").html(data);
        });
    }
</script>