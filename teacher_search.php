<?php
	require "db_connection.php";

	$id = $_GET['teacher_id'];

	$get_teacher = $dbconn->query("SELECT username, first_name, last_name from teacher where teacher_id = '$id';");
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
												echo "<a href=teacher_home.php?teacher_id=",urlencode($id)," class='dropdown-item'>Home</a>";
											?>
											<a class="dropdown-item" href="#">Profile</a>
											<?php 
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

						</div>
						<!-- Nav End -->
					</div>
				</nav>
			</div>
		</div>
	</header>
	<!-- ##### Header Area End ##### -->

	<!-- ##### List of Subjects ##### -->
	
	<section>
		<div class="container">
			<?php
				echo "<a href=student_home.php?student_id=",urlencode($id)," class='btn btn-primary clever-btn'>Back</a>";
			?>
			<div class="row">

				<?php 

				if (isset($_GET['find_subject'])) {
						$search = $_GET['search'];

						$check_sub = $dbconn->query("SELECT * from subject where (course_title like '%$search%')");
						$result = mysqli_num_rows($check_sub);

						if ($result == 0) {
							echo "<h4>No subjects found.</h4>";
						} else {
						$subject_list_query= "SELECT * FROM `subject` where teacher_id='$id' and (course_title like '%$search%')"
							;
						$connect_to_db = mysqli_query($dbconn,$subject_list_query);
						$affected = mysqli_num_rows($connect_to_db);
								
						if ($affected != 0) {
							while ($row = mysqli_fetch_row($connect_to_db)) {?>
								<div class="col-12 col-md-6 col-lg-4">
									<div class="single-student-subject mb-100 wow fadeInUp" data-wow-delay="250ms">
										<form method="post">
										   <img src="img/bg-img/c1.jpg" alt="">
										<!-- Course Content -->
											<div class="course-content">
												<?php echo "<a href='teacher_course.php?s_id=".$id."&subject_id=".$row[0]."'><h4>$row[2]</h4></a>"; ?>
												<div class="meta d-flex align-items-center">
													<h7><b><?php echo $row[3]?></b></h7>
												</div>
											</div> 
										</form>
									</div>
								</div>
							<?php } ?>
						<?php } 
						}
					}?>
			</div>
		</div>
	</section>

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
						<p><a href="#">Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0.
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