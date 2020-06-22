<?php
include "db_tools/db_functions.php";
include "validate/user_validation.php";
session_start();
$conn = connect_db();
$userAuth = $_SESSION["login_user"];
// validate_role($userAuth, "Instructor");
$date = new DateTime();
$date -> setTimezone(new DateTimeZone('America/Toronto'));
$dateStr = $date -> format('Y-m-d');
$myRequest = getRemarkReq($conn, $userAuth, $dateStr, "");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title></title>
</head>
<body>
<?php
echo file_get_contents("html_templates/header.html");
?>
<div id="main_block">
    <div id="main_page_body">
        <div id="request_date" class="new-component">
            <h2>Date of the Request</h2>
            <div class="row">Please selected the date of the remark requested: </div>
            <div class="row grid-2">
                <div class="col">
                    <div class="col"><input id="date" type="date"/></div>
                </div>
                <div class="col">
                    <input id="number" type="number" placeholder="Limited to">
                </div>
            </div>
            <div class="center-button col tran" onclick="getElementById('remark').style.display = 'block', queryRequest()">Show</div>
            <div id="hint" style="color: red;"></div>
            <div id="remark" style="display: none">
                <div id="update_mark" class="component" style="background: white">
                    <h2>Remark</h2>
                    <form id="update_info" onsubmit="return false">
                        <input placeholder="UTorId" name="utorid" autocomplete="off" required>
                        <input placeholder="WorkId" name="workid" autocomplete="off" required>
                        <input type="number" placeholder="Mark" name="mark" autocomplete="off" required>
                        <button type="submit" name="search" value="Search" onclick="addMark()">Update</button>
                    </form>
                    <div id="update_hint"></div>
                </div>
            </div>
        </div>
        <div class="new-component">
            <h2>Request to Me</h2>
            <?php
            if(count($myRequest) == 0){
                echo "<div style='color: red; font-size: x-small'>Currently no request to you.</div>";
            }
            ?>
        </div>
        <?php
        foreach($myRequest as $request){
            ?>
            <div class="component remarkreq">
                <h2>Posted On <?php echo $request["UpdateDate"]?></h2>
            </div>
            <?php
        }
        ?>
    </div>

    <?php
    echo file_get_contents("html_templates/footer.html");
    close_db($conn);
    ?>
</div>
</body>
<script src="js/main.js"></script>
<script src="js/check_remark.js"></script>
</html>

