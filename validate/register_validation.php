<?php
header('content-type: application/json;charset=utf-8');
include "../db_tools/db_functions.php";
session_start();
$content = json_decode($_GET["user"], true);
$conn = connect_db();
$userid = isset($content["userid"])?$content["userid"]:Null;
$psw = isset($content["psw"])?$content["psw"]:Null;
$email = isset($content["email"])?$content["email"]:Null;
$role = isset($content["role"])?$content["role"]:Null;
$legalRole = array("Student", "Instructor", "TA");
if($userid != "" && $psw != "" && $email != "" &&
    $role != ""){
    if (!in_array($role, $legalRole)){
        echo "<p style='color: red; font-size: x-small'>".
            "No such role!</p>";
    } else if (!add_user($conn, $userid, $psw, $email, $role)){
        echo "<p style='color: red; font-size: x-small'>".
            "User or email already exists!</p>";
    } else {
        $_SESSION["login_user"] = get_user_info($conn, $userid, $psw);
        echo "true";
    }
}
close_db($conn)
?>
