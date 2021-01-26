<?php 
    require "../../../includes/header.php";    
    require "../../../models/User.php";

    $user = new User($_SESSION["userId"]);
?>

<main>
<h1> PROFILE </h1>

<?php 

    if(isset($_GET["error"])){
        echo "<p id=\"profile-error\" class=\"profile-error\"> Unable to Save Profile </p>";
        echo "<script> 
            setTimeout( () => {
                document.getElementById(\"profile-error\").classList.add(\"hide\");
            }, 3000);

        </script>";
    }
    if($_SERVER["REQUEST_METHOD"] === "POST"){ 

        $query = $user->update_portfolio($_POST["gamertag"], $_POST["favgame"], $_POST["console"], $_POST["streams"]);

        if(!$query){
            header("Location: ?error");
        }
        echo "<p id=message class=success> Profile Saved </p>";
        echo "<script> 
            setTimeout( () => {
                document.getElementById(\"message\").classList.add(\"hide\");
            }, 3000);

        </script>";

    }

    $username = $user->user["full_name"];
    $profile = $user->profile();

    $gamertag = "";
    $favGame = "";
    $gameConsole = "";
    $streams = "";
    if($profile){
        $gamertag = $profile["gamertag"];
        $favGame = $profile["favgame"];
        $gameConsole = $profile["gamingConsole"];
        $streams = $profile["streams"];
    }
?>
<form class="profile-form" action="profile.php" method="POST">
    <div class="field">
        <label> Username </label>
        <input type="text" name="name" placeholder=<?=$username?> disabled>
    </div>
    <div class="field">
        <label> Gamertag </label>
        <input type="text" name="gamertag" value="<?=$gamertag?>" placeholder="Gamertag">        
    </div>
    <div class="field">
        <label> Favorite Game </label>
        <input type="text" name="favgame" value="<?=$favGame?>" placeholder="Favorite Game">
    
    </div>
    <div class="field">
        <label> Preferred System </label>
        <select name="console">
        <option value="">--Please choose an option--</option>
        <option <?=($gameConsole === "PC" ? "selected" : null)?> value="PC">PC</option>
        <option <?=($gameConsole === "PS" ? "selected" : null)?> value="PS">Playstation</option>
        <option <?=($gameConsole === "BOX" ? "selected" : null)?> value="BOX">Xbox</option>
    </select>
    </div>
    <div class="field">
        <label> Streams </label>
        <input type="text" name="streams" value="<?=$streams?>" placeholder="Twitch, YouTube, etc..." >
    </div>

    <button type="submit" name="submit"> Update Profile</button>
</form>
    

</main>
    <script>  </script>

<?php 
    require "../../../includes/footer.php";
?>