<?php
require(__DIR__."/../config.php");

    $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
    
    if (!$conn) {
        die("Connection Failed: " . mysqli_connect_error());
    }
