<?php require_once ("Include/db.php") ?>
<?php require_once ("Include/sessions.php") ?>
<?php require_once ("Include/functions.php") ?>
<?php
    if(isset($_GET["id"])){
        $idFromURL = $_GET["id"];
        $connection;
        $Admin = $_SESSION["Username"];
        $query = "UPDATE comments SET status='ON', approvedby='$Admin' WHERE id='$idFromURL'";
        $Execute = mysqli_query($connection, $query);

        if($Execute){
            $_SESSION["SuccessMessage"] = "Comment Approved Succesfully";
            redirectTo("comments.php");
        }
        else{
            $_SESSION["ErrorMessage"] = "Something Went Wrong! Try Again";
            redirectTo("comments.php");
        }
    }
?>