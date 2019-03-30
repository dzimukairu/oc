<?php
	include("db_connection.php");
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$id = $_GET['subject_id'];
	$sql = "SELECT subject_code, course_title, course_description, course_about, teacher_id from subject where subject_id = $id";
	
	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];

	$get_teacher = $dbconn->query("SELECT * from teacher where teacher_id = '$teacher_id';");
	$trow = mysqli_fetch_array($get_teacher);

	$t_username = $trow['username'];
	$t_firstname = $trow['first_name'];
	$t_lastname = $trow['last_name'];
	$image = $trow['image'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- The above 4 meta tags *Must* come first in the head; any other head content must come *after* these tags -->

	<!-- Title -->
	<title>Online Classroom | Quiz</title>

	<!-- Favicon -->
	<link rel="icon" href="img/core-img/favicon.ico">

	<!-- Stylesheet -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/bootstrap-toggle.min.css">

	<style>
		.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
		.toggle.ios .toggle-handle { border-radius: 20px; }

		/*.modal{
			display: block !important;
		}*/
		.modal-dialog{
			overflow-x: initial !important;
			overflow-y: initial !important;
		}
		.modal-body{
			height: 400px;
			overflow-x: auto;
			overflow-y: auto;
		}
	</style>

	<script>
		function printData(fname, lname, title) {
			var divToPrint = document.getElementById("printTable");

			newWin = window.open("_blank");
			newWin.document.write("<h2 class='text-center'><b>"+fname+" "+lname+" - "+title+" Class Record</b></h2>" + divToPrint.outerHTML);
			newWin.document.close();
			newWin.focus();
			newWin.print();
			newWin.close();
		}
	</script>

</head>

<body>
	<!-- Preloader -->
	<div id="preloader">
		<div class="spinner"></div>
	</div>

	<!-- ##### Header Area Start ##### -->
	<header class="header-area">


		<!-- Navbar Area -->
		<div class="clever-main-menu">
			<div class="classy-nav-container breakpoint-off">
				<!-- Menu -->
				<nav class="classy-navbar justify-content-between" id="cleverNav">

					<!-- Logo -->
					<a class="nav-brand" href="index.php"><img src="img/core-img/logo.png" alt=""></a>

					<!-- Navbar Toggler -->
					<div class="classy-navbar-toggler">
						<span class="navbarToggler"><span></span><span></span><span></span></span>
					</div>

					<!-- Menu -->
					<div class="classy-menu">

						<!-- Close Button -->
						<div class="classycloseIcon">
							<div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
						</div>

						<!-- Nav Start -->
						<div class="classynav">
							<!-- <ul>
								<li><a href="teacher_home.php">Home</a></li>
							</ul> -->

							<!-- Register / Login -->
							<div class="login-state d-flex align-items-center">
								<div class="user-name mr-30">
									<div class="dropdown">
										<a class="dropdown-toggle" href="#" role="button" id="userName" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $t_firstname." ".$t_lastname; ?></a>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userName">
											<?php 
												echo "<a href=teacher_home.php class='dropdown-item'>Home</a>"; 
												echo "<a href=profile.php class='dropdown-item'>Profile</a>";
												echo "<a href=logout.php class='dropdown-item'>Logout</a>";
											?>
										</div>
									</div>
								</div>
								<div class="userthumb">
									<!-- <img src="img/bg-img/t1.png" alt=""> -->
									<?php 
										echo "<a href=profile.php><img src=img/tea-img/",urlencode($image)," style='border-radius: 50%; height: 40px; width: 40px'></a>" 
									?>
								</div>
							</div>
						</div>
						<!-- Nav End -->
					</div>
				</nav>
			</div>
		</div>
	</header>
	<!-- ##### Header Area End ##### -->

	<div class="student-quiz-content">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-11">
					<div class="section-heading">
						<h3>Class Record</h3>
					</div>        
			   </div>
			   <div class="col-lg-1">
			   		<button onClick='printData("<?php echo $t_firstname; ?>", "<?php echo $t_lastname; ?>","<?php echo $course_title; ?>")' class="btn btn-primary">Print Record</button>
			   	</div>
			</div>
			<?php
				$get_student_id = $dbconn->query("SELECT * from enrolls where subject_id = '$id' ");
				$hasStudent = false;
				if (mysqli_num_rows($get_student_id) != 0) {
					$hasStudent = true;

					$all_enrolled = array();
					while ($irow = mysqli_fetch_array($get_student_id)) {
						$all_enrolled[] = $irow['student_id'];
					}

					$all_lastname = array();
					foreach ($all_enrolled as $sid) {
						$get_lastname = $dbconn->query("SELECT * from student where student_id = '$sid' ");
						$ln = mysqli_fetch_array($get_lastname);
						$lastname = $ln['last_name'];
						$all_lastname[] = $lastname;
					}
					
					$sorted_ln = $all_lastname;
					sort($sorted_ln);

					// GET ALL ASSIGNMENT
					$all_ass_id = array();
					$assignment_count = 0;
					$get_ass_id = $dbconn->query("SELECT * from assignment where subject_id = '$id' ");
					while ($arow = mysqli_fetch_array($get_ass_id)) {
						$all_ass_id[] = $arow['assignment_id'];
					}
					$assignment_count = count($all_ass_id);
					$ass_colspan = 2;
					if ($assignment_count > 1) {
						$ass_colspan = $assignment_count+1;
					}
					// echo "assignment_count: ".$assignment_count;
					// echo "<br>";


					// GET ALL QUIZ
					$all_quiz_id = array();
					$quiz_count = 0;
					$get_quiz_id = $dbconn->query("SELECT * from quiz where subject_id = '$id' ");
					while ($arow = mysqli_fetch_array($get_quiz_id)) {
						$all_quiz_id[] = $arow['quiz_id'];
					}
					$quiz_count = count($all_quiz_id);
					$quiz_colspan = 2;
					if ($quiz_count > 1) {
						$quiz_colspan = $quiz_count+1;
					}
					// echo "quiz_count: ".$quiz_count;
				}
			?>
			<div class="row">
				<div class="col-12 col-lg-12">
					<?php
						if ($hasStudent) {
							// echo "ass_colspan: ".$ass_colspan;
							// echo "<br>";
							// echo "quiz_colspan: ".$quiz_colspan;
					?>
							<table class="table table-bordered" id="printTable">
								<tr style="text-align: center">
									<th rowspan="2" style="width: 25%; vertical-align: middle;">NAME</th>
									<th colspan="<?php echo $ass_colspan; ?>">ASSIGNMENTS</th>
									<th colspan="<?php echo $quiz_colspan; ?>">QUIZZES</th>
									<!-- <th rowspan="2" style="width: 5%; vertical-align: middle;">PERCENTAGE</th> -->
								</tr>
								<?php
									$totalscore = 0;
									$allscore = array();
									foreach ($all_ass_id as $ass_id) {
										$getass = $dbconn->query("SELECT * from assignment where assignment_id = '$ass_id' ");
										$ass = mysqli_fetch_array($getass);
										$xscore = $ass['score'];
										$allscore[] = $xscore;
										$totalscore = $totalscore + $xscore;
									}
									echo "<tr style='text-align: center'>";
									if ($assignment_count != 0) {
										for($x = 0; $x < $assignment_count; $x++) {
											echo "<td style='vertical-align: middle'><a href='assignment.php?assignment_id=$all_ass_id[$x]'><b class='text-success'>".($x+1)."  (".$allscore[$x].")</b></a></td>";
										}
										echo "<td style='width: 180px'><b>Total Grades (".$totalscore.")</b></td>";
									} else {
										echo "<td><i>No assignment/s found.</i></td>";
									}

									if ($quiz_count != 0) {
										for($x = 0; $x < $quiz_count; $x++) {
											echo "<td><b>".($x+1)."</b></td>";
										}
									} else {
										echo "<td><i>No quiz/es found.</i></td>";
									}
									echo "</tr>";

									foreach ($sorted_ln as $sln) {
										$get_student = $dbconn->query("SELECT * from student where last_name = '$sln' ");
										$srow = mysqli_fetch_array($get_student);
										$fname = $srow['first_name'];
										$sid = $srow['student_id'];

										echo "<tr>";
										echo "<th>".$sln.", ".$fname."</th>";
										$totalgrade = 0;
										foreach ($all_ass_id as $key) {
											$get_ans = $dbconn->query("SELECT * from answer_assignment where assignment_id = '$key' and student_id = '$sid' ");
											$hasAns = false;
											$grade = 0;
											if (mysqli_num_rows($get_ans) != 0) {
												$hasAns = true;
												$ansrow = mysqli_fetch_array($get_ans);
												$grade = $ansrow['grade'];
												$totalgrade = $totalgrade + $grade;
											}

											if ($hasAns) {
												echo "<td style='text-align: center'><b>".$grade."<b></td>";
											} else {
												echo "<td style='text-align: center'><b>-</b></td>";
											}
										}
										echo "<td style='text-align: center'><b>".$totalgrade."</b></td>";
										echo "</tr>";
									}
								?>
							</table>
					<?php 
						} else {
							echo "<h4>No Student/s Found.</h4>";
						}
					?>
				</div>
			</div>
			<?php 
				echo "<a href=teacher_course.php?subject_id=",urlencode($id)," class='btn clever-btn'>Back</a>";
			?>
			<br><br>
		</div>
	</div>

	<!-- MODAL STARTS HERE (EDIT CLASSRECORD) -->
	<div class="modal fade" id="editClassrecord" role="dialog">
		<div class="modal-dialog modal-lg">
		
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Edit Classrecord</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<form>
						<div class="modal-body input-group">
							<table class="table table-bordered table-hover">
								<tr>
									<th>Name</th>
									<th>Quiz 1</th>
									<th>Quiz 2</th>
									<th>Assignment 1</th>
								</tr>
								<tr>
									<td>Humphrey, Noelani O.</td>
									<td><input type="text" class="form-control"></td>
									<td><input type="text" class="form-control"></td>
									<td><input type="text" class="form-control"></td>
								</tr>
								<tr>
									<td>Byers, Tanner P.</td>
									<td><input type="text" class="form-control"></td>
									<td><input type="text" class="form-control"></td>
									<td><input type="text" class="form-control"></td>
								</tr>
								<tr>
									<td>Santana, Dean I.</td>
									<td><input type="text" class="form-control"></td>
									<td><input type="text" class="form-control"></td>
									<td><input type="text" class="form-control"></td>
								</tr>
								<tr>
									<td>Barton, Colt A.</td>
									<td><input type="text" class="form-control"></td>
									<td><input type="text" class="form-control"></td>
									<td><input type="text" class="form-control"></td>
								</tr>
								<tr>
									<td>Gutierrez, Alana N.</td>
									<td><input type="text" class="form-control"></td>
									<td><input type="text" class="form-control"></td>
									<td><input type="text" class="form-control"></td>
								</tr>
								<tr>
									<td>Horne, Wyatt S.</td>
									<td><input type="text" class="form-control"></td>
									<td><input type="text" class="form-control"></td>
									<td><input type="text" class="form-control"></td>
								</tr>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary clever-btn mb-30">Add Row</button>
							<button type="button" class="btn btn-primary clever-btn mb-30">Add Column</button>
							<button type="button" class="btn btn-success clever-btn mb-30" data-dismiss="modal">Submit</button>
							<button type="submit" class="btn btn-default clever-btn mb-30" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
		  
		</div>
	</div>

	<!-- MODAL ENDS HERE -->

	<!-- ##### Footer Area Start ##### -->
	<footer class="footer-area">
		<!-- Top Footer Area -->
		<div class="top-footer-area">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- Footer Logo -->
						<div class="footer-logo">
							<a href="index.php"><img src="img/core-img/logo2.png" alt=""></a>
						</div>
						<!-- Copywrite -->
						<p><a href="#"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
					</div>
				</div>
			</div>
		</div>

		<!-- Bottom Footer Area -->
	</footer>
	<!-- ##### Footer Area End ##### -->

	<!-- ##### All Javascript Script ##### -->
	<!-- jQuery-2.2.4 js -->
	<script src="js/jquery/jquery-2.2.4.min.js"></script>
	<!-- Popper js -->
	<script src="js/bootstrap/popper.min.js"></script>
	<!-- Bootstrap js -->
	<script src="js/bootstrap/bootstrap.min.js"></script>
	<!-- All Plugins js -->
	<script src="js/plugins/plugins.js"></script>
	<!-- Active js -->
	<script src="js/active.js"></script>
	<!-- Toggle -->
	<script src="js/bootstrap-toggle.min.js"></script>
	<script src="js/quiz.js"></script>
</body>

</html>
