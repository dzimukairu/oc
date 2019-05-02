<?php
	require "db_connection.php";
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "";
	date_default_timezone_set("Asia/Manila");

	$username = $_SESSION['username'];

	$id = $_GET['quiz_id'];

	$sql = "SELECT subject.subject_id, subject.subject_code, subject.course_title, subject.course_description, subject.course_about, subject.teacher_id, quiz.quiz_title, quiz.date_posted, quiz.deadline_date, quiz.deadline_time, quiz.total_grade  from subject INNER JOIN quiz on (quiz.quiz_id = $id and subject.subject_id = quiz.subject_id)";

	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_id = $row['subject_id'];
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];

	$quiz_title = $row['quiz_title'];
	$deadline_date = $row['deadline_date'];
	$deadline_time = $row['deadline_time'];
	$date_posted = $row['date_posted'];
	$score = $row['total_grade'];

	$combinedtime = date('Y-m-d H:i:s', strtotime("$deadline_date $deadline_time"));
	$xdate = new DateTime($combinedtime);
	$combinedtime = date_format($xdate, 'M d, Y - h:i A');

	$get_student = $dbconn->query("SELECT * from student where username = '$username';");
	$srow = mysqli_fetch_array($get_student);
	
	$s_id = $srow['student_id'];
	$s_username = $srow['username'];
	$s_firstname = $srow['first_name'];
	$s_lastname = $srow['last_name'];
	$image = $srow['image'];


	$getIdentification = $dbconn->query("SELECT * from identification_quiz where quiz_id = '$id' ");
	$getIdenSize = mysqli_num_rows($getIdentification);

	$getMultipleChoice = $dbconn->query("SELECT * from multiplechoice_quiz where quiz_id = '$id' ");
	$getMulChoSize = mysqli_num_rows($getMultipleChoice);

	$getMultipleAnswer = $dbconn->query("SELECT * from multipleanswer_quiz where quiz_id = '$id' ");
	$getMulAnsSize = mysqli_num_rows($getMultipleAnswer);

	$getEssay = $dbconn->query("SELECT * from essay_quiz where quiz_id = '$id' ");
	$getEssaySize = mysqli_num_rows($getEssay);


	if(isset($_POST['submit_answer'])) {
		$insertAnswer = $dbconn->query("INSERT into answer_quiz(date_posted, total_grade, student_id, quiz_id) values(NOW(), -1, '$s_id', '$id')" );

		$answer_id = $dbconn->insert_id;
		$total_grade = 0;

		if ($insertAnswer) {
			$idenAnswer = $_POST['iden_quiz_answer'];
			$mcAnswer = $_POST['mc_quiz_answer'];
			$maAnswer = $_POST['ma_quiz_answer'];
			$essayAnswer = $_POST['essay_quiz_answer'];

			$count = 1;
			foreach($idenAnswer as $key => $n ) {
				$insertIdenAnswer = $dbconn->query("INSERT into answer_iden_quiz(answer_id, question_number, answer, grade) values('$answer_id', '$count', '$n', -1) ");
				$count++;
			}

			$count = 1;
			foreach($mcAnswer as $key => $n) {
				$insertMCAnswer = $dbconn->query("INSERT into answer_mc_quiz(answer_id, question_number, answer, grade) values('$answer_id', '$count', '$n', -1) ");
				$count++;
			}

			// $count = 1;
			// $maPicks = array();
			// foreach($maAnswer as $key => $n) {
			// 	$maPicks[] = $n;

			// 	foreach($maPicks as $key => $n ) {
			// 		$insertMAAnswer = $dbconn->query("INSERT into answer_ma_quiz(answer_id, question_number, answer, grade) values('$answer_id', '$count', '$n', -1) ");
			// 	}
			// 	$count++;
			// }
			
			$count = 1;
			foreach($essayAnswer as $key => $n ) {
				$insertEssayAnswer = $dbconn->query("INSERT into answer_essay_quiz(answer_id, question_number, answer, grade) values('$answer_id', '$count', '$n', -1) ");
				$count++;
			}
		}
	}
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
	<link rel="stylesheet" href="css/expand.css">
	<link rel="stylesheet" href="css/bootstrap-toggle.min.css">
	<!-- <script src="js/getdate.js"></script> -->


	<!-- https://stephanwagner.me/auto-resizing-textarea -->
	<style>
		#answerDiv {
			display: none;
		}

		#updateDiv {
			display: none;
		}
	</style>
	<script>
		function show_hide() {
			var x = document.getElementById("answerDiv");
			if (x.style.display === "block") {
				x.style.display = "none";
			} else {
				x.style.display = "block";
				x.scrollIntoView();
			} 
		}

		function show_hide_update() {
			var x = document.getElementById("updateDiv");
			if (x.style.display === "block") {
				x.style.display = "none";
			} else {
				x.style.display = "block";
			} 
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

	<!-- ##### Single Course Intro Start ##### -->
   <section class="hero-area bg-img bg-overlay-2by5" style="background-image: url(img/bg-img/bg1.jpg);">
		<div class="container h-100">
			<div class="row h-100 align-items-center">
				<div class="col-12">
					<!-- Hero Content -->
					<div class="hero-content text-center">
						<h2><?php echo $course_description;?></h2>
						<h3><?php echo $course_title;?></h3>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- ##### Single Course Intro End ##### -->

	<div class="student-quiz-content" style="margin-top: 50px">
		<div class="container">
			<div class="row">
				<div style="margin-bottom: 12px">
					<?php 
						echo "<a href=student_course.php?subject_id=",urlencode($subject_id)," class='btn clever-btn'>Back</a>";
					?>
				</div>
				<div class="col-12 col-lg-12 border rounded">
					<div style="padding: 20px 12px 50px 12px;">
						<h5><?php echo $quiz_title;?></h5>
						<br>
						<h6>Total Points: <?php echo $score ?></h6>
						<h6>Deadline: <?php echo $combinedtime ?></h6>
						<br>
						<p>
							<?php 
								$xdate = new DateTime($date_posted);
								// $x = DateTime::createFromFromat('M d, Y', $xdate);
								$y = date_format($xdate, 'M d, Y - h:i A');
								echo $y;
							?>
						</p>

						<button class='btn btn-primary clever-btn pull-right' onclick='show_hide()'>Answer</button>
					</div>
				</div>
			</div>

			<div class="row" style="margin-top:20px" id="answerDiv" name="answerDiv">
				<div class="col-12 col-lg-12 border rounded" style="padding-top: 20px; padding-bottom: 70px">
					<form method="POST">
						<div id="quizDiv" style="margin-left: 40px; padding-right: 50px">
							<?php
								if ($getIdenSize != 0) {
									echo "<h5>Identification</h5>";
									for ($i=1; $i<=$getIdenSize; $i++) {
										$getIden = $dbconn->query("SELECT * from identification_quiz where quiz_id = '$id' and question_number = '$i' ");
										$iden = mysqli_fetch_array($getIden);
										echo "<h6 style='font-weight: bold; margin-bottom: 0; margin-left: 20px;'>".$i.". ".$iden['question']." (".$iden['grade']."pts)</h6>";
							?>

										<textarea data-autoresize rows="1" cols="50" class="form-control expand_this" id="iden_quiz_answer[]" name="iden_quiz_answer[]"></textarea>
										<br>
							<?php
									} 
								}

								if ($getMulChoSize != 0) {
									echo "<br>";
									echo "<h5>Multiple Choice</h5>";
									for ($i=1; $i<=$getMulChoSize; $i++) {
										$getMC = $dbconn->query("SELECT * from multiplechoice_quiz where quiz_id = '$id' and question_number = '$i' ");
										$mc = mysqli_fetch_array($getMC);
										echo "<h6 style='font-weight: bold; margin-bottom: 0; margin-left: 20px;'>".$i.". ".$mc['question']." (".$mc['grade']."pts)</h6>";

										$getMCchoices = $dbconn->query("SELECT * from multiplechoice_choices where quiz_id = '$id' and question_number = '$i' ");
										echo "<div style='margin-left: 20px'>";
										while ($choice = mysqli_fetch_array($getMCchoices)) {
											echo "<input style='margin-left: 30px;' type='radio' name='mc_quiz_answer[]' id='mc_quiz_answer[]' value=".$choice['option'].">&nbsp;".$choice['option'];
										}
										echo "</div>";

										echo "<br>";
									} 	
								}

								if ($getMulAnsSize != 0) {
									echo "<h5>Multiple Answers</h5>";
									for ($i=1; $i<=$getMulAnsSize; $i++) {
										$getMA = $dbconn->query("SELECT * from multipleanswer_quiz where quiz_id = '$id' and question_number = '$i' ");
										$ma = mysqli_fetch_array($getMA);
										echo "<h6 style='font-weight: bold; margin-bottom: 0; margin-left: 20px;'>".$i.". ".$ma['question']." (".$ma['grade']."pts)</h6>";

										$getMAchoices = $dbconn->query("SELECT * from multipleanswer_choices where quiz_id = '$id' and question_number = '$i' ");
										echo "<div style='margin-left: 20px'>";
										while ($choice = mysqli_fetch_array($getMAchoices)) {
											echo "<input style='margin-left: 30px;' type='checkbox' name='ma_quiz_answer[]' id='ma_quiz_answer[]' value=".$choice['option'].">&nbsp;".$choice['option'];
										}
										echo "</div>";
										echo "<br>";
									} 	
								}

								if ($getEssaySize != 0) {
									echo "<h5>Essay</h5>";
									for ($i=1; $i<=$getEssaySize; $i++) {
										$getEssay = $dbconn->query("SELECT * from essay_quiz where quiz_id = '$id' and question_number = '$i' ");
										$essay = mysqli_fetch_array($getEssay);
										echo "<h6 style='font-weight: bold; margin-bottom: 0; margin-left: 20px;'>".$i.". ".$essay['question']." (".$essay['grade']."pts)</h6>";
							?>

										<textarea data-autoresize rows="1" cols="50" class="form-control expand_this" id="essay_quiz_answer[]" name="essay_quiz_answer[]"></textarea>
										<br>
							<?php
									}
								}
							?>
						</div>
						<br>
						<button class="btn btn-success pull-right" id="submit_answer" name="submit_answer">Submit Answer</button>
					</form>
				</div>
			</div>

			
		</div>
	</div>

	<?php include "footer.php"; ?>

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
	<script src="js/expand.js"></script>
</body>

</html>