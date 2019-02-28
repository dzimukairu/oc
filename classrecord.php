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
				<li class="breadcrumb-item"><a href="student_home.php">Home</a></li>
				<li class="breadcrumb-item"><a href="student_course.php">Course</a></li>
				<li class="breadcrumb-item"><a href="student_quiz.php">Quizzes</a></li>
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
						<!-- ##### Example: Management System ##### -->
						<h2>Course Description</h2>
						<!-- ##### Example: CMSC 152 ##### -->
						<h3>Course Title</h3>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="student-quiz-content section-padding-100">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-12">
					<div class="section-heading">
						<h3>Class Record</h3>
					</div>        
			   </div>
			</div>
			<div class="row">
				<div class="col-12 col-lg-12">
					<table class="table table-bordered table-hover">
						<tr>
							<th>Name</th>
							<th>Quiz 1</th>
							<th>Quiz 2</th>
							<th>Assignment 1</th>
							<th>Total Score</th>
							<th>Percentage</th>
						</tr>
						<tr>
							<td>Humphrey, Noelani O.</td>
							<td>6</td>
							<td>7</td>
							<td>9</td>
							<td>30</td>
							<td>99.9%</td>
						</tr>
						<tr>
							<td>Byers, Tanner P.</td>
							<td>4</td>
							<td>1</td>
							<td>2</td>
							<td>30</td>
							<td>99.9%</td>
						</tr>
						<tr>
							<td>Santana, Dean I.</td>
							<td>10</td>
							<td>4</td>
							<td>5</td>
							<td>30</td>
							<td>99.9%</td>
						</tr>
						<tr>
							<td>Barton, Colt A.</td>
							<td>2</td>
							<td>10</td>
							<td>7</td>
							<td>30</td>
							<td>99.9%</td>
						</tr>
						<tr>
							<td>Gutierrez, Alana N.</td>
							<td>10</td>
							<td>9</td>
							<td>7</td>
							<td>30</td>
							<td>99.9%</td>
						</tr>
						<tr>
							<td>Horne, Wyatt S.</td>
							<td>1</td>
							<td>8</td>
							<td>4</td>
							<td>30</td>
							<td>99.9%</td>
						</tr>
					</table>
				</div>
			</div>
			<a href="teacher_course.php" class="btn btn-primary pull-right clever-btn mb-30">Back</a>
			<button type="button" class="btn btn-primary pull-right clever-btn mb-30" data-toggle="modal" data-target="#editClassrecord" style="margin-right: 5px;">Edit</button>
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
