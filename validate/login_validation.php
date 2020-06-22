<?php
header('content-type: application/json;charset=utf-8');
include "../db_tools/db_functions.php";
session_start();
if(isset($_GET["logout"])){
    session_destroy();
    session_start();
}
$conn = connect_db();
$content = json_decode($_GET["user"], true);
$userid = isset($content["username"])?$content["username"]:Null;
$psw = isset($content["password"])?$content["password"]:Null;
if(isset($userid) && isset($psw)){
    $userInfo = get_user_info($conn, $userid, $psw);
    if(!isset($userInfo)){
        echo "<p style='color: red; font-size: x-small'>".
            "The username or password is incorrect!</p>";
    }else{
        $_SESSION['login_user'] = $userInfo;
        echo "true";
    }
}
close_db($conn)
?>
