<?php
include 'db_tools/db_functions.php';
session_start();
$conn = connect_db();
if(!isset($_SESSION["login_user"])){
	header("Location: login.php");
}else{
	$userInfo = $_SESSION["login_user"];
}
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
                <section class="component">
                    <h2>Currently Logged in: <?php echo $userInfo["UserID"]?>
                        (<?php echo $userInfo["Role"]?>)
                    </h2>
					<?php
					switch($userInfo["Role"]){
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
				<div class="row double-component grid-2">
					<div id="course_description" class="col component">
						<h2>Course Description</h2>
                        <?php
                        $description = get_course_description($conn);
                        if ($description == ""){
                            echo "No description yet...";
                        } else {
                            echo $description;
                        }
                        ?>
					</div>
					<div id="announcement_block" class="col component">
						<h2>Announcement</h2>
							<div>
								<ol>
		          					<li>Cancelling office hours on 2nd March</li>
							        <li>Assignment2 is now available</li>
							        <li>Midterm Exam Marks are now available</li>
							    </ol>
						    </div>
						    <div class="left"><a href="announcement.html">More Details</a></div>
					</div>
				</div>
				<section class="component">
					<h2>Schedule and Instructor</h2>
					<div class="mock-table">
						<div class="row grid-3">
							<div class="col">Instructor:</div>
							<div class="col">A. Attarwala</div>
						</div>
						<div class="row grid-3">
							<div class="col">Lecture:</div>
							<div class="col">Mondays 9am to 11am in SW 319</div>
						</div>
						<div class="row grid-3">
							<div class="col">Tutorials:</div>
							<div class="col">Check Online Schedule</div>
						</div>
						<div class="row grid-3">
							<div class="col">Email:</div>
							<div class="col">A.Attarwala@utoronto.ca</div>
						</div>
					</div>
				</section>
				<section class="component">
					<h2>Assessment</h2>
					<div class="mock-table-border">
						<p class="row grid-4">
							<span class="col">Work</span>
							<span class="col">Weight</span>
							<span class="col">Start Date</span>
							<span class="col">Due Date</span>
						</p>
                        <?php
                        $work = get_assessment($conn);
                        foreach ($work as $title => $info){?>
                            <p class="row grid-4">
                                <span class="col"><?php echo $title?></span>
                                <span class="col"><?php echo $work[$title]["weight"]?>%</span>
                                <span class="col"><?php echo $work[$title]["start"]?></span>
                                <span class="col"><?php echo $work[$title]["end"]?></span>
                            </p>
                        <?php
                        }
                        close_db($conn)
                        ?>
					</div>
				</section>	
				<section class="component">
					<h2>Need more info of the course?</h2>
					<div class="mock-table">
						<div class="row grid-3">
							<a href="" class="center-button col grow">Material</a>
							<a href="location.html" class="center-button col grow">Location</a>
							<a href="calendar.php" class="center-button col grow">Calender</a>
						</div>
					</div>
				</section>
			</div>
            <?php
			echo file_get_contents("html_templates/footer.html");
            ?>
		</div>
	</body>
	<script src="js/main.js"></script>
</html>
