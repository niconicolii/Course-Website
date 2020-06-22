<?php
include 'db_tools/db_functions.php';
$conn = connect_db();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
	</head>
	<body>
		<?php
        echo file_get_contents("html_templates/header.html");
        ?>
		<div id="main_block">
			<div id="main_page_body">
				<div class="component">
					<h2>
						Office Hour
					</h2>
					<div class="mock-table">
						<b>TA's Office Hour</b>
						<div class="mock-table-border">
							<div class="row grid-3">
								<div class="col">
									Nagarjun
								</div>
								<div class="col">
									Tuesday 9am - 12pm
								</div>
								<div class="col">
									IC 404
								</div>
							</div>
							<div class="row grid-3">
								<div class="col">
									Zhongyang
								</div>
								<div class="col">
									Friday 1pm - 4pm
								</div>
								<div class="col">
									IC 404
								</div>
							</div>
							<div class="row grid-3">
								<div class="col">
									Syeda
								</div>
								<div class="col">
									Thursday 11am - 12pm
								</div>
								<div class="col">
									IC 404
								</div>
							</div>
							<div class="row grid-3">
								<div class="col"></div>
								<div class="col">
									Friday 3pm - 5pm
								</div>
								<div class="col">
									IC 404
								</div>
							</div>
						</div>
						<b>Professor's Office Hour</b>
						<div class="mock-table-border">
							<div class="row grid-2">
								<div class="col">
									Monday 11:30am - 1:30pm
								</div>
								<div class="col">
									IC 478
								</div>
							</div>
							<div class="row grid-2">
								<div class="col">
									Friday 11:30am - 1:30pm
								</div>
								<div class="col">
									IC 478
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="component">
					<h2>
						Lecture and Tutorial
					</h2>
					<div class="mock-table-border">
						<div class="row grid-4">
							<div class="col">
								Lecture:
							</div>
							<div class="col">
								LEC 01
							</div>
							<div class="col">
								Mondays 9am - 11am
							</div>
							<div class="col">
								SW 319
							</div>
						</div>
						<div class="row grid-4">
							<div class="col">
								Tutorial:
							</div>
							<div class="col">
								TUT 0001
							</div>
							<div class="col">
								Monday 11:00am - 12:00pm
							</div>
							<div class="col">
								BV 473
							</div>
						</div>
						<div class="row grid-4">
							<div class="col"></div>
							<div class="col">
								TUT 0002
							</div>
							<div class="col">
								Monday 12:00am - 1:00pm
							</div>
							<div class="col">
								BV 473
							</div>
						</div>
						<div class="row grid-4">
							<div class="col"></div>
							<div class="col">
								TUT 0003
							</div>
							<div class="col">
								Monday 1:00pm - 2:00pm
							</div>
							<div class="col">
								BV 473
							</div>
						</div>
						<div class="row grid-4">
							<div class="col"></div>
							<div class="col">
								TUT 0004
							</div>
							<div class="col">
								Monday 2:00pm - 3:00pm
							</div>
							<div class="col">
								BV 473
							</div>
							
						</div>
						<div class="row grid-4">
							<div class="col"></div>
							<div class="col">
								TUT 0005
							</div>
							<div class="col">
								Friday 2:00pm - 3:00pm
							</div>
							<div class="col">
								BV 473
							</div>
						</div>
					</div>
				</div>
				<div class="component">
					<h2>
						Assignment
					</h2>
					<div class="mock-table-border">
						<div class="row grid-3">
							<div class="col">
								<b>Assignment Name</b>
							</div>
							<div class="col">
								<b>Start Date</b>
							</div>
							<div class="col">
								<b>Due Date</b>
							</div>
						</div>
                        <?php
                        $assArray = get($conn, "Assignment");
                        foreach($assArray as $item){
                            ?>
                            <div class="row grid-3">
                                <div class="col">
                                    <?php echo $item["WorkID"]?>:
                                </div>
                                <div class="col">
                                    <?php echo $item["StartTime"]?>
                                </div>
                                <div class="col">
                                    <?php echo $item["EndTime"]?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
					</div>
				</div>
				<div class="component">
					<h2>
						Quiz
					</h2>
					<div class="mock-table-border">
						<div class="row grid-3">
							<div class="col">
								<b>Quiz Name</b>
							</div>
							<div class="col">
								<b>Start Date</b>
							</div>
							<div class="col">
								<b>Due Date</b>
							</div>
						</div>
                        <?php
                        $quizArray = get($conn, "Quiz");
                        foreach($quizArray as $quiz) {
                            ?>
                            <div class="row grid-3">
                                <div class="col">
                                    <?php echo $quiz["WorkID"]?>:
                                </div>
                                <div class="col">
                                    <?php echo $quiz["StartTime"]?>
                                </div>
								<div class="col">
									<?php echo $quiz["EndTime"]?>
								</div>
                            </div>
                            <?php
                        }
                        ?>
					</div>
				</div>
				<div class="component">
					<h2>
						Midterm
					</h2>
					<div class="mock-table-border">
						<div class="row grid-3">
							<div class="col">
								<b>Midterm Name</b>
							</div>
							<div class="col">
								<b>Start Date</b>
							</div>
							<div class="col">
								<b>Due Date</b>
							</div>
						</div>
						<?php
						$quizArray = get($conn, "Midterm");
						foreach($quizArray as $quiz) {
							?>
							<div class="row grid-3">
								<div class="col">
									<?php echo $quiz["WorkID"]?>:
								</div>
								<div class="col">
									<?php echo $quiz["StartTime"]?>
								</div>
								<div class="col">
									<?php echo $quiz["EndTime"]?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="component">
					<h2>
						Practical
					</h2>
					<div class="mock-table-border">
						<div class="row grid-3">
							<div class="col">
								<b>Practical Name</b>
							</div>
							<div class="col">
								<b>Start Date</b>
							</div>
							<div class="col">
								<b>Due Date</b>
							</div>
						</div>
						<?php
						$quizArray = get($conn, "Practical");
						foreach($quizArray as $quiz) {
							?>
							<div class="row grid-3">
								<div class="col">
									<?php echo $quiz["WorkID"]?>:
								</div>
								<div class="col">
									<?php echo $quiz["StartTime"]?>
								</div>
								<div class="col">
									<?php echo $quiz["EndTime"]?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="component">
					<h2>
						Final
					</h2>
					<div class="mock-table-border">
						<div class="row grid-3">
							<div class="col">
								<b>Final Name</b>
							</div>
							<div class="col">
								<b>Start Date</b>
							</div>
							<div class="col">
								<b>Due Date</b>
							</div>
						</div>
						<?php
						$quizArray = get($conn, "Final");
						foreach($quizArray as $quiz) {
							?>
							<div class="row grid-3">
								<div class="col">
									<?php echo $quiz["WorkID"]?>:
								</div>
								<div class="col">
									<?php echo $quiz["StartTime"]?>
								</div>
								<div class="col">
									<?php echo $quiz["EndTime"]?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="component">
					<h2>Calendar</h2>
					<div class="responsive-iframe-container big-container">
						<iframe src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=otoiicgnrujipibej280ls4osk%40group.calendar.google.com&amp;color=%23691426&amp;ctz=America%2FToronto" style="border-width:0" width="100%" height="600" frameborder="0" scrolling="no" id="cal"></iframe>
					</div>
					<div class="responsive-iframe-container small-container">
						<iframe src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=otoiicgnrujipibej280ls4osk%40group.calendar.google.com&amp;color=%23691426&amp;ctz=America%2FToronto" style="border-width:0" width="100%" height="600" frameborder="0" scrolling="no" id="cal"></iframe>
					</div>
					If It is too small to see, please rotate the device to landscape mode.
				</div>
		</div>
		<?php
        echo file_get_contents("html_templates/footer.html");
        ?>
	</div>
	</body>
	<script src="js/main.js"></script>
</html>
