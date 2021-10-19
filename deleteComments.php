<?php require_once ("Include/db.php") ?>
<?php require_once ("Include/sessions.php") ?>
<?php require_once ("Include/functions.php") ?>
<?php
    if(isset($_GET["id"])){
        $idFromURL = $_GET["id"];
        $connection;
        $query = "DELETE FROM comments WHERE id='$idFromURL'";
        $Execute = mysqli_query($connection, $query);

        if($Execute){
            $_SESSION["SuccessMessage"] = "Comment deleted Succesfully";
            redirectTo("comments.php");
        }
        else{
            $_SESSION["ErrorMessage"] = "Something Went Wrong! Try Again";
            redirectTo("comments.php");
        }
    }
?>