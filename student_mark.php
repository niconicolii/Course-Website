<?php
include "validate/user_validation.php";
include "db_tools/db_functions.php";
session_start();
$userAuth = $_SESSION["login_user"];
validate_role($userAuth, "Student");
$conn = connect_db();
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
                    <h2>Currently Logged in: <a id="userID"><?php echo $userAuth["UserID"]?></a>
                        (<?php echo $userAuth["Role"]?>)
                    </h2>
					<?php
					echo file_get_contents("html_templates/student_nav.html");
					?>
                </section>

				<div class="component">
					<h2>
						Grades
					</h2>
					<div class="mock-table-border">
					<div class="row grid-4">
						<div class="col"><b>Item</b></div>
						<div class="col">
							<div class="row grid-2 no-border">
								<div class="col" style="text-align: right"><b>Result</b></div>
								<div class="col" style="text-align: right"><b>Weight</b></div>
							</div>
						</div>
						<div class="col" style="text-align: right"><b>Update Date</b></div>
						<div class="col" style="text-align: right"><b>Request Remark</b></div>
					</div>
					<?php 
					$userID = $userAuth["UserID"];
					$grades = getStudentMarks($conn, $userID);
					if (!$grades){
						echo "No marks available";
					}else {
						foreach ($grades as $nextWork) {
							$workID = $nextWork["WorkID"];
							?>
							<div class="row grid-4">
								<div class="col">
									<?php echo $workID;?>
								</div>
								<div class="col">
									<div class="row grid-2 no-border">
										<span class="col" style="text-align: right"><?php echo $nextWork["Percentage"];?></span>
										<span class="col" style="text-align: right"><?php echo $nextWork["Weight"]."% ";?></span>
									</div>
								</div>
								<div id=<?php echo $workID.'time'; ?> class="col" style="text-align: right">
									<?php echo $nextWork["UpdateDate"];?>
								</div>
								<?php 
								if ($nextWork["Type"] != 'Assignment') { ?>

									<div class="col" style="text-align: right">See Instructor/TA for remark.</div>
								</div>
								<?php
								} else { ?>
								<div class="col" style="text-align: right">
								<?php
								$status = getRemarkStatus($conn, $userID, $workID);
								if ($status == 'actived') {
								?>
									Remark pending review...
		                        <?php
		                    	} elseif ($status == 'false'){
		                        ?>
		                            <button class="center-button tran" style="width: 80%" onclick="getElementById('<?php echo $workID.'form';?>').style.display = 'block'">
		                            		Request Remark
		                            </button>

		                        <?php 
		                    	} else{ ?>
		                    		Remark updated<br>
		                    		(<?php echo $status;?>)
		                    		<script type="text/javascript">
		                    			document.getElementById("<?php echo $workID.'time';?>").value = "<?php echo $status; ?>";
		                    		</script>
		                    	<?php
		                    	} 
		                        ?>
		                        </div>
		                    </div>
							<div id=<?php echo $workID.'form';?> class="component" style="display: none; margin: 15px; background: white">
								<p><b>Remark Request</b>
									<span class="grow" style="float:right; cursor:pointer" onclick="getElementById('<?php echo $workID.'form';?>').style.display = 'none'">
										&times;
									</span>
								</p>
								<form onsubmit="return false" method="post" autocomplete="off">
									<div>
										<textarea id=<?php echo $workID."reason";?> placeholder="Explain why you are asking for a remarking request" rows="3" name="reason" required>
										</textarea>
									</div>
									<div class="row grid-4 flex-float">
									<div class="col">
										Send to:<br>
										<select id="sentTo" style="width: 100%" name="marker">
											<?php
											$teacher = getInstructorAndTA($conn);
											if (!$teacher){
												echo "<option disabled>No teacher found</option>";
											}else {
												foreach ($teacher as $nextTeacher) {
													echo "<option value'$nextTeacher'>".$nextTeacher."</option>";
												}
											}
											?>
										</select>
									</div>
									<input id="<?php echo $workID; ?>" type="submit" name="submit" value="Submit" class="center-button col" onclick="submitRemark(this.id)">
									</div>
								</form>
							</div>
							<?php
							}
						}
					}
					?>
					</div>
					<br>
					<p style="text-align: right; font-size: x-large"><b>
						Total: <?php echo calculateTotal($grades); ?>
					</b></p>
				</div>
			</div>
		</div>
		<?php
		echo file_get_contents("html_templates/footer.html");
        ?>
	</div>
	</body>
	<script src="js/main.js"></script>
	<script src="js/remark.js"></script>
</html>
