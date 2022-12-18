<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Generated QR</title>
        <link rel="stylesheet" href="../css/default.css">
        <link rel="stylesheet" href="../css/generate_qr.css">
    </head>
    <body>
    <?php
    include 'phpMethods/connection.php';
    $conn = OpenCon();
    if (isset($_POST['submit'])) {
        insertData($conn);
    }
    CloseCon($conn);
    function insertData($conn){
        $lrn = $_POST['lrn'];
        $gwa = round($_POST['gwa'],2);
        $firstName = $_POST['first-name'];
        $middleName = $_POST['middle-name'];
        $lastName = $_POST['last-name'];
        $suffix = $_POST['suffix'];
        $gender = $_POST['gender-choice'];
        $birthDate = $_POST['birthday'];
        $birthPlace = $_POST['birthplace'];
        $gradeLevel = $_POST['grade-level'];
        $houseAddress = $_POST['house-address'];
        $barangay = $_POST['barangay'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $lastSchool = $_POST['last-school'];
        $lastSchoolAddress = $_POST['last-school-address'];
        $isActive = True;
        $parentName = $_POST['parent-fullname'];
        $parentContact = $_POST['parent-contact'];
        $parentRelationship = $_POST['relationship'];
        $studentPicture = $lrn . "_student_picture." . pathinfo($_FILES['student-picture']['name'], PATHINFO_EXTENSION);
        $reportCard = $lrn . "_report_card." . pathinfo($_FILES['report-card']['name'], PATHINFO_EXTENSION);
        $birthCertificate = $lrn . "_birth_certificate." . pathinfo($_FILES['birth-certificate']['name'], PATHINFO_EXTENSION);

        $schoolYear = $_POST['school-year'];
        $targetDir = "../../uploads/". $lrn . "/";
        if(!is_dir($targetDir)){
            mkdir($targetDir);
        }

        if(move_uploaded_file($_FILES['student-picture']['tmp_name'], $targetDir . $studentPicture) && move_uploaded_file($_FILES['report-card']['tmp_name'], $targetDir . $reportCard) && move_uploaded_file($_FILES['birth-certificate']['tmp_name'], $targetDir . $birthCertificate)){
            $addStudentInfo = "INSERT INTO students(lrn, gwa, first_name, middle_name, last_name, suffix, gender, birth_date, birth_place, grade_level, house_address, barangay, city, province, last_school, last_school_address, student_picture, report_card, birth_certificate, isActive)
                            VALUES ('$lrn', '$gwa', '$firstName', '$middleName', '$lastName', '$suffix', '$gender', '$birthDate', '$birthPlace', $gradeLevel, '$houseAddress', '$barangay', '$city', '$province', '$lastSchool', '$lastSchoolAddress', '".$studentPicture."', '".$reportCard."', '".$birthCertificate."', '$isActive')";
            $addParentInfo = "INSERT INTO parent_information(student_lrn, parent_name, parent_contact, parent_relationship)
                            VALUES ('$lrn', '$parentName', '$parentContact', '$parentRelationship')";
            $addStudentToEnrollees = "INSERT INTO Enrollees(student_lrn, school_year)
                            VALUES ('$lrn', '$schoolYear')";
            if(mysqli_query($conn, $addStudentInfo) && mysqli_query($conn, $addParentInfo) && mysqli_query($conn, $addStudentToEnrollees)){
                require_once 'phpMethods/phpqrcode/qrlib.php';
                $qrPath = "../../uploads/generatedQr/";
                $generatedQr = $qrPath.$lrn.".png";
                $qrContent = getHostByName(getHostName())."/BMIS-Capstone-Project/BMIS/scanned_QR.php?lrn=".$lrn;
                QRcode::png($qrContent, $generatedQr, 'H');
                ?>
                <div class="container">
                    <h1>ENROLLMENT SUCCESSFUL!!!</h1>
                    <p>Please scan this QR to check your information. This QR will also help you to track your enrollment Status</p>
                    <img src="<?= $generatedQr ?>" alt="">
                    <div class="action">
                        <a href="<?= $generatedQr ?>" download="<?= $lrn ?>.png">Download QR Image</a>
                        <a href="../index.php">Back to Main Page</a>
                    </div>
                </div>
            <?php }else{
                echo "Error! Please Try Again!!!";
            }
        }else{
            echo "Error in uploading your files!";
        }
    }
    
?>
    </body>
</html>