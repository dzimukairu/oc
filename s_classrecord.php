<?php
	include("db_connection.php");
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$id = $_GET['subject_id'];
	$username = $_SESSION['username'];

	$sql = "SELECT subject_code, course_title, course_description, course_about, teacher_id from subject where subject_id = $id";
	
	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];

	$get_student = $dbconn->query("SELECT * from student where username = '$username';");
	$srow = mysqli_fetch_array($get_student);
	
	$s_id = $srow['student_id'];
	$s_username = $srow['username'];
	$s_firstname = $srow['first_name'];
	$s_lastname = $srow['last_name'];
	$image = $srow['image'];

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
										<a class="dropdown-toggle" href="#" role="button" id="userName" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $s_firstname." ".$s_lastname; ?></a>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userName">
											<?php 
												echo "<a href=student_home.php class='dropdown-item'>Home</a>";
												echo "<a href=s_profile.php class='dropdown-item'>Profile</a>";
												echo "<a href=logout.php class='dropdown-item'>Logout</a>";
											?>
										</div>
									</div>
								</div>
								<div class="userthumb">
									<?php 
										echo "<a href=s_profile.php><img src=img/stu-img/",urlencode($image)," style='border-radius: 50%; height: 40px; width: 40px'></a>" 
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

	<!-- ##### Breadcumb Area Start ##### -->
	<!-- <div class="breadcumb-area">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="student_home.php">Home</a></li>
				<li class="breadcrumb-item"><a href="student_course.php">Course</a></li>
				<li class="breadcrumb-item"><a href="student_quiz.php">Quizzes</a></li>
			</ol>
		</nav>
	</div> -->
	<!-- ##### Breadcumb Area End ##### -->

	<!-- ##### Single Course Intro Start ##### -->
	<!-- <section class="hero-area bg-img bg-overlay-2by5" style="background-image: url(img/bg-img/bg1.jpg);">
		<div class="container h-100">
			<div class="row h-100 align-items-center">
				<div class="col-12">
					<div class="hero-content text-center">
						<h2><?php echo $course_description;?></h2>
						<h3><?php echo $course_title;?></h3>
					</div>
				</div>
			</div>
		</div>
	</section> -->

	<div class="student-quiz-content">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-12">
					<div class="section-heading">
						<h3>Your Grades</h3>
					</div>        
			   </div>
			</div>

			<?php
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
					echo "assignment_count: ".$assignment_count;
					echo "<br>";


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
					echo "quiz_count: ".$quiz_count;
			?>

			<div class="row">
				<div class="col-12 col-lg-12">
					<table class="table table-bordered">
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
									echo "<td style='vertical-align: middle'><a href='s_assignment.php?s_id=$s_id&assignment_id=$all_ass_id[$x]'><b class='text-success'>".($x+1)."  (".$allscore[$x].")</b></a></td>";
								}
								echo "<td style='width: 140px'><b>Grades (".$totalscore.")</b></td>";
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

							echo "<th>".$s_lastname.", ".$s_firstname."</th>";
							$totalgrade = 0;
							foreach ($all_ass_id as $key) {
								$get_ans = $dbconn->query("SELECT * from answer_assignment where assignment_id = '$key' and student_id = '$s_id' ");
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
						?>
					</table>
				</div>
			</div>
			<br>
			<?php 
				echo "<a href=student_course.php?subject_id=",urlencode($id)," class='btn clever-btn'>Back</a>";
			?>
		</div>
		<br><br>
	</div>


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
