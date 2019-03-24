<?php
	include("db_connection.php");
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "";
	date_default_timezone_set("Asia/Manila");

	$id = $_GET['subject_id'];
	$s_id = $_GET['s_id'];

	$sql = "SELECT subject_code, course_title, course_description, course_about from subject where subject_id = $id";
	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];

	$get_student = $dbconn->query("SELECT username, first_name, last_name from student where student_id = '$s_id';");
	$srow = mysqli_fetch_array($get_student);

	$s_username = $srow['username'];
	$s_firstname = $srow['first_name'];
	$s_lastname = $srow['last_name'];
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
	<title>Online Classroom | Course</title>

	<!-- Favicon -->
	<link rel="icon" href="img/core-img/favicon.ico">

	<!-- Stylesheet -->
	<link rel="stylesheet" href="style.css">

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

	<!-- ##### Courses Content Start ##### -->
	<div class="single-course-content section-padding-100">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-8">
					<div class="course--content">
						<div class="clever-tabs-content">
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="tab--1" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="false">Main</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab--2" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="true">Announcement</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab--3" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="true">Assignment</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab--5" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="true">Quiz</a>
								</li>   
								<li class="nav-item">
									<a class="nav-link" id="tab--4" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="true">Members</a>
								</li>
							</ul>

							<div class="tab-content" id="myTabContent">
								<!-- Tab Text About Class-->
								<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab--1">
									<div class="clever-description">

										<!-- About Course -->
										<div class="about-course mb-30">
											<?php
												echo "<h5>Subject Code: ".$subject_code."</h5>";
												echo "<br>";
											?>
											<h6>About this course</h6>
											<p><?php echo $course_about; ?></p>
										</div>

										<!-- All Learning Materials -->
										<button type="button" class="btn clever-btn mb-30" data-toggle="modal" data-target="#upload-modal" hidden>Add Learning Materials</button>
										<div class="all-instructors mb-30">
											<h4>Learning Materials</h4>
											<div class="row">
												<div class="col-lg-6">
													<?php
														$get_lecture_id = $dbconn->query("SELECT * from learning_materials where subject_id = '$id'");

														if (mysqli_num_rows($get_lecture_id) == 0) {
															echo "<h5>No Uploaded File/s.</h5>";
														} else {
															while ($row = mysqli_fetch_array($get_lecture_id)) {
																$f_id = $row['file_id'];
																$f_title = $row['title'];

																$get_file = $dbconn->query("SELECT * from uploaded_files where file_id = '$f_id'");
																$frow = mysqli_fetch_array($get_file);
																$f_name = $frow['filename']

																?>
																<h6>
																	<?php echo $f_title?>
																	<a href='uploads/<?php echo $f_name ?>'>(<i class='fa fa-download'></i> Download)</a>
																<h6>

																<?php

															}
														}
													?>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Tab Text Announcements -->
								<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab--2">
									<div class="clever-curriculum">
										<?php
											echo "<a href=teacher_announcement.php?subject_id=",urlencode($id)," class='btn clever-btn mb-30' hidden><i class='fa fa-bullhorn'></i> Add Announcement</a>";
									  
											$subject_announcement_query= "SELECT * FROM `announcement` WHERE subject_id = $id order by date_posted desc";
											$connect_to_db = mysqli_query($dbconn,$subject_announcement_query);
											$affected = mysqli_num_rows($connect_to_db);
																									
											if ($affected != 0) {
												while ($row = mysqli_fetch_row($connect_to_db)) {

												$a_id = $row[0];
												echo "<a href=s_announcement.php?s_id=",urlencode($s_id),"&announcement_id=",urlencode($a_id),">";
													
										?>
														<div class="about-curriculum mb-30">
															<?php 
																echo "<h5>".$row[3]."</h5>";
																echo "<h7>".$row[4]."</h7>";

																$xdate = new DateTime($row[2]);
																$y = date_format($xdate, 'M d, Y - h:i A');
																echo "<br><br><br>";
																echo "<p>".$y."</p>";
															?>
														</div>
												<?php } ?>
											<?php } else {
												echo "<h4>No announcements found.</h4>";
											}?>
									</div>
								</div>


								<!-- Tab Text Assignments -->
								<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab--3">
									<div class="clever-curriculum">
										<?php
											echo "<a href=teacher_assignment.php?subject_id=",urlencode($id)," class='btn clever-btn mb-30' hidden>Add Assignment</a>";

											$subject_assignment_query= "SELECT * FROM `assignment` WHERE subject_id = $id order by date_posted desc";
											$connect_to_db = mysqli_query($dbconn,$subject_assignment_query);
											$affected = mysqli_num_rows($connect_to_db);
																									
											if ($affected != 0) {
												while ($row = mysqli_fetch_row($connect_to_db)) {

												$a_id = $row[0];
												echo "<a href=s_assignment.php?s_id=",urlencode($s_id),"&assignment_id=",urlencode($a_id),">";
													
										?>
														<div class="about-curriculum mb-30">
															<?php 
																echo "<h5>".$row[5]."</h5>";
																echo "<h7>".$row[6]."</h7>";
																echo "<br>";

																$combinedtime = date('Y-m-d H:i:s', strtotime("$row[3] $row[4]"));
																$xdate = new DateTime($combinedtime);
																$combinedtime = date_format($xdate, 'M d, Y - h:i A');
																echo "<h7>Deadline: ".$combinedtime."</h7>";

																$xdate = new DateTime($row[2]);
																$y = date_format($xdate, 'M d, Y - h:i A');
																echo "<br><br><br>";
																echo "<p>".$y."</p>";
																
															?>
														</div>
												<?php } ?>
											<?php } else {
												echo "<h4>No assignments found.</h4>";
											} ?>
									</div>
								</div>

								<!-- Tab Text Students List -->
								<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab--4">
									<div class="clever-members">
										<?php
											echo "<a href=add_student.php?subject_id=",urlencode($id)," class='btn clever-btn mb-30' hidden><i class='fa fa-user-plus'></i> Add Student</a>"; 
										?>

										<div class="all-instructors mb-30">
											<div class="row">
												<h6>Teacher</h6>
											</div>

											<?php
												$get_teacher_id_query = $dbconn->query("SELECT teacher_id from subject where subject_id = '$id' ");
												$row = mysqli_fetch_array($get_teacher_id_query);
												$teacher_id = $row['teacher_id'];

												$get_teacher_query = $dbconn->query("SELECT * from teacher where teacher_id = '$teacher_id' ");
												$teacher = mysqli_fetch_array($get_teacher_query);
											?>

											<div class='row'>
												<div class="col-lg-offset-3 col-lg-6">
													<div class="single-instructor d-flex align-items-center mb-30">
														<div class="instructor-thumb">
															<img src="img/bg-img/t1.png" alt="">
														</div>
														<div class="instructor-info">
															<?php 
																echo "<h6>".$teacher['first_name']." ".$teacher['last_name']."</h6>";
															
															?>
															<button class="btn btn-info">
																<a><i class="fa fa-comments-o"></i> Chat</a>
															</button>

														</div>
														<br>
													</div>
												</div>
											</div>

											<div class="row">
												<h6>Students List</h6>
											</div>

											<div class="row">
											<?php
												$get_student_id = $dbconn->query("SELECT student_id FROM enrolls WHERE subject_id = '$id' and status = 'enrolled' ");
												$affected = mysqli_num_rows($get_student_id);
																										
												if ($affected != 0) {
													$all_stu_id = array();
													while ($row = mysqli_fetch_array($get_student_id)) {
														$all_stu_id[] = $row['student_id'];
													}

													$all_lastname = array();
													foreach ($all_stu_id as $sid) {
														$get_lastname = $dbconn->query("SELECT * from student where student_id = '$sid' ");
														$ln = mysqli_fetch_array($get_lastname);
														$lastname = $ln['last_name'];
														$all_lastname[] = $lastname;
													}

													$sorted_ln = $all_lastname;
													sort($sorted_ln);

													foreach ($sorted_ln as $ln) {
														$get_student_query = $dbconn->query("SELECT * from student where last_name = '$ln'");

														$student = mysqli_fetch_array($get_student_query);
														$student_id = $student['student_id'];
											?>
														<div class="col-lg-6">
															<div class="single-instructor d-flex align-items-center mb-30">
																<div class="instructor-thumb">
																	<img src="img/bg-img/t1.png" alt="">
																</div>
																<div class="instructor-info">
																	<?php 
																		echo "<h6>".$student['last_name'].", ".$student['first_name']."</h6>";
																
																		echo "<a href=del_student.php?subject_id=",urlencode($id),"&student_id=",urlencode($student_id)," class='btn text-danger' hidden><i class='fa fa-user-times'></i> Remove</a>";

																		if ($student_id == $s_id) {
																			echo "<h7><i>(You)</i></h7>";
																		}
																	?>
																</div>
															</div>
														</div>
												<?php } ?>
											<?php } else {
												echo "<h4>No students found.</h4>";
											} ?>
											</div>
										</div>
									</div>
								</div>

								<!-- Tab Text Quizzes -->
								<div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab--5">
									<div class="clever-review">
										<a href="teacher_quiz.php" class="btn clever-btn mb-30" hidden>Add Quiz</a>
										<!-- Quiz -->
										<div class="about-review mb-30">
											<h4>Quizzes Given</h4>
											<p>Sed elementum lacus a risus luctus suscipit. Aenean sollicitudin sapien neque, in fermentum lorem dignissim a. Nullam eu mattis quam. Donec porttitor nunc a diam molestie blandit. Maecenas quis ultrices</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-4">
					<div class="course-sidebar">
						<!-- Class Record -->
						<?php 
							echo "<a href=s_classrecord.php?s_id=",urlencode($s_id),"&subject_id=",urlencode($id)," class='btn clever-btn w-100 mb-30'><i class='fa fa-table'></i> Your Grades</a>";
						?>

						<!-- <?php
							echo "<h4>Subject Code: ".$subject_code."</h4>";
							echo "<br>";
						?> -->

						<!-- Widget -->
						<div class="sidebar-widget">
							<h4>Submitted Works</h4>
							<ul class="features-list">
								<li>
									<a href="#"><h6><i class="fa" aria-hidden="true"></i>Assignment</h6></a>
								</li>
								<li>
									<a href="#"><h6><i class="fa" aria-hidden="true"></i>Quizzes</h6></a>
								</li>
							</ul>
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>

   
	<!-- ##### Courses Content End ##### -->

	<!-- ##### Footer Area Start ##### -->
	<footer class="footer-area">
		<!-- Top Footer Area -->
		<div class="top-footer-area">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- Footer Logo -->
						<div class="footer-logo">
							<a href="index.html"><img src="img/core-img/logo2.png" alt=""></a>
						</div>
						<!-- Copywrite -->
						<p><a href="#"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
					</div>
				</div>
			</div>
		</div>
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
</body>

</html>