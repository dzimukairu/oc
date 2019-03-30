<?php
	include("db_connection.php");

	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "";
	date_default_timezone_set("Asia/Manila");
				
	$id = $_GET['subject_id'];
	// $id = $_SESSION['subject'];
	$sql = "SELECT subject_code, course_title, course_description, course_about, teacher_id from subject where subject_id = $id";
	
	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];

	$get_teacher = $dbconn->query("SELECT * from teacher where teacher_id = '$teacher_id' ");
	$trow = mysqli_fetch_array($get_teacher);

	$t_username = $trow['username'];
	$t_firstname = $trow['first_name'];
	$t_lastname = $trow['last_name'];
	$image = $trow['image'];

	if(isset($_POST['update_about'])){
		$new_about = ($_POST['new_about']);
		$update_query = "UPDATE subject SET course_about = '$new_about' WHERE subject_id = '$id'";
		if ($update_connect = mysqli_query($dbconn, $update_query)) {
			header("Location: teacher_course.php?subject_id=".$id);
		}
	}

	$get_pending = $dbconn->query("SELECT * from enrolls where subject_id = '$id' and status = 'pending' ");

	if(isset($_POST['add_lecture'])){
		$lecture_title = $_POST['lecture_title'];
		$target_dir = "uploads/";
		$fileName = basename($_FILES["fileToUpload"]["name"]);
		$target_files = $target_dir . $fileName;
		$fileType = pathinfo($target_files,PATHINFO_EXTENSION);

		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_files)) {
			$insert_file_query = $dbconn->query("INSERT into uploaded_files(filename, date_posted) values ('".$fileName."', NOW())");
		}

		if ($insert_file_query) {
			$file_id = $dbconn->insert_id;

			$query = $dbconn->query("INSERT into learning_materials(title, date_posted, subject_id, file_id) VALUES('$lecture_title', NOW(), '$id', '$file_id')");
			
			if ($query) {
				header("Location: teacher_course.php?subject_id=".$id);
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
	<title>Online Classroom | Course</title>

	<!-- Favicon -->
	<link rel="icon" href="img/core-img/favicon.ico">

	<!-- Stylesheet -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/expand.css">
	
	<?php
		if (mysqli_num_rows($get_pending) != 0) {
	?>
			<style>
				#pendingDiv {
					display: block;
				}
			</style>
	<?php
		} else {
	?>
			<style>
				#pendingDiv {
					display: none;
				}
			</style>
	<?php
		}
	?>

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
									<a class="nav-link" id="tab--4" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="true">Students</a>
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
											<button class="btn btn-info" data-toggle="modal" data-target="#update-about-modal"><i class="fa fa-info-circle"></i> Update About</button>
										</div>

										<!-- All Learning Materials -->
										<button type="button" class="btn clever-btn mb-30" data-toggle="modal" data-target="#upload-modal"><i class="fa fa-file"></i> Add Learning Materials</button>
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
											echo "<a href=teacher_announcement.php?subject_id=",urlencode($id)," class='btn clever-btn mb-30'><i class='fa fa-bullhorn'></i> Add Announcement</a>";
									  
											$subject_announcement_query= "SELECT * FROM `announcement` WHERE subject_id = $id order by date_posted desc";
											$connect_to_db = mysqli_query($dbconn,$subject_announcement_query);
											$affected = mysqli_num_rows($connect_to_db);
																									
											if ($affected != 0) {
												while ($row = mysqli_fetch_row($connect_to_db)) {

												$a_id = $row[0];
												echo "<a href=announcement.php?announcement_id=",urlencode($a_id),">";
													
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
												<?php echo "</a>"; } ?>
											<?php } else {
												echo "<h4>No announcements found.</h4>";
											}?>
									</div>
								</div>


								<!-- Tab Text Assignments -->
								<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab--3">
									<div class="clever-curriculum">
										<?php
											echo "<a href=teacher_assignment.php?subject_id=",urlencode($id)," class='btn clever-btn mb-30'><i class='fa fa-tasks'></i> Add Assignment</a>";

											$subject_assignment_query= "SELECT * FROM `assignment` WHERE subject_id = $id order by date_posted desc";
											$connect_to_db = mysqli_query($dbconn,$subject_assignment_query);
											$affected = mysqli_num_rows($connect_to_db);
																									
											if ($affected != 0) {
												while ($row = mysqli_fetch_row($connect_to_db)) {

												$a_id = $row[0];
												echo "<a href=assignment.php?assignment_id=",urlencode($a_id),">";
													
										?>
														<div class="about-curriculum mb-30">
															<?php 
																echo "<h5>".$row[5]."</h5>";
																echo "<h7>".$row[6]."</h7>";
																echo "<br>";
																echo "<br>";
																echo "<h7>Score: ".$row[7]."</h7>";
																echo "<br>";
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
												<?php  echo "</a>"; }  ?>
											<?php } else {
												echo "<h4>No assignments found.</h4>";
											} ?>
									</div>
								</div>

								<!-- Tab Text Students List -->
								<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab--4">
									<div class="clever-members">
										<?php
											echo "<a href=add_student.php?subject_id=",urlencode($id)," class='btn clever-btn mb-30'><i class='fa fa-user-plus'></i> Add Student</a>";
										?>

										<div class="all-instructors mb-30">
											
											<div id="pendingDiv">
												<div>
													<h6><i>Pending Students</i></h6>
												</div>
												<div class="row">
											<?php
													while ($row = mysqli_fetch_array($get_pending)) {
														$student_id = $row['student_id'];

														$get_student_query = $dbconn->query("SELECT * from student where student_id = '$student_id'");

														$student = mysqli_fetch_array($get_student_query);
													
													echo "<a href=assignment.php?assignment_id=",urlencode($student_id),">";
														
											?>
														<div class="col-lg-6">
															<div class="single-instructor d-flex align-items-center mb-30">
																<div class="instructor-thumb">
																	<?php 
																		echo "<img id='profilePic' style='border-radius: 50%; height: 80px; width: 80px' src=img/stu-img/",urlencode($student['image']),">" 
																	?>
																</div>
																<div class="instructor-info">
																	<?php 
																		echo "<h6>".$student['first_name']." ".$student['last_name']."</h6>";
																	?>
																	<button class="btn btn-primary btn-xs" onclick='addStudent("<?php echo $id; ?>", "<?php echo $student_id; ?>", "<?php echo $student['first_name']." ".$student['last_name']?>")'>
																		<a><i class='fa fa-user-plus'></i> Add Student</a>
																	</button>

																	<script>
																		function addStudent(subject_id, student_id, name) {
																			var add = confirm("Do you want to add "+ name + "?");

																			if (add == true) {
																				document.location.href = 'add_s.php?subject_id='+subject_id+'&student_id='+student_id;
																			}
																		}
																	</script>
																</div>
															</div>
														</div>
												<?php  echo "</a>"; } ?>
												</div>
											</div>

											<h6>Students List</h6>
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
																	<?php 
																		echo "<img id='profilePic' style='border-radius: 50%; height: 80px; width: 80px' src=img/stu-img/",urlencode($student['image']),">" 
																	?>
																</div>
																<div class="instructor-info">
																	<?php 
																		echo "<h6>".$student['last_name'].", ".$student['first_name']."</h6>";
																	?>
																	<!-- <?php
																		echo "<a href=del_student.php?subject_id=",urlencode($id),"&student_id=",urlencode($student_id)," class='btn text-danger'><i class='fa fa-user-times'></i> Remove</a>";
																	?> -->
																	<button class="btn btn-info btn-xs">
																		<a><i class="fa fa-comments-o"></i> Chat</a>
																	</button>
																	<button class="btn btn-danger btn-xs" onclick='delStudent("<?php echo $id; ?>", "<?php echo $student_id; ?>", "<?php echo $student['first_name']." ".$student['last_name']?>")'>
																		<a><i class='fa fa-user-times'></i> Remove</a>
																	</button>

																	<script>
																		function delStudent(subject_id, student_id, name) {
																			var del = confirm("Do you want to remove "+ name + "?");

																			if (del == true) {
																				document.location.href = 'del_student.php?subject_id='+subject_id+'&student_id='+student_id;
																			}
																		}
																	</script>
																</div>
															</div>
														</div>
												<?php  echo "</a>"; } ?>
												
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
										<?php
											echo "<a href='teacher_quiz.php' class='btn clever-btn mb-30'><i class='fa fa-file-text'></i> Add Quiz</a>";
										?>
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
							echo "<a href=classrecord.php?subject_id=",urlencode($id)," class='btn clever-btn w-100 mb-30'><i class='fa fa-table'></i> Class Record</a>";
						?>

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

						<!-- Add Learning Matrials modal -->
						<div id="upload-modal" class="modal fade" role="dialog">
							<div class="modal-dialog" style="max-width: 50% !important;">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title pull-left">Upload Learning Material</h4>
									</div>
									<div class="modal-body">
										<form method="POST" action="teacher_course.php?subject_id=<?php echo $id ?>" enctype="multipart/form-data">
											<div class="form-group">
												<div class="col-auto">
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">Lecture Title</div>
														</div>
														<textarea data-autoresize rows="1" cols="80" class="form-control expand_this" id="lecture_title" name="lecture_title"></textarea>
													</div>
													<br>
													<input type="file" name="fileToUpload">
												</div>
											</div>
											
										
												<!-- <button type="button" class="btn btn-primary" name="add_lecture">Submit</button> -->
											 &nbsp;
											<!-- <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button> -->
											<div class="pull-right">
												<input type="submit" class="btn btn-success" name="add_lecture" value="SUBMIT"/>
												<button  class="btn btn-danger" data-dismiss="modal">Cancel</button> 
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>

						<!-- Update About Modal -->
						<div id="update-about-modal" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title pull-left">Update About</h4>
									</div>
									<div class="modal-body">
										<form method="POST">
											<div class="input-group">
												<textarea data-autoresize rows="2" class="form-control expand_this" id="new_about" name="new_about"><?php echo $course_about?></textarea>
											</div> 
											<br/>  
											<div class="pull-right">
												<button  class="btn btn-primary" name="update_about">Update</button>
												<button  class="btn btn-danger" data-dismiss="modal">Cancel</button> 
											</div>
										</form>
									</div>
								</div>
							</div>
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
	<script src="js/expand.js"></script>
</body>

</html>