<?php
    require "../models/db.php";
    session_start();

    $id = $_SESSION["userId"];
    mysqli_query($conn, "UPDATE users SET active=0 WHERE id=$id");
    session_unset();
    session_destroy();
    header("Location: /");