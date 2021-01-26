<?php

session_start();
require "../../../models/User.php";

$user = new User($_SESSION["userId"]);
$gamers = $user->gamers();

$reduce = array();

foreach($gamers as $gamer){
    $reduce[] = array(
        "id" => $gamer["id"], 
        "active" => $gamer["active"]
    );
}
echo json_encode($reduce);
exit();