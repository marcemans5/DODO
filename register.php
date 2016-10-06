<h3 class="centerText">Registreren</h3>
<div class="innerContent">
    <form method="post" action="javascript:register()" id="registerForm" enctype="multipart/form-data">
        <div id="Error" style="color: red"></div>
        Gebruikersnaam:
        <input type="text" name="Gebruikersnaam" class="userInput" required="required"/>
        Wachtwoord:
        <input type="password" name="Wachtwoord" class="userInput" required="required"/>
        Herhaal wachtwoord:
        <input type="password" name="Wachtwoord2" class="userInput" required="required"/>
        E-mail:
        <input type="email" name="Email" class="userInput" required="required"/>
        Voornaam:
        <input type="text" name="Voornaam" class="userInput" required="required"/>
        Achternaam:
        <input type="text" name="Achternaam" class="userInput" required="required"/>
        Foto:
        <input type="file" name="Foto" accept="image/*"/>
        <button id="registerBtn" class="greenBtn" type="submit" value="submit" >Registreren</button>
    </form>
    <button id="registerBack" class="redBtn" onclick="back()" >Terug</button>
</div>
<script>
    
    
    function register(){
        
        var formData = new FormData($("#registerForm")[0]);
        
        $.ajax({
            url: "registerUser.php",
            type: 'POST',
            processData: false,
            data: formData,
            contentType: false
        }).done(function (data){
            switch(data){
                case '0':
                    $.ajax({
                        url: "login.php",
                        type: 'POST',
                        processData: false,
                        data: formData,
                        contentType: false
                    }).done(function(data){
                        if(data){
                            location.reload();
                        }else{
                            console.log("data: " + data);
                            $("#Error").html("Interne fout");
                        }
                    });
                    break;

                case '1':
                    $("#Error").html("Interne fout");
                    break;

                case '2':
                    $("#Error").html("Wachtwoorden komen niet overeen");
                    break;

                case '3':
                    $("#Error").html("Foute afbeelding");
                    break;

                case '4':
                    $("#Error").html("Gebruikersnaam al gebruikt");
                    break;
            }
        });
        
    }
    
    function back(){
        $.get("logoutUser.php").done(function(data){
            $("#userDiv").html(data);
        });
    }
</script>