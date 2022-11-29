<?php
    function reEnrollStudent($conn){?>
        <div class="re-enroll__container">
            <p>SCHOOL YEAR HAS ENDED. PLEASE RE-ENROLL</p>
            <a href="?lrn=<?= $_GET['lrn'] ?>&re-enroll=<?= $_GET['lrn'] ?>">Re-Enroll Now!</a>
        </div>
    <?php 
        if (isset($_GET["re-enroll"])) {
            $studentInfoQuery = "SELECT * FROM students WHERE lrn = '". $_GET['re-enroll'] ."'";
            if ($studentInfo = mysqli_fetch_array(mysqli_query($conn, $studentInfoQuery))) {
                if($studentInfo['grade_level'] == 10){?>
                    <div class="prompt">
                        <div class="prompt__container">
                            <h1>PLEASE PROCEED TO SENIOR HIGH SCHOOL ENROLLMENT</h1>
                        </div>
                    </div>
                <?php }else{?>
                    <div class="prompt">
                        <div class="prompt__container">
                            <h1>Do you want to enroll for Grade <?= $studentInfo['grade_level']+1 ?></h1>
                            <div class="action">
                                <a href="?lrn=<?= $_GET['lrn'] ?>&re-enrolling=<?= $_GET['lrn'] ?>" id="yes">Yes</a>
                                <a href="?lrn=<?= $_GET['lrn'] ?>" id="no">No</a>
                            </div>
                        </div>
                    </div>
                <?php }
            }
            ?>
            <!--  -->
        <?php }
        if (isset($_GET['re-enrolling'])) {
            $lrn = $_GET['re-enrolling'];
            $insertToEnrollees = "INSERT INTO enrollees (student_lrn) VALUES ('$lrn');";
            $updateGradeLevel = "UPDATE students SET grade_level = grade_level + 1 WHERE students.lrn = '". $_GET['re-enrolling'] ."';";
            if (mysqli_query($conn, $insertToEnrollees) && mysqli_query($conn, $updateGradeLevel)) { ?>
                <div class="prompt">
                    <div class="prompt__container">
                        <h1>Re-Enrollment is Successful!</h1>
                        <div class="action">
                            <a href="?lrn=<?= $_GET['lrn'] ?>" id="yes">Continue</a>
                        </div>
                    </div>
                </div>
            <?php }
        }
    }
    if (isset($_GET['lrn'])) {
        include 'phpMethods/connection.php';
        $conn = OpenCon();
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../css/default.css">
                <link rel="stylesheet" href="../css/scanned_QR.css">
                <title>BMIS Student Info</title>
            </head>
            <body>
                <?php
                $queryStudentInfo = "SELECT * FROM students WHERE students.lrn =". $_GET['lrn'];
                $queryStudentIfEnrollee = "SELECT * FROM enrollees WHERE enrollees.student_lrn = ". $_GET['lrn'];
                
                if ($result = mysqli_query($conn, $queryStudentInfo)) {
                    $res = mysqli_fetch_array($result);
                    ?>
                    <div class="student-info__container">
                        <img src="../../uploads/<?= $res['lrn'] ?>/<?= $res['student_picture'] ?>" alt="">
                        <h1>
                            <?php
                            if ($res['suffix'] == "" && $res['middle_name'] == "") {
                                echo $res['last_name'] . ", " . $res['first_name'];
                            }elseif ($res['suffix'] == "") {
                                $middleName = $res['middle_name'];
                                echo $res['last_name'].", ".$res['first_name']." ".$middleName[0].".";
                            }elseif ($res['middle_name'] == "") {
                                echo $res['last_name']." ".$res['suffix'].", ".$res['first_name'];
                            }else{
                                $middleName = $res['middle_name'];
                                echo $res['last_name']." ".$res['suffix'].", ".$res['first_name']." ".$middleName[0].".";
                            }
                            ?>
                        </h1>
                        <p><b>LRN : </b><?= $res['lrn'] ?></p>
                        <?php
                            $checkEnrolleeQuery = "SELECT * FROM enrollees WHERE student_lrn = '" . $_GET['lrn'] . "'";
                            if (mysqli_num_rows(mysqli_query($conn, $checkEnrolleeQuery)) == 0) {
                                $queryActiveSchoolYear = "SELECT * FROM school_years WHERE isActive = true";
                                if(mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear)) == 0){
                                    reEnrollStudent($conn);
                                }elseif($activeSchoolYear = mysqli_fetch_array(mysqli_query($conn, $queryActiveSchoolYear))){
                                    $checkStudentEnrolledQuery = "SELECT * FROM `". $activeSchoolYear['school_year'] ."` WHERE enrolled_lrn = '" . $_GET['lrn'] . "'";
                                    if (mysqli_num_rows(mysqli_query($conn, $checkStudentEnrolledQuery)) == 0) {
                                        reEnrollStudent($conn);
                                    }elseif($enrolledStudentInfo = mysqli_fetch_array(mysqli_query($conn, $checkStudentEnrolledQuery))){
                                        ?>
                                        <div class="enrolled-info__container">
                                            <p>Enrolled in Grade <?= $enrolledStudentInfo['grade_level'] ?> Section <?= $enrolledStudentInfo['section'] ?> School Year <?= $activeSchoolYear['school_year']?></p>
                                        </div>
                                    <?php ; }
                                }
                            }else{ ?>
                                <p class="queue">Student Enrollment is in Queue</p>
                            <?php }
                        ?>
                    </div>
                <?php }else {
                    header("Location: ../index.php");
                }
                ?>
            </body>
        </html>
    <?php }else {
        header("Location: ../index.php");
    }
?>