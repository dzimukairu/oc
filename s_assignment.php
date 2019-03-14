<?php
	require "db_connection.php";

	$error = "";
	date_default_timezone_set("Asia/Manila");

	$id = $_GET['assignment_id'];
	$s_id = $_GET['s_id'];
	$date = date('Y-m-d H:i:s');

	$sql = "SELECT subject.subject_id, subject.subject_code, subject.course_title, subject.course_description, subject.course_about, subject.teacher_id, assignment.title, assignment.instruction, assignment.date_posted, assignment.deadline_date, assignment.deadline_time, assignment.score, assignment.file_id  from subject INNER JOIN assignment on (assignment.assignment_id = $id and subject.subject_id = assignment.subject_id)";

	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_id = $row['subject_id'];
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];

	$assignment_title = $row['title'];
	$assignment_instruction = $row['instruction'];
	$deadline_date = $row['deadline_date'];
	$deadline_time = $row['deadline_time'];
	$date_posted = $row['date_posted'];
	$score = $row['score'];
	$file_id = $row['file_id'];

	$isFileEmpty = true;
	$fileName = "";
	if ($file_id != NULL) {
		$get_file_query = $dbconn->query("SELECT * from uploaded_files where file_id = '$file_id'");
		$frow = mysqli_fetch_array($get_file_query);

		$fileName = $frow['filename'];
		$isFileEmpty = false;
	}

	$first_time = date('Y-m-d H:i:s', strtotime("$deadline_date $deadline_time"));
	$xdate = new DateTime($first_time);
	$combinedtime = date_format($xdate, 'M d, Y - h:i A');

	$get_student = $dbconn->query("SELECT username, first_name, last_name from student where student_id = '$s_id';");
	$srow = mysqli_fetch_array($get_student);

	$s_username = $srow['username'];
	$s_firstname = $srow['first_name'];
	$s_lastname = $srow['last_name'];

	$get_answer_query = $dbconn->query("SELECT * from answer_assignment where student_id = '$s_id' and assignment_id = '$id'");
	$a_row = mysqli_fetch_array($get_answer_query);
	$answer_id = $a_row['id'];
	$content = $a_row['content'];
	$a_file_id = $a_row['file_id'];
	$grade = $a_row['grade'];

	$is_a_FileEmpty = true;
	$a_fileName = "";
	if ($a_file_id != NULL) {
		$get_file_query = $dbconn->query("SELECT * from uploaded_files where file_id = '$a_file_id'");
		$frow = mysqli_fetch_array($get_file_query);

		$a_fileName = $frow['filename'];
		$is_a_FileEmpty = false;
	}


	if (isset($_POST['pass_assignment'])) {
		$answer_content = $_POST['answer_content'];

		if($_FILES['fileToUpload']['size'] == 0) {
			$query = $dbconn->query("INSERT into answer_assignment(content, date_posted, student_id, assignment_id) VALUES('$answer_content', NOW(), '$s_id', '$id')");
			
			if ($query) {
				header("Location: s_assignment.php?s_id=".$s_id."&assignment_id=".$id);
			}
		} else {
			$target_dir = "uploads/";
			$fileName = basename($_FILES["fileToUpload"]["name"]);
			$target_files = $target_dir . $fileName;
			$fileType = pathinfo($target_files,PATHINFO_EXTENSION);

			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_files)) {
				$insert_file_query = $dbconn->query("INSERT into uploaded_files(filename, date_posted) values ('".$fileName."', NOW())");
			}

			if ($insert_file_query) {
				$file_id = $dbconn->insert_id;

				$query = $dbconn->query("INSERT into answer_assignment(content, date_posted, student_id, assignment_id, file_id) VALUES('$answer_content', NOW(), '$s_id', '$id', '$file_id')");
			
				if ($query) {
					header("Location: s_assignment.php?s_id=".$s_id."&assignment_id=".$id);
				}
			}
		}
	}

	if (isset($_POST['update_assignment'])) {
		$new_answer_content = $_POST['new_answer_content'];
		$a_id = $_POST['a_id'];

		if($_FILES['fileToUpdate']['size'] == 0) {
			$query = $dbconn->query("UPDATE answer_assignment set content = '$new_answer_content', date_posted = NOW() where id = '$a_id' ");
			
			if ($query) {
				header("Location: s_assignment.php?s_id=".$s_id."&assignment_id=".$id);
			}
		} else {
			$target_dir = "uploads/";
			$ufileName = basename($_FILES["fileToUpdate"]["name"]);
			$target_files = $target_dir . $ufileName;
			$fileType = pathinfo($target_files,PATHINFO_EXTENSION);

			if (move_uploaded_file($_FILES["fileToUpdate"]["tmp_name"], $target_files)) {
				$insert_file_query = $dbconn->query("UPDATE uploaded_files set filename = '$ufileName' where file_id = '$a_file_id' ");
			}

			if ($insert_file_query) {
				$file_id = $dbconn->insert_id;

				$query = $dbconn->query("UPDATE answer_assignment set content = '$new_answer_content', date_posted = NOW() where id = '$a_id'");
			
				if ($query) {
					header("Location: s_assignment.php?s_id=".$s_id."&assignment_id=".$id);
				}
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
	<script src="js/getdate.js"></script>


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
												echo "<a href=student_home.php?student_id=",urlencode($s_id)," class='dropdown-item'>Home</a>";
											?>
											<a class="dropdown-item" href="#">Profile</a>
											<a class="dropdown-item" href="index.php">Logout</a>
										</div>
									</div>
								</div>
								<div class="userthumb">
									<img src="img/bg-img/t1.png" alt="">
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
				<li class="breadcrumb-item"><a href="teacher_home.php">Home</a></li>
				<li class="breadcrumb-item"><a href="teacher_course.php">Courses</a></li>
			</ol>
		</nav>
	</div> -->
	<!-- ##### Breadcumb Area End ##### -->

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

	<div class="student-quiz-content section-padding-100">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-12 border rounded">
					<div style="padding: 20px 12px 60px 12px;">
						<h5><?php echo $assignment_title;?></h5>
						<br>
						<h6><?php echo $assignment_instruction;?></h6>
						<h6>Points: <?php echo $score ?></h6>
						<br>
						<h6>File:
							<?php
								if ($isFileEmpty == false) {
									echo $fileName;
									echo "&nbsp&nbsp";
									?> 
									<a href='uploads/<?php echo $fileName ?>'>(<i class='fa fa-download'></i> Download)</a>
									<?php
								} else {
									echo "No Uploaded File";
								}
							?>
						</h6>
						<br>
						<h6>Deadline: <?php echo $combinedtime ?></h6>
						<br>
						<p>
							<?php 
								$xdate = new DateTime($date_posted);
								$y = date_format($xdate, 'M d, Y - h:i A');
								echo $y;
							?>
						</p>
						<p style="font-style: italic;">Note: Button will be disabled once past deadline.</p>

						<?php 
							if (strtotime($date) > strtotime($first_time)) { ?>
								<button class='btn btn-primary clever-btn pull-right' onclick='show_hide()' disabled>Answer</button>
							<?php
							} else { ?>
								<button class='btn btn-primary clever-btn pull-right' onclick='show_hide()'>Answer</button>
							<?php
							}
						?>
					</div>
				</div>

				<div class="col-12 col-lg-12 border rounded" style="padding-top: 20px; padding-bottom: 20px">
					<div style="padding-left: 80px; padding-right: 80px;">
						<h6>Your Work:</h6>
						<div>
							<p><?php echo $content; ?></p>
							
							<?php
								if ($is_a_FileEmpty == false) {
									echo "File: ".$a_fileName;
									echo "&nbsp&nbsp";
									?> 
									<a href='uploads/<?php echo $a_fileName ?>'>(<i class='fa fa-download'></i> Download)</a>
									<?php
								}
							?>

							<br><br>
							<h7>Your Grade:
								<?php 
									if ($grade == NULL) {
										echo "<i>Not graded yet.</i>";
									} else {
										echo "<b>".$grade."/".$score."</b>";
									}

								?>
							</h7>
						</div>
						<?php 
							if (strtotime($date) > strtotime($first_time)) { ?>
								<button class='btn btn-info pull-right' onclick='show_hide_update()' disabled>Update</button>
							<?php
							} else { ?>
								<button class='btn btn-info pull-right' onclick='show_hide_update()'>Update</button>
							<?php
							}
						?>
					</div>
				</div>
			</div>

			<div class="row" style="margin-top:20px" id="answerDiv" name="answerDiv">
				<div class="col-12 col-lg-12 border rounded" style="padding-top: 20px; padding-bottom: 70px">
					<div style="padding-left: 80px; padding-right: 80px;">
						<h6>Your Answer:</h6>

						<div>
							<form method="POST" enctype="multipart/form-data">
								<textarea data-autoresize rows="1" cols="80" class="form-control expand_this" id="answer_content" name="answer_content"></textarea>
								<input type="file" name="fileToUpload">

								<br><br>
								<input type="submit" class="btn btn-success pull-right" name="pass_assignment" value="SUBMIT"/>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="row" style="margin-top:20px" id="updateDiv" name="updateDiv">
				<div class="col-12 col-lg-12 border rounded" style="padding-top: 20px; padding-bottom: 70px">
					<div style="padding-left: 80px; padding-right: 80px;">
						<h6>Update Your Answer:</h6>

						<div>
							<form method="POST" enctype="multipart/form-data">
								<input type="text" value="<?php echo $answer_id; ?>" name="a_id" hidden>
								<textarea data-autoresize rows="1" cols="80" class="form-control expand_this" id="new_answer_content" name="new_answer_content"><?php echo $content;?></textarea>
								<input type="file" name="fileToUpdate">

								<br><br>
								<input type="submit" class="btn btn-success pull-right" name="update_assignment" value="UPDATE"/>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="row" style="margin-top:20px">
				<?php 
					echo "<a href=student_course.php?s_id=",urlencode($s_id),"&subject_id=",urlencode($subject_id)," class='btn clever-btn'>Back</a>";
				?>
			</div>
		</div>
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
	<script src="js/expand.js"></script>
</body>

</html>