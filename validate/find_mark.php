<?php
header('Content-Type: application/json');
include "../db_tools/db_functions.php";
include "../validate/user_validation.php";
session_start();
validate_role($_SESSION["login_user"], "Instructor", "TA");
$conn = connect_db();
$content = json_decode($_GET["mark"], true);
$id = $content["id"];
$result = array();
$result["result"] = checkStudent($conn, $id);
if ($result["result"]){
    $result["works"] = get_works_by_student($conn, $id);
}
echo json_encode($result);
close_db($conn);