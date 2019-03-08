<?php
	include('db_connection.php');

	$error = "<br>";

	$id = $_GET['subject_id'];
	$sql = "SELECT subject_code, course_title, course_description, course_about, teacher_id from subject where subject_id = '$id'";
	
	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	// $subject_code = $row['subject_code']; 
	// $course_title = $row['course_title'];
	// $course_description = $row['course_description'];
	// $course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];

	$get_teacher = $dbconn->query("SELECT username, first_name, last_name from teacher where teacher_id = '$teacher_id';");
	$trow = mysqli_fetch_array($get_teacher);

	$t_username = $trow['username'];
	$t_firstname = $trow['first_name'];
	$t_lastname = $trow['last_name'];
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
	<title>Online Classroom | Home</title>

	<!-- Favicon -->
	<link rel="icon" href="img/core-img/favicon.ico">

	<!-- Stylesheet -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/expand.css">

	<!-- <script type="text/javascript">
		$(document).ready(function() {
			$("#find_subject").click(function() {
				$.ajax({
					type: "GET",
					url: "s_show_subject.php",
					dataType: "html",
					success: function(response){
						$("#subject-list").html(response);
					}
				});
			});
		});
	</script> -->

</head>

<body>
	<!-- Preloader -->
	<div id="preloader">
		<div class="spinner"></div>
	</div>

	<!-- ##### Header Area Start ##### -->
	<header class="header-area">

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
							<div class="login-state d-flex align-items-center">
								<div class="user-name mr-30">
									<div class="dropdown">
										<a class="dropdown-toggle" href="#" role="button" id="userName" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $t_firstname." ".$t_lastname; ?></a>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userName">
											<?php 
												echo "<a href=teacher_home.php?teacher_id=",urlencode($teacher_id)," class='dropdown-item'>Home</a>";
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

						</div>
						<!-- Nav End -->
					</div>
				</nav>
			</div>
		</div>
	</header>
	<!-- ##### Header Area End ##### -->

	<!-- ##### List of Subjects ##### -->
	
	<div class="announcement-page-area section-padding-100">
		<div class="container">
			<div class="col-12">
				<div class="section-heading">
					<h3>ADD STUDENT</h3>
				</div>
			</div>
			<div class="page-content">
				<h7 class="text text-danger"><?php echo $error;?></h7>
				<form method="GET">
					<div class="input-group mb-3">
						<input value="<?php echo $id ?>" name="subject_id" hidden>
  						<input type="text" name="search" class="form-control" placeholder="Student Name/Username">
  						<div class="input-group-append">
  							<span>&nbsp;</span>
  							<input type="reset" class="btn" value="X">
  							<span>&nbsp;</span>
    						<button  type="submit" class="btn btn-success" name="find_student"><i class="fa fa-search"></i> Find</button>
  						</div>
					</div>
				</form>

				<div id="student-list">
					<?php
						if (isset($_GET['find_student'])) {
							$subject_id = $_GET['subject_id'];
							$search = $_GET['search'];

							$check_stu = $dbconn->query("SELECT * from student where (username = '$search') or (first_name like '%$search%') or (last_name like '%$search%')");
							$result = mysqli_num_rows($check_stu);

							if ($result == 0) {
								echo "No students found.";
							} else {
								// $check = $dbconn->query("SELECT subject_id from enrolls where student_id = '$student_id'");

								// $all_enrolled_subjects = array();

								// while ($sub = mysqli_fetch_array($check)) {
								// 	$all_enrolled_subjects[] = $sub['subject_id'];
								// }
					?>
								<table class="table">
									<tr>
										<th>First Name</th>
										<th>Last Name</th>
										<th>Username</th>
										<th>Action</th>
									</tr>
									<?php 
										while($row = mysqli_fetch_array($check_stu)) {
											$student_id = $row['student_id'];

											$check = $dbconn->query("SELECT subject_id from enrolls where student_id = '$student_id'");

											$all_enrolled_subjects = array();

											while ($sub = mysqli_fetch_array($check)) {
												$all_enrolled_subjects[] = $sub['subject_id'];
											}
									?>
									<tr>
										<td><?php echo $row['first_name']; ?></td>
										<td><?php echo $row['last_name']; ?></td>
										<td><?php echo $row['username']; ?></td>
										<td>
											<?php 
												if (in_array($subject_id, $all_enrolled_subjects)) {
													echo "Enrolled";
												} else {
											?>
											<button class="btn" onclick='addStudent("<?php echo $subject_id; ?>", "<?php echo $student_id; ?>")'><i class="fa fa-plus"></i></button>
										<?php } ?>
										</td>

										<script>
											function addStudent(subject_id, student_id) {
												var add = confirm("Is this the right student you want to add?");

												if (add == true) {
													document.location.href = 'add_stu.php?subject_id='+subject_id+'&student_id='+student_id;
												}
											}
										</script>
									</tr>
								<?php } ?>
								</table>

								<?php
							}
						}
						
					?>
				</div>
			</div>
			<br>
			<?php 
				echo "<a href=teacher_course.php?subject_id=",urlencode($id)," class='btn clever-btn'>Back</a>";
			?> 
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

	<script src="js/code.js"></script>
</body>

</html>

