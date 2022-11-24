<?php
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