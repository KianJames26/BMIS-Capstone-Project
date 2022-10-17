<?php
    //Write Dashboard content Below!
    
    function dashboardContent()
    {
        $conn = OpenCon();
        if($result = mysqli_query($conn, "SELECT count(enrollees.student_lrn) from enrollees inner join students on enrollees.student_lrn = students.lrn WHERE students.grade_level > 6;")){
            if($row = mysqli_fetch_array($result)) {
                $highschoolEnrollees = $row[0];
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
                    <p class="title">Number of Highschool Enrollees : </p>
                    <p class="count"><?= $highschoolEnrollees; ?></p>
                </div>
            </div>
            <div class="box">
                <div class="icon">
                    <img src="../../../img/reading-book.png" alt="O" srcset="">
                </div>
                <div class="text">
                    <p class="title" style="font-size: 16px;">Number of Enrolled Highschool Students : </p>
                    <p class="count"><?php //echo $highschoolStudents; ?>0</p>
                </div>
            </div>
        </div>
    <?php ;
    }
    //Write Enrollees content Below!
    function enrolleesContent()
    {
        ?>
    
        <div class="enrollees">
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
                $sql = "SELECT enrollees.student_lrn, students.*, parent_information.* from enrollees join students on enrollees.student_lrn = students.lrn join parent_information on parent_information.student_lrn = students.lrn WHERE students.grade_level > 6;";
                if($result = mysqli_query($conn, $sql)){
                    while ($res = mysqli_fetch_array($result)) {?>
                        <tr>
                            <td><?= $res['last_name'];?>, <?php echo $res['first_name'];?></td>
                            <td><?= $res['email'];?></td>
                            <td><?= $res['contact_number'];?></td>
                            <td><?= $res['parent_name'];?></td>
                            <td><?= $res['parent_relationship'];?></td>
                            <td><?= $res['parent_contact'];?></td>
                            <td><?= $res['grade_level'];?></td>
                            <td class="action">
                                <a id="edit" href="?page=enrollees&edit=<?php echo $res['lrn'];?>">Edit</a>
                                <a id="delete" href="?page=enrollees&delete_student=<?php echo $res['lrn'];?>">Delete</a>
                            </td>
                        </tr>
                    <?php }
                }
                if (isset($_GET['edit'])) {
                    $sql = "SELECT students.*, parent_information.* FROM students JOIN parent_information ON parent_information.student_lrn = students.lrn where students.lrn = " . $_GET['edit'];
                    if ($result = mysqli_query($conn, $sql)) {
                        if ($res = mysqli_fetch_array($result)) {?>
                            <div class="edit">
                                <div class="enrollee-info">
                                    <a href="?page=enrollees"><div id="close-editor"></div></a>
                                    <div class="row">
                                        <img src="../../../../uploads/<?= $res['lrn']?>/<?= $res['student_picture']?>">
                                        <div class="student-info">
                                            <p><b>LRN : </b><?= $res['lrn']?></p>
                                            <h1><?= $res['last_name']?>, <?= $res['first_name']?></h1>
                                            <p><b>Enrolling for Grade : </b> <?= $res['grade_level']?></p>
                                            <p><?= $res['email']?></p>
                                            <p><?= $res['contact_number']?></p>
                                            <p><b>Gender : </b><?= $res['gender']?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p><b>Address : </b> <?= $res['house_address']?>, <?= $res['barangay']?>, <?= $res['city']?>, <?= $res['province']?></p>
                                    </div>
                                    <div class="row">
                                        <div class="no-column">
                                            <p><b>Birth Day : </b><?= $res['birth_date']?></p>
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
                                            <a id="confirm-enrollment" href="?page=enrollees&confirm_enrollment=<?php echo $res['lrn'];?>">Confirm Enrollment</a>
                                            <a id="delete" href="?page=enrollees&delete_student=<?php echo $res['lrn'];?>">Delete this Enrollee</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                    
                }
                if (isset($_GET['delete_student'])) {?>
                    <div class="small_box">
                        <div class="container">
                            <h1>Are you sure you want to delete <?= $_GET['delete_student']?>?</h1>
                            <div class="action">
                                <a href="?page=enrollees" id="cancel">Cancel</a>
                                <a href="?page=enrollees&yes=<?= $_GET['delete_student']?>" id="yes">Yes</a>
                            </div>
                        </div>
                    </div>
                <?php }
                if (isset($_GET['yes'])) {
                    $deleteEnrollees = "DELETE from enrollees where enrollees.student_lrn = " . $_GET['yes'];
                    $deleteParentInfo = "DELETE from parent_information where parent_information.student_lrn = " . $_GET['yes'];
                    $deleteStudent = "DELETE from students where students.lrn = " . $_GET['yes'];
                    if(mysqli_query($conn, $deleteEnrollees)){
                        if(mysqli_query($conn, $deleteParentInfo)){
                            if(mysqli_query($conn, $deleteStudent)){?>
                                <div class="small_box">
                                    <div class="container">
                                        <h1><?= $_GET['yes']?> successfully Deleted in the Database</h1>
                                        <div class="action">
                                            <a href="?page=enrollees" id="proceed">Proceed to Enrollees!</a>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                    }
                }
                CloseCon($conn);
                ?>
            </table>
        </div>
    <?php ;
    }
    //Write Enrolled Students Content Below!
    function enrolledStudentsContent(){?>
        This is Enrolled Students
    <?php ;
    }
    //Write Enrollment Form content Below!
    function enrollmentFormContent()
    {?>
        This is Enrollment Form
    <?php ;
    }
?>
