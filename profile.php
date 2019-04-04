<?php
	include('db_connection.php');
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "<br>";

	$username = $_SESSION['username'];
	$sql = $dbconn->query("SELECT * from teacher where username = '$username'");
	
	$trow = mysqli_fetch_array($sql);

	$id = $trow['teacher_id'];
	$t_username = $trow['username'];
	$t_firstname = $trow['first_name'];
	$t_lastname = $trow['last_name'];
	$image = $trow['image'];

	if(isset($_POST['updateImage'])) {
		$profileName = $t_username.'-'.$_FILES['profileImage']['name'];
		$target = 'img/tea-img/' . $profileName;

		if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target)) {
			$updatePhoto = $dbconn->query("UPDATE teacher set image = '$profileName' where username = '$t_username' ");

			if ($updatePhoto) {
				$message = "Success";
				echo "<script type='text/javascript'>alert('$message');</script>";
				header("Refresh:0");
			} else {
				$message = "Error";
				echo "<script type='text/javascript'>alert('$message');</script>";
				header("Refresh:0");
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
	<title>Online Classroom | Home</title>

	<!-- Favicon -->
	<link rel="icon" href="img/core-img/favicon.ico">

	<!-- Stylesheet -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/expand.css">

	<style>
		#updateImage {
			display: none;
		}
	</style>

	<script>
		function triggerClick() {
			document.querySelector('#profileImage').click();
		}

		function displayImage(e) {
			if (e.files[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {
					document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
				}
				reader.readAsDataURL(e.files[0]);
				document.querySelector('#updateImage').style.display = "block";
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

						</div>
						<!-- Nav End -->
					</div>
				</nav>
			</div>
		</div>
	</header>
	<!-- ##### Header Area End ##### -->

	<!-- ##### List of Subjects ##### -->
	
	<div class="announcement-page-area" style="padding-bottom: 20px">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8 border rounded" style="padding: 20px 20px">
					<div class="row justify-content-center" style="padding: 30px 12px">
						<div class="col-md-6">
							<div class="container" id="imgContainer">
								<form method="post" enctype="multipart/form-data">
									<div class="form-group text-center">
										<?php 
											echo "<img id='profileDisplay' style='border-radius: 50%; height: 300px; width: 300px; cursor: pointer;' src=img/tea-img/",urlencode($image)," onclick='triggerClick()'>" 
										?>
										<br><br>
										<label for="profileImage"><h5><b>Profile Image</b></h5></label>
										<br>
										<i>(Note: Click image to change it.)</i>
										<input type="file" name="profileImage" onchange="displayImage(this)" id="profileImage" style="display: none;" accept="image/*">
									</div>
									<button type="submit" name="updateImage" id="updateImage" class="btn btn-info btn-block">Update Image</button>
								</form>
							</div>
						</div>
					</div>
					<div class="row justify-content-center" style="padding-bottom: 12px" >
						<div class="col-md-6" id="previewDiv">
							<h6>Name: <?php echo $t_firstname." ".$t_lastname; ?></h6>
							<h6>Username: <?php echo $t_username; ?></h6>
						</div>
					</div>
					<!-- <button class="btn btn-info pull-right" onclick="toggleDiv()" id="toggleButton">Update</button> -->
				</div>		
			</div>
			<br>
			<?php 
				echo "<a href=teacher_home.php class='btn clever-btn'>Home</a>";
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

