<?php
    //Write Dashboard content Below!
    function dashboardContent($gradeLevel)
    {
        $conn = OpenCon();
        if($result = mysqli_query($conn, "SELECT count(enrollees.student_lrn) from enrollees inner join students on enrollees.student_lrn = students.lrn WHERE students.grade_level ". $gradeLevel ." and students.isActive = true;")){
            if($row = mysqli_fetch_array($result)) {
                $elementaryEnrollees = $row[0];
            }
        }
        $selectActiveSchoolYear = "SELECT * from school_years where school_years.isActive = true";
        if(mysqli_num_rows(mysqli_query($conn, $selectActiveSchoolYear)) == 0){
            $elementaryStudents = 0;
        }else{
            if ($activeSchoolYear = mysqli_fetch_array(mysqli_query($conn, $selectActiveSchoolYear))) {
                $enrolleStudentsQuery = "SELECT * FROM `". $activeSchoolYear['school_year'] ."` WHERE `". $activeSchoolYear['school_year'] ."`.grade_level". $gradeLevel;
                if (mysqli_num_rows(mysqli_query($conn, $enrolleStudentsQuery)) == 0) {
                    $elementaryStudents = 0;
                }else{
                    $elementaryStudents = mysqli_num_rows(mysqli_query($conn, $enrolleStudentsQuery));
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
        $searchKeyword = "";
        ?>
    
        <div class="enrollees">
            <form action="admin.php?page=<?= $_GET['page']?>" method="post">
                <input type="search" name="search-keyword" id="search" placeholder="Search LRN, First Name or Last Name" value="<?php echo isset($_POST['search-keyword']) ? $_POST['search-keyword'] : ''; ?>">
                <button name="search">Search</button>
                <a href="?page=archived">View Archive Students</a>
            </form>
            <table>
                <tr class="table-header">
                    <th>Full Name</th>
                    <th>Email Adress</th>
                    <th>Contact Number</th>
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
                    $sql = "SELECT enrollees.student_lrn, students.*, parent_information.* from enrollees join students on enrollees.student_lrn = students.lrn join parent_information on parent_information.student_lrn = students.lrn WHERE students.grade_level ". $gradeLevel ." and students.isActive = true;";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) == 0){?>
                            <tr><td colspan="100%"><h1>No Student Enrollees at the Moment</h1></td></tr>
                        <?php }else{
                            while ($res = mysqli_fetch_array($result)) {
                                $selectActiveSchoolYearQuery = "SELECT * FROM school_years WHERE isActive = true";
                                if(mysqli_num_rows(mysqli_query($conn, $selectActiveSchoolYearQuery)) == 0){
                                    ?>
                                    <tr id=<?= $res['lrn']?>>
                                        <td><?= $res['last_name'];?>, <?php echo $res['first_name'];?></td>
                                        <td><?= $res['email'];?></td>
                                        <td><?= $res['contact_number'];?></td>
                                        <td><?= $res['parent_name'];?></td>
                                        <td><?= $res['parent_relationship'];?></td>
                                        <td><?= $res['parent_contact'];?></td>
                                        <td><?= $res['grade_level'];?></td>
                                        <td class="action">
                                            <a id="edit" href="?page=<?= $_GET['page']?>&edit=<?php echo $res['lrn'];?>">Edit</a>
                                            <a id="delete" href="?page=<?= $_GET['page']?>&delete_student=<?php echo $res['lrn'];?>">Delete</a>
                                        </td>
                                    </tr>
                                <?php }elseif($activeSchoolYear = mysqli_fetch_array(mysqli_query($conn, $selectActiveSchoolYearQuery))){
                                    $checkIfEnrolled = "SELECT * FROM `". $activeSchoolYear['school_year'] ."` WHERE enrolled_lrn = '" . $res['lrn'] . "'";
                                    if (mysqli_num_rows(mysqli_query($conn, $checkIfEnrolled)) == 0) {?>
                                        <tr id=<?= $res['lrn']?>>
                                        <td><?= $res['last_name'];?>, <?php echo $res['first_name'];?></td>
                                        <td><?= $res['email'];?></td>
                                        <td><?= $res['contact_number'];?></td>
                                        <td><?= $res['parent_name'];?></td>
                                        <td><?= $res['parent_relationship'];?></td>
                                        <td><?= $res['parent_contact'];?></td>
                                        <td><?= $res['grade_level'];?></td>
                                        <td class="action">
                                            <a id="edit" href="?page=<?= $_GET['page']?>&edit=<?php echo $res['lrn'];?>">Edit</a>
                                            <a id="delete" href="?page=<?= $_GET['page']?>&delete_student=<?php echo $res['lrn'];?>">Delete</a>
                                        </td>
                                    </tr>
                                    <?php }
                                }
                            }
                        }
                    }
                }else {
                    $sql = "SELECT enrollees.student_lrn, students.*, parent_information.* from enrollees join students on enrollees.student_lrn = students.lrn join parent_information on parent_information.student_lrn = students.lrn WHERE students.grade_level ". $gradeLevel ." and students.isActive = true and (students.lrn like '". $searchKeyword ."%' or students.first_name like '%". $searchKeyword ."%' or students.last_name like '%". $searchKeyword ."%');";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) == 0){?>
                            <tr><td colspan="100%"><h1>There are no data fetched in your search</h1></td></tr>
                        <?php }else{
                            while ($res = mysqli_fetch_array($result)) {
                                $selectActiveSchoolYearQuery = "SELECT * FROM school_years WHERE isActive = true";
                                if(mysqli_num_rows(mysqli_query($conn, $selectActiveSchoolYearQuery)) == 0){
                                    ?>
                                    <tr id=<?= $res['lrn']?>>
                                        <td><?= $res['last_name'];?>, <?php echo $res['first_name'];?></td>
                                        <td><?= $res['email'];?></td>
                                        <td><?= $res['contact_number'];?></td>
                                        <td><?= $res['parent_name'];?></td>
                                        <td><?= $res['parent_relationship'];?></td>
                                        <td><?= $res['parent_contact'];?></td>
                                        <td><?= $res['grade_level'];?></td>
                                        <td class="action">
                                            <a id="edit" href="?page=<?= $_GET['page']?>&edit=<?php echo $res['lrn'];?>">Edit</a>
                                            <a id="delete" href="?page=<?= $_GET['page']?>&delete_student=<?php echo $res['lrn'];?>">Delete</a>
                                        </td>
                                    </tr>
                                <?php }elseif($activeSchoolYear = mysqli_fetch_array(mysqli_query($conn, $selectActiveSchoolYearQuery))){
                                    $checkIfEnrolled = "SELECT * FROM `". $activeSchoolYear['school_year'] ."` WHERE enrolled_lrn = '" . $res['lrn'] . "'";
                                    if (mysqli_num_rows(mysqli_query($conn, $checkIfEnrolled)) == 0) {?>
                                        <tr id=<?= $res['lrn']?>>
                                        <td><?= $res['last_name'];?>, <?php echo $res['first_name'];?></td>
                                        <td><?= $res['email'];?></td>
                                        <td><?= $res['contact_number'];?></td>
                                        <td><?= $res['parent_name'];?></td>
                                        <td><?= $res['parent_relationship'];?></td>
                                        <td><?= $res['parent_contact'];?></td>
                                        <td><?= $res['grade_level'];?></td>
                                        <td class="action">
                                            <a id="edit" href="?page=<?= $_GET['page']?>&edit=<?php echo $res['lrn'];?>">Edit</a>
                                            <a id="delete" href="?page=<?= $_GET['page']?>&delete_student=<?php echo $res['lrn'];?>">Delete</a>
                                        </td>
                                    </tr>
                                    <?php }
                                }
                            }?>
                    </table>
                        <?php }
                    }
                }
                
                if (isset($_GET['edit'])) {
                    $sql = "SELECT students.*, parent_information.* FROM students JOIN parent_information ON parent_information.student_lrn = students.lrn where students.lrn = " . $_GET['edit'];
                    if ($result = mysqli_query($conn, $sql)) {
                        if ($res = mysqli_fetch_array($result)) {?>
                            <div class="edit">
                                <div class="enrollee-info">
                                    <a href="?page=<?= $_GET['page']?>"><div id="close-editor"></div></a>
                                    <div class="row">
                                        <img src="../../../../uploads/<?= $res['lrn']?>/<?= $res['student_picture']?>">
                                        <div class="student-info">
                                            <p><b>LRN : </b><?= $res['lrn']?></p>
                                            <h1><?= $res['last_name']?>, <?= $res['first_name']?></h1>
                                            <p><b>Enrolling for Grade : </b> <?= $res['grade_level']?></p>
                                            <p><?= $res['email']?></p>
                                            <p><?= $res['contact_number']?></p>
                                            <p><b>Gender : </b><?= $res['gender']?></p>
                                            <p><b>Age : </b><?php 
                                                $today = date("y-m-d");
                                                $age = date_diff(date_create($res['birth_date']), date_create($today));
                                                echo $age -> format('%y');
                                            ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p><b>Address : </b> <?= $res['house_address']?>, <?= $res['barangay']?>, <?= $res['city']?>, <?= $res['province']?></p>
                                    </div>
                                    <div class="row">
                                        <div class="no-column">
                                            <p><b>Birth Day : </b><?= date("F j,Y", strtotime($res['birth_date']))?></p>
                                            <p><b>Birth Place : </b><?= $res['birth_place']?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="no-column">
                                            <p><b>Parent/Guardian Name : </b> <?= $res['parent_name']?></p>
                                            <p><b>Parent/Guardian Contact No. : </b> <?= $res['parent_contact']?></p>
                                            <p><b>Relationship to the Enrollee : </b> <?= $res['parent_relationship']?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="no-column">
                                            <p><b>Last School Attended : </b> <?= $res['last_school']?></p>
                                            <p><b>Last School Address : </b> <?= $res['last_school_address']?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="files">
                                            <a href="../../../../uploads/<?= $res['lrn']?>/<?= $res['birth_certificate']?>"  target="_blank">Open Birth Certificate</a>
                                            <a href="../../../../uploads/<?= $res['lrn']?>/<?= $res['report_card']?>" target="_blank">Open Form 137</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="action">
                                            <a id="confirm-enrollment" href="?page=<?= $_GET['page']?>&confirm_enrollment=<?php echo $res['lrn'];?>">Confirm Enrollment</a>
                                            <a id="delete" href="?page=<?= $_GET['page']?>&delete_student=<?php echo $res['lrn'];?>">Delete this Enrollee</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                    
                }
                if (isset($_GET['confirm_enrollment'])) {?>
                    <div class="small_box">
                        <div class="container">
                            <h1>Confirm enrollment of <?= $_GET['confirm_enrollment']?>?</h1>
                            <div class="action">
                                <a href="?page=<?= $_GET['page']?>&edit=<?= $_GET['confirm_enrollment']?>" id="cancel">Cancel</a>
                                <a href="?page=<?= $_GET['page']?>&enroll=<?= $_GET['confirm_enrollment']?>" id="yes">Yes</a>
                            </div>
                        </div>
                    </div>
                <?php }
                if (isset($_GET['enroll'])) {
                    $selectActiveSchoolYear = "SELECT * from school_years where school_years.isActive = true";
                    if($result = mysqli_query($conn, $selectActiveSchoolYear)){
                        if(mysqli_num_rows($result) == 0){?>
                            <div class="small_box">
                                <div class="container">
                                    <h1>Please Activate a School Year First</h1>
                                    <div class="action">
                                        <a href="?page=admin_controls&sub-page=school-year" id="proceed">Go to Admin Controls</a>
                                        <a href="?page=<?= $_GET['page']?>&edit=<?= $_GET['enroll']?>" id="cancel">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        <?php }else{ 
                            $gradeLevelQuery = "SELECT students.grade_level from students where students.lrn = ".$_GET['enroll'];
                            if ($enrolleeGradeLevel = mysqli_fetch_array(mysqli_query($conn, $gradeLevelQuery))) {?>
                                <div class="enrollment-confirmation">
                                    <div class="enrollment-confirmation__container">
                                        <form action="<?php echo $_SERVER['PHP_SELF']."?page=enrollees&enrolled=".$_GET['enroll']; ?>" method="post" onsubmit="confirm('Confirm Enrollment of Student <?= $_GET['enroll']; ?>')">
                                            <h1>Confirm Student Enrollment</h1>
                                            <p class="sub-header">Note: Make sure to check all the student information completely before confirming their enrollment</p>
                                            <p>LRN : <b><?= $_GET['enroll']?></b></p>
                                            <p>Grade Level : <b><?= $enrolleeGradeLevel['grade_level']?></b></p>
                                            <div class="input">
                                                <label for="section">Select Student Section : </label>
                                                <select name="section" id="section">
                                                    <?php
                                                        $activeSchoolYearQuery = "SELECT * FROM school_years where school_years.isActive = true";
                                                        if ($activeSchoolYear = mysqli_fetch_array(mysqli_query($conn, $activeSchoolYearQuery))) {
                                                            $sectionCounter = "SELECT * FROM `".$activeSchoolYear['school_year']."` WHERE grade_level = ".$enrolleeGradeLevel['grade_level']." AND section =";
                                                            for ($i=1; $i <= 10; $i++) { 
                                                                if (mysqli_num_rows(mysqli_query($conn, $sectionCounter.$i)) < 40) {
                                                                    echo "<option value=".$i.">".$i."</option>";
                                                                }
                                                            }
                                                        }?>
                                                </select>
                                            </div>
                                            <input type="submit" value="Confirm Student Enrollment" name="submit">
                                        </form>
                                    </div>
                                </div>
                            <?php }
                            
                        }
                    }
                }
                if (isset($_GET['enrolled'])) {
                    $gradeLevelQuery = "SELECT students.grade_level from students where students.lrn = ".$_GET['enrolled'];
                    if ($enrolleeGradeLevel = mysqli_fetch_array(mysqli_query($conn, $gradeLevelQuery))) {
                        $activeSchoolYearQuery = "SELECT * FROM school_years where school_years.isActive = true";
                        if ($activeSchoolYear = mysqli_fetch_array(mysqli_query($conn, $activeSchoolYearQuery))) {
                            $lrn = $_GET['enrolled'];
                            $gradeLevel = $enrolleeGradeLevel['grade_level'];
                            $section = $_POST['section'];
                            $addToCurrentSchoolYearQuery = "INSERT INTO `". $activeSchoolYear['school_year'] ."` (enrolled_lrn, grade_level, section) VALUES ('$lrn', '$gradeLevel', '$section');";
                            $removeFromEnrolleeQuery = "DELETE FROM enrollees WHERE enrollees.student_lrn = '".$_GET['enrolled']."'";
                            if (mysqli_query($conn, $addToCurrentSchoolYearQuery)) {
                                if (mysqli_query($conn, $removeFromEnrolleeQuery)) {?>
                                    <div class="small_box">
                                        <div class="container">
                                            <h1>Student <?= $_GET['enrolled']?> successfully enrolled!</h1>
                                            <div class="action">
                                                <a href="?page=<?= $_GET['page']?>" id="proceed">Proceed to Enrollees</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            }
                        }
                        
                    }
                }
                if (isset($_GET['delete_student'])) {?>
                    <div class="small_box">
                        <div class="container">
                            <h1>Are you sure you want to delete <?= $_GET['delete_student']?>?</h1>
                            <div class="action">
                                <a href="?page=<?= $_GET['page']?>" id="cancel">Cancel</a>
                                <a href="?page=<?= $_GET['page']?>&yes=<?= $_GET['delete_student']?>" id="yes">Yes</a>
                            </div>
                        </div>
                    </div>
                <?php }
                if (isset($_GET['yes'])) {
                    $deleteStudent = "UPDATE students set students.isActive = false where students.lrn =" . $_GET['yes'];
                    if(mysqli_query($conn, $deleteStudent)){?>
                        <div class="small_box">
                            <div class="container">
                                <h1><?= $_GET['yes']?> successfully Deleted in the Database</h1>
                                <div class="action">
                                    <a href="?page=<?= $_GET['page']?>" id="proceed">Proceed to Enrollees!</a>
                                </div>
                            </div>
                        </div>
                    <?php }
                }
                CloseCon($conn);
                ?>
            
        </div>
    <?php ;
    }
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
                    <th>Full Name</th>
                    <th>Email Adress</th>
                    <th>Contact Number</th>
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
                                    <td><?= $res['last_name'];?>, <?php echo $res['first_name'];?></td>
                                    <td><?= $res['email'];?></td>
                                    <td><?= $res['contact_number'];?></td>
                                    <td><?= $res['parent_name'];?></td>
                                    <td><?= $res['parent_relationship'];?></td>
                                    <td><?= $res['parent_contact'];?></td>
                                    <td><?= $res['grade_level'];?></td>
                                    <td class="action">
                                        <a id="edit" href="?page=<?= $_GET['page']?>&restore=<?php echo $res['lrn'];?>">Restore</a>
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
                                    <td><?= $res['last_name'];?>, <?= $res['first_name'];?></td>
                                    <td><?= $res['email'];?></td>
                                    <td><?= $res['contact_number'];?></td>
                                    <td><?= $res['parent_name'];?></td>
                                    <td><?= $res['parent_relationship'];?></td>
                                    <td><?= $res['parent_contact'];?></td>
                                    <td><?= $res['grade_level'];?></td>
                                    <td class="action">
                                        <a id="edit" href="?page=<?= $_GET['page']?>&restore=<?php echo $res['lrn'];?>">Restore</a>
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
                                            <p class="sub-page-header">Total Enrolled Students: <?= mysqli_num_rows(mysqli_query($conn, $queryActiveSchoolYear." WHERE grade_level ".$gradeLevel)) ?></p>
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
                    <a href="?page=<?= $_GET['page']?>&grade-level=7">Grade 7</a>
                    <a href="?page=<?= $_GET['page']?>&grade-level=8">Grade 8</a>
                    <a href="?page=<?= $_GET['page']?>&grade-level=9">Grade 9</a>
                    <a href="?page=<?= $_GET['page']?>&grade-level=10">Grade 10</a>
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
                                                <td><?= $i+1 ?>.) <?= $maleName ?></td>
                                                <td><?= $i+1 ?>.) <?= $femaleName ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <a href="?page=enrolled_students&select_grade=true" id="previous">Reselect Grade</a>
                                <a id="print">Print</a>
                                <script>
                                    function autoClick(){
                                        $("#print").click();
                                    }
                                    $(document).ready(function(){
                                        var element = $("#student-list");

                                        $("#print").on('click', function(){
                                            html2canvas(element, {
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