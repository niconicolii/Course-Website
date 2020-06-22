<?php
include "db_tools/db_functions.php";
include "validate/user_validation.php";
session_start();
$conn = connect_db();
$userAuth = $_SESSION["login_user"];
validate_role($userAuth, "Instructor");
$date = new DateTime();
$date -> setTimezone(new DateTimeZone('America/Toronto'));
$dateStr = $date -> format('Y-m-d');
$myFeedback = getFeedbackByInstructor($conn, $userAuth, $dateStr, "");
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
                <div class="component">
                    <h2>Currently Logged in: <?php echo $userAuth["UserID"]?>
                        (<?php echo $userAuth["Role"]?>)
                    </h2>
                    <?php
                    echo file_get_contents("html_templates/instructor_nav.html");
                    ?>
                </div>
                <div id="feedback_date" class="new-component">
                    <h2>Date of the Feedback</h2>
                    <div class="row">Please selected the date of the feedback: </div>
                    <div class="row grid-2">
                        <div class="col">
                            <div class="col"><input id="date" type="date"/></div>
                        </div>
                        <div class="col">
                            <input id="number" type="number" placeholder="Limited to">
                        </div>
                    </div>
                    <div class="center-button col tran" onclick="queryFeedback()">Show</div>
                    <div id="hint" style="color: red;"></div>
                </div>
                <?php
                    foreach($myFeedback as $feedback){
                        ?>
                        <div class="new-component feedback">
                            <h2>Posted On <?php echo $feedback["UpdateDate"]?></h2>
                            <div>
                                <label><b>(a) What do you like about the instructor teaching?</b></label>
                                <div class="ans"><?php echo $feedback["Qa"]?></div>
                            </div>
                            <div>
                                <label><b>(b) What do you recommend the instructor to
                                        do to improve their teaching?</b></label>
                                <div class="ans"><?php echo $feedback["Qb"]?></div>
                            </div>
                            <div>
                                <label><b>(c) What do you like about the labs?</b></label>
                                <div class="ans"><?php echo $feedback["Qc"]?></div>
                            </div>
                            <div>
                                <label><b>(d) What do you recommend the lab
                                        instructors to do to improve their lab teaching?</b></label>
                                <div class="ans"><?php echo $feedback["Qd"]?></div>
                            </div>
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
    <script src="js/feedback.js"></script>
</html>

