<?php
    if (isset($_GET['lrn'])) {
        include 'phpMethods/connection.php';
        $conn = OpenCon();
        $lrn = $_GET['lrn'];
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
                $queryStudentInfo = "SELECT * FROM students WHERE students.lrn =". $lrn;
                
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
                        <form action="" method="post" id="student">
                        <?php
                        $queryActiveSchoolYear = "SELECT * FROM school_years WHERE isActive = 1";
                        if (mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear)) > 0) {
                            if($activeSchoolYear = mysqli_fetch_assoc(mysqli_query($conn, $queryActiveSchoolYear))){
                                $checkEnrolleeQuery = "SELECT * FROM enrollees WHERE enrollees.student_lrn = " . $lrn;
                                $checkRejectedQuery = "SELECT * FROM rejected_enrollees WHERE rejected_enrollees.student_lrn = " . $lrn;
                                $checkEnrolledQuery = "SELECT * FROM `". $activeSchoolYear['school_year'] ."` WHERE `". $activeSchoolYear['school_year'] ."`.enrolled_lrn = " . $lrn;
                                if(mysqli_num_rows(mysqli_query($conn, $checkEnrolleeQuery)) > 0){
                                    if($enrolleeInfo = mysqli_fetch_assoc(mysqli_query($conn, $checkEnrolleeQuery))){
                                        $enrolleeSchoolYear = $enrolleeInfo['school_year'];
                                        if ($enrolleeSchoolYear == $activeSchoolYear['school_year']) {?>
                                            <p class="queue">Your Enrollement is in Queue</p>
                                        <?php }else{?>
                                            <p class="queue">You're an enrollee from S.Y. <?= $enrolleeSchoolYear ?> which already ended. Please Consider Re-enrollment</p>
                                            <button type="submit" class="re-enroll" name="re-enroll" value="<?= $lrn ?>">Re-Enroll Now</button>
                                        <?php }
                                    }
                                }elseif (mysqli_num_rows(mysqli_query($conn, $checkRejectedQuery)) > 0) {
                                    if($rejectedInfo = mysqli_fetch_assoc(mysqli_query($conn, $checkRejectedQuery))){?>
                                        <p class="queue">Your Enrollment from S.Y. <?= $rejectedInfo['school_year'] ?> was rejected please re-enroll</p>
                                        <p><i>Remarks : <?= $rejectedInfo['remark']?></i></p>
                                        <button type="submit" class="re-enroll" name="update-form" value="<?= $lrn ?>">Update my Information</button>
                                    <?php }
                                }elseif (mysqli_num_rows(mysqli_query($conn, $checkEnrolledQuery)) > 0) {
                                    if($enrolledInfo = mysqli_fetch_assoc(mysqli_query($conn, $checkEnrolledQuery))){?>
                                        <p class="enrolled">You're enrolled to Grade <?= $enrolledInfo['grade_level'] ?> Section <?= $enrolledInfo['section'] ?> S.Y. <?= $activeSchoolYear['school_year'] ?></p>
                                    <?php }
                                }elseif (mysqli_num_rows(mysqli_query($conn, $checkEnrolledQuery)) == 0) {?>
                                    <p class="queue">School Year has Ended, Please Re-Enroll</p>
                                    <button type="submit" class="re-enroll" name="new-enrollment" value="<?= $lrn ?>">Re-Enroll Now</button>
                                <?php }
                            }
                        }else {?>
                            <p class="queue">No school Year is activated at the moment. Please wait for further announcement.</p>
                        <?php }
                        ?>
                        </form>
                        
                    </div>
                <?php }else {
                    header("Location: ../index.php");
                }
                ?>
            </body>
        </html>
    <?php 
        if (isset($_POST['re-enroll'])) {
            $updateEnrolleeQuery = "UPDATE enrollees SET school_year = '". $activeSchoolYear['school_year'] ."' WHERE enrollees.student_lrn = '". $_POST['re-enroll'] ."';";
            if(mysqli_query($conn, $updateEnrolleeQuery)){?>
                <div class="prompt">
                    <div class="prompt__container">
                        <h1>Enrollment is successful!</h1>
                        <div class="actions">
                            <a href="" class="confirm">Okay</a>
                        </div>
                    </div>
                </div>
            <?php }
        }elseif (isset($_POST['update-form'])) { 
            $queryStudentInfo = "SELECT * FROM students JOIN parent_information ON students.lrn = parent_information.student_lrn WHERE students.lrn = ". $_POST['update-form'];
            if ($result = mysqli_fetch_assoc(mysqli_query($conn, $queryStudentInfo))) {?>
                <div id="hidden-error"></div>
                <div class="prompt">
                    <div class="prompt__update">
                        <form action="" method="post" id="form" enctype="multipart/form-data">
                            <script src="../js/scanned_qr.js"></script>
                            <h1>Update Information</h1>
                            <div class="row">
                                <div class="column">
                                    <p class="header">Student Information</p>
                                </div>
                            </div>
                            <?php
                                if($result['grade_level'] > 0){?>
                                    <div class="row">
                                        <div class="column">
                                            <label for="lrn">Last School Year Average <span class="required"></span></label>
                                            <input type="number" name="gwa" step="any" id="gwa" placeholder="Enter your Average Last School Year (74-100)" value="<?= $result['gwa'] ?>">
                                            <script>
                                                const inputGrade = document.getElementById('gwa');
                                                inputGrade.addEventListener('change', function() {
                                                    if (this.value < 74) {
                                                    this.value = 74;
                                                    } else if (this.value > 100) {
                                                    this.value = 100;
                                                    }
                                                });
                                            </script>
                                        </div>
                                    </div>
                                <?php }else{?>
                                    <input type="hidden" name="gwa" value="0">
                                <?php }
                            ?>
                            <div class="row">
                                <div class="column">
                                    <label for="last-name">Last Name <span class="required"></span></label>
                                    <input type="text" name="last-name" id="last-name" placeholder="Enter your Last Name" value="<?= $result['last_name'] ?>">
                                </div>
                                <div class="column">
                                    <label for="first-name">First Name <span class="required"></span></label>
                                    <input type="text" name="first-name" id="first-name" placeholder="Enter your First Name" value="<?= $result['first_name'] ?>">
                                </div>
                            </div>
                            <div class="row">
                            <div class="column">
                                <label for="middle-name">Middle Name</label>
                                <input type="text" name="middle-name" id="middle-name" placeholder="Enter your Middle Name" value="<?= $result['middle_name'] ?>">
                            </div>
                            <div class="column">
                                <label for="suffix">Suffix</label>
                                <select name="suffix" id="suffix">
                                    <option value="" <?php if ($result['suffix'] == "") echo "selected"; ?>>none</option>
                                    <option value="Jr" <?php if ($result['suffix'] == "Jr") echo "selected"; ?>>Jr</option>
                                    <option value="I" <?php if ($result['suffix'] == "I") echo "selected"; ?>>I</option>
                                    <option value="II" <?php if ($result['suffix'] == "II") echo "selected"; ?>>II</option>
                                    <option value="III" <?php if ($result['suffix'] == "III") echo "selected"; ?>>III</option>
                                    <option value="IV" <?php if ($result['suffix'] == "IV") echo "selected"; ?>>IV</option>
                                    <option value="V" <?php if ($result['suffix'] == "V") echo "selected"; ?>>V</option>
                                    <option value="VI" <?php if ($result['suffix'] == "VI") echo "selected"; ?>>VI</option>
                                </select>
                            </div>
                            </div>
                            <div class="row" style="margin-bottom: 5px;">
                                <label for="gender-choice">Gender <span class="required"></span></label>
                            </div>
                            <div class="radio-group">
                                <label for="null" style="display: none;"><input id="null" type="radio" name="gender-choice" value="null" checked="checked"/>Null</label>
                                <label for="gender-male"><input id="gender-male" type="radio" name="gender-choice" value="Male" <?php if ($result['gender'] == "Male") echo "checked"; ?>/> Male</label>
                                <label for="gender-female"><input id="gender-female" type="radio" name="gender-choice" value="Female" <?php if ($result['gender'] == "Female") echo "checked"; ?>/> Female</label>
                            </div>
                            <div class="row">
                                <div class="column">
                                    <label for="birthday">Date of Birth <span class="required"></span></label>
                                    <input type="date" name="birthday" id="birthday" value="<?= $result['birth_date'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <p class="header">Parent/Guardian Information</p>
                            </div>
                            <div class="row">
                                <div class="column">
                                    <label for="parent-fullname">Full Name <span class="required"></span></label>
                                    <input type="text" name="parent-fullname" id="parent-fullname" placeholder="Enter Parent/Guardian Full Name" value="<?= $result['parent_name'] ?>">
                                </div>
                                <div class="column">
                                    <label for="parent-contact">Contact Number <span class="required"></span></label>
                                    <input type="number" name="parent-contact" id="parent-contact" placeholder="Enter Parent/Guardian Contact No. " maxlength="11" value="<?= $result['parent_contact'] ?>">
                                    <script>
                                        const inputMobile = document.getElementById('parent-contact');
                                        inputMobile.addEventListener('input', function() {
                                            this.value = this.value.substring(0, 11); 
                                        });
                                    </script>
                                </div>
                                <div class="column">
                                    <label for="relationship">Relationship <span class="required"></span></label>
                                    <input type="text" name="relationship" id="relationship" placeholder="Enter relationship" value="<?= $result['parent_relationship'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="column" style="width: 100%;">
                                    <p class="header">File Upload</p>
                                    <p class="sub-header">Please follow the instructions below</p>
                                    <p class="sub-header" style="font-weight: bolder;">For the 1x1 picture, upload a picture with a png format.The picture must have a white background. Upload form 138 and birth certificate as pdf file.</p>
                                    <p class="sub-header" style="font-weight: bolder;">Don't upload if you don't want to change!</p>
                                </div>
                            </div>
                            <div class="file-upload">
                                <div class="row">
                                    <div class="column1">
                                        <label for="student-picture">1x1 picture <span class="required"></span></label>
                                    </div>
                                    <div class="column2">
                                        <input type="file" name="student-picture" id="student-picture" onchange="return studentPictureValidation()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="column1">
                                        <label for="report-card">Form 138 <span class="required"></span></label>
                                    </div>
                                    <div class="column2">
                                        <input type="file" name="report-card" id="report-card" onchange="return pdfValidation('report-card')">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="column1">
                                        <label for="birth-certificate">Birth Certificate <span class="required"></span></label>
                                    </div>
                                    <div class="column2">
                                        <input type="file" name="birth-certificate" id="birth-certificate" onchange="return pdfValidation('birth-certificate')">
                                    </div>
                                </div>
                            </div>
                            <div class="actions" style="padding-bottom: 40px;">
                                <button type="submit" name="update" class="confirm" value="<?= $_POST['update-form'] ?>">Update Infromation</button>
                                <a href="?lrn=<?= $_POST['update-form'] ?>" class="cancel">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php }
            }elseif (isset($_POST['update'])) {
                $queryStudentInfo = "SELECT * FROM students JOIN parent_information ON students.lrn = parent_information.student_lrn WHERE students.lrn = ". $_POST['update'];
                if($result = mysqli_fetch_assoc(mysqli_query($conn, $queryStudentInfo))){
                    $lrn = $_POST['update'];
                    if(trim($_POST['gwa']) == ""){
                        $gwa = $result['gwa'];
                    }else{
                        $gwa = round($_POST['gwa'],2);
                    }
                    if (trim($_POST['first-name']) == "") {
                        $firstName = $result['first_name'];
                    }else{
                        $firstName = $_POST['first-name'];
                    }

                    if (trim($_POST['last-name']) == "") {
                        $lastName = $result['last_name'];
                    }else{
                        $lastName = $_POST['last-name'];
                    }

                    $middleName = $_POST['middle-name'];
                    $suffix = $_POST['suffix'];

                    $gender = $_POST['gender-choice'];

                    if ($_POST['birthday'] == "") {
                        $birthDate = $result['birth_date'];
                    }else{
                        $birthDate = $_POST['birthday'];
                    }

                    if (trim($_POST['parent-fullname']) == "") {
                        $parentName = $result['parent_name'];
                    }else{
                        $parentName = $_POST['parent-fullname'];
                    }

                    if ($_POST['parent-contact'] == "") {
                        $parentContact= $result['parent_contact'];
                    }else{
                        $parentContact = $_POST['parent-contact'];
                    }

                    if (trim($_POST['relationship'])== "") {
                        $parentRelationship= $result['parent_relationship'];
                    }else{
                        $parentRelationship = $_POST['relationship'];
                    }
                    $parentRelationship = $_POST['relationship'];
                    $schoolYear = $activeSchoolYear['school_year'];
                    $targetDir = "../../uploads/". $lrn . "/";
                }
                if(!is_dir($targetDir)){
                    mkdir($targetDir);
                }
                if (isset($_FILES['student-picture']) && !empty($_FILES['student-picture']['name'])) {
                    $studentPicture = $lrn . "_student_picture." . pathinfo($_FILES['student-picture']['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES['student-picture']['tmp_name'], $targetDir . $studentPicture);
                }
                if (isset($_FILES['report-card']) && !empty($_FILES['report-card']['name'])) {
                    $reportCard = $lrn . "_report_card." . pathinfo($_FILES['report-card']['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES['report-card']['tmp_name'], $targetDir . $reportCard);
                }
                if (isset($_FILES['birth-certificate']) && !empty($_FILES['birth-certificate']['name'])) {
                    $birthCertificate = $lrn . "_birth_certificate." . pathinfo($_FILES['birth-certificate']['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES['birth-certificate']['tmp_name'], $targetDir . $birthCertificate);
                }
                $updateStudentInfoQuery = "UPDATE students
                SET students.last_name = '$lastName',
                students.first_name = '$firstName',
                students.middle_name = '$middleName',
                students.suffix = '$suffix',
                students.gender = '$gender',
                students.birth_date = '$birthDate',
                students.gwa = '$gwa'
                WHERE lrn = '$lrn'";
                if (mysqli_query($conn, $updateStudentInfoQuery)) {
                    $updateParentInformation = "UPDATE parent_information
                    SET parent_information.parent_name = '$parentName',
                    parent_information.parent_contact = '$parentContact',
                    parent_information.parent_relationship = '$parentRelationship'
                    WHERE student_lrn = '$lrn'";
                    if (mysqli_query($conn, $updateParentInformation)) {
                        $addToEnrolleesQuery = "INSERT INTO enrollees (student_lrn, school_year)
                        VALUES('$lrn', '$schoolYear')";
                        if (mysqli_query($conn, $addToEnrolleesQuery)) {
                            $removeFromReject = "DELETE FROM rejected_enrollees WHERE student_lrn = '$lrn'";
                            if (mysqli_query($conn, $removeFromReject)) {?>
                                <div class="prompt">
                                    <div class="prompt__container">
                                        <h1>Information Updated Successfully</h1>
                                        <div class="actions"><a href="?lrn=<?= $lrn ?>" class="confirm">Okay</a></div>
                                    </div>
                                </div>
                            <?php }
                        }
                    }
                }
            }elseif (isset($_POST['new-enrollment'])) {
                $lrn = $_POST['new-enrollment'];
                ?>
                <div class="prompt">
                    <div id="hidden-error"></div>
                    <div class="prompt__update">
                        <form action="" method="post" id="form" enctype="multipart/form-data">
                        <script src="../js/scanned_qr.js"></script>
                            <h1>Re-Enrollment Form</h1>
                            <?php
                                $queryStudentInfo = "SELECT * FROM students WHERE students.lrn = '$lrn'";
                                if ($result = mysqli_fetch_assoc(mysqli_query($conn, $queryStudentInfo))) {?>
                                    <div class="row">
                                        <div class="column">
                                            <p class="header">Enrolling for Grade <?= $result['grade_level'] + 1 ?></p>
                                            <input type="hidden" name="grade-level" value="<?= $result['grade_level'] + 1?>">
                                        </div>
                                    </div>
                                <?php }
                            ?>
                            <div class="row">
                                <div class="column">
                                    <label for="lrn">Last School Year Average <span class="required"></span></label>
                                    <input type="number" name="gwa" step="any" id="gwa" placeholder="Enter your Average Last School Year (74-100)">
                                    <script>
                                        const inputGrade = document.getElementById('gwa');
                                        inputGrade.addEventListener('change', function() {
                                            if (this.value < 74) {
                                            this.value = 74;
                                            } else if (this.value > 100) {
                                            this.value = 100;
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="row">
                                <div class="column" style="width: 100%;">
                                    <p class="header">File Upload</p>
                                    <p class="sub-header">Please follow the instructions below</p>
                                    <p class="sub-header" style="font-weight: bolder;">For the 1x1 picture, upload a picture with a png format.The picture must have a white background. Upload form 138 and birth certificate as pdf file.</p>
                                </div>
                            </div>
                            <div class="file-upload">
                                <div class="row">
                                    <div class="column">
                                        <label for="report-card">Form 138 <span class="required"></span></label>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="column2">
                                        <input type="file" name="report-card" id="report-card" onchange="return pdfValidation('report-card')">
                                    </div>
                                </div>
                            </div>
                            <div class="actions" style="padding-bottom: 40px;">
                                <button type="submit" name="new-enroll" class="confirm" value="<?= $_POST['new-enrollment'] ?>" style="display:none;" id="new-enroll">Update Infromation</button>
                                <a href="?lrn=<?= $_POST['new-enrollment'] ?>" class="cancel">Cancel</a>
                            </div>
                            <input type="hidden" name="last-school" value="Barasoain Memorial Integrated School">
                            <input type="hidden" name="last-school-address" value="Malolos,Bulacan">
                        </form>
                        <script>
                            function checkInputs() {
                                var inputText = document.getElementById('gwa').value;
                                var inputFile = document.getElementById('report-card').value;
                                if (inputText && inputFile) {
                                document.getElementById('new-enroll').style.display = 'block';
                                } else {
                                document.getElementById('new-enroll').style.display = 'none';
                                }
                            }
                            document.getElementById('gwa').addEventListener('input', checkInputs);
                            document.getElementById('gwa').addEventListener('change', checkInputs);
                            document.getElementById('report-card').addEventListener('change', checkInputs);
                        </script>
                    </div>
                </div>
        <?php }elseif(isset($_POST['new-enroll'])){
            $lrn = $_POST['new-enroll'];
            $gwa = round($_POST['gwa'], 2);
            $gradeLevel = $_POST['grade-level'];
            $schoolYear = $activeSchoolYear['school_year'];
            $targetDir = "../../uploads/". $lrn . "/";
            if(!is_dir($targetDir)){
                mkdir($targetDir);
            }
            $reportCard = $lrn . "_report_card." . pathinfo($_FILES['report-card']['name'], PATHINFO_EXTENSION);
            if(move_uploaded_file($_FILES['report-card']['tmp_name'], $targetDir . $reportCard)){
                $updateGradeLevel = "UPDATE students
                SET students.grade_level = '$gradeLevel',
                students.gwa = '$gwa'
                WHERE students.lrn = '$lrn';
                ";
                if(mysqli_query($conn, $updateGradeLevel)){
                    $addToEnrolleesQuery = "INSERT INTO enrollees (student_lrn, school_year)
                    VALUES ('$lrn', '$schoolYear')
                    ";
                    if (mysqli_query($conn, $addToEnrolleesQuery)) {?>
                        <div class="prompt">
                            <div class="prompt__container">
                                <h1>Re-Enrolled Successfully</h1>
                                <div class="actions"><a href="?lrn=<?= $lrn ?>" class="confirm">Okay</a></div>
                            </div>
                        </div>
                    <?php }
                }
            }
        }
    }else {
        header("Location: ../index.php");
    }
?>