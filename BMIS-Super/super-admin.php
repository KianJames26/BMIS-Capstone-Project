<?php
    session_start();
    if ($_SESSION['logged'] == false) {
        header("Location:index.php");
    }else {
        include '../BMIS/phpMethods/connection.php';
        include 'super-admin_content.php';
        $conn = OpenCon();
    }
    if (isset($_GET['logout'])) {
        header("Location: index.php");
        session_destroy();
    }

?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BMIS-SuperAdmin</title>
        <link href="styles.css" rel="stylesheet" type="text/css">
    </head>

    <body>
      <!-- Top Bar -->
        <div class="topnav">
            <img src="img/logo.png" alt="logo"/>
            <a>BMIS Supervisor Admin</a>
        <!--Logout Button-->
            <div class="lgt">
                <a href="?logout"><img src="img/exit.png" alt="dp" style="width: 28px;"/></a>
            </div>
        <!--Profile Picture-->
            <div class="dp">
                <img src="img/accimg.png" alt="dp" 
                style="width: 50px;"/>
            </div>
        </div>
        <!-- Sidebar -->
        <div class="sidebar">
            <hr>
                <button class="buttonaccmng">
                    <img src="img/accmanage.png" alt="accmanage" style="width: 25px;"/>
                    <a href="?page=user_management">User Management</a>
                </button>
            <hr>
                <button class="buttonadminlog">
                    <img src="img/statistics.png" alt="Adminlogs" style="width: 25px;"/>
                    <a href="?page=logs">Admin Account Logs</a>
                </button>
            <hr>
        </div>
        <!-- Page Content -->
        <?php
        if($_GET['page'] == 'user_management'){
            userManagement();
        }elseif($_GET['page'] == 'logs'){
            logsManagement();
        }elseif($_GET['page'] == 'elem_management'){
            elemManagement();
        }elseif($_GET['page'] == 'hs_management'){
            hsManagement();
        }else{
            header("Location: ?page=user_management");
        }
        if (isset($_GET['add_user'])) {?>
            <div class="prompt">
                <div class="prompt__container">
                    <form action="" method="post" autocomplete="off">
                        <h1>Add New Admin</h1>
                        <label for="admin-id">Admin ID : </label><br>
                        <input type="text" name="admin-id" id="admin-id" placeholder="Enter Admin ID" required value="<?php if(isset($_POST['admin-id'])){echo $_POST['admin-id']; } ?>"><br>
                        <label for="admin-username">Admin Username : </label><br>
                        <input type="text" name="admin-username" id="admin-username" placeholder="Enter Admin Username" required value="<?php if(isset($_POST['admin-username'])){echo $_POST['admin-username']; } ?>"><br>
                        <label for="admin-password">Admin Password : </label><br>
                        <input type="text" name="admin-password" id="admin-password" placeholder="Enter Admin Password" required value="<?php if(isset($_POST['admin-password'])){echo $_POST['admin-password']; } ?>"><br>
                        <label for="admin-role">Admin Role</label><br>
                        <select name="admin-role" id="admin-role">
                            <option value="elementary">Elementary Admin</option>
                            <option value="high_school">High School Admin</option>
                        </select>
                        <br>
                        <div class="actions">
                            <button type="submit" name="add-user" class="confirm">Register Admin</button>
                            <a href="?page=<?= $_GET['page'] ?>" class="cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php 
            if (isset($_POST['add-user'])) {
                $adminID = $_POST['admin-id'];
                $adminUsername = $_POST['admin-username'];
                $adminPassword = $_POST['admin-password'];
                $adminRole = $_POST['admin-role'];
                $exists = false;
                
                $queryAllAdminID = "SELECT admin_accounts.admin_id FROM admin_accounts WHERE admin_accounts.admin_id = '$adminID'";
                if (mysqli_num_rows(mysqli_query($conn, $queryAllAdminID)) > 0) {
                    $exists = true;
                }
                if ($exists) {?>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Admin ID',
                            text: 'Admin Id already exists in the system'
                        })
                    </script>
                <?php }elseif(strlen(trim($adminID)) < 5){ ?>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Admin ID',
                            text: 'Admin Id should atleast have more than 5 digits'
                        })
                    </script>
                <?php }elseif (strlen(trim($adminUsername)) < 5) {?>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Username',
                            text: 'Admin Username should atleast have more than 5 digits'
                        })
                    </script>
                <?php 
                }elseif (strlen($adminPassword)< 8) {?>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Password',
                            text: 'Admin Password should atleast have 8 digits'
                        })
                    </script>
                <?php }else {
                    $securedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);
                    $status = TRUE;
                    $addNewAdminQuery = "INSERT INTO admin_accounts (admin_id, admin_username, admin_password, admin_role, admin_status)
                    VALUES ('$adminID', '$adminUsername', '$securedPassword', '$adminRole', '$status')";
                    if(mysqli_query($conn, $addNewAdminQuery)){?>
                        <div class="prompt">
                            <div class="prompt__container">
                                <h1>Successfully Added New Account</h1>
                                <div class="actions">
                                    <a href="?page=<?= $_GET['page'] ?>" class="confirm">Okay</a>
                                </div>
                            </div>
                        </div>
                    <?php }
                }
            }
        }
        if (isset($_GET['edit'])){
            // $admin_id = $_GET['edit'];
            ?>
            <div class="prompt">
                <div class="prompt__container">
                    <form action="" method="post" autocomplete="off">
                        <h1>Edit Admin</h1>
                        <label for="admin-id">Admin ID : </label><br>
                        <input type="text" name="admin-id" id="admin-id" placeholder="Enter Admin ID" required value="<?php if(isset($_POST['admin-id'])){echo $_POST['admin-id']; } ?>"><br>
                        <label for="admin-username">Admin Username : </label><br>
                        <input type="text" name="admin-username" id="admin-username" placeholder="Enter Admin Username" required value="<?php if(isset($_POST['admin-username'])){echo $_POST['admin-username']; } ?>"><br>
                        <label for="admin-password">Admin Password : </label><br>
                        <input type="text" name="admin-password" id="admin-password" placeholder="Enter Admin Password" required value="<?php if(isset($_POST['admin-password'])){echo $_POST['admin-password']; } ?>"><br>
                        <label for="admin-role">Admin Role</label><br>
                        <select name="admin-role" id="admin-role">
                            <option value="elementary">Elementary Admin</option>
                            <option value="high_school">High School Admin</option>
                        </select>
                        <br>
                        <div class="actions">
                            <button type="submit" name="add-user" class="confirm">Register Admin</button>
                            <a href="?page=<?= $_GET['page'] ?>" class="cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }
        ?>
    </body>
    <!-- Account Management -->
<html>

<?php

