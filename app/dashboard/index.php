<?php 
    require "../../includes/header.php"; // must be first to ensure user is logged in
    require "../../models/User.php";

    $user = new User($_SESSION["userId"]);
?>

<button class="toggle-gamers" onClick="toggleGamersList()"> View Gamers </button>
<main>
    <div id="gamers" class="gamers">
        <h1> Gamers </h1>
        <div class="follow-stats">
            <h6> Online <h6>
            <h6 class="following">Started Following</h6>
        </div>
        <?php 
            $gamers = $user->gamers();
            foreach ($gamers as $gamer){
                $full_name = $gamer["full_name"];
                $id = $gamer["id"];
                $active = $gamer["active"] == 1 ? "online" : "offline";
                // seperate SQL date into yyyy-mm-dd and time (Only showing the date)
                $date = explode(" ", $gamer["date"])[0];
                echo "
                <a href=/dashboard/?user=$id >
                    <div class=gamer>
                        <p> 
                            $full_name
                        </p>
                        <span> <div class=\"circle $active\" ></div> </span>
                        <span> $date </span>
                    </div>
                </a>";
            }
        ?>
    </div>
    
    <div class="profile">
        <?php 
            // Single gamer/user profile
            
            if(isset($_GET["user"])){
                // Display One Gamer 
                $gamer_id = $_GET["user"];  
                $gamer = new User($gamer_id);
                $name = $gamer->user["full_name"];
                $profile = $gamer->profile();

                echo "<div>";
                echo "<h3> $name </h3> ";
                if(empty($profile)){
                    echo "<p> $name's profile is not setup yet!</p>";
                } else {
                    $gamertag = $profile["gamertag"];
                    $favgame = $profile["favgame"];
                    $gamingConsole = $profile["gamingConsole"];
                    $streams = $profile["streams"];
                    if(!empty($gamertag)){
                        echo "<p> Gamertag: $gamertag </p>";
                    }
                    if(!empty($favgame)){
                        echo "<p> Favorite Game: $favgame </p>";
                    }
                    if(!empty($gamingConsole)){
                        echo "<p> System: $gamingConsole </p>";
                    }
                    if(!empty($streams)){
                        echo "<p> Streams: $streams </p>";
                    }
                }

                echo "</div>";

            } else {
                //  Display User Info/Stats??
                $profile = $user->profile();
                echo "<div>";
                echo "<h3> Your Profile... </h3> ";
                if(empty($profile)){
                    echo "<p> Create your profile for others to see! </p>"; // create as a link to profile setup
                } else {
                    $gamertag = $profile["gamertag"];
                    $favgame = $profile["favgame"];
                    $gamingConsole = $profile["gamingConsole"];
                    $streams = $profile["streams"];
                    if(!empty($gamertag)){
                        echo "<p> Gamertag: $gamertag </p>";
                    }
                    if(!empty($favgame)){
                        echo "<p> Favorite Game: $favgame </p>";
                    }
                    if(!empty($gamingConsole)){
                        echo "<p> System: $gamingConsole </p>";
                    }
                    if(!empty($streams)){
                        echo "<p> Streams: $streams </p>";
                    }
                }

                echo "</div>";

            }

        ?>
    </div>
</main>

<script src="/dashboard/scripts/toggleGamersList.js"></script>