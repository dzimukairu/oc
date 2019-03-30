<?php
	require "db_connection.php";
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "<br>";
	date_default_timezone_set("Asia/Manila");

	$id = $_GET['announcement_id'];
	$s_id = $_GET['s_id'];

	$sql = "SELECT subject.subject_id, subject.subject_code, subject.course_title, subject.course_description, subject.course_about, announcement.title, announcement.content, announcement.date_posted  from subject INNER JOIN announcement on (announcement.announcement_id = $id and subject.subject_id = announcement.subject_id)";

	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_id = $row['subject_id'];
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];

	$announcement_title = $row['title'];
	$announcement_content = $row['content'];
	$date_posted = $row['date_posted'];

	$get_student = $dbconn->query("SELECT * from student where student_id = '$s_id';");
	$srow = mysqli_fetch_array($get_student);

	$s_username = $srow['username'];
	$s_firstname = $srow['first_name'];
	$s_lastname = $srow['last_name'];
	$image = $srow['image'];

	if(isset($_POST['add_comment'])){
		$content = $_POST['scomment'];
		$s_uname = $_POST['s_uname'];

		$add_comment_query = "INSERT into announcement_comment(announcement_id, username, content, date_posted) values('$id', '$s_uname', '$content', NOW())";
		if ($add_comment_connect = mysqli_query($dbconn, $add_comment_query)) {
			header("Location: s_announcement.php?s_id=".$s_id."&announcement_id=".$id);
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
		table {
			border-collapse: collapse;
		}
		tr td {
			padding: 0 !important; 
			margin: 0 !important;
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
					<div style="padding: 20px 12px 50px 12px;">
					<!-- <?php echo $id; ?> -->
						<h5><?php echo $announcement_title;?></h5>
						<br>
						<h6><?php echo $announcement_content;?></h6>
						<br>
						<p><?php 
							$xdate = new DateTime($date_posted);
							$y = date_format($xdate, 'M d, Y - h:i A');
							echo $y;
						?></p>
										
						<!-- <button class="btn btn-info" data-toggle="modal" data-target="#update-announcement-modal">Update</button>

						<button class="btn btn-danger" onclick="deleteFunction(<?php echo $id;?>)">Delete</button>

						<script>
							function deleteFunction(id) {
								var del = confirm("Do you really want to delete this announcement?");

								if (del == true) {
									document.location.href = 'announcement_delete.php?id='+id;
								}
							}
						</script> -->
					</div>
				</div>

				<div class="col-12 col-lg-12 border rounded" style="padding-top: 20px; padding-bottom: 20px;" id="announcement_comment" name="announcement_comment">
					<?php
						$comment_query= "SELECT * FROM `announcement_comment` WHERE announcement_id = $id  order by date_posted asc";
						$connect_to_db = mysqli_query($dbconn,$comment_query);
						$affected = mysqli_num_rows($connect_to_db);
																									
						if ($affected != 0) {
							while ($row = mysqli_fetch_row($connect_to_db)) {
								$get_uname = $row[2];
								$content = $row[3];
								$d_post = $row[4];

								$xdate = new DateTime($d_post);
								$show_post = date_format($xdate, 'M d, Y - h:i A');

								$student_query = $dbconn->query("SELECT * FROM student WHERE username = '$get_uname'");

								if (mysqli_num_rows($student_query) == 1) {
									$srow = mysqli_fetch_row($student_query);
									$first_name = $srow[1];
									$last_name = $srow[2];
								} else {
									$teacher_query = $dbconn->query("SELECT * FROM teacher WHERE username = '$get_uname'");

									$trow = mysqli_fetch_row($teacher_query);
									$first_name = $trow[1];
									$last_name = $trow[2];
								}
							
					?>
						<div>
							<table class="table table-borderless">
								<tr>
									<?php
										echo "<th style='width: 15%;' rowspan='2'>".$first_name." ".$last_name."</th>";
										echo "<td style='width: 85%;' colspan='3'>".$content."</td>";
									?>
								</tr>
								<tr>
									<?php
										echo "<td style='width: 85%;' colspan='3'><h7>".$show_post."</h7></td>";
									?>
								</tr>
							<?php 
								}}
							?>	

							</table>
							<br>
							<table class="table table-borderless">
								<tr>
									<th style='width: 15%;'><?php echo $s_firstname." ".$s_lastname?></th>
									<form id="form1" method="POST" action="s_announcement.php?s_id=<?php echo $s_id?>&announcement_id=<?php echo $id?>">
										<input name="s_uname" value="<?php echo $s_username; ?>" hidden>
										<td>
											<div class="input-group mb-3">
  												<textarea data-autoresize rows="1" class="form-control expand_this" name="scomment" id="scomment"></textarea>
  												<div class="input-group-append">
  													<span>&nbsp;</span>
  													<input type="reset" class="btn" value="X">
  													<span>&nbsp;</span>
    												<button class="btn btn-success" name="add_comment">Post</button>
  												</div>
											</div>
										</td>
									</form>
								</tr>
							</table>
						</div>
				</div>

				<div style="margin-top:12px;">
					<?php 
						echo "<a href=student_course.php?s_id=",urlencode($s_id),"&subject_id=",urlencode($subject_id)," class='btn clever-btn'>Back</a>";
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
	<script src="js/expand.js"></script>
</body>

</html>