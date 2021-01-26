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
            $this->user = $result->fetch_assoc();
        }
    }

    public function test(?string $a = "not set"){
        return $a;
    }

    public function gamers() {
        // return array of all gamers for a user
        global $conn;
        $sql = "SELECT u.active, u.full_name, u.id, r.date FROM relationships r
                JOIN users u 
                ON u.id = (case when (r.user1 != $this->id) then r.user1 else r.user2 END)
                WHERE r.user1=$this->id OR r.user2=$this->id 
                AND r.active";

        $results = mysqli_query($conn,$sql);
        $array = array();
        while($row = $results->fetch_assoc()){
            $array[] = $row;
        }
        return $array;

    }

    public function update_portfolio($gamertag = NULL, $favgame = NULL, $console = NULL, $streams = NULL){
        if(empty($gamertag)){
            $gamertag = NULL;
        }
        if(empty($favgame)){
            $favgame = NULL;
        }
        if(empty($console)){
            $console = NULL;
        }
        if(empty($streams)){
            $streams = NULL;
        }
        global $conn;
        $sql = "SELECT * FROM profiles WHERE user_id=$this->id LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows === 0){
            $insert = "INSERT INTO profiles(gamertag, favgame, gamingConsole, streams, user_id) VALUES (?,?,?,?,?)";
            $stmt = mysqli_prepare($conn, $insert);
            $stmt->bind_param("ssssi", $gamertag, $favgame, $console, $streams, $this->id);
            if(!$stmt->execute()){
                return false;
            }
        } else {
            $sql = "UPDATE profiles SET 
                gamertag = ?, 
                favgame = ?, 
                gamingConsole = ?, 
                streams = ?
                WHERE user_id= ?
            ";
            $stmt = mysqli_prepare($conn, $sql);
            $stmt->bind_param("ssssi", $gamertag, $favgame, $console, $streams, $this->id);
            if(!$stmt->execute()){
                return false;
            }
        }
        return $stmt;
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