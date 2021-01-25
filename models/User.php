<?php

require_once "db.php";

require "Route.php";

class User extends Route {
    private $id;
    public $user;
    public function __construct($id) {
        $this->id = $id;

        global $conn;
        $sql = "SELECT * FROM users WHERE id=$id LIMIT 1";
        $result = mysqli_query($conn,$sql);
        if(empty($result)){
            die();
        }else {
            $this->user = mysqli_fetch_assoc($result);
        }
    }

    public function gamers() {
        // return array of all gamers for a user
        global $conn;
        $sql = "SELECT u.*, r.date FROM relationships r
                JOIN users u 
                ON u.id = (case when (r.user1 != $this->id) then r.user1 else r.user2 END)
                WHERE r.user1=$this->id OR r.user2=$this->id 
                AND r.active";

        $results = mysqli_query($conn,$sql);
        $array = array();
        while($row = mysqli_fetch_assoc($results)){
            $array[] = $row;
        }
        return $array;

    }

    public function update_portfolio($gamertag = NULL, $favgame = NULL, $console = NULL, $streams = NULL){
        global $conn;
        $sql = "SELECT * FROM profiles WHERE user_id=$this->id LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows === 0){
            $query = mysqli_query($conn, "INSERT INTO profiles(gamertag, favgame, gamingConsole, streams, user_id) VALUES (\"$gamertag\", \"$favgame\", \"$console\", \"$streams\", \"$this->id\")");
            if(!$query){
                return false;
            }
        } else {
            $query = mysqli_query($conn, "UPDATE profiles SET 
                gamertag = \"$gamertag\", 
                favgame = \"$favgame\", 
                gamingConsole = \"$console\", 
                streams = \"$streams\"
                WHERE user_id=\"$this->id\"
            ");
            if(!$query){
                return false;
            }
        }
        return $query;
    }

    public function profile() {
        global $conn;
        $sql = "SELECT * FROM profiles WHERE user_id=$this->id LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if($result->num_rows > 0) {
            return mysqli_fetch_assoc($result);
        }
        return false;
    }

    static function login($email, $pwd) {
        global $conn;

        $sql = "SELECT * FROM users WHERE email=? LIMIT 0,1";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: /?error=sqlerror");
            exit();

        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
        }

        $result = mysqli_stmt_get_result($stmt);

        if(!mysqli_num_rows($result) > 0){
            header("Location: /?email=$email");
            exit();
        } else {
            $user = mysqli_fetch_assoc($result);

            if( $user["password"] !== $pwd ){
                header("Location: /?password&email=$email");
                exit();
            }
            // We get here - user has successfully logged in
            session_start();
            // Set user to active 
            $id = $user["id"];
            mysqli_query($conn, "UPDATE users SET active=1 WHERE id=$id");
            $_SESSION["userId"] = $user["id"];
            $_SESSION["userUid"] = $user["email"];
            $_SESSION["userName"] = $user["full_name"];
            header("Location: /dashboard");
        }
    }

}