<?php
    //Write Dashboard content Below!
    
    function dashboardContent()
    {
        $conn = OpenCon();
        if($result = mysqli_query($conn, "SELECT count(enrollees.student_lrn) from enrollees inner join students on enrollees.student_lrn = students.lrn WHERE students.grade_level <7;")){
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
                $sql = "SELECT enrollees.student_lrn, students.*, parent_information.* from enrollees join students on enrollees.student_lrn = students.lrn join parent_information on parent_information.student_lrn = students.lrn WHERE students.grade_level <7;";
                if($result = mysqli_query($conn, $sql)){
                    while ($res = mysqli_fetch_array($result)) {?>
                        <tr>
                            <td><?php echo $res['last_name'];?>, <?php echo $res['first_name'];?></td>
                            <td><?php echo $res['email'];?></td>
                            <td><?php echo $res['contact_number'];?></td>
                            <td><?php echo $res['parent_name'];?></td>
                            <td><?php echo $res['parent_relationship'];?></td>
                            <td><?php echo $res['parent_contact'];?></td>
                            <td><?php echo $res['grade_level'];?></td>
                            <td class="action">
                                <a id="edit" href="?page=enrollees&lrn=<?php echo $res['lrn'];?>">Edit</a>
                                <a id="delete" href="?page=enrollees&delete_student=<?php echo $res['lrn'];?>">Delete</a>
                            </td>
                        </tr>
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
