<?php
include "db_tools/db_functions.php";
include "validate/user_validation.php";
session_start();
$conn = connect_db();
$userAuth = $_SESSION["login_user"];
validate_role($userAuth, "Student");
$myFeedback = getFeedbackByStudent($conn, $userAuth);
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
                    echo file_get_contents("html_templates/student_nav.html");
                    ?>
                </div>
                <?php
                foreach($myFeedback as $feedback){
                    ?>
                    <div class="new-component">
                        <h2>To <?php echo $feedback["InstructorID"]?></h2>
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
                        <div class="end-text">
                            posted on <?php echo $feedback["UpdateDate"]?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div id="feedback-submit" class="component">
                    <h2>Submit a new feedback:</h2>
                    <form id="feedback" onsubmit="return false" method="post" autocomplete="off">
                        <input autocomplete="off" name="hidden" type="text"
                               style="display:none"/>
                        <div id="feedback_form">
                            <div>
                                <label><b>(a) What do you like about the instructor teaching?</b></label>
                                <textarea name="a" spellcheck="false" required></textarea>
                                <div class="char_hint"></div>
                            </div>
                            <div>
                                <label><b>(b) What do you recommend the instructor to
                                    do to improve their teaching?</b></label>
                                <textarea name="b" spellcheck="false" required></textarea>
                                <div class="char_hint"></div>
                            </div>
                            <div>
                                <label><b>(c) What do you like about the labs?</b>
                                </label>
                                <textarea name="c" spellcheck="false" required></textarea>
                                <div class="char_hint"></div>
                            </div>
                            <div>
                                <label><b>(d) What do you recommend the lab
                                    instructors to do to improve their lab teaching?</b></label>
                                <textarea name="d" required></textarea>
                                <div class="char_hint"></div>
                            </div>
                            <div>
                                <span><b>(e) Who would you like to send it to?&nbsp</b></span>
                                <select required name="e">
                                    <?php
                                    $instructors = getInstructors($conn);
                                    if(isset($instructors)){
                                        foreach($instructors as $ins){
                                            echo "<option value=$ins>$ins</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div id="hint"></div>
                            <div>
                                <button class="grow" type="submit" onclick="submitFeedback()">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            echo file_get_contents("html_templates/footer.html");
            close_db($conn);
            ?>
        </div>
    </body>
    <script src="js/main.js"></script>
    <script src="js/feedback.js"></script>
    <script>
        var tx = document.getElementsByTagName('textarea');
        for (var i = 0; i < tx.length; i++) {
            let element = tx[i];
            element.maxLength = 500;
            element.nextElementSibling.innerHTML = "Remaining characters : 500";
            element.setAttribute('style', 'height:' + (tx[i].scrollHeight) + 'px;overflow-y:hidden;');
            element.addEventListener("input", OnInput, false);
        }
    </script>
</html>

