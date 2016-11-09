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
<table class="Tbl">
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
                $id = $result['GebruikerID'];
                echo '<tr><td>';
                echo $id;
                echo '</td><td id="Gebruikersnaam-';
                echo $id;
                echo '" class="text">';
                echo $result['Gebruikersnaam'];
                echo '</td><td id="Email-';
                echo $id;
                echo '" class="text">';
                echo $result['Email'];
                echo '</td><td id="Voornaam-';
                echo $id;
                echo '" class="text">';
                echo $result['Voornaam'];
               echo '</td><td id="Achternaam-';
                echo $id;
                echo '" class="text">';
                echo $result['Achternaam'];
                echo '</td><td>';
                echo $result['Admin'];
                echo '</td><td id="Punten-';
                echo $id;
                echo '" class="number">';
                echo $result['Punten'];
                echo '</td></tr>';
            }
        ?>
    </tbody>
</table>

<script>
    var isEditing = false;
    
    $(".text").dblclick(function() {
        if(!isEditing){
            isEditing = true;
            var oldVal = $(this).html();
            var id = $(this).attr('id');
            id = id.split('-');
            var field = id[0];
            var uid = id[1];
            $(this).html('<input id="editField" type="text" value="' + oldVal + '"/>');
            $("#editField").keyup( function(e) {
                if(e.which === 13){
                    $.post('postUserChange.php', { 'field': field, 'id': uid, 'value': $(this).val() }).done(function(data) {
                        admin();
                    });
                }
            });
        }
    });
    
    $(".number").dblclick(function() {
        if(!isEditing){
            isEditing = true;
            var oldVal = $(this).html();
            var id = $(this).attr('id');
            id = id.split('-');
            var field = id[0];
            var uid = id[1];
            $(this).html('<input id="editField" type="number" value="' + oldVal + '" style="width: 20%" />');
            $("#editField").keyup( function(e) {
                if(e.which === 13){
                    $.post('postUserChange.php', { 'field': field, 'id': uid, 'value': $(this).val() }).done(function(data) {
                        admin();
                    });
                }
            });
        }
    });
    
    function terug(){
        $.post("loginHome.php").done(function (data){
            location.reload();
        });
    }
</script>