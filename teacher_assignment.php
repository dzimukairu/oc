<?php
	require "db_connection.php";
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}
	
	$id = $_GET['subject_id'];
	$error = '';
	$error1 = '';
	$error2 = '';
	$errorcount = true;

	date_default_timezone_set("Asia/Manila");

	$sql = "SELECT subject_code, course_title, course_description, course_about, teacher_id from subject where subject_id = $id";

	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];

	$get_teacher = $dbconn->query("SELECT username, first_name, last_name from teacher where teacher_id = '$teacher_id';");
	$trow = mysqli_fetch_array($get_teacher);

	$t_username = $trow['username'];
	$t_firstname = $trow['first_name'];
	$t_lastname = $trow['last_name'];

	if(isset($_POST['add_assignment'])) {
		$id = $_GET['subject_id'];
		$assignment_title = $_POST['assignment_title'];
		$assignment_instruction = $_POST['assignment_instruction'];
		$deadline_date = $_POST['deadline_date'];
		$deadline_time = $_POST['deadline_time'];
		$score = $_POST['score'];

		$xdate = date('m/d/Y');
		$xtime = date('H:i');

		// $combinedtime = date('Y-m-d H:i:s', strtotime("$deadline_date $deadline_time"));
		// echo $combinedtime;


		$to_time = strtotime(date('H:i:s'));
		$from_time = strtotime($deadline_time);
		// echo "<br><br>".(($to_time - $from_time) / -60). " minute";
		$timediff = (($to_time - $from_time) / -60);

		//check date if yesterday/past
		$current = strtotime(date('m/d/Y'));
		$ydate = strtotime($deadline_date);
		$datediff = $ydate - $current;
		$difference = floor($datediff/(60*60*24));

		if ($difference  < 0) {
			$error1 = 'Invalid date.';
			$errorcount = false;
		} else {
			if ($timediff < 0) {
				$error1 = 'Invalid time (Must set after the current time).<br>';
				$errorcount = false;
			} else {
				$error = '';
			}
		}

		if (empty($assignment_title) && empty($assignment_instruction)) {
			$error2 = 'Please input title and instruction.';
			$errorcount = false;
		} else if (empty($assignment_title)) {
			$error2 = 'Please input title.';
			$errorcount = false;
		} else if (empty($assignment_instruction)) {
			$error2 = 'Please input instruction.';
			$errorcount = false;
		}

		if ($errorcount > 2) {
			$error = $error1. ' '. $error2.' ';
		}

		if ($errorcount) {
			if($_FILES['fileToUpload']['size'] == 0) {
				$query = $dbconn->query("INSERT into assignment(subject_id, date_posted, deadline_date, deadline_time, title, instruction, score) VALUES('$id', NOW(), '$deadline_date', '$deadline_time', '$assignment_title', '$assignment_instruction', '$score')");
			
				if ($query) {
					header("Location: teacher_course.php?subject_id=".$id);
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

					$query = $dbconn->query("INSERT into assignment(subject_id, date_posted, deadline_date, deadline_time, title, instruction, score, file_id) VALUES('$id', NOW(), '$deadline_date', '$deadline_time', '$assignment_title', '$assignment_instruction', '$score', '$file_id')");
			
					if ($query) {
						header("Location: teacher_course.php?subject_id=".$id);
					}
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
	<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->

	<style>
		.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
		.toggle.ios .toggle-handle { border-radius: 20px; }
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
				<div class="col-12 col-lg-12">
					<div class="section-heading">
						<h3>Create New Assignment</h3>
					</div>        
			   </div>
			</div>
			<div class="row">
				<h7 class="text-danger"><?php echo $error1 ?></h7>
				<h7 class="text-danger"><?php echo $error2 ?></h7>
				
				<div class="col-12 col-lg-12 border rounded">
					<div style="padding: 20px 12px 60px 12px;">
						<form method="post" action="teacher_assignment.php?subject_id=<?php echo $id ?>" enctype="multipart/form-data">
							<div class="offset-md-2 col-8 input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">Title:</div>
									<textarea data-autoresize rows="1" cols="80" class="form-control expand_this" id="assignment_title" name="assignment_title"></textarea>
								</div>
							</div>

							<br>

							<div class="offset-md-3 col-6 input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">Deadline:</div>
								</div>
								<?php
									$month = date('m');
									$day = date('d');
									$year = date('Y');

									$today_date = $year . '-' . $month . '-' . $day;

								?>
								<input type="date" name="deadline_date" id="deadline_date" value="<?php echo $today_date; ?>" min="2019-01-01" class="form-control">
								<input type="time" name="deadline_time" id="deadline_time" value="<?php echo date('H:i', time()+3600);?>" class="form-control">
							</div>
							<div class="offset-md-3 col-6">
								<p style="font-style: italic">Deadline time is set 1 hour after of current time. (You can change it)</p>
							</div>
							<br><br>

							<div class="form-group offset-md-1 col-10">
								<label style="font-weight: bold">Instruction:</label>
								<textarea data-autoresize rows="2" class="form-control expand_this" id="assignment_instruction" name="assignment_instruction"></textarea>

								<input type="file" name="fileToUpload">
							</div>
							<div class="offset-md-3 col-6 input-group">
								<div class="input-group-text">Score:</div>
								<input type="number" pattern= "^[0–9]$" class="form-control expand_this" id="score" name="score" required>
							</div>

							<br>

							<input type="submit" class="btn btn-success pull-right" name="add_assignment" value="SUBMIT"/>
						</form>
					</div>
				</div>

				<div style="margin-top:12px;">
					<?php 
						echo "<a href=teacher_course.php?subject_id=",urlencode($id)," class='btn clever-btn'>Back</a>";
					?>
				</div>
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
	<script src="js/quiz.js"></script>
	<script src="js/expand.js"></script>
</body>

</html>