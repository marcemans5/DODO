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
<input type="text" placeholder="Zoeken" id="searchUser" oninput="searchUser()" />
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
                echo '<tr id="' . $id . '" class="userRij Displayed"><td>';
                echo $id;
                echo '</td><td id="Gebruikersnaam-' . $id . '" class="text">';
                echo $result['Gebruikersnaam'];
                echo '</td><td id="Email-' . $id . '" class="text">';
                echo $result['Email'];
                echo '</td><td id="Voornaam-' . $id . '" class="text">';
                echo $result['Voornaam'];
                echo '</td><td id="Achternaam-' . $id . '" class="text">';
                echo $result['Achternaam'];
                echo '</td><td id="Admin-' . $id . '" class="admin">';
                echo $result['Admin'] == 1 ? 'Ja' : 'Nee';
                echo '</td><td id="Punten-' . $id . '" class="number">';
                echo $result['Punten'];
                echo '</td></tr>';
            }
            echo '<tr id="geenData" style="display: none"><td><span style="color: darkred">Geen data</span></td><td></td><td></td><td></td><td></td><td></td></tr>';
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
    
    //TODO: Hier dropdown maken om admin aan te passen
    $(".admin").dblclick(function() {
        if(!isEditing){
            isEditing = true;
            var oldVal = $(this).html();
            var id = $(this).attr('id');
            id = id.split('-');
            var field = id[0];
            var uid = id[1];
            var JaSel = '';
            var NeeSel = '';
            if(oldVal === 'Ja'){
                JaSel = 'selected';
            }else{
                NeeSel = 'selected';
            }
            var htmlStr = '<select id="editField"><option value="1" ' + JaSel + '>Ja</option><option value="0" ' + NeeSel + '>Nee</option></select>';
            $(this).html(htmlStr);
            $("#editField").change( function() {
                $.post('postUserChange.php', { 'field': field, 'id': uid, 'value': $(this).val() }).done(function(data) {
                    admin();
                });
            });
        }
    });
    
    function terug(){
        $.post("loginHome.php").done(function (data){
            location.reload();
        });
    }
    
    function searchUser(){
        var searchStr = $("#searchUser").val();
        $.get("search.php", { type: 'user', src: searchStr }).done(function (data){
            filterUser(data);
        });
    }
    
    function filterUser(data){
        var UserIds = data.split(',');
        
        $.each($(".userRij"), function (index, user){
            if(UserIds.indexOf(user.id) === -1){
                $(user).css("display", "none");
                $(user).removeClass("Displayed");
            }else{
                $(user).css("display", "table-row");
                $(user).addClass("Displayed");
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