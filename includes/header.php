<?php 
    session_start();

    if(!isset($_SESSION["userUid"])){
        header("Location: /?unauthorized");
        exit();
    }
    require_once(__DIR__."/../models/db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Testing</title>

    <link rel="stylesheet" href="/dashboard/styles/main.css">
    <link rel="stylesheet" href="/dashboard/styles/header.css">
</head>
<body>
<header>
    <?php   
        echo "<h5 id=status> <a href=/>" . $_SESSION["userName"] . "</a></h5>";
    ?>
    <nav>
        <ul> 
            <?php
                $uri = $_SERVER["REQUEST_URI"];
                echo "<li><a href=/dashboard/pages/profile.php class=" . ($uri == "/dashboard/pages/profile.php" ? "current" : "") . "> Profile </a></li>";
                echo "<li class=logout><a href=/logout.php> Logout </a></li>";
            ?>
        </ul>
    </nav>
</header>