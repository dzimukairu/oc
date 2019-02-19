<?php
    include("db_connection.php");

    $error = "<br>";

    $id = $_GET['subject_id'];
    if(isset($_POST['update_about'])){
        $new_about = ($_POST['new_about']);
        $update_query = "UPDATE subject SET course_about = '$new_about' WHERE subject_id = '$id'";
        if ($update_connect = mysqli_query($dbconn, $update_query)) {
            header("Location: teacher_course.php?subject_id=".$id);
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

   <section class="hero-area bg-img bg-overlay-2by5" style="background-image: url(img/bg-img/bg1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <!-- Hero Content -->
                    <div class="hero-content text-center">
                        <?php
                            $id = $_GET['subject_id'];
                            $sql = "SELECT subject_code, course_title, course_description, course_about from subject where subject_id = $id";

                            $result = mysqli_query($dbconn, $sql);
                            $row = mysqli_fetch_array($result);
                            
                            $subject_code = $row['subject_code']; 
                            $course_title = $row['course_title'];
                            $course_description = $row['course_description'];
                            $course_about = $row['course_about'];
                       
                        ?>
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
                                    <a class="nav-link active" id="tab--1" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="false">About</a>
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
                                            <h6>About this course</h6>
                                            <p><?php echo $course_about; ?></p>
                                            <button class="btn btn-info" data-toggle="modal" data-target="#update-about-modal">Update About</button>
                                        </div>

                                        <!-- All Learning Materials -->
                                        <button type="button" class="btn clever-btn mb-30" data-toggle="modal" data-target="#upload-modal">Add Learning Materials</button>
                                        <div class="all-instructors mb-30">
                                            <h6>Learning Materials</h6>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="single-learning-materials mb-50 wow fadeInUp" data-wow-delay="500ms">
                                                        <div class="events-thumb">
                                                            <img src="img/document.png" alt="">
                                                            <h6 class="lecture-number">Lecture 2</h6>
                                                            <h4 class="lecture-title">Lecture No.2 Topic</h4>
                                                        </div>
                                                        <div class="open-save d-flex justify-content-between">
                                                            <div class="extra-space">
                                                                <span></span>
                                                            </div>
                                                            <div class="save-btn">
                                                                <a class="delete" href="#">Delete</a>
                                                                <a href="#">Save</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Text Announcements -->
                                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab--2">
                                    <div class="clever-curriculum">
                                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-announcement-modal">Add Announcement</button> -->

                                        <?php 
                                            echo "<a href=teacher_announcement.php?subject_id=",urlencode($id)," class='btn clever-btn mb-30'>Add Announcement</a>";
                                      
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
                                                                echo "<h6>".$row[3]."</h6>";
                                                                echo "<p>".$row[4]."</p>";

                                                                $xdate = new DateTime($row[2]);
                                                                // $x = DateTime::createFromFromat('M d, Y', $xdate);
                                                                $y = date_format($xdate, 'M d, Y - h:i A');
                                                                echo "<br>";
                                                                echo $y;

                                                                echo "<br>";
                                                                echo "<br>";
                                                                echo "<br>";
                                                                $a_id = $row[0];
                                                                
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

                                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-assignment-modal">Add Assignment</button> -->

                                        <a href="teacher_assignment.php" class="btn clever-btn mb-30">Add Assignment</a>

                                        <div class="about-curriculum mb-30">
                                            <button class="btn btn-info">Edit</button><button class="btn btn-danger">Delete</button>
                                            <h6>Assignment Title</h6>
                                            <p>Nullam eu mattis quam. Donec porttitor nunc a diam molestie blandit. Maecenas quis ultrices ex. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nullam eget vehicula lorem, vitae porta nisi. Ut vel quam erat. Ut vitae erat tincidunt, tristique mi ac, pharetra dolor. In et suscipit ex. Pellentesque aliquet velit tortor, eget placerat mi scelerisque a. Aliquam eu dui efficitur purus posuere viverra. Proin ut elit mollis, euismod diam et, fermentum enim.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Text Students List -->
                                <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab--4">
                                    <div class="clever-members">
                                        <!-- All Members -->
                                        <button type="button" class="btn clever-btn mb-30" data-toggle="modal" data-target="#add-student-modal">Add Students</button>
                                        <div class="all-instructors mb-30">
                                            <div class="row">
                                                <h6>Students List</h6>
                                            </div>
                                            <div class="row">
                                                <!-- Single Student -->
                                                <div class="col-lg-6">
                                                    <div class="single-instructor d-flex align-items-center mb-30">
                                                        <div class="instructor-thumb">
                                                            <img src="img/bg-img/t1.png" alt="">
                                                        </div>
                                                        <div class="instructor-info">
                                                            <h5>Student's Name</h5>
                                                            <a class="text-danger" href="#">Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Text Quizzes -->
                                <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab--5">
                                    <div class="clever-review">
                                        <a href="teacher_quiz.php" class="btn clever-btn mb-30">Add Quiz</a>
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
                        <a href="classrecord.php" class="btn clever-btn mb-30 w-100">Class Record</a>

                        <?php
                            echo "<h4>Subject Code: ".$subject_code."</h4>";
                            echo "<br>";
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
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title pull-left">Upload Learnng Material</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST">
                                            <div class="form-group">
                                                <div class="col-auto">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Lecture No.</div>
                                                        </div>
                                                        <input type="text" class="form-control" id="inlineFormInputGroup" name="lecture-number" placeholder="(example: 1)" />
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Lecture Topic</div>
                                                        </div>
                                                        <input type="text" class="form-control" id="inlineFormInputGroup" name="lecture_topic" />
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="file" name="material_file" />
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-info" name="add_material">Add</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add assignment modal -->
                        <div id="add-assignment-modal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title pull-left">Add Assignment</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="POST">
                                            <div class="form-group">
                                                <div class="col-auto">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Assignment No.</div>
                                                        </div>
                                                        <input type="text" class="form-control" id="inlineFormInputGroup" name="assignment_number" placeholder="(example: 1)" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-auto">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Title</div>
                                                        </div>
                                                        <input type="text" class="form-control" id="inlineFormInputGroup" name="add_assignment_title" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-auto">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Instruction</div>
                                                        </div>
                                                        <textarea class="form-control" id="inlineFormInputGroup" name="assignment_instruction"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-primary" name="add_assignment">Add</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>          
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add student Modal -->
                        <div id="add-student-modal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title pull-left">Add Student</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST">
                                            <div class="form-group">
                                                <div class="col-auto">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Search</div>
                                                        </div>
                                                        <input type="search" class="form-control" placeholder="Name of Student"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-primary" name="add_student">Add</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                                                <textarea class="form-control" name="new_about"><?php echo $course_about?></textarea>
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
</body>

</html>