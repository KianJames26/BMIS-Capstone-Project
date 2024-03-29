<?php session_start();session_destroy();include 'BMIS/phpMethods/connection.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/default.css">
    <title>BIMS Enrollment</title>
</head>
<body>
    <?php 
        if (isset($_GET['enrollment'])) {
            $conn = OpenCon();
            $checkActiveSchoolYearQuery = "SELECT * FROM school_years WHERE isActive=true";
            if (mysqli_num_rows(mysqli_query($conn, $checkActiveSchoolYearQuery)) == 0) { ?>
                <div class="hidden">
                    <dialog>
                        <a href="index.php"><div id="close-editor"></div></a>
                        <p class="title">Enrollment isn't opened yet. Please wait for further announcement</p>
                        <div class="link">
                            <a href="index.php">Okay</a>
                        </div>
                    </dialog>
                </div>
            <?php }else {?>
                <div class="hidden">
                        <dialog>
                            <a href="index.php"><div id="close-editor"></div></a>
                            <p class="title">What kind of enrollment?</p>
                            <div class="link">
                                <a href="BMIS/enrollment_form.php">New Enrollee</a>
                                <a href="BMIS/transferree_form.php">Transferee</a>
                            </div>
                        </dialog>
                    </div>
        <?php }
        }
    ?>
    <section class="section-one">
        <div class="section-one-left">
            <img src="img/logo.png" alt="">
        </div>
        <div class="section-one-right">
            <a href="BMIS/login.php" id="login">Login</a>
            <p>Welcome to</p>
            <p class="header">Barasoain Memorial <br> Integrated School <br> e-Enrollment</p>
            <a href="?enrollment=true">Enroll Now</a>
        </div>
    </section>
    <section class="section-two">
        <div class="section-two-left">
            <p class="header">About Barasoain Memorial Integrated School</p>
            <p>Formerly known as Barasoain Memorial Elementary School 2017, the school was under by the authority of President Corazon C. Aquino Montessori High School 2018, BMES became Barasoain Memorial Integrated School.</p>
        </div>
        <div class="section-two-right">
            <img src="img/logo.png" alt="">
        </div>
    </section>
    <section class="section-three">
        <div class="section-three-top">
            <p class="header">Why Choose BMIS?</p>
        </div>
        <div class="section-three-bottom">
            <div class="section-three-bottom-card">
                <img src="img/good-facility.jpg" alt="">
                <p class="header">01 <br>Good Facilities</p>
                <p>Classrooms have considerable amount of space for students to learn and create</p>
            </div>
            <div class="section-three-bottom-card">
                <img src="img/free-tuition.png" alt="">
                <p class="header">02 <br>Free Tuition</p>
                <p>The students will enjoy free tuition, paid for by the government and funds from private sectors</p>
            </div>
            <div class="section-three-bottom-card">
                <img src="img/conductive-learning.jpg" alt="">
                <p class="header">03 <br>Conductive Learning Environment</p>
                <p>Social interaction facilitated by the caring faculty will be observed carefully and integrated into learning</p>
            </div>
        </div>
    </section>
    <footer>
        <p>Barasoain Memorial Integrated School</p>
        <p>A.Y. 2022-2023</p>
    </footer>
</body>
</html>