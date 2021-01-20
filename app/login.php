<?php 
    if( isset($_POST["login-submit"]) && isset($_POST["email"]) && isset($_POST["pwd"]) ){
        require "../models/User.php";

        $email = $_POST["email"];
        $pwd = $_POST["pwd"];
        User::login($email, $pwd);
        
    } else {
        header("Location: /?unauthorized");
        exit();
    }

