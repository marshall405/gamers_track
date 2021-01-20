<?php 
    session_start();
    if(isset($_SESSION["userUid"])){
        header("Location: /dashboard");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Testing</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <main>
        <?php
            // redirected from login.php
            if(isset($_GET["unauthorized"])){
                echo "<h4 class=warning> Please login first! </h4>";   
            };
            if( isset($_GET["email"]) ){
                $email = $_GET["email"];
                if(isset($_GET["password"])){
                    echo "<h4 class=warning> Oops! Password is incorrect. </h4>";   
                } elseif(!isset($_GET["password"])){
                    echo "<h4 class=warning> Oops! Email is incorrect. </h4>";   
                }
            }
        ?>
        <div class="form-login-wrapper">
            <h2> Login </h2>
            <form class="form-login" action="login.php" method="POST">
                <input 
                    type="email" 
                    name="email"
                    placeholder="Email" 
                    minlength="4"
                    required
                    <?php 
                        if(isset($email) ){
                            if(!isset($_GET["password"])){
                                echo "value=$email class=wrong";
                            } else {
                                echo "value=$email";
                            }
                        }
                    ?>
                >
                <input 
                    type="password" 
                    name="pwd"
                    placeholder="Password" 
                    required
                    autocomplete
                    <?php 
                        if(isset($_GET["password"])){
                            echo "class=wrong";
                        }
                    ?>
                >
                <button type="submit" name="login-submit"> Login </button>
            </form>
        </div>
    </main>
</body>
</html>