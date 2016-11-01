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
        <tr><td><?php echo $_SESSION["Punten"]; ?></td></tr>
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