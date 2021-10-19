<?php require_once ("Include/sessions.php") ?>
<?php require_once ("Include/functions.php")?>
<?php
    $_SESSiON["User_id"] = null;
    session_destroy();
    redirectTo("login.php");
?>