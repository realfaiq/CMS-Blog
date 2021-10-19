<?php require_once ("Include/db.php") ?>
<?php require_once ("Include/sessions.php") ?>
<?php require_once ("Include/functions.php") ?>
<?php
    if(isset($_GET["id"])){
        $idFromURL = $_GET["id"];
        $connection;
        $query = "DELETE FROM registration WHERE id='$idFromURL'";
        $Execute = mysqli_query($connection, $query);

        if($Execute){
            $_SESSION["SuccessMessage"] = "Admin deleted Succesfully";
            redirectTo("admins.php");
        }
        else{
            $_SESSION["ErrorMessage"] = "Something Went Wrong! Try Again";
            redirectTo("admins.php");
        }
    }
?>