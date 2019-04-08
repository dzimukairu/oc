<?php
	include('db_connection.php');

	if(isset($_POST['user_name'])) {
		$username = $_POST['user_name'];

		$checkUname = $dbconn->query("SELECT * from teacher, student where username = '$username' ");

		if (mysqli_num_rows($checkUname) > 0) {
			echo '<span class="text-danger">Username not available.</span>';
		} else {
			echo '<span class="text-success">Username is available.</span>';
		}
	}
?>