<?php
header('Content-Type: application/json');
include "../db_tools/db_functions.php";
session_start();
$conn = connect_db();
$content = json_decode($_GET["user"], true);
$userid = isset($content["userID"])?$content["userID"]:Null;
$workid = isset($content["workID"])?$content["workID"]:Null;
$description = isset($content["description"])?$content["description"]:Null;
$markerid = isset($content["markerID"])?$content["markerID"]:Null;
if($userid != "" && $workid != "" && $description != "" && $markerid != ""){
    $success = submitRemark($conn, $userid, $markerid, $workid, $description);
    if(!$success) {
        echo "duplicate";
    }else{
        echo 'true';
    }
}else{
	echo "missing statements".$userid.$workid.$description.$markerid;
}
close_db($conn)
?>
