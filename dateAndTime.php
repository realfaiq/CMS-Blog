<?php

date_default_timezone_set("Asia/Karachi");

$currentTime = time();
// $DateTime = strftime("%Y-%m-%d %H:%M:%S", $currentTime);
$DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);

echo $DateTime;

?>