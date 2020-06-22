<?php
header('Content-Type: application/json');
include "../db_tools/db_functions.php";
include "../validate/user_validation.php";
session_start();
validate_role($_SESSION["login_user"], "Instructor", "TA");
$conn = connect_db();
$content = json_decode($_GET["user"], true);
$workid = isset($content["workID"])?$content["workID"]:Null;
$type = isset($content["type"])?$content["type"]:Null;
$starttime = isset($content["starttime"])?$content["starttime"]:Null;
$endtime = isset($content["endtime"])?$content["endtime"]:Null;
$weight = isset($content["weight"])?$content["weight"]:Null;
$success = false;
if($workid != "" && $type != "" && $starttime != "" && $endtime != "" &&
    $weight != ""){
    if(in_array($type, array("Assignment", "Quiz", "Pra", "Midterm", "Final"))){
        $success = add_work($conn, $workid, $type, $starttime, $endtime, $weight);
    }
}
echo json_encode(array('result' => $success));
close_db($conn)
?>
