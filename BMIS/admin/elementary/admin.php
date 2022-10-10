<?php session_start();
    if ($_SESSION['loggedin'] == false && $_SESSION['login-role'] != "elementary-admin") {
        header("Location: ../../../index.php");
    }else {
        include '../../phpMethods/connection.php';
        include 'content.php';
        if (isset($_GET['logout'])) {
            header("Location: ../../../index.php");
            session_destroy();
        }
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
                <a href="?logout">Logout</a>
            </div>
            <div class="navigation">
                <a <?php if($_GET['page'] == "dashboard"){echo "id='active'";}else{echo "href='?page=dashboard'";}?> >Dashboard</a>
                <a <?php if($_GET['page'] == "enrollees"){echo "id='active'";}else{echo "href='?page=enrollees'";}?> >Enrollees</a>
                <a <?php if($_GET['page'] == "enrollment_form"){echo "id='active'";}else{echo "href='?page=enrollment_form&enrollment=one'";}?> >Enrollment Form</a>
            </div>
            <div class="content">
                <div class="container">
                    <?php
                        // if ($_GET['page'] == "dashboard") {
                        //     echo $dashboard;
                        // }else if($_GET['page'] == "enrollees"){
                        //     echo $enrollees;
                        // }else if($_GET['page'] == "enrollment_form"){
                        //     echo $enrollment_form;
                        // }else{
                        //     header("Location: ../../../index.php");
                        //     session_destroy();
                        // }
                    ?>

                </div>
            </div>
        </body>
        </html>

    <?php
    }?>
