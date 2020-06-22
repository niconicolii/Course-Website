<?php
header('content-type: application/json;charset=utf-8');
include "../db_tools/db_functions.php";
session_start();
$content = json_decode($_GET["feedback"], true);
$conn = connect_db();
$a = isset($content["a"])?$content["a"]:Null;
$b = isset($content["b"])?$content["b"]:Null;
$c = isset($content["c"])?$content["c"]:Null;
$d = isset($content["d"])?$content["d"]:Null;
$role = isset($content["e"])?$content["e"]:Null;
if($a != "" && $b != "" && $c != "" && $d != "" && $role != "")
{
    $date = new DateTime();
    $date -> setTimezone(new DateTimeZone('America/Toronto'));
    $dateStr = $date->format('Y-m-d H:i:s');
    $result = array();
    if (!submitFeedback($conn, $_SESSION["login_user"], $content, $dateStr)){
        $result["result"] = false;
        $result["message"] = "<p style='color: red; font-size: x-small'>".
            "Feedback cannot be submitted, check if you already submitted a ".
            "feedback to this instructor.</p>";
        echo json_encode($result);
    } else {
        $result["result"] = true;
        $result["message"] = $dateStr;
        echo json_encode($result);
    }
}
close_db($conn)
?>
