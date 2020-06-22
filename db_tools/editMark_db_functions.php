<?php
header('content-type:text/html;charset=utf-8');
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "cscb20home";
function connect_db(){
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function get_course_description(mysqli $conn){
    $query = <<<SQL
    SELECT Content from course_info
    WHERE Type = 'course description'
SQL;
    $result = $conn->query($query);
    $content = $result->fetch_array();
    return $content[0];
}

function get_assessment(mysqli $conn){
    $work = array();
    $query = <<<SQL
    SELECT Type, Weight, StartTime, EndTime from work
SQL;
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()) {
        $typeName = $row["Type"];
        // If the type does not exist, create the new type.
        if(!key_exists($typeName, $work)){
            $work[$typeName] = array("weight" => 0);
        }
            $item = &$work[$typeName];
        // If the event is an individual event, then, get the start and end time
        // of it.
        if(key_exists("start", $item)){
            $item["start"] = "N/A";
            $item["end"] = "N/A";
        } else {
            $item["start"] = $row["StartTime"];
            $item["end"] = $row["EndTime"];
        }
        $item["weight"] += $row["Weight"];
    }
    return $work;
}

function get_assignments(mysqli $conn){
    $assignment = array();
    $query = <<<SQL
    SELECT WorkID, StartTime, EndTime from work
    WHERE Type = 'Assignment';
SQL;
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()){
        array_push($assignment, $row);
    }
    return $assignment;
}

function get_quizzes(mysqli $conn){
    $quizzes = array();
    $query = <<<SQL
    SELECT WorkID, StartTime from work
    WHERE Type = 'Quiz';
SQL;
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()){
        array_push($quizzes, $row);
    }
    return $quizzes;
}
function get_user_info(mysqli $conn, $user, $psw){
    $user_safe = mysqli_real_escape_string($conn, $user);
    $psw_safe = mysqli_real_escape_string($conn, $psw);
    $query = <<<SQL
    SELECT * from user_info
    WHERE UserID = '$user_safe' AND Password = '$psw_safe';
SQL;
    $result = $conn->query($query);
    if(!$result){
        return Null;
    } else {
        return $result -> fetch_assoc();
    }
}
function verify_user(mysqli $conn, $user, $email){
    $query = <<<SQL
    SELECT count(*) as count FROM user_info
    WHERE UserID = '$user' OR Email = '$email';
SQL;
    $result = $conn->query($query);
    $count = $result -> fetch_assoc()["count"];
    if($count > 0){
        return false;
    } else {
        return true;
    }
}

function add_user(mysqli $conn, $user, $psw, $email=Null, $role=Null){
    $user_safe = mysqli_real_escape_string($conn, $user);
    $psw_safe = mysqli_real_escape_string($conn, $psw);
    $email_safe = mysqli_real_escape_string($conn, $email);
    if (verify_user($conn, $user_safe, $email_safe)){
        $query = <<<SQL
    INSERT INTO user_info(UserID, Password, Email, Role)
    VALUES ('$user_safe', '$psw_safe', '$email_safe', '$role');
SQL;
        $conn->query($query);
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function submitRemark(mysqli $conn, $userAuth, $markerID, $workID, $reason){
    $userID = $userAuth["UserID"];
    $query = <<<SQL
    INSERT INTO
      remark_request VALUES ('$userID', '$markerID','$workID', '$reason');
SQL;
    return $conn->query($query) === True;
}

function getInstructors(mysqli $conn){
    $query = <<<SQL
    Select UserID
    FROM user_info
    WHERE Role = "Instructor";
SQL;
    $result = $conn -> query($query);
    if($result){
        $instructors = array();
        while($row = $result -> fetch_assoc()){
            array_push($instructors, $row["UserID"]);
        }
        return $instructors;
    } else {
        return null;
    }
}

function submitFeedback(mysqli $conn, $userAuth, $feedbackArray, $time){
    $userID = $userAuth["UserID"];
    $instructor = $feedbackArray["e"];
    $instructors = getInstructors($conn);
    if($instructors == null || !in_array($instructor, $instructors)){
        echo 'wocao';
        return false;
    }
    $a = $feedbackArray["a"];
    $b = $feedbackArray["b"];
    $c = $feedbackArray["c"];
    $d = $feedbackArray["d"];
    $query = <<<SQL
    INSERT INTO
      feedback(StudentID, InstructorID, Qa, Qb, Qc, Qd, UpdateDate)
      VALUES('$userID', '$instructor', '$a', '$b', '$c', '$d', '$time');
SQL;
    $result = $conn -> query($query);
    echo $conn -> error;
    return $result !== false;
}
function getFeedbackByStudent(Mysqli $conn, $userAuth){
    $query = <<<SQL
    Select *
    FROM feedback
    WHERE StudentID = "{$userAuth["UserID"]}";
SQL;
    $result = $conn -> query($query);
    if($result){
        return $result -> fetch_all(MYSQLI_ASSOC);
    } else {
        return null;
    }
}
function getFeedbackByInstructor(Mysqli $conn, $userAuth, $date, $limit){
    $query = "SELECT UpdateDate, Qa, Qb, Qc, Qd FROM feedback ".
                "WHERE InstructorID = '{$userAuth["UserID"]}'";
    if($date != ""){
        $from = $date;
        $to = $date." 23:59:59";
        $query = $query." AND UpdateDate BETWEEN '$from' AND '$to'";
    }
    if($limit != ""){
        $query = $query." LIMIT {$limit}";
    }
    $query = $query.";";
    $result = $conn -> query($query);
    if($result){
        return $result -> fetch_all(MYSQLI_ASSOC);
    } else {
        return null;
    }
}



function update_mark(mysqli $conn, $user, $work, $newmark){
    $query = <<<SQL
    UPDATE mark SET UpdateDate=NOW(), Percentage='$newmark'
    WHERE UserID='$user' AND WorkID='$work'
SQL;
    $result = $conn->query($query);
    if (!$result) {
        return false;
    } else {
        return true;
    }
}


function get_updateDate(mysqli $conn, $user, $work) {
    $query = <<<SQL
    SELECT UpdateDate FROM mark
    WHERE UserID='$user' and WorkID='$work'
SQL;
    $result = $conn->query($query);
    if (!$result) {
        return Null;
    } else {
        return $result->fetch_assoc()['UpdateDate'];
    }
}


function getCurrDate(){
    $curr = getdate(); 
    $curr = new DateTime();
    $curr -> setTimezone(new DateTimeZone('America/Toronto'));
    $dateStr = $curr -> format("Y-m-d");
    return $dateStr;
}

function getCurrTime(){
    $curr = new DateTime();
    $curr -> setTimezone(new DateTimeZone('America/Toronto'));
    $dateStr = $curr -> format("H:i");
    return $dateStr;
}

function add_work(mysqli $conn, $work, $type, $start, $end, $weight){
    $updatedate = getCurrDate();
    $query = <<<SQL
    INSERT INTO work
    VALUES ('$work', '$type', '$start', '$end', '$weight', 1, '$updatedate')
SQL;
    $result = $conn->query($query);
    echo $conn -> error;
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function add_mark(mysqli $conn, $user, $work, $percent){
    $query = <<<SQL
    INSERT INTO mark VALUES ('$user', '$work', '$percent', NOW())
SQL;
    $result = $conn->query($query);
    if (!$result) {
        return false;
    } else {
        return true;
    }
}

function getStudentEmptyWork(mysqli $conn, $user) {
    $allWork = array();
    $studentWork = array();
    $emptyWork = array();
    $allQuery = <<<SQL
    SELECT WorkID FROM work
SQL;
    $studentQuery = <<<SQL
    SELECT WorkID FROM mark
    WHERE UserID='$user'
SQL;
    $allResult = $conn->query($allQuery);
    $studentResult = $conn->query($studentQuery);
    while($row = $allResult->fetch_assoc()){
        array_push($allWork, $row["WorkID"]);
    }

    while($row2 = $studentResult->fetch_assoc()){
        array_push($studentWork, $row2["WorkID"]);
    }
    $emptyWork = array_diff($allWork,$studentWork);
    return $emptyWork;
}

function getInstructorAndTA(mysqli $conn) {
    $teacher = array();
    $query = <<<SQL
    SELECT UserID FROM user_info
    WHERE Role="Instructor" OR Role="TA"
SQL;
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()){
        array_push($teacher, $row["UserID"]);
    }
    if ($teacher) {
        return $teacher;
    }else{
        return null;
    }
}



function checkStudent(mysqli $conn, $searchID){
    $query = <<<SQL
    SELECT Role FROM user_info
    WHERE UserID='$searchID'
SQL;
    $result = $conn->query($query);
    $roleArray = $result->fetch_assoc();
    $role = $roleArray["Role"];
    if ($role != "Student"){
        return false;
    }else{
        return true;
    }
}



function close_db(mysqli $conn){
    $conn->close();
}