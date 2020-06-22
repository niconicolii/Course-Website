<?php
function validate_role($userAuto, $role, $role2=""){
    $correct = $userAuto["Role"] == $role || $userAuto["Role"] == $role2;
    if(!$correct){
        header("location: login.php?auth=false");
    }
}
