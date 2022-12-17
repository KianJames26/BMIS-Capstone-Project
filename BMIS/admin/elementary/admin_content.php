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
                    <p class="title">Number of Elementary Enrollees : </p>
                    <p class="count"><?php echo $elementaryEnrollees; ?></p>
                </div>
            </div>
            <div class="box">
                <div class="icon">
                    <img src="../../../img/reading-book.png" alt="O" srcset="">
                </div>
                <div class="text">
                    <p class="title" style="font-size: 16px;">Number of Enrolled Elementary Students : </p>
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
                        <option value="0" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '0') {echo "selected=selected";}?> >Kinder</option>
                        <option value="1" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '1') {echo "selected=selected";}?> >1</option>
                        <option value="2" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '2') {echo "selected=selected";}?>>2</option>
                        <option value="3" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '3') {echo "selected=selected";}?>>3</option>
                        <option value="4" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '4') {echo "selected=selected";}?>>4</option>
                        <option value="5" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '5') {echo "selected=selected";}?>>5</option>
                        <option value="6" <?php if (isset($_POST['grade-level']) && $_POST['grade-level'] == '6') {echo "selected=selected";}?>>6</option>
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
                                        <td>Null</td>
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
                            if($res['gwa'] >= 60 && $res['gwa'] <= 86 && $res['gwa']){
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
                                        <h1>Enrollees Accepted Successfull</h1>
                                        <div class="actions">
                                            <a href="?page=manage_enrollees" class="confirm">Okay</a>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                    }
                }
            }elseif(isset($_POST['individual-accept'])){
                $lrn = $_POST['individual-accept'];
                $queryStudentGrade = "SELECT * FROM students WHERE lrn = ". $lrn;
                    if ($result = mysqli_query($conn, $queryStudentGrade)) {
                        
                        $res = mysqli_fetch_assoc($result);
                        $enrolleeGradeLevel = $res['grade_level'];
                        if ($res['grade_level'] == 0) {
                            $section = rand(1, 10);
                        }else {
                            if($res['gwa'] >= 60 && $res['gwa'] <= 86 && $res['gwa']){
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
            }elseif (isset($_POST['multi-reject'])) {
                foreach ($_POST['lrn'] as $lrn) {
                    
                }
            }elseif(isset($_POST['individual-reject'])){
                
            }
            ?>
        </div>
    <?php }
    //Write Archived Content Below!
    function archived($gradeLevel){
        $searchKeyword = "";
        ?>
    
        <div class="enrollees">
            <form action="admin.php?page=<?= $_GET['page']?>" method="post">
                <input type="search" name="search-keyword" id="search" placeholder="Search LRN, First Name or Last Name" value="<?php echo isset($_POST['search-keyword']) ? $_POST['search-keyword'] : ''; ?>">
                <button name="search">Search</button>   
            </form>
            <table>
                <tr class="table-header">
                    <th>LRN</th>
                    <th>Full Name</th>
                    <th>Parent/Guardian Information</th>
                    <th>Relationship</th>
                    <th>Parent Contact Number</th>
                    <th>Grade Level</th>
                    <th>Action</th>
                </tr>
                <?php
                $conn = OpenCon();
                if(isset($_POST['search'])){
                    $searchKeyword = $_POST['search-keyword'];
                }
                if(trim($searchKeyword) == ""){
                    $sql = "SELECT enrollees.student_lrn, students.*, parent_information.* from enrollees join students on enrollees.student_lrn = students.lrn join parent_information on parent_information.student_lrn = students.lrn WHERE students.grade_level ". $gradeLevel ." and students.isActive = false;";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) == 0){?>
                            <tr><td colspan="100%"><h1>No Archived Students</h1></td></tr>
                        <?php }else{
                            while ($res = mysqli_fetch_array($result)) {
                                ?>
                                <tr id=<?= $res['lrn']?>>
                                    <td><?= $res['lrn'] ?></td>
                                    <td><?= $res['last_name'];?>, <?php echo $res['first_name'];?></td>
                                    <td><?= $res['parent_name'];?></td>
                                    <td><?= $res['parent_relationship'];?></td>
                                    <td><?= $res['parent_contact'];?></td>
                                    <td><?= $res['grade_level'];?></td>
                                    <td class="action">
                                        <a href="?page=<?= $_GET['page']?>&restore=<?php echo $res['lrn'];?>"><img src="../../../img/history.png" alt="" height="30px"></a>
                                    </td>
                                </tr>
                            <?php }
                        }
                    }
                }else {
                    $sql = "SELECT enrollees.student_lrn, students.*, parent_information.* from enrollees join students on enrollees.student_lrn = students.lrn join parent_information on parent_information.student_lrn = students.lrn WHERE students.grade_level ". $gradeLevel ." and students.isActive = false and (students.lrn like '". $searchKeyword ."%' or students.first_name like '%". $searchKeyword ."%' or students.last_name like '%". $searchKeyword ."%');";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) == 0){?>
                            <tr><td colspan="100%"><h1>There are no data fetched in your search</h1></td></tr>
                        <?php }else{
                            while ($res = mysqli_fetch_array($result)) {
                                ?>
                                <tr id=<?= $res['lrn']?>>
                                    <td><?= $res['lrn'] ?></td>
                                    <td><?= $res['last_name'];?>, <?= $res['first_name'];?></td>
                                    <td><?= $res['parent_name'];?></td>
                                    <td><?= $res['parent_relationship'];?></td>
                                    <td><?= $res['parent_contact'];?></td>
                                    <td><?= $res['grade_level'];?></td>
                                    <td class="action">
                                        <a id="edit" href="?page=<?= $_GET['page']?>&restore=<?php echo $res['lrn'];?>"><img src="../../../img/history.png" alt="" height="30px"></a>
                                    </td>
                                </tr>
                            <?php }
                        }
                    }
                }
                if(isset($_GET['restore'])){?>
                    <div class="small_box">
                        <div class="container">
                            <h1>Are you sure you want to restore <?= $_GET['restore']?>?</h1>
                            <div class="action">
                                <a href="?page=<?= $_GET['page']?>" id="cancel">Cancel</a>
                                <a href="?page=<?= $_GET['page']?>&yes=<?= $_GET['restore']?>" id="yes">Yes</a>
                            </div>
                        </div>
                    </div>
                <?php ;}
                if (isset($_GET['yes'])){
                    $restoreStudent = "UPDATE students set students.isActive = true where students.lrn =" . $_GET['yes'] . ";";
                    if(mysqli_query($conn, $restoreStudent)){?>
                        <div class="small_box">
                            <div class="container">
                                <h1><?= $_GET['yes']?> was successfully restored</h1>
                                <div class="action">
                                    <a href="?page=<?= $_GET['page']?>" id="proceed">Proceed back to Archives!</a>
                                    <a href="?page=enrollees" id="proceed">Proceed to Enrollees!</a>
                                </div>
                            </div>
                        </div>
                <?php ; }?>
            </table>
        </div>
    <?php ;}
        CloseCon($conn);
    }
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
                                            <p>Grade 1 : <?= mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear." WHERE grade_level = 1")) ?></p>
                                            <p>Grade 2 : <?= mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear." WHERE grade_level = 2")) ?></p>
                                            <p>Grade 3 : <?= mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear." WHERE grade_level = 3")) ?></p>
                                            <p>Grade 4 : <?= mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear." WHERE grade_level = 4")) ?></p>
                                            <p>Grade 5 : <?= mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear." WHERE grade_level = 5")) ?></p>
                                            <p>Grade 6 : <?= mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear." WHERE grade_level = 6")) ?></p>
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
        $selectActiveSchoolYear = "SELECT * FROM school_years WHERE school_years.isActive = true";

        if(mysqli_num_rows(mysqli_query($conn, $selectActiveSchoolYear)) == 0){?>
            <div class="no-school-year__container">
                <h1>No school year is activated</h1>
                <a href="?page=admin_controls&sub-page=school-year" id="proceed">Activate School Year</a>
            </div>
        <?php }else if($activeSchoolYear = mysqli_fetch_array(mysqli_query($conn, $selectActiveSchoolYear))){
            if (isset($_GET['select_grade'])) {?>
                <div class="select-grade__container">
                <h1>Please Select Grade Level to Browse</h1>
                <div class="grade-levels">
                    <a href="?page=<?= $_GET['page']?>&grade-level=1">Grade 1</a>
                    <a href="?page=<?= $_GET['page']?>&grade-level=2">Grade 2</a>
                    <a href="?page=<?= $_GET['page']?>&grade-level=3">Grade 3</a>
                    <a href="?page=<?= $_GET['page']?>&grade-level=4">Grade 4</a>
                    <a href="?page=<?= $_GET['page']?>&grade-level=5">Grade 5</a>
                    <a href="?page=<?= $_GET['page']?>&grade-level=6">Grade 6</a>
                </div>
            </div>
            <?php }elseif (isset($_GET['grade-level']) && isset($_GET['section'])) {
                $gradeLevel = $_GET['grade-level'];
                $section = $_GET['section'];
                $studentInfoQuery = "SELECT * from `".$activeSchoolYear['school_year']."` join students on `".$activeSchoolYear['school_year']."`.enrolled_lrn = students.lrn where `".$activeSchoolYear['school_year']."`.`grade_level` = ".$gradeLevel." AND `". $activeSchoolYear['school_year'] ."`.section = ".$section." ORDER BY students.last_name ASC;";
                if ($result = mysqli_query($conn, $studentInfoQuery)) {?>
                    <div class="student-list__container" id="student-list">
                        <h1>Grade <?= $gradeLevel ?> Section <?= $section ?> S.Y. <?= $activeSchoolYear['school_year'] ?></h1>
                        <?php
                            if (mysqli_num_rows($result) == 0) {?>
                                <h2>No Students are enrolled to this section</h2>
                                <a href="?page=enrolled_students&select_grade=true" id="previous">Reselect Grade</a>
                            <?php }else{
                                $maleStudents = [];
                                $femaleStudents = [];
                                while ($res = mysqli_fetch_array($result)) {
                                    $lastName = $res['last_name'];
                                    $firstName = $res['first_name'];
                                    $middleName = $res['middle_name'];
                                    $suffix = $res['suffix'];
                                    $gender = $res['gender'];
                                    // echo $lastName." ".$suffix.", ".$firstName." ".$middleName[0].".";
                                    if ($middleName == "" && $suffix == "") {
                                        $fullName = $lastName.", ".$firstName;
                                    }elseif ($suffix == "") {
                                        $fullName = $lastName.", ".$firstName." ".$middleName[0].".";
                                    }elseif ($middleName == "") {
                                        $fullName = $lastName." ".$suffix.", ".$firstName;
                                    }else{
                                        $fullName = $lastName." ".$suffix.", ".$firstName." ".$middleName[0].".";
                                    }

                                    if ($gender == "Male") {
                                        array_push($maleStudents, $fullName);
                                    }elseif ($gender == "Female") {
                                        array_push($femaleStudents, $fullName);
                                    }
                                }

                                if(count($maleStudents) > count($femaleStudents)){
                                    $limit = count($maleStudents);
                                }elseif(count($maleStudents) < count($femaleStudents)){
                                    $limit = count($femaleStudents);
                                }else{
                                    $limit = count($maleStudents);
                                }?>
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>Male</th>
                                            <th>Female</th>
                                        </tr>
                                        <?php for ($i=0; $i < $limit; $i++) { 
                                            
                                            if(array_key_exists($i, $maleStudents)){
                                                $maleName = $maleStudents[$i];
                                            }else{
                                                $maleName = " ";
                                            }

                                            if(array_key_exists($i, $femaleStudents)){
                                                $femaleName = $femaleStudents[$i];
                                            }else{
                                                $femaleName = " ";
                                            }?>
                                            <tr>
                                                <td><?= $i+1 ?>. <?= $maleName ?></td>
                                                <td><?= $i+1 ?>. <?= $femaleName ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <a href="?page=enrolled_students&select_grade=true" id="previous" data-html2canvas-ignore>Reselect Grade</a>
                                <a id="print" data-html2canvas-ignore>Print</a>
                                <script>
                                    function autoClick(){
                                        $("#print").click();
                                    }
                                    $(document).ready(function(){
                                        var element = $("#student-list");

                                        $("#print").on('click', function(){
                                            html2canvas(element, {
                                                scale: 5,
                                                onrendered: function(canvas){
                                                    var imageData = canvas.toDataURL("image/jpg");
                                                    var newData = imageData.replace(/^data:image\/jpg/, "data:application/octet-stream");
                                                    $("#print").attr("download", "Grade <?= $gradeLevel ?> Section <?= $section ?> S.Y. <?= $activeSchoolYear['school_year'] ?>.jpg").attr("href", newData)
                                                }
                                            });
                                        });
                                    })
                                </script>
                                
                            <?php }
                        ?>
                        
                    </div>
                <?php }?>
            <?php }elseif (isset($_GET['grade-level'])) {?>
                <div class="select-section__container">
                    <a href="?page=enrolled_students&select_grade=true" id="previous"><<< Back to Grade Selection</a>
                    <h1>Please Select the Section from Grade <?= $_GET['grade-level'] ?> to Browse</h1>
                    <div class="sections">
                        <li><a href="?page=enrolled_students&grade-level=<?= $_GET['grade-level'] ?>&section=1">Section 1</a></li>
                        <li><a href="?page=enrolled_students&grade-level=<?= $_GET['grade-level'] ?>&section=2">Section 2</a></li>
                        <li><a href="?page=enrolled_students&grade-level=<?= $_GET['grade-level'] ?>&section=3">Section 3</a></li>
                        <li><a href="?page=enrolled_students&grade-level=<?= $_GET['grade-level'] ?>&section=4">Section 4</a></li>
                        <li><a href="?page=enrolled_students&grade-level=<?= $_GET['grade-level'] ?>&section=5">Section 5</a></li>
                        <li><a href="?page=enrolled_students&grade-level=<?= $_GET['grade-level'] ?>&section=6">Section 6</a></li>
                        <li><a href="?page=enrolled_students&grade-level=<?= $_GET['grade-level'] ?>&section=7">Section 7</a></li>
                        <li><a href="?page=enrolled_students&grade-level=<?= $_GET['grade-level'] ?>&section=8">Section 8</a></li>
                        <li><a href="?page=enrolled_students&grade-level=<?= $_GET['grade-level'] ?>&section=9">Section 9</a></li>
                        <li><a href="?page=enrolled_students&grade-level=<?= $_GET['grade-level'] ?>&section=10">Section 10</a></li>
                    </div>
                </div>
            <?php }
        }
        CloseCon($conn);
    }
    //Write Enrollment Form content Below!
    function enrollmentFormContent()
    {?>
        This is Enrollment Form
    <?php ;
    }?>