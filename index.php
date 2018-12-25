<?php
    include('db_connection.php');

    $error = '<br>';
    $error2 = '<br>';

    //for creating account
    if(isset($_POST['register']) ) {

        $first_name = ($_POST['first_name']);
        $last_name = ($_POST['last_name']);
        $username = ($_POST['username']);
        $email = ($_POST['email']);
        $pwd = ($_POST['pwd']);
        $retype_pwd = ($_POST['retype_pwd']);
        $type = ($_POST['type']);
        

        //checks if the input fields are empty
        if (empty($first_name)|empty($last_name)|empty($username)|empty($email)|empty($pwd)|empty($retype_pwd)|empty($type) ) {
            $error2= 'Please fillup all the fields below';
        }

        //checks if the password matched
        if($_POST['pwd']!=$_POST['retype_pwd']){
            $error2= 'Password does not match';
        }


        //teacher registration
        if ($type == 1){
            $checkUserQuery_teacher = "SELECT username from teacher  WHERE username = '$username'";
            $dupUserRes_teacher = mysqli_query($dbconn,$checkUserQuery_teacher);
            $affected_rows_teacher = mysqli_num_rows($dupUserRes_teacher);
            if ($affected_rows_teacher != 0) {
                $error2="username already taken";
            }
            else{
                $query= "INSERT into teacher(first_name, last_name, username, email_address, password) VALUES('$first_name','$last_name', '$username', '$email', sha1($pwd) )";
                if($result = mysqli_query($dbconn, $query)){
                    $_SESSION['username'] = $username;
                    header("Location: teacher_home.php");
                }
            }  
        }

        //student_registration
        if ($type == 0){
            $checkUserQuery_student = "SELECT username from student  WHERE username = '$username'";
            $dupUserRes_student = mysqli_query($dbconn,$checkUserQuery_student);
            $affected_rows_student = mysqli_num_rows($dupUserRes_student);
            if ($affected_rows_student != 0) {
                $error2="username already taken";
            }
            else{
                $query_student= "INSERT into student(first_name, last_name, username, email_address, password) VALUES('$first_name','$last_name', '$username', '$email', sha1($pwd) )";
                if($result2 = mysqli_query($dbconn, $query_student)){
                    $_SESSION['username'] = $username;
                    header("Location: student_home.php");
                }
            }
        }     
    }
    //create account end

    //for teacher login

    if(isset($_POST['login'])){
        $username_log = $_POST['username_log'];    
        $password_log = $_POST['password_log']; 

        if(empty($username_log )){
            $error = 'Please enter your username!!!.';
        }
    
        if(empty($password_log)){
            $error = 'Please enter your password!!!.';
        }
    
        if((empty($username_log )) && (empty($password_log))){
            $error = 'Please enter your username and password.';
        } else {
            $student_query = $dbconn->prepare("SELECT * FROM student WHERE username = '$username_log' and password = $password_log");
            $student_query->execute();
            $user = $student_query->fetchAll();

            if(count($user) == 1) {                  
                header("Location:student_home.php");
            } else {
                $teacher_query = $dbconn->prepare("SELECT * FROM teacher WHERE username = '$username_log' and password = $password_log");
                $teacher_query->execute();
                $user = $teacher_query->fetchAll();

                if(count($user) == 1) {                  
                header("Location:teacher_home.php");
                }
            }
            
            $error = 'NO ACCOUNT FOUND.';
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
    <title>Online Classroom</title>

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
                    <!-- Menu -->
                    <div class="classy-menu">
                        <!-- Close Button -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <!-- Nav Start -->
                        <div class="classynav">
                            <!-- Register / Login -->
                            <div class="register-login-area">
                                <a href="#forms" class="btn">Register</a>
                                <a href="#forms" class="btn active">Login</a>
                            </div>

                        </div>
                        <!-- Nav End -->
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Hero Area Start ##### -->
    <section class="hero-area bg-img bg-overlay-2by5" style="background-image: url(img/bg-img/bg1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <!-- Hero Content -->
                    <div class="hero-content text-center">
                        <h2>Let's Study Together</h2>
                        <a href="#forms" class="btn clever-btn">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Hero Area End ##### -->
    <div id="forms" class="single-course-content section-padding-100" style="background-image: url(img/core-img/texture.png);">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8"> 
                    <div class="course--content">
                        <div class="clever-tabs-content">
                            <div class="tab-content" id="myTabContent">
                                <!-- Tab Text -->
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab--1">
                                    <div class="clever-description">

                                        <!-- About Course -->
                                        <div class="about-course mb-30">
                                            <h4>Create Account</h4>
                                            <h7 class="text-danger"><?php echo $error2 ?></h7>
                                            <form method="post" id="createAccountForm">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="first_name">First Name</label>
                                                            <input type="text" class="form-control" name="first_name" id="first_name">
                                                        </div>
                                                        <span id="firstnameMsg" name="firstnameMsg">Status Message here</span>
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="last_name">Last Name:</label>
                                                            <input type="text" class="form-control" name="last_name" id="last_name">
                                                        </div>
                                                        <span id="lastnameMsg" name="lastnameMsg">Status Message here</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="username">Username:</label>
                                                            <input type="text" class="form-control" name="username" id="username">
                                                        </div>
                                                        <span id="usernameMsg" name="usernameMsg">Status Message here</span>
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="email">Email Address:</label>
                                                            <input type="email" class="form-control" name="email" id="email">
                                                        </div>
                                                        <span id="emailMsg" name="emailMsg">Status Message here</span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="pwd">Password:</label>
                                                            <input type="password" class="form-control" name="pwd" id="pwd">
                                                        </div>
                                                        <span id="pwdMsg" name="pwdMsg">Status Message here</span>
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="retype_pwd">Confirm Password:</label>
                                                            <input type="password" class="form-control" name="retype_pwd" id="retype_pwd">
                                                        </div>
                                                        <span id="retype_pwdMsg" name="retype_pwdMsg">Status Message here</span>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-6">
                                                        <label for="user_type">Register As:</label>
                                                        <select name="type" id="user_type" class="form-control">
                                                            <option value="1">Teacher</option>
                                                            <option value="0">Student</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button class="btn clever-btn w-100" name="register">Create Account</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="course-sidebar">
                        <div class="sidebar-widget">
                            <h4>Login</h4>
                            <h7 class="text-danger">
                                <?php echo $error;?>
                            </h7>
                            <form method="post">
                                <div class="col-12 col-lg-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="username_log" placeholder="username" name="username_log">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12">
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="password_log" placeholder="password" name="password_log">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn clever-btn w-100" name="login">Log In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Register End ##### -->

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
    <!-- Form validation -->
    <script src="js/index.js"></script>
</body>

</html>