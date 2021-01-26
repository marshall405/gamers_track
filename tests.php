<?php 

require "models/User.php";

function test($expected, $actual, $callback) {
    if($expected === $actual){
        $callback("success");
    }else {
        $callback("Expected $expected but got $actual");
    }
}








// Test User Class
// User id 2 = TEST USER
$user = new User(2);

test($user->user["full_name"],"Marshall Slemp", function($message) {
    echo "User equals Marshall Slemp: $message \n";
});

test($user->user["email"],"marshall.slemp@gmail.com", function($message) {
    echo "User equals Marshall Slemp: $message \n";
});