<?php session_start();
    if ($_SESSION['loggedin'] == false && $_SESSION['role'] != "high_school") {
        header("Location: ../../../index.php");
    }else {
        include '../../phpMethods/connection.php';
        include '../../phpMethods/log.php';
        include 'admin_content.php';
        $gradeLevel = "> 6";
        if (isset($_GET['logout'])) {
            logNow("Logged out of the system", $_SESSION['admin_id'], OpenCon());
            header("Location: ../../../index.php");
            session_destroy();
        }
        // $conn = OpenCon();
?>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../../../css/default.css">
            <link rel="stylesheet" href="../../../css/admin.css">
            <title>BMIS Elementary</title>
        </head>
        <body>
            <div class="header">
                <img src="../../../img/logo.png" alt="BMIS" srcset="">
                <h1>Barasoain Memorial Integrated School</h1>
                <p style="text-align: center;">Welcome to High School Admin <br> <b><?= $_SESSION['username'] ?></b></p>
                <a href="?logout"><img src="../../../img/logout.png" alt=""></a>
            </div>
            <div class="navigation">
                <a <?php if($_GET['page'] == "dashboard"){echo "id='active'";}else{echo "href='?page=dashboard'";}?> >Dashboard</a>
                <a <?php if($_GET['page'] == "manage_enrollees"){echo "id='active'";}else{echo "href='?page=manage_enrollees'";}?> >Manage Enrollees</a>
                <a <?php if($_GET['page'] == "rejected_enrollees"){echo "id='active'";}else{echo "href='?page=rejected_enrollees'";}?> >Manage Rejected Enrollees</a>
                <a <?php if($_GET['page'] == "enrolled_students"){echo "id='active'";}else{echo "href='?page=enrolled_students&select_grade=true'";}?> >Manage Students</a>
                <a <?php if($_GET['page'] == "admin_controls"){echo "id='active'";}else{echo "href='?page=admin_controls&sub-page=school-year'";}?> >Admin Controls</a>
            </div>
            <div class="content">
                <div class="container">
                    <?php
                        if ($_GET['page'] == "dashboard") {
                            echo dashboardContent($gradeLevel);
                        }else if($_GET['page'] == "manage_enrollees"){
                            echo enrolleesContent($gradeLevel);
                        }else if($_GET['page'] == "enrolled_students"){
                            echo enrolledStudentsContent();
                        }else if($_GET['page'] == "rejected_enrollees"){
                            echo archived($gradeLevel);
                        }else if($_GET['page'] == "admin_controls"){
                            echo adminControlsContent($gradeLevel);
                        }else{
                            header("Location: ?page=dashboard");
                        }
                    ?>
                </div>
            </div>
        </body>
        </html>

    <?php
    }?>