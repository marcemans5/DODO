<h3 class="centerText">Login</h3>
<div class="innerContent">
    <form method="post" action="javascript:login()" id="loginForm">
        <div id="loginErr" style="color: red"></div>
        Gebruikersnaam:
        <input type="text" name="Gebruikersnaam" class="userInput"/>
        Wachtwoord:
        <input type="password" name="Wachtwoord" class="userInput"/>
        <button id="loginBtn" class="greenBtn" type="submit" value="submit" >Login</button>
    </form>
    <button id="register" onclick="openRegister()">Registreren</button>
</div>
<script>
    function login(){
        $.post("login.php", $("#loginForm").serialize()).done(function(data){
            if(!data){
                $("#loginErr").html("Gebruikersnaam of wachtwoord onjuist.");
            }else if(data){
                location.reload();
            }else{
                $("#loginErr").html("Interne fout");
            }
        });
    }
    
    function openRegister(){
        $.get("register.php").done(function(data){
            $("#userDiv").html(data);
        });
    }
</script>