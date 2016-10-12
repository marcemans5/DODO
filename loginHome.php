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
    $komend = "Komend";
    
    $pdo = new PDO("mysql:host=$DBhost;dbname=$DB", "$DBuser", "$DBpassw");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //SQL HIER AANPASSEN
    $stmt = $pdo->prepare("SELECT * FROM dodo_wedstrijd INNER JOIN WHERE status=:st;");
    $stmt->bindParam(":st", $komend, PDO::PARAM_STR);
    $stmt->execute();
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        
    }
    ?>
</table>