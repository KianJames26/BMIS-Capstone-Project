<?php
function userManagement(){
    $conn = OpenCon();
    ?>
    <div style="margin-left:22%">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
        <div class="pickuser">
            <a href="?page=elem_management" class="elem">Elementary Admin</a>
            <a href="?page=hs_management" class="hs">High School Admin</a>
            <div class="userrole">
                <a href="?page=<?= $_GET['page'] ?>&add_user=true" class="adduser">Add a new user</a>
            </div>
        </div>
        <table id="crud">
            <tr>
                <th>Role</th>
                <th>Username</th>
                <th>Status</th>
            </tr>
            <?php
            $queryAccounts = "SELECT * FROM admin_accounts";
            if($result = mysqli_query($conn, $queryAccounts)){
                while ($res = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php if ($res['admin_role'] == "elementary") {
                            echo "Elementary Admin";
                        }elseif($res['admin_role'] == "high_school") {
                            echo "High School Admin";
                        }?></td>
                        <td><?= $res['admin_username'] ?></td>
                        <td><?php if ($res['admin_status'] == 1) {
                            echo "Enabled";
                        }else {
                            echo "Disabled";
                        }?></td>
                        <td>
                            <a href="?page=user_management&edit=<?= $res['admin_id'] ?>">
                                <img src="img/edit.png" alt="dp" style="width: 20px;"/>
                            </a>
                        </td> 
                        <td>
                            <a href="#">
                                <img src="img/delete.png" alt="dp" style="width: 15px;"/>
                            </a>
                        </td>   
                    </tr>
                <?php }
            }
            ?>
        </table>
    </div>
    
<?php 
    CloseCon($conn);
}

function logsManagement(){
    $conn = OpenCon();
    ?>
    <div style="margin-left:22%">
        <div class="userrole">
        <a class="lgntemps">Logs</a>
    
        </div>
        <table id="crud">
            <tr>
                <th>Date</th>
                <th>Admin Role</th>
                <th>Username</th>
                <th>Log Description</th>
                
            </tr>
            <?php
                $queryLogs = "SELECT * FROM logs JOIN admin_accounts ON logs.admin_id = admin_accounts.admin_id ORDER BY logs.log_id DESC";
                if ($result = mysqli_query($conn, $queryLogs)) {
                    $i = 1;
                    while ($res = mysqli_fetch_assoc($result)) {?>
                        <tr>
                            <td><?= $res['log_date'] ?></td>
                            <td>
                                <?php if ($res['admin_role'] == "elementary") {
                                    echo "Elementary Admin";
                                }elseif($res['admin_role'] == "high_school") {
                                    echo "High School Admin";
                                }?>
                            </td>
                            <td><?= $res['admin_username'] ?></td>
                            <td><?= $res['log_description'] ?></td>
                        </tr>
                    <?php 
                    }
                }
            ?>
        </table>
    </div>
<?php
    CloseCon($conn);
}
function elemManagement(){
    $conn = OpenCon();
    ?>
    <div style="margin-left:22%">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
        <div class="pickuser">
                <a href="?page=hs_management" class="hs">High School Admin</a>
            <div class="userrole">
                <a class="pickedrole">Elementary Admin</a>
                <a href="?page=<?= $_GET['page'] ?>&add_user=true" class="adduser">Add a new user</a>
            </div>
        </div>
        <table id="crud">
            <tr>
                <th>Role</th>
                <th>Username</th>
                <th>Status</th>
            </tr>
            <?php
            $queryAccounts = "SELECT * FROM admin_accounts WHERE admin_accounts.admin_role = 'elementary'";
            if($result = mysqli_query($conn, $queryAccounts)){
                while ($res = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php if ($res['admin_role'] == "elementary") {
                            echo "Elementary Admin";
                        }elseif($res['admin_role'] == "high_school") {
                            echo "High School Admin";
                        }?></td>
                        <td><?= $res['admin_username'] ?></td>
                        <td><?php if ($res['admin_status'] == 1) {
                            echo "Enabled";
                        }else {
                            echo "Disabled";
                        }?></td>
                        <td>
                            <a href="?page=<?= $_GET['page'] ?>&edit=<?= $res['admin_id'] ?>">
                                <img src="img/edit.png" alt="dp" style="width: 20px;"/>
                            </a>
                        </td> 
                        <td>
                            <a href="#">
                                <img src="img/delete.png" alt="dp" style="width: 15px;"/>
                            </a>
                        </td>   
                    </tr>
                <?php }
            }
            ?>
        </table>
    </div>
    <?php
    CloseCon($conn);
}
function hsManagement(){
    $conn = OpenCon();
    ?>
    <div style="margin-left:22%">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
        <div class="pickuser">
            <a href="?page=elem_management" class="elem">Elementary Admin</a>
            <div class="userrole">
            <a class="pickedrole">High School Admin</a>
            <a href="?page=<?= $_GET['page'] ?>&add_user=true" class="adduser">Add a new user</a>
            </div>
        </div>
        <table id="crud">
            <tr>
                <th>Role</th>
                <th>Username</th>
                <th>Status</th>
            </tr>
            <?php
            $queryAccounts = "SELECT * FROM admin_accounts WHERE admin_accounts.admin_role = 'high_school'";
            if($result = mysqli_query($conn, $queryAccounts)){
                while ($res = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php if ($res['admin_role'] == "elementary") {
                            echo "Elementary Admin";
                        }elseif($res['admin_role'] == "high_school") {
                            echo "High School Admin";
                        }?></td>
                        <td><?= $res['admin_username'] ?></td>
                        <td><?php if ($res['admin_status'] == 1) {
                            echo "Enabled";
                        }else {
                            echo "Disabled";
                        }?></td>
                        <td>
                            <a href="?page=<?= $_GET['page'] ?>&edit=<?= $res['admin_id'] ?>">
                                <img src="img/edit.png" alt="dp" style="width: 20px;"/>
                            </a>
                        </td> 
                        <td>
                            <a href="#">
                                <img src="img/delete.png" alt="dp" style="width: 15px;"/>
                            </a>
                        </td>   
                    </tr>
                <?php }
            }
            ?>
        </table>
    </div>
    <?php
    CloseCon($conn);
}

?>