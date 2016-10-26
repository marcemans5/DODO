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
        <tr><td><b>Rechten:</b></td></tr>
        <tr><td><?php echo $_SESSION["Admin"] == 1 ? 'Admin' : 'Normaal'; ?></td></tr>
    </table>
    <button id="logoutBtn" class="redBtn" onclick="logout()">Logout</button>
</div>

<script>
    function logout(){
        $.ajax("logout.php").done(function (){
            location.reload();
        })
    }
</script>