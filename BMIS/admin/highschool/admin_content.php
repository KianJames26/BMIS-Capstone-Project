<?php
    //Write Dashboard content Below!
    function dashboardContent($gradeLevel)
    {
        $conn = OpenCon();
        $selectActiveSchoolYear = "SELECT * from school_years where school_years.isActive = true";
        $elementaryStudents = 0;
        $elementaryEnrollees = 0;
        if($activeSchoolYear = mysqli_fetch_array(mysqli_query($conn, $selectActiveSchoolYear))){
            if($result = mysqli_query($conn, "SELECT count(enrollees.student_lrn) from enrollees inner join students on enrollees.student_lrn = students.lrn WHERE students.grade_level ". $gradeLevel ." and students.isActive = true and enrollees.school_year = '". $activeSchoolYear['school_year'] ."';")){
                if($row = mysqli_fetch_array($result)) {
                    $elementaryEnrollees = $row[0];
                }
            }
            
            if(mysqli_num_rows(mysqli_query($conn, $selectActiveSchoolYear)) == 0){
                $elementaryStudents = 0;
            }else{
                if ($activeSchoolYear = mysqli_fetch_array(mysqli_query($conn, $selectActiveSchoolYear))) {
                    $enrolledStudentsQuery = "SELECT * FROM `". $activeSchoolYear['school_year'] ."` WHERE `". $activeSchoolYear['school_year'] ."`.grade_level". $gradeLevel;
                    if (mysqli_num_rows(mysqli_query($conn, $enrolledStudentsQuery)) == 0) {
                        $elementaryStudents = 0;
                    }else{
                        $elementaryStudents = mysqli_num_rows(mysqli_query($conn, $enrolledStudentsQuery));
                    }
                }
            }
        }
        CloseCon($conn);
        ?>
        <div class="dashboard">
            <div class="box">
                <div class="icon">
                    <img src="../../../img/add-user.png" alt="O" srcset="">
                </div>
                <div class="text">
                    <p class="title">Number of High School Enrollees : </p>
                    <p class="count"><?php echo $elementaryEnrollees; ?></p>
                </div>
            </div>
            <div class="box">
                <div class="icon">
                    <img src="../../../img/reading-book.png" alt="O" srcset="">
                </div>
                <div class="text">
                    <p class="title" style="font-size: 16px;">Number of Enrolled High School Students : </p>
                    <p class="count"><?php echo $elementaryStudents; ?></p>
                </div>
            </div>
        </div>
    <?php ;
    }
    //Write Enrollees content Below!
    function enrolleesContent($gradeLevel)
    {
        $conn = OpenCon();
        ?>
        <div class="enrollees">
        <?php
        $queryActiveSchoolYear = "SELECT * FROM school_years WHERE isActive = 1";
        if (mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear)) == 0) { ?>
            <h1>No School Year is Active at the moment</h1>
        <?php }elseif ($result = mysqli_fetch_array(mysqli_query($conn, $queryActiveSchoolYear))) {
            $activeSchoolYear = $result['school_year'];
            ?>
            <form action="" method="post" id="filtration">
                <div class="search">
                    <input type="search" name="search-keyword" placeholder="Search for LRN, First Name or Last Name" value="<?php if(isset($_POST['search-keyword'])){echo $_POST['search-keyword'];} ?>">
                    <input type="submit" name="search" value="Search">
                </div>
                <div class="select-grade">
                    <label for="grade-level">Grade Level : </label>
                    <select name="grade-level" id="grade-level" >
                        <option value="default" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == 'default') {echo "selected=selected";}?> >All</option>
                        <option value="7" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '7') {echo "selected=selected";}?> >7</option>
                        <option value="8" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '8') {echo "selected=selected";}?> >8</option>
                        <option value="9" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '9') {echo "selected=selected";}?>>9</option>
                        <option value="10" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '10') {echo "selected=selected";}?>>10</option>
                    </select>
                    <input type="submit" name="filter-grade" value="Filter">
                </div>
                <?php
                if (isset($_POST['grade-level']) || isset($_POST['search-keyword'])) { ?>
                    <a href="?page=manage_enrollees"><img src="../../../img/reset.png" alt="Reset" width="50px"></a>
                <?php }
                ?>
            </form>
            <?php
            if (isset($_POST['search']) || isset($_POST['filter-grade'])) {
                $searchKeyword = trim($_POST['search-keyword']);
                if ($_POST['grade-level'] == "default") {
                    $gradeLevelFilter = $gradeLevel;
                }else{
                    $gradeLevelFilter = $_POST['grade-level'];
                }
                if ($searchKeyword == "" && $gradeLevelFilter == $gradeLevel) {
                    $queryEnrollees = "SELECT * FROM enrollees
                    JOIN students ON enrollees.student_lrn = students.lrn
                    JOIN parent_information ON enrollees.student_lrn = parent_information.student_lrn
                    WHERE enrollees.school_year = '". $activeSchoolYear ."' && students.grade_level". $gradeLevel .";";
                }elseif ($searchKeyword == "") {
                    $queryEnrollees = "SELECT * FROM enrollees
                    JOIN students ON enrollees.student_lrn = students.lrn
                    JOIN parent_information ON enrollees.student_lrn = parent_information.student_lrn
                    WHERE enrollees.school_year = '". $activeSchoolYear ."' && students.grade_level=". $gradeLevelFilter .";";
                }elseif($gradeLevelFilter == $gradeLevel){
                    $queryEnrollees = "SELECT * FROM enrollees
                    JOIN students ON enrollees.student_lrn = students.lrn
                    JOIN parent_information ON enrollees.student_lrn = parent_information.student_lrn
                    WHERE enrollees.school_year = '". $activeSchoolYear ."' AND students.grade_level".$gradeLevel ." AND (students.lrn LIKE '%". $searchKeyword ."%' OR students.first_name LIKE '%". $searchKeyword ."%' OR students.last_name LIKE '%". $searchKeyword ."%');";
                }else{
                    $queryEnrollees = "SELECT * FROM enrollees
                    JOIN students ON enrollees.student_lrn = students.lrn
                    JOIN parent_information ON enrollees.student_lrn = parent_information.student_lrn
                    WHERE enrollees.school_year = '". $activeSchoolYear ."' AND students.grade_level=".$gradeLevelFilter ." AND (students.lrn LIKE '%". $searchKeyword ."%' OR students.first_name LIKE '%". $searchKeyword ."%' OR students.last_name LIKE '%". $searchKeyword ."%');";
                }
            }else{
                $queryEnrollees = "SELECT * FROM enrollees
                JOIN students ON enrollees.student_lrn = students.lrn
                JOIN parent_information ON enrollees.student_lrn = parent_information.student_lrn
                WHERE enrollees.school_year = '". $activeSchoolYear ."' && students.grade_level". $gradeLevel .";";
            }
        } ?>
            <form action="" method="post" id="manage-enrollees">
                <script language="JavaScript">
                    function toggle(selectAll){
                        let checkboxes = document.querySelectorAll('input[type="checkbox"]');
                        if (selectAll.checked == true) {
                            for (let i = 0; i < checkboxes.length; i++) {
                            checkboxes[i].checked = true;
                            }
                        } else {
                            for (let i = 0; i < checkboxes.length; i++) {
                            checkboxes[i].checked = false;
                            }
                        }
                    }
                    function showButton() {
                        var checkboxes = document.querySelectorAll('input[name="lrn[]"]:checked').length;
                        var buttons = document.getElementsByClassName('appear');;
                        if (checkboxes > 0) {
                            for (let i = 0; i < buttons.length; i++) {
                                buttons[i].style.opacity = "100%";
                            }
                        } else {
                            for (let i = 0; i < buttons.length; i++) {
                                buttons[i].style.opacity = "0%";
                            }
                        }
                    }
                </script>
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all" onclick="toggle(this); showButton();"></th>
                            <th>LRN</td>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Gender</th>
                            <th>Birth Date</th>
                            <th>Birth Place</th>
                            <th>Age</th>
                            <th>Grade Level</th>
                            <th>GWA Last School Year</th>
                            <th>Last School</th>
                            <th>Last School Address</th>
                            <th>Guardian Full Name</th>
                            <th>Guardian Contact Number</th>
                            <th>Relationship to Enrollee</th>
                            <th>View Additional Info</th>
                            <th>View Attachments</th>
                            <th>Accept Enrollee</th>
                            <th>Reject Enrollee</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ($result = mysqli_query($conn, $queryEnrollees)) {
                            if (mysqli_num_rows($result) == 0) {?>
                                <tr>
                                    <td colspan="100%"><h1>Empty Data</h1</td>
                                </tr>
                            <?php }else {
                                while ($res = mysqli_fetch_assoc($result)) {
                                    $lrn = $res['lrn'];
                                    $lastName = $res['last_name'];
                                    $firstName = $res['first_name'];
                                    $gender = $res['gender'];
                                    $birthDateNum = $res['birth_date'];
                                    $birthDate = date("F d, Y", strtotime($birthDateNum));
                                    $today = date("Y-m-d");
                                    $diff = date_diff(date_create($birthDateNum), date_create($today));
                                    $age = $diff->format('%y');
                                    $birthPlace = $res['birth_place'];
                                    $enrollGradeLevel = $res['grade_level'];
                                    if ($enrollGradeLevel == "0") {
                                        $enrollGradeLevel = "Kinder";
                                    }
                                    $gwa = $res['gwa'];
                                    $lastSchool = $res['last_school'];
                                    $lastSchoolAddress = $res['last_school_address'];
                                    $parentFullName = $res['parent_name'];
                                    $parentContact = $res['parent_contact'];
                                    $relationship = $res['parent_relationship'];
                                    ?>
                                    <tr id="<?= $lrn?>">
                                        <td><input type="checkbox" name="lrn[]" value="<?= $lrn?>" onchange="showButton()"></td>
                                        <td><?= $lrn ?></td>
                                        <td><?= $lastName ?></td>
                                        <td><?= $firstName ?></td>
                                        <td><?= $gender ?></td>
                                        <td><?= $birthDate ?></td>
                                        <td><?= $birthPlace ?></td>
                                        <td><?= $age ?></td>
                                        <td><?= $enrollGradeLevel ?></td>
                                        <td><?= $gwa ?></td>
                                        <td><?= $lastSchool ?></td>
                                        <td><?= $lastSchoolAddress ?></td>
                                        <td><?= $parentFullName ?></td>
                                        <td><?= $parentContact ?></td>
                                        <td><?= $relationship ?></td>
                                        <td><button type="submit" title="View Addtional Info" name="additional-info" value="<?= $lrn ?>"><img src="../../../img/view.png" alt="Additional Info"></button></td>
                                        <td>Null</td>
                                        <td><button type="submit" title="Accept Enrollee" name="individual-accept" value="<?= $lrn?>"><img src="../../../img/check.png" alt="Accept"></button></td>
                                        <td><button type="submit" title="Reject Enrollee" name="individual-reject" value="<?= $lrn?>"><img src="../../../img/cross-button.png" alt="Reject"></button></td>
                                    </tr>
                                <?php }
                            }
                        }
                    ?>
                    </tbody>
                </table>
                <div class="buttons">
                    <input type="submit" value="Accept" class="appear" id="accept" name="multi-accept">
                    <input type="submit" value="Reject" class="appear" id="reject" name="multi-reject">
                </div>
                <script>
                    const selectAllCheckbox = document.getElementById("select-all");
                    const checkboxes = document.querySelectorAll('input[name="lrn[]"]');
                    for(var i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].addEventListener('change', function() {
                            var anyUnchecked = false;
                            for(var i = 0; i < checkboxes.length; i++) {
                                if(!checkboxes[i].checked) {
                                    anyUnchecked = true;
                                    break;
                                }
                                
                            }
                            if(anyUnchecked) {
                                selectAllCheckbox.checked = false;
                            }
                        });
                    }
                </script>
            </form>
            <?php
            if(isset($_POST['multi-accept'])){
                foreach ($_POST['lrn'] as $lrn) {
                    $queryStudentGrade = "SELECT * FROM students WHERE lrn = ". $lrn;
                    if ($result = mysqli_query($conn, $queryStudentGrade)) {
                        
                        $res = mysqli_fetch_assoc($result);
                        $enrolleeGradeLevel = $res['grade_level'];
                        if ($res['grade_level'] == 0) {
                            $section = rand(1, 10);
                        }else {
                            if($res['gwa'] >= 0 && $res['gwa'] <= 86){
                                $section = rand(6, 10);
                                
                            }elseif($res['gwa'] >= 87 && $res['gwa']<=100){
                                $section = rand(1, 5);
                            }
                        }
                        $enrollStudentsQuery = "INSERT INTO `". $activeSchoolYear ."` (enrolled_lrn, grade_level, section)
                        VALUES ('$lrn', '$enrolleeGradeLevel', '$section')";
                        if (mysqli_query($conn, $enrollStudentsQuery)) {
                            $removeFromEnrolleesQuery = "DELETE FROM enrollees WHERE enrollees.student_lrn = ". $lrn;
                            if (mysqli_query($conn, $removeFromEnrolleesQuery)) {
                                $noError = true;
                            }
                        }
                    }
                }
                if($noError == true){?>
                    <div class="prompt">
                        <div class="prompt__container">
                            <h1>Enrollees Accepted Successfull</h1>
                            <div class="actions">
                                <a href="?page=manage_enrollees" class="confirm">Okay</a>
                            </div>
                        </div>
                    </div>
                <?php }
            }elseif(isset($_POST['individual-accept'])){
                $lrn = $_POST['individual-accept'];
                $queryStudentGrade = "SELECT * FROM students WHERE lrn = ". $lrn;
                    if ($result = mysqli_query($conn, $queryStudentGrade)) {
                        
                        $res = mysqli_fetch_assoc($result);
                        $enrolleeGradeLevel = $res['grade_level'];
                        if ($res['grade_level'] == 0) {
                            $section = rand(1, 10);
                        }else {
                            if($res['gwa'] >= 0 && $res['gwa'] <= 86){
                                $section = rand(6, 10);
                                
                            }elseif($res['gwa'] >= 87 && $res['gwa']<=100){
                                $section = rand(1, 5);
                            }
                        }
                        $enrollStudentsQuery = "INSERT INTO `". $activeSchoolYear ."` (enrolled_lrn, grade_level, section)
                        VALUES ('$lrn', '$enrolleeGradeLevel', '$section')";
                        if (mysqli_query($conn, $enrollStudentsQuery)) {
                            $removeFromEnrolleesQuery = "DELETE FROM enrollees WHERE enrollees.student_lrn = ". $lrn;
                            if (mysqli_query($conn, $removeFromEnrolleesQuery)) {?>
                                <div class="prompt">
                                    <div class="prompt__container">
                                        <h1>Enrollee Accepted Successfully</h1>
                                        <div class="actions">
                                            <a href="?page=manage_enrollees" class="confirm">Okay</a>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                    }
            }elseif (isset($_POST['multi-reject'])) {?>
                <div class="prompt">
                    <form action="" method="post" class="prompt__reject" autocomplete="off">
                        <h1 style="text-align: center;">Reject Students</h1>
                        <table>
                            <thead>
                                <tr>
                                    <th>LRN</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($_POST['lrn'] as $lrn) {?>
                                <tr>
                                    <td><?= $lrn ?><input type="hidden" name="rejected-lrn[]" value="<?= $lrn ?>"></td>
                                    <td><input type="text" name="remark[<?= $lrn ?>]" placeholder="Remark for <?= $lrn?>"></td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                        <div class="actions">
                            <input type="submit" value="Reject Students" name="rejects" class="confirm">
                            <a href="?page=manage_enrollees" class="cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            <?php }elseif(isset($_POST['individual-reject'])){
                $lrn = $_POST['individual-reject'];
                ?>
                <div class="prompt">
                    <form action="" method="post" class="prompt__reject" autocomplete="off">
                        <h1 style="text-align: center;">Reject Students</h1>
                        <table>
                            <thead>
                                <tr>
                                    <th>LRN</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $lrn ?><input type="hidden" name="rejected-lrn" value="<?= $lrn ?>"></td>
                                    <td><input type="text" name="remark[<?= $lrn ?>]" placeholder="Remark for <?= $lrn?>"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="actions">
                            <input type="submit" value="Reject Student" name="reject" class="confirm">
                            <a href="?page=manage_enrollees" class="cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            <?php }elseif (isset($_POST['rejects'])) {
                foreach($_POST['rejected-lrn'] as $lrn){
                    if(trim($_POST['remark'][$lrn]) == ""){
                        $remark = "No Remark";
                    }else{
                        $remark = $_POST['remark'][$lrn];
                    }
                    $addToRejectSql = "INSERT INTO rejected_enrollees (student_lrn, school_year, remark)
                    VALUES ('$lrn', '$activeSchoolYear', '$remark')";
                    if (mysqli_query($conn, $addToRejectSql)) {
                        $removeFromEnrolleesQuery = "DELETE FROM enrollees WHERE enrollees.student_lrn = ". $lrn;
                        if (mysqli_query($conn, $removeFromEnrolleesQuery)) {
                            $noError = true;
                        }
                    }
                }
                if($noError == true){?>
                    <div class="prompt">
                        <div class="prompt__container">
                            <h1>Enrollees Rejected Successfully</h1>
                            <div class="actions">
                                <a href="?page=manage_enrollees" class="confirm">Okay</a>
                            </div>
                        </div>
                    </div>
                <?php }
            }elseif (isset($_POST['reject'])) {
                $lrn = $_POST['rejected-lrn'];
                if(trim($_POST['remark'][$lrn]) == ""){
                    $remark = "No Remarks";
                }else{
                    $remark = $_POST['remark'][$lrn];
                }
                $addToRejectSql = "INSERT INTO rejected_enrollees (student_lrn, school_year, remark)
                VALUES ('$lrn', '$activeSchoolYear', '$remark')";
                if (mysqli_query($conn, $addToRejectSql)) {
                    $removeFromEnrolleesQuery = "DELETE FROM enrollees WHERE enrollees.student_lrn = ". $lrn;
                    if (mysqli_query($conn, $removeFromEnrolleesQuery)) {?>
                        <div class="prompt">
                            <div class="prompt__container">
                                <h1>Enrollee Rejected Successfully</h1>
                                <div class="actions">
                                    <a href="?page=manage_enrollees" class="confirm">Okay</a>
                                </div>
                            </div>
                        </div>
                    <?php }
                }
            }
            ?>
        </div>
    <?php }
    //Write Archived Content Below!
    function archived($gradeLevel){
        $conn = OpenCon();
        ?>
        <div class="enrollees">
        <?php
        $queryActiveSchoolYear = "SELECT * FROM school_years WHERE isActive = 1";
        if (mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear)) == 0) { ?>
            <h1>No School Year is Active at the moment</h1>
        <?php }elseif ($result = mysqli_fetch_array(mysqli_query($conn, $queryActiveSchoolYear))) {
            $activeSchoolYear = $result['school_year'];
            ?>
            <form action="" method="post" id="filtration">
                <div class="search">
                    <input type="search" name="search-keyword" placeholder="Search for LRN, First Name or Last Name" value="<?php if(isset($_POST['search-keyword'])){echo $_POST['search-keyword'];} ?>">
                    <input type="submit" name="search" value="Search">
                </div>
                <div class="select-grade">
                    <label for="grade-level">Grade Level : </label>
                    <select name="grade-level" id="grade-level" >
                        <option value="default" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == 'default') {echo "selected=selected";}?> >All</option>
                        <option value="7" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '7') {echo "selected=selected";}?> >7</option>
                        <option value="8" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '8') {echo "selected=selected";}?> >8</option>
                        <option value="9" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '9') {echo "selected=selected";}?>>9</option>
                        <option value="10" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '10') {echo "selected=selected";}?>>10</option>
                    </select>
                    <input type="submit" name="filter-grade" value="Filter">
                </div>
                <?php
                if (isset($_POST['grade-level']) || isset($_POST['search-keyword'])) { ?>
                    <a href="?page=rejected_enrollees"><img src="../../../img/reset.png" alt="Reset" width="50px"></a>
                <?php }
                ?>
            </form>
            <?php
            if (isset($_POST['search']) || isset($_POST['filter-grade'])) {
                $searchKeyword = trim($_POST['search-keyword']);
                if ($_POST['grade-level'] == "default") {
                    $gradeLevelFilter = $gradeLevel;
                }else{
                    $gradeLevelFilter = $_POST['grade-level'];
                }
                if ($searchKeyword == "" && $gradeLevelFilter == $gradeLevel) {
                    $queryEnrollees = "SELECT * FROM rejected_enrollees
                    JOIN students ON rejected_enrollees.student_lrn = students.lrn
                    JOIN parent_information ON rejected_enrollees.student_lrn = parent_information.student_lrn
                    WHERE rejected_enrollees.school_year = '". $activeSchoolYear ."' && students.grade_level". $gradeLevel .";";
                }elseif ($searchKeyword == "") {
                    $queryEnrollees = "SELECT * FROM rejected_enrollees
                    JOIN students ON rejected_enrollees.student_lrn = students.lrn
                    JOIN parent_information ON rejected_enrollees.student_lrn = parent_information.student_lrn
                    WHERE rejected_enrollees.school_year = '". $activeSchoolYear ."' && students.grade_level=". $gradeLevelFilter .";";
                }elseif($gradeLevelFilter == $gradeLevel){
                    $queryEnrollees = "SELECT * FROM rejected_enrollees
                    JOIN students ON rejected_enrollees.student_lrn = students.lrn
                    JOIN parent_information ON rejected_enrollees.student_lrn = parent_information.student_lrn
                    WHERE rejected_enrollees.school_year = '". $activeSchoolYear ."' AND students.grade_level".$gradeLevel ." AND (students.lrn LIKE '%". $searchKeyword ."%' OR students.first_name LIKE '%". $searchKeyword ."%' OR students.last_name LIKE '%". $searchKeyword ."%');";
                }else{
                    $queryEnrollees = "SELECT * FROM rejected_enrollees
                    JOIN students ON rejected_enrollees.student_lrn = students.lrn
                    JOIN parent_information ON rejected_enrollees.student_lrn = parent_information.student_lrn
                    WHERE rejected_enrollees.school_year = '". $activeSchoolYear ."' AND students.grade_level=".$gradeLevelFilter ." AND (students.lrn LIKE '%". $searchKeyword ."%' OR students.first_name LIKE '%". $searchKeyword ."%' OR students.last_name LIKE '%". $searchKeyword ."%');";
                }
            }else{
                $queryEnrollees = "SELECT * FROM rejected_enrollees
                JOIN students ON rejected_enrollees.student_lrn = students.lrn
                JOIN parent_information ON rejected_enrollees.student_lrn = parent_information.student_lrn
                WHERE rejected_enrollees.school_year = '". $activeSchoolYear ."' && students.grade_level". $gradeLevel .";";
            }
        } ?>
            <form action="" method="post" id="manage-enrollees">
                <script language="JavaScript">
                    function toggle(selectAll){
                        let checkboxes = document.querySelectorAll('input[type="checkbox"]');
                        if (selectAll.checked == true) {
                            for (let i = 0; i < checkboxes.length; i++) {
                            checkboxes[i].checked = true;
                            }
                        } else {
                            for (let i = 0; i < checkboxes.length; i++) {
                            checkboxes[i].checked = false;
                            }
                        }
                    }
                    function showButton() {
                        var checkboxes = document.querySelectorAll('input[name="lrn[]"]:checked').length;
                        var buttons = document.getElementsByClassName('appear');;
                        if (checkboxes > 0) {
                            for (let i = 0; i < buttons.length; i++) {
                                buttons[i].style.opacity = "100%";
                            }
                        } else {
                            for (let i = 0; i < buttons.length; i++) {
                                buttons[i].style.opacity = "0%";
                            }
                        }
                    }
                </script>
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all" onclick="toggle(this); showButton();"></th>
                            <th>LRN</td>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Remarks</th>
                            <th>Gender</th>
                            <th>Birth Date</th>
                            <th>Birth Place</th>
                            <th>Age</th>
                            <th>Grade Level</th>
                            <th>GWA Last School Year</th>
                            <th>Last School</th>
                            <th>Last School Address</th>
                            <th>Guardian Full Name</th>
                            <th>Guardian Contact Number</th>
                            <th>Relationship to Enrollee</th>
                            <th>View Additional Info</th>
                            <th>View Attachments</th>
                            <th>Undo Rejection</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ($result = mysqli_query($conn, $queryEnrollees)) {
                            if (mysqli_num_rows($result) == 0) {?>
                                <tr>
                                    <td colspan="100%"><h1>Empty Data</h1</td>
                                </tr>
                            <?php }else {
                                while ($res = mysqli_fetch_assoc($result)) {
                                    $lrn = $res['lrn'];
                                    $lastName = $res['last_name'];
                                    $firstName = $res['first_name'];
                                    $reason = $res['remark'];
                                    $gender = $res['gender'];
                                    $birthDateNum = $res['birth_date'];
                                    $birthDate = date("F d, Y", strtotime($birthDateNum));
                                    $today = date("Y-m-d");
                                    $diff = date_diff(date_create($birthDateNum), date_create($today));
                                    $age = $diff->format('%y');
                                    $birthPlace = $res['birth_place'];
                                    $enrollGradeLevel = $res['grade_level'];
                                    if ($enrollGradeLevel == "0") {
                                        $enrollGradeLevel = "Kinder";
                                    }
                                    $gwa = $res['gwa'];
                                    $lastSchool = $res['last_school'];
                                    $lastSchoolAddress = $res['last_school_address'];
                                    $parentFullName = $res['parent_name'];
                                    $parentContact = $res['parent_contact'];
                                    $relationship = $res['parent_relationship'];
                                    ?>
                                    <tr id="<?= $lrn?>">
                                        <td><input type="checkbox" name="lrn[]" value="<?= $lrn?>" onchange="showButton()"></td>
                                        <td><?= $lrn ?></td>
                                        <td><?= $lastName ?></td>
                                        <td><?= $firstName ?></td>
                                        <td><?= $reason ?></td>
                                        <td><?= $gender ?></td>
                                        <td><?= $birthDate ?></td>
                                        <td><?= $birthPlace ?></td>
                                        <td><?= $age ?></td>
                                        <td><?= $enrollGradeLevel ?></td>
                                        <td><?= $gwa ?></td>
                                        <td><?= $lastSchool ?></td>
                                        <td><?= $lastSchoolAddress ?></td>
                                        <td><?= $parentFullName ?></td>
                                        <td><?= $parentContact ?></td>
                                        <td><?= $relationship ?></td>
                                        <td><button type="submit" title="View Addtional Info" name="additional-info" value="<?= $lrn ?>"><img src="../../../img/view.png" alt="Additional Info"></button></td>
                                        <td>Null</td>
                                        <td><button type="submit" title="Undo Rejection" name="individual-undo" value="<?= $lrn?>"><img src="../../../img/turn-left.png" alt="Accept"></button></td>
                                    </tr>
                                <?php }
                            }
                        }
                    ?>
                    </tbody>
                </table>
                <div class="buttons">
                    <input type="submit" value="Undo Rejection" class="appear" id="accept" name="multi-undo">
                </div>
                <script>
                    const selectAllCheckbox = document.getElementById("select-all");
                    const checkboxes = document.querySelectorAll('input[name="lrn[]"]');
                    for(var i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].addEventListener('change', function() {
                            var anyUnchecked = false;
                            for(var i = 0; i < checkboxes.length; i++) {
                                if(!checkboxes[i].checked) {
                                    anyUnchecked = true;
                                    break;
                                }
                            }
                            if(anyUnchecked) {
                                selectAllCheckbox.checked = false;
                            }
                        });
                    }
                </script>
            </form>
            <?php
                if (isset($_POST['multi-undo'])) {
                    foreach($_POST['lrn'] as $lrn){
                        $addToEnrolleesQuery = "INSERT INTO enrollees (student_lrn, school_year)
                        VALUES ('$lrn','$activeSchoolYear')";
                        if (mysqli_query($conn, $addToEnrolleesQuery)) {
                            $removeFromRejectedQuery = "DELETE FROM rejected_enrollees WHERE rejected_enrollees.student_lrn = ". $lrn;
                            if(mysqli_query($conn, $removeFromRejectedQuery)){
                                $noError = true;
                            }
                        }
                    }
                    if($noError == true){?>
                        <div class="prompt">
                            <div class="prompt__container">
                                <h1>Rejected Enrollees Successfully Returned to Enrollees</h1>
                                <div class="actions">
                                    <a href="?page=rejected_enrollees" class="confirm">Okay</a>
                                </div>
                            </div>
                        </div>
                    <?php }
                }elseif(isset($_POST['individual-undo'])) {
                    $lrn = $_POST['individual-undo'];
                    $addToEnrolleesQuery = "INSERT INTO enrollees (student_lrn, school_year)
                    VALUES ('$lrn','$activeSchoolYear')";
                    if (mysqli_query($conn, $addToEnrolleesQuery)) {
                        $removeFromRejectedQuery = "DELETE FROM rejected_enrollees WHERE rejected_enrollees.student_lrn = ". $lrn;
                        if(mysqli_query($conn, $removeFromRejectedQuery)){?>
                            <div class="prompt">
                                <div class="prompt__container">
                                    <h1>Rejected Enrollee Successfully Returned as an Enrollee</h1>
                                    <div class="actions">
                                        <a href="?page=rejected_enrollees" class="confirm">Okay</a>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                }
            ?>
        </div>
    <?php }
    //Write Admin Controls Content Below!
    function adminControlsContent($gradeLevel){
        $conn = OpenCon();
        ?>
        <div class="admin-controls">
            <nav class="sub-pages">
            <a <?php if($_GET["sub-page"] == "school-year"){echo "id='active-sub-page'";}else{echo "href='?page=".$_GET['page']."&sub-page=school-year'";}?> >School Year</a>
                <a <?php if($_GET["sub-page"] == "news"){echo "id='active-sub-page'";}else{echo "href='?page=".$_GET['page']."&sub-page=news'";}?> >News</a>
                <a <?php if($_GET["sub-page"] == "announcement"){echo "id='active-sub-page'";}else{echo "href='?page=".$_GET['page']."&sub-page=announcement'";}?> >Announcements</a>
            </nav>
            <div class="sub-page-container">
                <?php if ($_GET["sub-page"] == "news") {?>
                    <div class="sub-page-news">
                        news
                    </div>
                <?php ;}else if ($_GET["sub-page"] == "announcement") {?>
                    <div>Announcement</div>
                <?php ;}else if ($_GET["sub-page"] == "school-year") {
                    $selectActiveSchoolYear = "SELECT * from school_years where school_years.isActive = true";
                    if($result = mysqli_query($conn, $selectActiveSchoolYear)){
                        if(mysqli_num_rows($result) == 0){?>
                            <script>
                                function hideAlertBox() {
                                    const alertBox = document.getElementsByClassName('alert-box')[0];
                                    alertBox.className = "hidden-alert-box";
                                }
                            </script>
                            <form autocomplete="off" action="" method="post" onsubmit="return confirm('Do you want to submit?')">
                                <h1>No School Year is active at the moment</h1>
                                <label for="school-year">Input or select School Year to be created : </label>
                                <input type="text" name="school-year" list="school-year-list" placeholder="20xx-20yy" value="<?php echo isset($_POST['school-year']) ? $_POST['school-year'] : ''; ?>">
                                <datalist id="school-year-list">
                                    <option value="2022-2023">
                                    <option value="2023-2024">
                                    <option value="2024-2025">
                                    <option value="2025-2026">
                                    <option value="2026-2027">
                                </datalist>
                                <input type="submit" value="Create">
                            </form>
                            <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $schoolYear = trim($_REQUEST['school-year']);
                                    if (empty($schoolYear)) {?>
                                        <div class="alert-box">
                                            <div class="alert-box__container">
                                                <p>School Year Field can't be empty</p>
                                                <button onclick="hideAlertBox()">Okay</button>
                                            </div>
                                        </div>
                                    <?php } else if(strlen($schoolYear) !=9){?>
                                        <div class="alert-box">
                                            <div class="alert-box__container">
                                                <p>Invalid School Year</p>
                                                <p class="sub">Please input a proper school year <br>(example : 2010-2011)</p>
                                                <button onclick="hideAlertBox()">Okay</button>
                                            </div>
                                        </div>
                                    <?php } else {
                                        $insertSchoolYear = "INSERT INTO school_years VALUES('$schoolYear', true)";
                                        $reactivateSchoolYear = "UPDATE school_years SET school_years.isActive = true WHERE school_years.school_year = '".$schoolYear."';";
                                        if ($result = mysqli_query($conn, "SELECT * FROM school_years WHERE school_years.school_year ='".$schoolYear."';")) {
                                            if (mysqli_num_rows($result) == 0) {
                                                if (mysqli_query($conn, $insertSchoolYear)) {
                                                    // header("Refresh:0");
                                                    $createSchoolYearTable = "CREATE TABLE `". $schoolYear ."` (
                                                        enrolled_lrn varchar(12) NOT NULL UNIQUE,
                                                        grade_level int NOT NULL,
                                                        section int NOT NULL,   
                                                        
                                                        FOREIGN KEY (enrolled_lrn) REFERENCES students(lrn)
                                                    )";
                                                    if (mysqli_query($conn, $createSchoolYearTable)) {
                                                        header("Refresh:0");
                                                    }
                                                }
                                            }else{
                                                if(mysqli_query($conn, $reactivateSchoolYear)){
                                                    header("Refresh:0");
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>
                        <?php ;}else{
                            while($res = mysqli_fetch_array($result)){
                                $queryActiveSchoolYear = "SELECT * FROM `". $res['school_year'] ."`";
                                ?>
                                <div class="sub-page-school-year">
                                    <p class="sub-page-header">Current School Year : <?= $res['school_year']?> </p>
                                    <div class="school-year-content">
                                        <div class="left">
                                            <p class="sub-page-header">Total Enrolled Students: <?= mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear." WHERE grade_level".$gradeLevel)) ?></p>
                                            <p>Grade 7 : <?= mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear." WHERE grade_level = 7")) ?></p>
                                            <p>Grade 8 : <?= mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear." WHERE grade_level = 8")) ?></p>
                                            <p>Grade 9 : <?= mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear." WHERE grade_level = 9")) ?></p>
                                            <p>Grade 10 : <?= mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear." WHERE grade_level = 10")) ?></p>
                                        </div>
                                        <div class="right">
                                            <a href="?page=<?= $_GET['page']?>&sub-page=<?= $_GET['sub-page']?>&reset=<?= $res['school_year']?>"><img src="../../../img/circular.png">Reset School Year</a>
                                        </div>
                                    </div>
                                </div>
                                <?php if (isset($_GET['reset'])) {?>
                                    <div class="small_box">
                                        <div class="container">
                                            <h1>Are you sure you want to reset school year?</h1>
                                            <p>Note: This will end the whole school year and will require students to enroll again.</p>
                                            <div class="action">
                                                <a href="?page=<?= $_GET['page']?>&sub-page=<?= $_GET['sub-page']?>" id="cancel">Cancel</a>
                                                <a href="?page=<?= $_GET['page']?>&sub-page=<?= $_GET['sub-page']?>&resetting=<?= $_GET['reset']?>" id="yes">Yes</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php ;}?>
                            <?php ;}
                        }
                    }
                    ?>
                <?php ;}else{
                    header("Location: ../../../index.php");
                    session_destroy();
                }?>
                <?php if(isset($_GET['resetting'])){
                    $resetQuery = "UPDATE `school_years` SET `isActive` = false WHERE `school_years`.`school_year` = '".$_GET['resetting']."';";
                    mysqli_query($conn, $resetQuery);
                    ?>
                    <div class="small_box">
                        <div class="container">
                            <h1>School Year <?= $_GET['resetting']?> successfully reset!</h1>
                            <div class="action">
                                <a href="?page=<?= $_GET['page']?>&sub-page=<?= $_GET['sub-page']?>" id="proceed">Proceed to School Year</a>
                            </div>
                        </div>
                    </div>
                <?php ;} ?>
            </div>
        </div>
    <?php ;
        CloseCon($conn);
    }
    //Write Enrolled Students Content Below!
    function enrolledStudentsContent(){
        $conn = OpenCon();
        ?>
        <div class="students">
            <?php
            $queryActiveSchoolYear = "SELECT * FROM school_years where school_years.isActive = 1";
            if (mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear)) == 0) {?>
                <h1>No School Year is Active at the moment</h1>
            <?php }elseif($activeSchoolYear = mysqli_fetch_assoc(mysqli_query($conn, $queryActiveSchoolYear))){
                $schoolYear = $activeSchoolYear['school_year'];
                ?>
                <form action="" method="post" id="filtration">
                    <div class="select-grade">
                        <label for="grade-level">Grade Level : </label>
                        <select name="grade-level" id="grade-level" >
                            <option value="default" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == 'default') {echo "selected=selected";}?> >All</option>
                            <option value="0" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '7') {echo "selected=selected";}?> >Kinder</option>
                            <option value="1" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '8') {echo "selected=selected";}?> >1</option>
                            <option value="2" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '9') {echo "selected=selected";}?>>2</option>
                            <option value="3" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '10') {echo "selected=selected";}?>>3</option>
                        </select>
                    </div>
                    <div class="select-grade">
                        <label for="section">Section : </label>
                        <select name="section" id="section" >
                            <option value="default" <?php if (isset($_POST['section']) && $_POST['section'] == 'default') {echo "selected";}?> >All</option>
                            <option value="1" <?php if (isset($_POST['section']) && $_POST['section'] == '1') {echo "selected";}?>>1</option>
                            <option value="2" <?php if (isset($_POST['section']) && $_POST['section'] == '2') {echo "selected";}?>>2</option>
                            <option value="3" <?php if (isset($_POST['section']) && $_POST['section'] == '3') {echo "selected";}?>>3</option>
                            <option value="4" <?php if (isset($_POST['section']) && $_POST['section'] == '4') {echo "selected";}?>>4</option>
                            <option value="5" <?php if (isset($_POST['section']) && $_POST['section'] == '5') {echo "selected";}?>>5</option>
                            <option value="6" <?php if (isset($_POST['section']) && $_POST['section'] == '6') {echo "selected";}?>>6</option>
                            <option value="7" <?php if (isset($_POST['section']) && $_POST['section'] == '7') {echo "selected";}?>>7</option>
                            <option value="8" <?php if (isset($_POST['section']) && $_POST['section'] == '8') {echo "selected";}?>>8</option>
                            <option value="9" <?php if (isset($_POST['section']) && $_POST['section'] == '9') {echo "selected";}?>>9</option>
                            <option value="10" <?php if (isset($_POST['section']) && $_POST['section'] == '10') {echo "selected";}?>>10</option>
                        </select>
                        <input type="submit" name="filter" value="Filter">
                    </div>
                    <?php
                    if (isset($_POST['grade-level']) || isset($_POST['section'])) { ?>
                        <a href="?page=enrolled_students"><img src="../../../img/reset.png" alt="Reset" width="50px"></a>
                    <?php }
                    ?>
                </form>
                <form action="" method="post" id="manage-enrollees">
                <?php 
                
                if (isset($_POST['filter'])) {
                    $filterGradeLevel = $_POST['grade-level'];
                    $filterSection = $_POST['section'];
                    if($filterGradeLevel == "default" && $filterSection == "default"){
                        for ($g=7; $g < 11; $g++) { 
                            for ($s=1; $s < 11; $s++) { 
                                showTable($g, $s, $conn, $schoolYear);
                            }
                        }
                    }elseif($filterGradeLevel == "default"){
                        for ($g=7; $g < 11; $g++) { 
                            showTable($g, $filterSection, $conn, $schoolYear);
                        }
                    }elseif ($filterSection == "default") {
                        for ($s=1; $s < 11; $s++) { 
                            showTable($filterGradeLevel, $s, $conn, $schoolYear);
                        }
                    }else{
                        showTable($filterGradeLevel, $filterSection, $conn, $schoolYear);
                    }
                }else{
                    for ($g=7; $g < 11; $g++) { 
                        for ($s=1; $s < 11; $s++) {
                            showTable($g, $s, $conn, $schoolYear);
                        }
                    }
                }
            }
            ?>
            <div class="buttons">
                <input type="submit" value="Remove Students" class="appear" id="reject" name="multi-remove">
            </div>
            </form>
            <script language="JavaScript">
                function showButtonIfChecked() {
                var checkboxes = document.querySelectorAll('input[name="lrn[]"]');
                var boool = false;
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].checked) {
                    boool = true;
                    break;
                    }
                }
                    if (boool) {
                        document.getElementById('reject').style.opacity = '100%';
                    } else {
                        document.getElementById('reject').style.opacity = '0%';
                    }
                }
                
                window.addEventListener('load', showButtonIfChecked);
            </script>
        </div>
        <?php
        if (isset($_POST['multi-remove'])) {
            foreach ($_POST['lrn'] as $lrn) {
                $removeFromEnrolledQuery = "DELETE FROM `$schoolYear` WHERE enrolled_lrn = '$lrn'";
                if (mysqli_query($conn, $removeFromEnrolledQuery)) {
                    $addToEnrolleesQuery = "INSERT INTO enrollees(student_lrn, school_year)
                    VALUES ('$lrn', '$schoolYear')";
                    if (mysqli_query($conn, $addToEnrolleesQuery)) {
                        $noError = true;
                    }
                }
            }
            if ($noError == true) {?>
                <div class="prompt">
                    <div class="prompt__container">
                        <h1>Students Moved Back to Enrollees Successfully!</h1>
                        <div class="actions">
                            <a href="?page=manage_enrollees" class="confirm">Okay</a>
                        </div>
                    </div>
                </div>
            <?php }
        }elseif (isset($_POST['individual-remove'])) {
            $lrn = $_POST['individual-remove'];
            $removeFromEnrolledQuery = "DELETE FROM `$schoolYear` WHERE enrolled_lrn = '$lrn'";
            if (mysqli_query($conn, $removeFromEnrolledQuery)) {
                $addToEnrolleesQuery = "INSERT INTO enrollees (student_lrn, school_year)
                VALUES ('$lrn', '$schoolYear')";
                if (mysqli_query($conn, $addToEnrolleesQuery)) {?>
                    <div class="prompt">
                        <div class="prompt__container">
                            <h1>Students Moved Back to Enrollees Successfully!</h1>
                            <div class="actions">
                                <a href="?page=manage_enrollees" class="confirm">Okay</a>
                            </div>
                        </div>
                    </div>
                <?php }
            }
        }
        CloseCon($conn);
    }
    function showTable($grade, $section, $conn, $schoolYear){
            if ($grade == 0) {
                $gradeLevel = "Kinder";
            }else {
                $gradeLevel = "Grade " . $grade;
            }
            $studentInfoQuery = "SELECT * FROM `$schoolYear`
            JOIN students ON `$schoolYear`.enrolled_lrn = students.lrn
            JOIN parent_information ON `$schoolYear`.enrolled_lrn = parent_information.student_lrn
            WHERE `$schoolYear`.grade_level = '$grade' AND `$schoolYear`.section = '$section'";
        ?>
        
        <h1><?= $gradeLevel ?> Section <?= $section?></h1>
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-<?= "g".$grade."s".$section ?>" onchange="showButtonIfChecked()"></th>
                    <th>LRN</td>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Gender</th>
                    <th>Birth Date</th>
                    <th>Birth Place</th>
                    <th>Age</th>
                    <th>Grade Level</th>
                    <th>GWA Last School Year</th>
                    <th>Last School</th>
                    <th>Last School Address</th>
                    <th>Guardian Full Name</th>
                    <th>Guardian Contact Number</th>
                    <th>Relationship to Enrollee</th>
                    <th>Remove Student</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($result = mysqli_query($conn, $studentInfoQuery)) {
                    if (mysqli_num_rows($result) == 0) {?>
                        <tr>
                            <td colspan="100%"><h1>Empty Data</h1</td>
                        </tr>
                    <?php }else {
                        while ($res = mysqli_fetch_assoc($result)) {
                            $lrn = $res['lrn'];
                            $lastName = $res['last_name'];
                            $firstName = $res['first_name'];
                            $gender = $res['gender'];
                            $birthDateNum = $res['birth_date'];
                            $birthDate = date("F d, Y", strtotime($birthDateNum));
                            $today = date("Y-m-d");
                            $diff = date_diff(date_create($birthDateNum), date_create($today));
                            $age = $diff->format('%y');
                            $birthPlace = $res['birth_place'];
                            $enrollGradeLevel = $res['grade_level'];
                            if ($enrollGradeLevel == "0") {
                                $enrollGradeLevel = "Kinder";
                            }
                            $gwa = $res['gwa'];
                            $lastSchool = $res['last_school'];
                            $lastSchoolAddress = $res['last_school_address'];
                            $parentFullName = $res['parent_name'];
                            $parentContact = $res['parent_contact'];
                            $relationship = $res['parent_relationship'];
                            ?>
                            <tr id="<?= $lrn?>">
                                <td><input type="checkbox" name="lrn[]" value="<?= $lrn?>" onchange="showButtonIfChecked()" class="<?= "g".$grade."s".$section ?>"></td>
                                <td><?= $lrn ?></td>
                                <td><?= $lastName ?></td>
                                <td><?= $firstName ?></td>
                                <td><?= $gender ?></td>
                                <td><?= $birthDate ?></td>
                                <td><?= $birthPlace ?></td>
                                <td><?= $age ?></td>
                                <td><?= $enrollGradeLevel ?></td>
                                <td><?= $gwa ?></td>
                                <td><?= $lastSchool ?></td>
                                <td><?= $lastSchoolAddress ?></td>
                                <td><?= $parentFullName ?></td>
                                <td><?= $parentContact ?></td>
                                <td><?= $relationship ?></td>
                                <td><button type="submit" title="Remove Student" name="individual-remove" value="<?= $lrn?>"><img src="../../../img/cross-button.png" alt="Reject"></button></td>
                            </tr>
                        <?php }
                    }
                }
            ?>
            </tbody>
        </table>
        <script>
            const selectAllCheckbox<?= "g".$grade."s".$section ?> = document.getElementById("select-<?= "g".$grade."s".$section ?>");
            const <?= "g".$grade."s".$section ?>checkboxes = document.querySelectorAll('.<?= "g". $grade ."s" . $section ?>');
            for(var i = 0; i < <?= "g".$grade."s".$section ?>checkboxes.length; i++) {
                <?= "g".$grade."s".$section ?>checkboxes[i].addEventListener('change', function() {
                    var anyUnchecked = false;
                    for(var i = 0; i < <?= "g".$grade."s".$section ?>checkboxes.length; i++) {
                        if(!<?= "g".$grade."s".$section ?>checkboxes[i].checked) {
                            anyUnchecked = true;
                            break;
                        }
                        
                    }
                    if(anyUnchecked) {
                        selectAllCheckbox<?= "g".$grade."s".$section ?>.checked = false;
                    }
                });
            }
            document.getElementById('select-<?= "g".$grade."s".$section ?>').addEventListener('click', function() {
                var selectAll = this;
                var selectCheckboxes = document.querySelectorAll('.<?= "g". $grade ."s" . $section ?>');
                selectCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = selectAll.checked;
                });
            });
        </script>
    <?php }?>