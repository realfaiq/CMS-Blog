<?php require_once ("Include/db.php") ?>
<?php require_once ("Include/sessions.php") ?>
<?php


    function redirectTo($location){
        header("Location:".$location);
        exit;
    }

    function loginAttempt($username, $password){
        global $connection;
        $query = "SELECT * FROM registration WHERE username = '$username' and password = '$password'";
        $execute = mysqli_query($connection,$query);
        if($admin = mysqli_fetch_assoc($execute)){
            return $admin;
        }
        else{
            return null;
        }
    }

    function Login(){
        if(isset($_SESSION["Id"])){
            return true;
        }
    }

    function confirmLogin(){
        if(!Login()){
            redirectTo("login.php");
        }
    }
?>