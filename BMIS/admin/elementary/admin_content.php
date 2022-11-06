<?php
    //Write Dashboard content Below!
    
    function dashboardContent()
    {
        $conn = OpenCon();
        if($result = mysqli_query($conn, "SELECT count(enrollees.student_lrn) from enrollees inner join students on enrollees.student_lrn = students.lrn WHERE students.grade_level < 7 and students.isActive = true;")){
            if($row = mysqli_fetch_array($result)) {
                $elementaryEnrollees = $row[0];
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
                    <p class="count"><?php //echo $elementaryStudents; ?>0</p>
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
                $sql = "SELECT enrollees.student_lrn, students.*, parent_information.* from enrollees join students on enrollees.student_lrn = students.lrn join parent_information on parent_information.student_lrn = students.lrn WHERE students.grade_level < 7 and students.isActive = true;";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) == 0){?>
                        <tr><td colspan="100%"><h1>No Student Enrollees at the Moment</h1></td></tr>
                    <?php }else {
                        while ($res = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
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
