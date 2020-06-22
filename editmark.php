<?php
include 'db_tools/editMark_db_functions.php';
include 'validate/user_validation.php';
session_start();
$userAuth = $_SESSION["login_user"];
validate_role($userAuth, "Instructor", "TA");
$conn = connect_db();?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>
<?php
echo file_get_contents("html_templates/header.html");
?>
<div id="main_block">
    <div id="main_page_body">
        <section class="component">
            <h2>Currently Logged in: <?php echo $userAuth["UserID"]?>
                (<?php echo $userAuth["Role"]?>)
            </h2>
            <?php
            switch($userAuth["Role"]){
                case "Student":
                    echo file_get_contents("html_templates/student_nav.html");
                    break;
                case "TA":
                    echo file_get_contents("html_templates/ta_nav.html");
                    break;
                case "Instructor":
                    echo file_get_contents("html_templates/instructor_nav.html");
                    break;
            }
            ?>
        </section>
        <div class="component">
            <h2>Add New Work</h2>
            <div class="mock-table">
                <form id="newWork" onsubmit="return false" method="post" autocomplete="off">
                    <div class="row grid-3">
                        <div class="col">
                            WorkID:<br>
                            <input name='newWorkID' style="width: 70%" required/>
                        </div>
                        <div class="col">
                            Work Type:<br>
                            <select name='workType' style="width: 70%" required>
                                <option value="Assignment">Assignment</option>
                                <option value="Quiz">Quiz</option>
                                <option value="Midterm">Midterm</option>
                                <option value="Final">Final</option>
                                <option value="Pra">Pra</option>
                            </select>
                        </div>
                        <div class="col">
                            Weight:<br>
                            <input name='weight' style="width: 30%" required/>%
                        </div>
                    </div>
                    <div class="row grid-3">
                        <div class="col">Start Time:</div>
                        <div class="col">End Time:</div>
                    </div>
                    <div class="row grid-3">
                        <div class="col">
                            <input name='startDate' type="date" style="width: 70%" value="<?php echo getCurrDate(); ?>" required/>
                        </div>
                        <div class="col">
                            <input name='endDate' type="date" style="width: 70%" value="<?php echo getCurrDate(); ?>" required>
                        </div>
                    </div>
                    <div class="row grid-3">
                        <div class="col">
                            <input type="time" name='startTime' style="width: 70%" value="<?php echo getCurrTime(); ?>" required/>
                        </div>
                        <div class="col">
                            <input type="time" name='endTime' style="width: 70%" value="23:59" required/><br>
                        </div>
                        <div class="col">
                            <button class="tran" onclick="updateNewTask()">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
            <div id="hint"></div>
        </div>
        <div id="find_mark" class="component">
            <h2>Edit Mark</h2>
                <form id="utorid" onsubmit="return false">
                    Find UTorID: <input name="searchID" autocomplete="off" required>
                    <button type="submit" name="search" value="Search" onclick="showMark()">Submit</button>
                </form>
            <div id="edit_hint"></div>
        </div>
        <div id="update_mark" class="component">
            <h2>Update Mark</h2>
            <form id="update_info" onsubmit="return false">
                <input placeholder="UTorId" name="utorid" autocomplete="off" required>
                <input placeholder="WorkId" name="workid" autocomplete="off" required>
                <input type="number" placeholder="Mark" name="mark" autocomplete="off" required>
                <button type="submit" name="search" value="Search" onclick="addMark()">Update</button>
            </form>
            <div id="update_hint"></div>
        </div>
    </div>
    <?php
    echo file_get_contents("html_templates/footer.html")
    ?>
</div>
</body>
<script src="js/main.js"></script>
<script src="js/edit_mark.js"></script>
</html>

