<?php
	require "db_connection.php";

	$error = "";
	date_default_timezone_set("Asia/Manila");

	$id = $_GET['assignment_id'];

	if(isset($_POST['update_assignment'])){
		$new_title = ($_POST['new_title']);
		$new_instruction = ($_POST['new_instruction']);
		$new_ddate = $_POST['new_ddate'];
		$new_dtime = $_POST['new_dtime'];

		$update_query = "UPDATE assignment SET title = '$new_title', instruction = '$new_instruction', deadline_date = '$new_ddate', deadline_time = '$new_dtime' WHERE assignment_id = '$id'";
		// $update_query = "UPDATE assignment SET instruction = '$new_instruction' WHERE assignment_id = '$id'";

		if ($update_connect = mysqli_query($dbconn, $update_query)) {
			header("Location: assignment.php?assignment_id=".$id);
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
							<ul>
								<li><a href="teacher_home.php">Home</a></li>
							</ul>

							<!-- Register / Login -->
							<div class="login-state d-flex align-items-center">
								<div class="user-name mr-30">
									<div class="dropdown">
										<a class="dropdown-toggle" href="#" role="button" id="userName" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Username</a>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userName">
											<a class="dropdown-item" href="teacher_home.php">Home</a>
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
	<div class="breadcumb-area">
		<!-- Breadcumb -->
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="teacher_home.php">Home</a></li>
				<li class="breadcrumb-item"><a href="teacher_course.php">Courses</a></li>
			</ol>
		</nav>
	</div>
	<!-- ##### Breadcumb Area End ##### -->

	<!-- ##### Single Course Intro Start ##### -->
   <section class="hero-area bg-img bg-overlay-2by5" style="background-image: url(img/bg-img/bg1.jpg);">
		<div class="container h-100">
			<div class="row h-100 align-items-center">
				<div class="col-12">
					<!-- Hero Content -->
					<div class="hero-content text-center">
						<?php
							$id = $_GET['assignment_id'];
							
							$sql = "SELECT subject.subject_id, subject.subject_code, subject.course_title, subject.course_description, subject.course_about, assignment.title, assignment.instruction, assignment.date_posted, assignment.deadline_date, assignment.deadline_time  from subject INNER JOIN assignment on (assignment.assignment_id = $id and subject.subject_id = assignment.subject_id)";

							$result = mysqli_query($dbconn, $sql);
							$row = mysqli_fetch_array($result);
							
							$subject_id = $row['subject_id'];
							$subject_code = $row['subject_code']; 
							$course_title = $row['course_title'];
							$course_description = $row['course_description'];
							$course_about = $row['course_about'];

							$assignment_title = $row['title'];
							$assignment_instruction = $row['instruction'];
							$deadline_date = $row['deadline_date'];
							$deadline_time = $row['deadline_time'];
							$date_posted = $row['date_posted'];
							// $file = $row['file'];


							$combinedtime = date('Y-m-d H:i:s', strtotime("$deadline_date $deadline_time"));
							$xdate = new DateTime($combinedtime);
							$combinedtime = date_format($xdate, 'M d, Y - h:i A');
					   
						?>
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
					<div style="padding: 20px 12px 50px 12px;">
					<!-- <?php echo $id; ?> -->
						<h5><?php echo $assignment_title;?></h5>
						<br>
						<h6><?php echo $assignment_instruction;?></h6>
						<br>
						<h6>File: WALA PA GAWORK
							<?php
								// if ($file == 0) {
								// 	echo "No file found.";
								// } else {
								// 	echo "file.jpg";
								// }
							?>

						</h6>
						<br>
						<h6>Deadline: <?php echo $combinedtime ?></h6>
						<br>
						<p><?php 
							$xdate = new DateTime($date_posted);
							// $x = DateTime::createFromFromat('M d, Y', $xdate);
							$y = date_format($xdate, 'M d, Y - h:i A');
							echo $y;
						?></p>
											

						<button class="btn btn-info" data-toggle="modal" data-target="#update-assignment-modal">Update</button>
						<!-- <button class="btn btn-danger" onclick="javascript:location.href='assignment_delete.php?id=<?php echo $id;?>';">Delete</button> -->

						<button class="btn btn-danger" onclick="deleteFunction(<?php echo $id;?>)">Delete</button>

						<script>
							function deleteFunction(id) {
								var del = confirm("Do you really want to delete this assignment?");

								if (del == true) {
									document.location.href = 'assignment_delete.php?id='+id;
								}
							}
						</script>
					</div>
				</div>

				<div style="margin-top:12px;">
					<?php 
						echo "<a href=teacher_course.php?subject_id=",urlencode($subject_id)," class='btn clever-btn'>Back</a>";
					?>
				</div>
			</div>
		</div>
	</div>


	<!-- Update assignment Modal -->
	<div id="update-assignment-modal" class="modal fade" role="dialog">
		<div class="modal-dialog" style="max-width: 80% !important;">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title pull-left">Update assignment</h4>
				</div>
				<div class="modal-body">
					<form method="POST" action="assignment.php?assignment_id=<?php echo $id?>" enctype="multipart/form-data">
						<div class="offset-md-2 col-8 input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">Title:</div>
								<textarea data-autoresize rows="1" cols="80" class="form-control expand_this" id="new_title" name="new_title"><?php echo $assignment_title ?></textarea>
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

							<input type="date" name="new_ddate" id="new_ddate" value="<?php echo $today_date; ?>" min="2019-01-01" class="form-control">
							<input type="time" name="new_dtime" id="new_dtime" value="<?php echo date('H:i', time()+3600);?>" class="form-control">
						</div>
			
						<div class="offset-md-3 col-6">
							<p style="font-style: italic">Deadline time is set on <span style="font-weight: bold;"><?php echo $combinedtime ?></span>.</p>
						</div>
						<br><br>

						<div class="form-group offset-md-1 col-10">
							<label style="font-weight: bold">Instruction:</label>
							<textarea data-autoresize rows="2" class="form-control expand_this" id="new_instruction" name="new_instruction"><?php echo $assignment_instruction ?></textarea>

							<input type="file" name="sent_file" id="sent_file">
						</div>
						<br/>  
						<div class="pull-right">
							<button  class="btn btn-primary" name="update_assignment">Update</button>
							<button  class="btn btn-danger" data-dismiss="modal">Cancel</button> 
						</div>
					</form>
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
	<script src="js/expand.js"></script>
</body>

</html>